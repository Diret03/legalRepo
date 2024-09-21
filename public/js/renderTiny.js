// renderTiny.js
function applyTailwindStyles(containerId) {
    const container = document.getElementById(containerId);

    // Add 'ml-5' and 'list-disc' to unordered lists
    container.querySelectorAll('ul').forEach(function(ul) {
        ul.classList.add('ml-5', 'list-disc');
    });

    // Add 'ml-5' and 'list-decimal' to ordered lists
    container.querySelectorAll('ol').forEach(function(ol) {
        ol.classList.add('ml-5', 'list-decimal');
    });

    // Add Tailwind classes to anchor (a) elements
    container.querySelectorAll('a').forEach(function(a) {
        a.classList.add('text-blue-600', 'underline');
    });

    // Add Tailwind classes to headings (h1-h6)
    container.querySelectorAll('h1').forEach(function(h1) {
        h1.classList.add('text-3xl', 'font-bold', 'mt-4', 'mb-2');
    });
    container.querySelectorAll('h2').forEach(function(h2) {
        h2.classList.add('text-2xl', 'font-semibold', 'mt-4', 'mb-2');
    });
    container.querySelectorAll('h3').forEach(function(h3) {
        h3.classList.add('text-xl', 'font-semibold', 'mt-3', 'mb-1');
    });
    container.querySelectorAll('h4').forEach(function(h4) {
        h4.classList.add('text-lg', 'font-medium', 'mt-2', 'mb-1');
    });
    container.querySelectorAll('h5').forEach(function(h5) {
        h5.classList.add('text-base', 'font-medium', 'mt-2', 'mb-1');
    });
    container.querySelectorAll('h6').forEach(function(h6) {
        h6.classList.add('text-sm', 'font-medium', 'mt-1', 'mb-1');
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // When the modal opens, modify the content
    document.querySelectorAll('[data-modal-target]').forEach(function(button) {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-target');

            // Call the function and pass the modalId
            applyTailwindStyles(modalId);
        });
    });
});
