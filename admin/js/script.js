document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.getElementById("hamburger");
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.getElementById("main-content"); // Fixed: uses ID now

    // 1. Sidebar is OPEN by default
    if (sidebar && mainContent) {
        sidebar.classList.add("active");
        mainContent.classList.add("shifted");
    }

    // 2. Click Event
    if (hamburger) {
        hamburger.addEventListener("click", function () {
            sidebar.classList.toggle("active");
            mainContent.classList.toggle("shifted");
        });
    }

    // 3. Submenu toggle
    document.querySelectorAll(".menu > a").forEach(function (menu) {
        menu.addEventListener("click", function (e) {
            const parent = this.parentElement;
            if (parent.querySelector('.submenu')) { // Check if submenu exists
                e.preventDefault();
                parent.classList.toggle("active");
            }
        });
    });
});

function updateNotificationCount() {
    // This assumes you have a small file that just returns the count number
    fetch('get_new_count.php')
        .then(response => response.text())
        .then(count => {
            const badge = document.querySelector('.notification-badge');
            if (parseInt(count) > 0) {
                if (badge) {
                    badge.textContent = count;
                } else {
                    // Refresh if badge needs to be created
                    location.reload(); 
                }
            }
        });
}

// Check every 1 minute
setInterval(updateNotificationCount, 60000);