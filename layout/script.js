// Slider JS
let slideIndex = 0;
const slides = document.querySelector('.slides');
const totalSlides = document.querySelectorAll('.slide').length;

function showSlides(index) {
    if (index >= totalSlides) {
        slideIndex = 0;
    } else if (index < 0) {
        slideIndex = totalSlides - 1;
    } else {
        slideIndex = index;
    }
    const offset = -slideIndex * 100;
    slides.style.transform = `translateX(${offset}%)`;
}

function plusSlides(n) {
    showSlides(slideIndex + n);
}

showSlides(slideIndex);

setInterval(() => {
    slideIndex++;
    showSlides(slideIndex);
}, 3000);

// Testimonials JS
let testimonialItems = Array.from(document.getElementsByClassName('testimonials-item'))

testimonialItems.forEach(element => {
    element.addEventListener('click', function () {
        document.getElementsByClassName('testimonials-item active')[0].classList.remove('active')
        this.classList.add('active')
    })
});

// Navbar toggle
function closeNavbar() {
    document.getElementById('mobile').style.left = '6500px'
}
function openNavbar() {
    const mediaQuery = window.matchMedia('(min-width: 768px)');
    if (mediaQuery.matches) {
        document.getElementById('mobile').style.left = '390px'
    } else {
        document.getElementById('mobile').style.left = '65px'
    }
}

// Modal toggle
function closeModal(id) {
    document.getElementById(id).classList.remove('active')
}
function openModal(id) {
    document.getElementById(id).classList.add('active')
}