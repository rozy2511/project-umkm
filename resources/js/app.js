import './bootstrap';

function toggleMenu() {
    const menu = document.querySelector('.nav-links');
    menu.classList.toggle('active');
}

// NAVBAR SCROLL EFFECT
window.addEventListener("scroll", function () {
    const navbar = document.getElementById("navbar");
    
    if (window.scrollY > 30) {
        navbar.classList.add("scrolled");
        navbar.classList.remove("transparent");
    } else {
        navbar.classList.add("transparent");
        navbar.classList.remove("scrolled");
    }
});
