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
            <li><a href="#HomeTag">Home</a></li>
            <li><a href="#AboutTag">About</a></li>
            <li><a href="#ServiceTag">Services</a></li>
            <li><a href="#GalleryTag">Gallery</a></li>
            <li><a href="#thingsToDoTag">See & Do</a></li>
            <li><a href="#contact-info">Contact</a></li>
            <li><button onclick="window.location.href='home.php'">Admin</button></li>
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
