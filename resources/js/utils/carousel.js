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
        this.slidesVisible = parseInt(element.dataset.slidesVisible) || 5;
        this.autoPlay = element.dataset.autoPlay === "true";
        this.autoPlayDelay = parseInt(element.dataset.autoPlayInterval) || 2000;
        this.maxIndex = 0;
        this.isTransitioning = false;
        this.autoPlayInterval = null;

        this.init();
    }

    init() {
        this.setupEventListeners();
        this.updateSlideWidth();
        this.updateCarousel();

        window.addEventListener("resize", () => {
            this.updateSlideWidth();
            this.updateCarousel();
        });

        if (this.autoPlay) {
            this.startAutoPlay();
        }

        this.carousel.addEventListener("mouseenter", () => this.stopAutoPlay());
        this.carousel.addEventListener("mouseleave", () => {
            if (this.autoPlay) {
                this.startAutoPlay();
            }
        });
    }

    setupEventListeners() {
        if (this.prevButton) {
            this.prevButton.addEventListener("click", () => this.prevSlide());
        }
        if (this.nextButton) {
            this.nextButton.addEventListener("click", () => this.nextSlide());
        }

        this.indicators.forEach((indicator, index) => {
            indicator.addEventListener("click", () => this.goToSlide(index));
        });
    }

    updateSlideWidth() {
        const containerWidth = this.carousel.offsetWidth;
        const padding = 32;
        const availableWidth = containerWidth - padding;

        if (window.innerWidth >= 1280) {
            this.slidesVisible = Math.min(5, this.slides.length);
        } else if (window.innerWidth >= 1024) {
            this.slidesVisible = Math.min(4, this.slides.length);
        } else if (window.innerWidth >= 768) {
            this.slidesVisible = Math.min(3, this.slides.length);
        } else if (window.innerWidth >= 640) {
            this.slidesVisible = Math.min(2, this.slides.length);
        } else {
            this.slidesVisible = 1;
        }

        this.maxIndex = Math.max(0, this.slides.length - this.slidesVisible);

        this.slideWidth = availableWidth / this.slidesVisible;

        this.slides.forEach((slide) => {
            slide.style.minWidth = `${this.slideWidth}px`;
            slide.style.maxWidth = `${this.slideWidth}px`;
        });
    }

    prevSlide() {
        if (this.isTransitioning) return;
        if (this.currentIndex > 0) {
            this.currentIndex = this.currentIndex - 1;
            this.updateCarousel();
        }
    }

    nextSlide() {
        if (this.isTransitioning) return;
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

        this.updateButtonStates();

        setTimeout(() => {
            this.isTransitioning = false;
        }, 500);
    }

    updateButtonStates() {
        if (!this.prevButton || !this.nextButton) return;

        const prevBtn = this.prevButton.querySelector("button");
        const nextBtn = this.nextButton.querySelector("button");

        if (!prevBtn || !nextBtn) return;

        if (this.currentIndex <= 0) {
            prevBtn.disabled = true;
            prevBtn.classList.add("opacity-50", "cursor-not-allowed");
        } else {
            prevBtn.disabled = false;
            prevBtn.classList.remove("opacity-50", "cursor-not-allowed");
        }

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
            if (this.currentIndex >= this.maxIndex) {
                this.goToSlide(0);
            } else {
                this.nextSlide();
            }
        }, this.autoPlayDelay);
    }

    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const carousels = document.querySelectorAll(".carousel");
    carousels.forEach((carousel) => new Carousel(carousel));
});

if (typeof module !== "undefined" && module.exports) {
    module.exports = Carousel;
}
