const sections = document.querySelectorAll(".section");

sections.forEach((section) => {
  section.addEventListener("mouseover", () => {
    section.style.transform = "scale(1.05)";
  });
  section.addEventListener("mouseout", () => {
    section.style.transform = "scale(1)";
  });
});
