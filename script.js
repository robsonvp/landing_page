// Variável que armazena o índice da imagem atual
let currentSlide = 0;
// Seleciona todas as imagens do carousel
const slides = document.querySelectorAll(".carousel img");

// Função para mostrar uma imagem do carousel
function showSlide() {
    slides.forEach((slide, index) => {
        if (index === currentSlide) {
            slide.style.transform = "translateX(0)";
        } else {
            slide.style.transform = "translateX(100%)";
        }
    });
}

// Função para avançar para a próxima imagem do carousel
function nextSlide() {
    currentSlide++;
    if (currentSlide >= slides.length) {
        currentSlide = 0;
    }
    showSlide();
}

// Função para voltar para a imagem anterior do carousel
function prevSlide() {
    currentSlide--;
    if (currentSlide < 0) {
        currentSlide = slides.length - 1;
    }
    showSlide();
}

// Função para avançar automaticamente para a próxima imagem do carousel
function autoSlide() {
    nextSlide();
}

setInterval(autoSlide, 2000); // Avança automaticamente a cada 2 segundos

showSlide();
