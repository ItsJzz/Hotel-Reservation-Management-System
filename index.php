<?php
    include("databaseConnection.php");
    include("navBar.php")
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://fonts.googleapis.com/css2?family=Didot&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href = "./index1.css">
    <script>
        function goToSignin(){
            window.location.href ="./login.php";
        }
    </script>
</head>
<script>

    let slideId = 1; // Initialize the first slide ID
    const totalSlides = 6; // Total number of slides (update this number as needed)

    function showSlide(slideId) {
        // Hide all slides
        const slides = document.querySelectorAll('.slide');
        slides.forEach(slide => slide.style.display = 'none');

        // Show the selected slide
        const selectedSlide = document.getElementById(`slider${slideId}`);
        if (selectedSlide) {
            selectedSlide.style.display = 'block';
        }
    }

    // Auto slide function
    function autoSlide() {
        showSlide(slideId);  // Show the current slide
        slideId++;  // Move to the next slide
        if (slideId > totalSlides) {
            slideId = 1;  // Reset to the first slide after the last one
        }
    }

    // Start the auto slide show
    setInterval(autoSlide, 5000);  // Change slide every 3 seconds
</script>
</script>
<body>
    <center>
            <div class="Headings">
                <p class="headingtag" id="HomeTag">Haven Rest Hotel</p>
                <p class="headingtags">-- Your peaceful retreat awaits -- </p>
            </div>

            <section id="paralla">
                <section id="parallax-1" class="snap-section">
                    <div class="parallax-inner">
                    </div>
                </section>
                <h2 id="AboutTag">About</h1>
                <div class="clearfix"></div>
                <p class="AboutUs">At Haven Rest Hotel, we offer an intimate and elegant escape designed to provide a peaceful and relaxing experience. Our boutique hotel combines timeless style with modern comfort, creating a serene atmosphere for every guest. From our beautifully appointed rooms to our attentive and accommodating staff, we ensure each moment of your stay is memorable and effortless. Whether you're here to unwind, celebrate, or simply enjoy a quiet retreat, Haven Rest Hotel promises a tranquil haven where you can recharge in the utmost comfort and luxury.</p>
                <section id="paralla">
                <section id="parallax-2" class="snap-section">
                    <div class="parallax-float-box">
                        <p>Discover comfort and luxury in our rooms. Click below to find your ideal escape!</p>
                        <a href="productsTry.php" class="button">Go to Our Room</a>
                    </div>
                </section>

                <h2 id="ServiceTag">Our Service</h2>
                <p style="letter-spacing: 2px;"class="OurService">At Haven Rest Hotel, we take pride in offering personalized services designed to enhance your stay. From tailored concierge assistance to impeccable room comfort, our dedicated team ensures every detail is taken care of. Experience warmth, luxury, and genuine hospitality with every interaction.</p>
                <h2 id="GalleryTag">Gallery</h2>
                <div class="container swiper">
            <div class="slide-wrapper">
                <div class="card-list swiper-wrapper">
                    <div class="card-item swiper-slide">
                        <img src="./pictures/parallax2.png" alt="" class="user-image">
                    </div>
                    <div class="card-item swiper-slide">
                        <img src="./pictures/parallax1.png" alt="" class="user-image">
                    </div>
                    <div class="card-item swiper-slide">
                        <img src="./pictures/parallax3.jpg" alt="" class="user-image">
                    </div>
                    <div class="card-item swiper-slide">
                        <img src="./pictures/piclumen-1732738173153.png" alt="" class="user-image">
                    </div>
                    <div class="card-item swiper-slide">
                        <img src="./pictures/piclumen-1732728266574.png" alt="" class="user-image">
                    </div>
                    <div class="card-item swiper-slide">
                        <img src="./pictures/piclumen-1732731915834.png" alt="" class="user-image">
                    </div>
                    <div class="card-item swiper-slide">
                        <img src="./pictures/piclumen-1732738173153.png" alt="" class="user-image">
                    </div>
                    <div class="card-item swiper-slide">
                        <img src="./pictures/piclumen-1732728266574.png" alt="" class="user-image">
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>

                    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
                    <script src="script.js"></script>

                <h2 id="thingsToDoTag" style="margin-top:100px;">Things to do</h2>
                <div class="container-to-do">
                    <table>
                        <tr>
                            <th>Wineries Tour</th>
                            <th>Cultural Sites</th>
                            <th>Marketing Tour</th>
                        </tr>
                        <tr>
                            <td>Explore local vineyards, enjoy wine tastings, and discover the art of winemaking on a guided Wineries Tour, perfect for wine lovers and enthusiasts.</td>
                        <td>Visit historic landmarks and cultural gems to immerse yourself in the rich heritage and fascinating history of the region.</td>
                            <td>Join our Marketing Tour for a behind-the-scenes look at the tourism industry, offering valuable insights for marketing professionals and curious travelers.</td>
                        </tr>
                        <tr>
                            <th>Leisure Activities</th>
                            <th>Birds Safari</th>
                            <th>Horse Riding</th>
                        </tr>
                        <tr>
                            <td>Relax and unwind with a variety of leisure activities, from poolside lounging to scenic exploration, perfect for a peaceful retreat.</td>
                            <td>Embark on a Birds Safari to observe rare species in their natural habitats, offering a serene and enriching wildlife experience.</td>
                            <td>Enjoy a guided Horse Riding tour through picturesque landscapes, ideal for both beginners and experienced riders seeking adventure.</td>
                        </tr>
                    </table>
                </div>
                </section>

    </center>
    <div class="multi-pictures">
    <h2>Contact Us</h2>
    <div id="contact-info">
        <p><strong>Address:</strong> 1234 Hotel Road, City Name, Country</p>
        <p><strong>Phone:</strong> +1 (555) 123-4567</p>
        <p><strong>Email:</strong> contact@hotelname.com</p>
        <div class="social-links">
            <p><strong>Follow us:</strong></p>
            <p>Facebook: <a href="#" class="facebook" target="_blank"><i class="fab fa-facebook-f"></i> Haven Rest Hotel</a></p>
            <p>Twitter: <a href="#" class="twitter" target="_blank"><i class="fab fa-twitter"></i> HavenHotel</a></p>
            <p>Instagram: <a href="#" class="instagram" target="_blank"><i class="fab fa-instagram"></i> RestHaven</a></p>
        </div>
    </div>
</div>
</body>
</html>