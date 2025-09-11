export class EventsCarousel {
    constructor() {
        this.currentSlide = 0;
        this.totalSlides = 0;
        this.slidesToShow = 1;
        this.autoplayInterval = null;
        this.autoplayDelay = 5000; // 5 seconds

        this.initializeCarousel();
    }

    initializeCarousel() {
        this.calculateSlidesToShow();
        this.setupEventListeners();
        this.startAutoplay();

        // Recalculate on window resize
        window.addEventListener("resize", () => {
            this.calculateSlidesToShow();
            this.updateCarousel();
        });
    }

    calculateSlidesToShow() {
        const width = window.innerWidth;
        if (width >= 1024) {
            this.slidesToShow = 3; // lg screens
        } else if (width >= 768) {
            this.slidesToShow = 2; // md screens
        } else {
            this.slidesToShow = 1; // sm screens
        }
    }

    setupEventListeners() {
        const prevButton = document.getElementById("carousel-prev");
        const nextButton = document.getElementById("carousel-next");

        if (prevButton) {
            prevButton.addEventListener("click", () => {
                this.stopAutoplay();
                this.prevSlide();
                this.startAutoplay();
            });
        }

        if (nextButton) {
            nextButton.addEventListener("click", () => {
                this.stopAutoplay();
                this.nextSlide();
                this.startAutoplay();
            });
        }

        // Touch/swipe support
        const track = document.getElementById("events-carousel-track");
        if (track) {
            let startX = 0;
            let isDragging = false;

            track.addEventListener("touchstart", (e) => {
                startX = e.touches[0].clientX;
                isDragging = true;
                this.stopAutoplay();
            });

            track.addEventListener("touchmove", (e) => {
                if (!isDragging) return;
                e.preventDefault();
            });

            track.addEventListener("touchend", (e) => {
                if (!isDragging) return;
                isDragging = false;

                const endX = e.changedTouches[0].clientX;
                const diffX = startX - endX;

                if (Math.abs(diffX) > 50) {
                    // Minimum swipe distance
                    if (diffX > 0) {
                        this.nextSlide();
                    } else {
                        this.prevSlide();
                    }
                }
                this.startAutoplay();
            });

            // Mouse drag support
            track.addEventListener("mousedown", (e) => {
                startX = e.clientX;
                isDragging = true;
                this.stopAutoplay();
                e.preventDefault();
            });

            track.addEventListener("mousemove", (e) => {
                if (!isDragging) return;
                e.preventDefault();
            });

            track.addEventListener("mouseup", (e) => {
                if (!isDragging) return;
                isDragging = false;

                const endX = e.clientX;
                const diffX = startX - endX;

                if (Math.abs(diffX) > 50) {
                    if (diffX > 0) {
                        this.nextSlide();
                    } else {
                        this.prevSlide();
                    }
                }
                this.startAutoplay();
            });

            track.addEventListener("mouseleave", () => {
                if (isDragging) {
                    isDragging = false;
                    this.startAutoplay();
                }
            });
        }
    }

    updateCarouselData(events) {
        this.totalSlides = Math.max(0, events.length - this.slidesToShow + 1);
        this.currentSlide = 0;
        this.updateCarousel();
        this.updateIndicators();
        this.showControls();
    }

    updateCarousel() {
        const track = document.getElementById("events-carousel-track");
        if (track && this.totalSlides > 0) {
            const translateX = -(this.currentSlide * (100 / this.slidesToShow));
            track.style.transform = `translateX(${translateX}%)`;
        }
        this.updateIndicators();
    }

    nextSlide() {
        if (this.totalSlides <= 1) return;

        this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        this.updateCarousel();
    }

    prevSlide() {
        if (this.totalSlides <= 1) return;

        this.currentSlide =
            this.currentSlide === 0
                ? this.totalSlides - 1
                : this.currentSlide - 1;
        this.updateCarousel();
    }

    goToSlide(slideIndex) {
        if (slideIndex >= 0 && slideIndex < this.totalSlides) {
            this.currentSlide = slideIndex;
            this.updateCarousel();
        }
    }

    updateIndicators() {
        const indicatorsContainer = document.getElementById(
            "carousel-indicators"
        );
        if (!indicatorsContainer || this.totalSlides <= 1) return;

        indicatorsContainer.innerHTML = "";

        for (let i = 0; i < this.totalSlides; i++) {
            const dot = document.createElement("button");
            dot.className = `w-3 h-3 rounded-full transition-all duration-200 ${
                i === this.currentSlide
                    ? "bg-primary"
                    : "bg-primary/30 hover:bg-primary/50"
            }`;
            dot.addEventListener("click", () => {
                this.stopAutoplay();
                this.goToSlide(i);
                this.startAutoplay();
            });
            indicatorsContainer.appendChild(dot);
        }
    }

    showControls() {
        const prevButton = document.getElementById("carousel-prev");
        const nextButton = document.getElementById("carousel-next");
        const indicators = document.getElementById("carousel-indicators");

        if (this.totalSlides > 1) {
            if (prevButton) prevButton.classList.remove("opacity-0");
            if (nextButton) nextButton.classList.remove("opacity-0");
            if (indicators) indicators.classList.remove("opacity-0");
        } else {
            if (prevButton) prevButton.classList.add("opacity-0");
            if (nextButton) nextButton.classList.add("opacity-0");
            if (indicators) indicators.classList.add("opacity-0");
        }
    }

    startAutoplay() {
        if (this.totalSlides <= 1) return;

        this.stopAutoplay();
        this.autoplayInterval = setInterval(() => {
            this.nextSlide();
        }, this.autoplayDelay);
    }

    stopAutoplay() {
        if (this.autoplayInterval) {
            clearInterval(this.autoplayInterval);
            this.autoplayInterval = null;
        }
    }

    destroy() {
        this.stopAutoplay();
        // Remove event listeners if needed
    }
}
