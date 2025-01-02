export function initializeLiveSearchNoCases(typeModel, setupDescListeners) {

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

        const searchQuery = document.getElementById('search').value;

        // Get current sort parameters from URL
        const urlParams = new URLSearchParams(window.location.search);
        const sortField = urlParams.get('sort') || 'updated_at';
        const sortDirection = urlParams.get('direction') || 'desc';
        const page = urlParams.get('page') || 1;

        // Show loading state
        const casesContainer = document.getElementById(`${typeModel}-data`);
        casesContainer.style.opacity = '0.5';

        // Prepare query parameters
        const params = new URLSearchParams();

        const pagination = document.getElementById('pagination');
        const loadingSpinner = document.getElementById('loading-spinner');

        if (searchQuery) {
            params.append('q', searchQuery);
        } else {
            pagination.style.display = '';
        }
        params.append('sort', sortField);
        params.append('direction', sortDirection);
        params.append('page', page);

        if (searchQuery.length > 0) {
            pagination.style.display = 'none';
        } else {
            pagination.style.display = '';
        }

        // Log the request URL for debugging
        console.log('Request URL:', `/${typeModel}/filter?${params.toString()}`);
        loadingSpinner.classList.remove('hidden');
        // Make API request
        fetch(`/${typeModel}/filter?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html',
            },
            credentials: 'same-origin' // Include cookies if using Laravel's CSRF protection
        })
            .then(response => {

                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('Error response body:', text);
                        throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
                    });
                }
                return response.text();
            })
            .then(html => {

                casesContainer.innerHTML = html;
                casesContainer.style.opacity = '1';

                // Update URL with current filters
                const newUrl = `${window.location.pathname}?${params.toString()}`;
                window.history.pushState({path: newUrl}, '', newUrl);

                loadingSpinner.classList.add('hidden');

                //reattach event listeners
                if (window.initFlowbite) {
                    window.initFlowbite();
                }

                const descModels = ['subjects', 'trials'];

                if (typeof setupDescListeners !== 'undefined' && descModels.includes(typeModel)) {
                    setupToggleDescListeners();
                }

            })
            .catch(error => {
                console.error('Detailed error:', error);
                casesContainer.style.opacity = '1';
                casesContainer.innerHTML = `
                        <div class="p-4 text-center">
                            <div class="text-red-500 mb-2 font-bold">Error al cargar registros</div>
                        </div>`;

                loadingSpinner.classList.add('hidden');
            });
    }

// Initialize all event listeners
    document.addEventListener('DOMContentLoaded', function () {

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

