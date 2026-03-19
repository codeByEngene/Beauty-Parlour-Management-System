const hamburger = document.getElementById("hamburger");
const sidebar = document.getElementById("sidebar");
const mainContent = document.querySelector(".main-content");

// Sidebar is OPEN by default — add 'active' class on page load
sidebar.classList.add("active");
mainContent.classList.add("shifted");

// Only toggle when hamburger is clicked
hamburger.addEventListener("click", function () {
    sidebar.classList.toggle("active");
    mainContent.classList.toggle("shifted");
});

// Submenu toggle — only on menu link click
document.querySelectorAll(".menu > a").forEach(function (menu) {
    menu.addEventListener("click", function (e) {
        e.preventDefault();
        this.parentElement.classList.toggle("active");
    });
});