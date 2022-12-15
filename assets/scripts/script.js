console.log('javascript run again')


const leBouton = document.querySelector("#button01");
const title = document.querySelector('h1')

leBouton.onclick = () => {
title.style.color = "green";
}