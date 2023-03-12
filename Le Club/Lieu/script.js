//Menu Burger
var btnMenu = document.getElementsByClassName("btn-menu");
var body = document.body;
for (var i = 0; i < btnMenu.length; i++) {
  btnMenu[i].addEventListener("click", function () {
    body.classList.toggle("menu-open");
  });
}
// On initialise la latitude et la longitude de Paris (centre de la carte)
var lat = 48.787615;
var lon = 2.232943;
var macarte = null;
// Fonction d'initialisation de la carte
function initMap() {
  // Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"
  macarte = L.map("map").setView([lat, lon], 11);
  // Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr
  L.tileLayer("https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png", {
    // Il est toujours bien de laisser le lien vers la source des données
    attribution:
      'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
    minZoom: 1,
    maxZoom: 20,
  }).addTo(macarte);
  // Nous ajoutons un marqueur
  var marker = L.marker([lat, lon]).addTo(macarte);
}
window.onload = function () {
  // Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
  initMap();
};
