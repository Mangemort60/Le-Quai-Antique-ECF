// système filtre par catégories

// récupère les buttons
const filterButtons = Array.from(document.querySelectorAll('.btn-filter'));

// event listener
filterButtons.forEach(button => {
    button.addEventListener('click', e => {
        // récupère la valeur de l'attribut data-filter du boutton
        const filter = e.target.dataset.filter;
        // récupère les élements à modifier par la suite
        const items = document.querySelectorAll('.categorie-section');


        // tout afficher si all est séléctionné
        if (filter === 'all') {
            items.forEach(item => item.style.display = 'block');
        } else {
            // sinon cacher tout les éléments
            items.forEach(item => item.style.display = 'none');

            // et ne montrer que celui qui est séléctionné
            document.querySelectorAll(`[data-category="${filter}"]`).forEach(item => item.style.display = 'block');
        }
    });
});

