
export function initializeLiveSearchCases(viewHeader, tagSelector = {}, tinymce = {}) {

// Initialize debounce function
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

// Main filtering function
    function filterCases() {
        // Get all filter values
        const subjectIds = Array.from(document.querySelectorAll('.subject-checkbox:checked'))
            .map(checkbox => checkbox.value);
        const trialIds = Array.from(document.querySelectorAll('.trial-checkbox:checked'))
            .map(checkbox => checkbox.value);


        const tagIds = tagSelector.items || [];


        const searchQuery = document.getElementById('search').value;

        // Get current sort parameters from URL
        const urlParams = new URLSearchParams(window.location.search);
        const sortField = urlParams.get('sort') || 'id';
        const sortDirection = urlParams.get('direction') || 'asc';
        const page = urlParams.get('page') || 1;

        // Show loading state
        const casesContainer = document.getElementById('cases-data');
        casesContainer.style.opacity = '0.5';

        // Prepare query parameters
        const params = new URLSearchParams();

        const pagination = document.getElementById('pagination');
        const loadingSpinner = document.getElementById('loading-spinner');

        // Only add parameters if they have values
        if (subjectIds.length > 0) {
            subjectIds.forEach(id => params.append('subject_ids[]', id));
        }
        if (trialIds.length > 0) {
            trialIds.forEach(id => params.append('trial_ids[]', id));
        }
        if (tagIds.length > 0) {
            tagIds.forEach(id => params.append('tag_ids[]', id))
        }

        if (searchQuery) {
            params.append('q', searchQuery);
        } else {
            pagination.style.display = '';
        }
        params.append('sort', sortField);
        params.append('direction', sortDirection);
        params.append('page', page);

        if (searchQuery.length > 0 || (subjectIds.length > 0 || trialIds.length > 0 || tagIds.length > 0)) {
            pagination.style.display = 'none';
        } else {
            pagination.style.display = '';
        }

        // Log the request URL for debugging
        console.log('Request URL:', `/cases/filter?${params.toString()}`);
        loadingSpinner.classList.remove('hidden');
        // Make API request
        fetch(`/cases/filter?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html',
                'View': viewHeader,
            },
            credentials: 'same-origin' // Include cookies if using Laravel's CSRF protection
        })
            .then(response => {


                console.log('Response status:', response.status);
                console.log('Response headers:', [...response.headers.entries()]);

                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('Error response body:', text);
                        throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
                    });
                }
                return response.text();
            })
            .then(html => {
                console.log('Received HTML length:', html.length);
                casesContainer.innerHTML = html;
                casesContainer.style.opacity = '1';

                // Update URL with current filters
                const newUrl = `${window.location.pathname}?${params.toString()}`;
                window.history.pushState({path: newUrl}, '', newUrl);

                loadingSpinner.classList.add('hidden');


                if (viewHeader === 'archived' || viewHeader === 'index') {
                    //reattach event listeners
                    if (window.initFlowbite) {
                        window.initFlowbite();
                    }

                    tinymce.remove(); // Remove any existing instances
                    tinymce.init({
                        selector: 'textarea.editor-modal',
                        readonly: true,
                        menubar: false,
                        toolbar: false,
                        branding: false,
                        license_key: 'gpl',
                        plugins: 'lists',
                        language: 'es',
                        resize: false,
                        height: 200,
                        content_style: "@import url('https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap'); body { font-family: 'Figtree', sans-serif; }",
                    });
                }

            })
            .catch(error => {
                console.error('Detailed error:', error);
                casesContainer.style.opacity = '1';
                casesContainer.innerHTML = `
                        <div class="p-4 text-center">
                            <div class="text-red-500 mb-2 font-bold">Error al cargar casos</div>
                        </div>`;

                loadingSpinner.classList.add('hidden');
            });
    }

// Initialize all event listeners
    document.addEventListener('DOMContentLoaded', function () {

        if (viewHeader === 'list') {

            // Initialize filter toggle for mobile
            const filterToggle = document.getElementById('filterToggle');
            const filterContainer = document.getElementById('filterContainer');

            if (filterToggle) {
                filterToggle.addEventListener('click', () => {
                    filterContainer.classList.toggle('hidden');
                });
            }

            // Subject toggles
            const toggleSubjects = document.getElementById('toggleSubjects');
            const subjectsContainer = document.getElementById('subjectsContainer');

            if (toggleSubjects) {
                toggleSubjects.addEventListener('click', () => {
                    subjectsContainer.classList.toggle('hidden');
                    toggleSubjects.textContent = subjectsContainer.classList.contains('hidden') ? 'Mostrar' : 'Ocultar';
                });
            }

            // Trial toggles
            const toggleTrials = document.getElementById('toggleTrials');
            const trialsContainer = document.getElementById('trialsContainer');

            if (toggleTrials) {
                toggleTrials.addEventListener('click', () => {
                    trialsContainer.classList.toggle('hidden');
                    toggleTrials.textContent = trialsContainer.classList.contains('hidden') ? 'Mostrar' : 'Ocultar';
                });
            }


            // Clean filters button
            const cleanFilters = document.getElementById('cleanFilters');
            if (cleanFilters) {
                cleanFilters.addEventListener('click', () => {
                    // Clear all checkboxes
                    document.querySelectorAll('.subject-checkbox, .trial-checkbox')
                        .forEach(checkbox => checkbox.checked = false);
                    // Clear search
                    document.getElementById('search').value = '';

                    if (tagSelector) {
                        //Clear tags
                        tagSelector.clear();

                    }

                    // Trigger filter update
                    filterCases();
                });
            }

            // Add event listeners for checkboxes
            document.querySelectorAll('.subject-checkbox, .trial-checkbox')
                .forEach(checkbox => {
                    checkbox.addEventListener('change', filterCases);
                });

            if (tagSelector) {
                // Add event listener for tag select
                tagSelector.on('change', filterCases);
            }
        }

        // Add event listener for search input with debounce
        const searchInput = document.getElementById('search');
        if (searchInput) {
            searchInput.addEventListener('input', debounce(filterCases, 300));
        }

        // Initial load if there are URL parameters
        if (window.location.search) {
            filterCases();

        }
    });
}
