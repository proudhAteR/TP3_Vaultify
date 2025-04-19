const navbar = document.getElementById("nav");
const element = navbar?.closest("li");
const path = window.location.pathname;

export default function listen() {
    if (!navbar) return;

    navbar.addEventListener("click", handleLinks);
    document.addEventListener("DOMContentLoaded", activateRow);
}

function activateRow() {
    let navLinks = navbar.querySelectorAll("li");

    navLinks.forEach(function (link) {
        if (link.querySelector("a").getAttribute("href") === path) {
            link.classList.add("active");
        }
    });
}

function handleLinks() {
    const activeItems = document.querySelectorAll("li.active");

    activeItems.forEach(function (item) {
        item.classList.remove("active");
    });
    element.classList.add("active");
}