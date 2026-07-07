<head>
<link rel="stylesheet" href="navBar.css">

<header class="navbar">
    <div class="navbar-container">
        <div class="hamburger" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul class="nav_links1" id="navMenu">
            <li><a href="#paralla">Home</a></li>
            <li><a href="#AboutTag">About</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#gallery">Gallery</a></li>
            <li><a href="#See&Do">See & Do</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </div>
</header>

<!-- Prevent Overlap -->
<style>
    body {
        padding-top: 100px; /* Match navbar height */
    }
</style>

<script>
    function toggleMenu() {
        document.getElementById("navMenu").classList.toggle("active");
    }
</script>
