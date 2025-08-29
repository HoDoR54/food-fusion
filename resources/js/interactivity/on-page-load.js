class OnPageLoad {
    constructor() {
        this.currentPageUrl = document.URL;
    }

    init() {
        this.scrollOnPageLoad();
    }

    scrollOnPageLoad() {
        if (this.currentPageUrl.endsWith("/recipes/new-recipe")) {
            this.scrollToElement(
                document.querySelector("#recipe-form-section")
            );
        }

        if (this.currentPageUrl.endsWith("/contact")) {
            this.scrollToElement(
                document.querySelector("#contact-form-section")
            );
        }
    }

    scrollToElement(element) {
        if (!element) {
            console.log("No element found");
            return;
        }
        element.scrollIntoView({ behavior: "smooth" });
    }
}

document.addEventListener("DOMContentLoaded", () => {
    console.log("OnPageLoad script loaded");
    new OnPageLoad().init();
});
