/* Script pour faire défiler les images dans le bandeau futuriste */
let bandeau = document.getElementById("bandeau");
let images = bandeau.getElementsByTagName("img");
let index = 0;

setInterval(() => {
  images[index].style.display = "none";
  index = (index + 1) % images.length;
  images[index].style.display = "inline-block";
}, 5000); // Changer la valeur pour modifier la vitesse de défilement
bandeau.style.display = "block";
images[0].style.display = "inline-block";
