/**
 * Sanguline Theme - Announcement Slider JavaScript
 * Elegant slider functionality for homepage announcements
 */
(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        initAnnouncementSlider();
    });

    function initAnnouncementSlider() {
        const slider = document.querySelector('.sanguline_announcement_slider');
        if (!slider) return;

        const track = slider.querySelector('.slider_track');
        const slides = slider.querySelectorAll('.slider_slide');
        const prevBtn = slider.querySelector('.slider_prev');
        const nextBtn = slider.querySelector('.slider_next');
        const dots = slider.querySelectorAll('.slider_dot');

        if (!track || slides.length === 0) return;

        let currentSlide = 0;
        const totalSlides = slides.length;
        let autoPlayInterval = null;

        // Go to specific slide
        function goToSlide(index) {
            // Wrap around
            if (index < 0) index = totalSlides - 1;
            if (index >= totalSlides) index = 0;

            currentSlide = index;

            // Update track position
            track.style.transform = 'translateX(-' + (currentSlide * 100) + '%)';

            // Update active states
            slides.forEach(function(slide, i) {
                slide.classList.toggle('active', i === currentSlide);
            });

            // Update dots
            dots.forEach(function(dot, i) {
                dot.classList.toggle('active', i === currentSlide);
            });
        }

        // Navigation handlers
        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                goToSlide(currentSlide - 1);
                resetAutoPlay();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                goToSlide(currentSlide + 1);
                resetAutoPlay();
            });
        }

        // Dot navigation
        dots.forEach(function(dot, i) {
            dot.addEventListener('click', function() {
                goToSlide(i);
                resetAutoPlay();
            });
        });

        // Auto-play functionality
        function startAutoPlay() {
            if (totalSlides > 1) {
                autoPlayInterval = setInterval(function() {
                    goToSlide(currentSlide + 1);
                }, 5000); // 5 seconds
            }
        }

        function resetAutoPlay() {
            if (autoPlayInterval) {
                clearInterval(autoPlayInterval);
            }
            startAutoPlay();
        }

        // Pause on hover
        slider.addEventListener('mouseenter', function() {
            if (autoPlayInterval) {
                clearInterval(autoPlayInterval);
                autoPlayInterval = null;
            }
        });

        slider.addEventListener('mouseleave', function() {
            startAutoPlay();
        });

        // Swipe support for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        slider.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        slider.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, { passive: true });

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    goToSlide(currentSlide + 1);
                } else {
                    goToSlide(currentSlide - 1);
                }
                resetAutoPlay();
            }
        }

        // Keyboard navigation
        slider.setAttribute('tabindex', '0');
        slider.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                goToSlide(currentSlide - 1);
                resetAutoPlay();
            } else if (e.key === 'ArrowRight') {
                goToSlide(currentSlide + 1);
                resetAutoPlay();
            }
        });

        // Initialize
        goToSlide(0);
        startAutoPlay();
    }
})();
