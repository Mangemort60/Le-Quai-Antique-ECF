// système filtre par catégories

// récupère-les buttons
const filterButtons = Array.from(document.querySelectorAll('.btn-filter'));

// event listener
filterButtons.forEach(button => {
    button.addEventListener('click', e => {
        // récupère la valeur de l'attribut data-filter du button
        const filter = e.target.dataset.filter;
        // récupère-les elements à modifier par la suite
        const items = document.querySelectorAll('.categorie-section');


        // tout afficher si all est sélectionné
        if (filter === 'all') {
            items.forEach(item => item.style.display = 'block');
        } else {
            // sinon cacher tous les éléments
            items.forEach(item => item.style.display = 'none');

            // et ne montrer que celui qui est sélectionné, pour ça on sélectionne tous les attributs data-category dont la valeur correspond
            // à la catégorie sélectionnée par l'utilisateur et on affiche les éléments.
            const selectedItem = document.querySelector(`[data-category="${filter}"]`);
            selectedItem.style.display = 'block';
        }
    });
});

