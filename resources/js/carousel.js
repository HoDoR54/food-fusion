class Carousel {
    constructor(element) {
        this.carousel = element;
        this.track = element.querySelector(".carousel-track");
        this.slides = [...element.querySelectorAll(".carousel-slide")];
        this.prevButton = element.querySelector(".carousel-prev");
        this.nextButton = element.querySelector(".carousel-next");
        this.indicators = [...element.querySelectorAll(".carousel-indicator")];

        this.currentIndex = 0;
        this.slideWidth = 0;
        this.slidesVisible = 5;
        this.maxIndex = 0;
        this.isTransitioning = false;

        this.init();
    }

    init() {
        this.setupEventListeners();
        this.updateSlideWidth();
        this.updateCarousel();

        // Auto-resize handler
        window.addEventListener("resize", () => {
            this.updateSlideWidth();
            this.updateCarousel();
        });

        // Auto-play functionality (every 2 seconds)
        this.startAutoPlay();

        // Pause auto-play on hover
        this.carousel.addEventListener("mouseenter", () => this.stopAutoPlay());
        this.carousel.addEventListener("mouseleave", () =>
            this.startAutoPlay()
        );
    }

    setupEventListeners() {
        this.prevButton.addEventListener("click", () => this.prevSlide());
        this.nextButton.addEventListener("click", () => this.nextSlide());

        this.indicators.forEach((indicator, index) => {
            indicator.addEventListener("click", () => this.goToSlide(index));
        });
    }

    updateSlideWidth() {
        const containerWidth = this.carousel.offsetWidth;
        const padding = 32; // Account for container padding
        const availableWidth = containerWidth - padding;

        // Responsive slides visible
        if (window.innerWidth >= 1280) {
            this.slidesVisible = Math.min(5, this.slides.length); // xl screens
        } else if (window.innerWidth >= 1024) {
            this.slidesVisible = Math.min(4, this.slides.length); // lg screens
        } else if (window.innerWidth >= 768) {
            this.slidesVisible = Math.min(3, this.slides.length); // md screens
        } else if (window.innerWidth >= 640) {
            this.slidesVisible = Math.min(2, this.slides.length); // sm screens
        } else {
            this.slidesVisible = 1; // mobile
        }

        // Calculate the maximum index we can scroll to
        this.maxIndex = Math.max(0, this.slides.length - this.slidesVisible);

        this.slideWidth = availableWidth / this.slidesVisible;

        this.slides.forEach((slide) => {
            slide.style.minWidth = `${this.slideWidth}px`;
            slide.style.maxWidth = `${this.slideWidth}px`;
        });
    }

    prevSlide() {
        if (this.isTransitioning) return;
        // Only go back if not at the first slide
        if (this.currentIndex > 0) {
            this.currentIndex = this.currentIndex - 1;
            this.updateCarousel();
        }
    }

    nextSlide() {
        if (this.isTransitioning) return;
        // Only go forward if not at the maximum index
        if (this.currentIndex < this.maxIndex) {
            this.currentIndex = this.currentIndex + 1;
            this.updateCarousel();
        }
    }

    goToSlide(index) {
        if (this.isTransitioning || index === this.currentIndex) return;
        this.currentIndex = index;
        this.updateCarousel();
    }

    updateCarousel() {
        this.isTransitioning = true;

        const translateX = -this.currentIndex * this.slideWidth;
        this.track.style.transform = `translateX(${translateX}px)`;

        // Update indicators
        this.indicators.forEach((indicator, index) => {
            if (index === this.currentIndex) {
                indicator.classList.add(
                    "active",
                    "bg-primary",
                    "scale-125",
                    "shadow-md"
                );
                indicator.classList.remove("bg-secondary/50");
            } else {
                indicator.classList.remove(
                    "active",
                    "bg-primary",
                    "scale-125",
                    "shadow-md"
                );
                indicator.classList.add("bg-secondary/50");
            }
        });

        // Update button states
        this.updateButtonStates();

        setTimeout(() => {
            this.isTransitioning = false;
        }, 500);
    }

    updateButtonStates() {
        const prevBtn = this.prevButton.querySelector("button");
        const nextBtn = this.nextButton.querySelector("button");

        // Disable/enable previous button
        if (this.currentIndex <= 0) {
            prevBtn.disabled = true;
            prevBtn.classList.add("opacity-50", "cursor-not-allowed");
        } else {
            prevBtn.disabled = false;
            prevBtn.classList.remove("opacity-50", "cursor-not-allowed");
        }

        // Disable/enable next button
        if (this.currentIndex >= this.maxIndex) {
            nextBtn.disabled = true;
            nextBtn.classList.add("opacity-50", "cursor-not-allowed");
        } else {
            nextBtn.disabled = false;
            nextBtn.classList.remove("opacity-50", "cursor-not-allowed");
        }
    }

    startAutoPlay() {
        this.autoPlayInterval = setInterval(() => {
            // If we're at the end, stop auto-play or go back to start
            if (this.currentIndex >= this.maxIndex) {
                this.goToSlide(0);
            } else {
                this.nextSlide();
            }
        }, 2000); // Auto-scroll every 2 seconds
    }

    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }
}

// Initialize carousels when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
    const carousels = document.querySelectorAll(".carousel");
    carousels.forEach((carousel) => new Carousel(carousel));
});

// Export for use in other modules
if (typeof module !== "undefined" && module.exports) {
    module.exports = Carousel;
}
