
const slides = document.querySelectorAll('.slide');
let currentIndex = 0;

function showSlide(index) {
  const slidesContainer = document.querySelector('.slides');
  slidesContainer.style.transform = `translateX(-${index * 100}%)`;
}

function nextSlide() {
  currentIndex = (currentIndex + 1) % slides.length;
  showSlide(currentIndex);
}

let slideInterval = setInterval(nextSlide, 2000); // Troca de slide a cada 4 segundos

//Menu hamburgui

const menuIcon = document.getElementById("hamburgui");
const navBar = document.getElementById("navBar");

menuIcon.addEventListener("click", function() {
    navBar.classList.toggle("ativo");
});