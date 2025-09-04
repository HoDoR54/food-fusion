export class Animator {
    constructor() {
        this.lastScrollY = window.scrollY;
        this.initObservers();
        this.observeNewElements();

        setTimeout(() => {
            this.handleInitialElements();
        }, 50);
    }

    initObservers() {
        this.observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        this.animate(entry.target);
                        this.observer.unobserve(entry.target);
                    }
                });
            },
            {
                threshold: 0.1,
                rootMargin: "0px 0px -30px 0px",
            }
        );

        this.observeElements();
    }

    handleInitialElements() {
        const elements = document.querySelectorAll(
            ".animate-on-scroll:not(.animated)"
        );

        elements.forEach((element) => {
            const rect = element.getBoundingClientRect();
            const isInViewport =
                rect.top < window.innerHeight && rect.bottom > 0;

            if (isInViewport) {
                const delay = parseFloat(element.dataset.delay || "0") * 1000;
                setTimeout(() => {
                    this.animate(element);
                    this.observer.unobserve(element);
                }, delay);
            }
        });
    }

    observeElements() {
        const entries = document.querySelectorAll(
            ".animate-on-scroll:not(.animated)"
        );
        entries.forEach((entry) => this.observer.observe(entry));
    }

    observeNewElements() {
        const mutationObserver = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === 1) {
                        if (
                            node.classList &&
                            node.classList.contains("animate-on-scroll") &&
                            !node.classList.contains("animated")
                        ) {
                            this.observer.observe(node);
                        }
                        const childElements =
                            node.querySelectorAll &&
                            node.querySelectorAll(
                                ".animate-on-scroll:not(.animated)"
                            );
                        if (childElements) {
                            childElements.forEach((element) =>
                                this.observer.observe(element)
                            );
                        }
                    }
                });
            });
        });

        mutationObserver.observe(document.body, {
            childList: true,
            subtree: true,
        });
    }

    animate(element) {
        const animationClass =
            element.dataset.animation || "animate-fade-in-up";
        const delay = element.dataset.delay || "0s";
        const duration = element.dataset.duration || "0.5s";

        element.classList.add(animationClass);
        element.classList.add("animated");
        element.style.animationDelay = delay;
        element.style.animationDuration = duration;
    }

    refresh() {
        this.observeElements();
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const animator = new Animator();

    window.FoodFusionAnimator = animator;
});

window.refreshAnimations = function () {
    if (window.FoodFusionAnimator) {
        window.FoodFusionAnimator.refresh();
    }
};
