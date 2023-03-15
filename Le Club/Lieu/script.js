var lat = 48.787615;
var lon = 2.232943;
var macarte = null;
function initMap() {
  macarte = L.map("map").setView([lat, lon], 11);
  L.tileLayer("https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png", {
    minZoom: 1,
    maxZoom: 20,
  }).addTo(macarte);
  var marker = L.marker([lat, lon]).addTo(macarte);
}
window.onload = function () {
  initMap();
};
