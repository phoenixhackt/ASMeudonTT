const competitions = document.getElementById("competitions");

fetch("https://api.fftt.com/competitions")
  .then(response => response.json())
  .then(data => {
    data.forEach(competition => {
      const li = document.createElement("li");
      li.textContent = competition.name;
      competitions.appendChild(li);
    });
  })
  .catch(error => console.error(error));
