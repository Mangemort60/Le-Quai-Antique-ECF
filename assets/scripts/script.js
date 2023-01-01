// système filtre par catégories

// récupère les buttons
const filterButtons = Array.from(document.querySelectorAll('.btn-filter'));

// event listener
filterButtons.forEach(button => {
    button.addEventListener('click', e => {
        // Get the selected filter
        const filter = e.target.dataset.filter;

        // Get the items
        const items = document.querySelectorAll('.categorie-section');

        // Show all items if the "all" filter is selected
        if (filter === 'all') {
            items.forEach(item => item.style.display = 'block');
        } else {
            // Hide all items
            items.forEach(item => item.style.display = 'none');

            // Show only the items with the selected filter
            document.querySelectorAll(`[data-category="${filter}"]`).forEach(item => item.style.display = 'block');
        }
    });
});

