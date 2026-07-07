const swiper = new Swiper('.swiper', {
    loop: true, // Enables infinite loop
    grabCursor: true, // Cursor changes on hover
    spaceBetween: 30, // Spacing between slides
    slidesPerView: 3, // Show 3 slides at once
    pagination: {
        el: '.swiper-pagination', // Pagination controls
        clickable: true, // Allows clicking on pagination dots
    },
    navigation: {
        nextEl: '.swiper-button-next', // Next button
        prevEl: '.swiper-button-prev', // Prev button
    },
    breakpoints: {
        0: {
            slidesPerView: 1, // 1 slide on small screens
        },
        620: {
            slidesPerView: 2, // 2 slides on medium screens
        },
        1024: {
            slidesPerView: 3, // 3 slides on large screens
        },
    },
});

