class PopUpManager {
    constructor() {
        this.container = document.getElementById("pop-up-container");
        this.overlay = document.getElementById("pop-up-overlay");

        if (!this.container) {
            console.warn("PopUpManager: pop-up-container not found");
        }
        if (!this.overlay) {
            console.warn("PopUpManager: pop-up-overlay not found");
        }

        this.initEventListeners();
        this.checkAutoShow();
    }

    initEventListeners() {
        document.addEventListener("click", (event) => {
            if (event.target.closest('[data-action="close-popup"]')) {
                event.preventDefault();
                this.closePopUp();
            }
        });

        document.addEventListener("click", (event) => {
            if (event.target.closest('[data-action="show-popup"]')) {
                event.preventDefault();
                this.showPopUp();
            }
        });

        if (this.overlay) {
            this.overlay.addEventListener("click", (event) => {
                this.closePopUp();
            });
        }

        if (this.container) {
            this.container.addEventListener("click", (event) => {
                if (event.target === this.container) {
                    this.closePopUp();
                }
            });
        }
    }

    // TO-DO: enhance this logic
    checkAutoShow() {
        if (this.container && this.container.hasAttribute("data-auto-show")) {
            const currentPath = window.location.pathname;
            const isHomePage = currentPath === "/" || currentPath === "";

            if (isHomePage) {
                this.showPopUp();
            }
        }
    }

    showPopUp() {
        if (this.container && this.overlay) {
            this.container.classList.remove("hidden");
            this.container.classList.add("flex");
            this.overlay.classList.remove("hidden");
        }
    }

    closePopUp() {
        if (this.container && this.overlay) {
            this.container.classList.add("hidden");
            this.container.classList.remove("flex");
            this.overlay.classList.add("hidden");
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    new PopUpManager();
});
