/**
 * Mobile Menu Toggle with Smooth Animation
 */
class MobileMenuToggle {
    constructor() {
        this.mobileMenu = null;
        this.menuIcon = null;
        this.isAnimating = false;
        this.init();
    }

    init() {
        document.addEventListener("DOMContentLoaded", () => {
            this.mobileMenu = document.getElementById("mobile-menu");
            this.menuIcon = document.getElementById("menu-icon");

            if (this.mobileMenu) {
                this.setupMenu();
            }
        });
    }

    setupMenu() {
        // Set initial state
        this.mobileMenu.style.maxHeight = "0px";
        this.mobileMenu.style.overflow = "hidden";
        this.mobileMenu.style.transition =
            "max-height 0.3s ease-in-out, opacity 0.3s ease-in-out";
        this.mobileMenu.classList.remove("hidden");
        this.mobileMenu.style.opacity = "0";
    }

    toggle() {
        if (this.isAnimating || !this.mobileMenu) return;

        this.isAnimating = true;
        const isOpen = this.mobileMenu.style.maxHeight !== "0px";

        if (isOpen) {
            this.close();
        } else {
            this.open();
        }
    }

    open() {
        // Get the natural height of the menu
        this.mobileMenu.style.maxHeight = "none";
        const height = this.mobileMenu.scrollHeight;
        this.mobileMenu.style.maxHeight = "0px";

        // Force reflow
        this.mobileMenu.offsetHeight;

        // Animate open
        this.mobileMenu.style.maxHeight = height + "px";
        this.mobileMenu.style.opacity = "1";

        // Update icon
        if (this.menuIcon) {
            this.menuIcon.setAttribute("data-lucide", "x");
            if (window.lucide) {
                window.lucide.createIcons();
            }
        }

        setTimeout(() => {
            this.mobileMenu.style.maxHeight = "none";
            this.isAnimating = false;
        }, 300);
    }

    close() {
        // Get current height
        const height = this.mobileMenu.scrollHeight;
        this.mobileMenu.style.maxHeight = height + "px";

        // Force reflow
        this.mobileMenu.offsetHeight;

        // Animate close
        this.mobileMenu.style.maxHeight = "0px";
        this.mobileMenu.style.opacity = "0";

        // Update icon
        if (this.menuIcon) {
            this.menuIcon.setAttribute("data-lucide", "menu");
            if (window.lucide) {
                window.lucide.createIcons();
            }
        }

        setTimeout(() => {
            this.isAnimating = false;
        }, 300);
    }
}

// Initialize mobile menu toggle
const mobileMenuToggle = new MobileMenuToggle();

// Make toggle function globally available
window.toggleMobileMenu = () => {
    mobileMenuToggle.toggle();
};
