import axios from "axios";
import { toastError } from "../../utils/toast";
import { LandingLoader } from "./load-all";
import { setCookie, getCookie } from "../../utils/general";

class CookiesConsentHandler {
    constructor() {
        this.cookiesBanner = document.getElementById("cookie-consent-banner");
        this.initEventListeners();
        this.checkCookiesStatus();
    }

    initEventListeners() {
        const acceptBtn = document.getElementById("accept-cookies-btn");
        if (acceptBtn) {
            acceptBtn.addEventListener("click", async () => {
                await this.acceptCookies();
            });
        }

        const closeBtn = document.getElementById("close-cookie-banner-btn");
        if (closeBtn) {
            closeBtn.addEventListener("click", () => {
                this.closeBanner();
            });
        }
    }

    async acceptCookies() {
        try {
            setCookie("cookies_accepted", "true");
            this.closeBanner();
        } catch (error) {
            toastError(error.message);
        }
    }

    isCookiesAccepted() {
        const cookiesAccepted = getCookie("cookies_accepted");
        return cookiesAccepted === "true";
    }

    checkCookiesStatus() {
        const accepted = this.isCookiesAccepted();
        console.log("Cookies accepted status:", accepted);

        if (!accepted) {
            console.log("Showing cookie banner");
            this.showBanner();
        } else {
            console.log("Cookies already accepted, banner remains hidden");
        }
    }

    showBanner() {
        if (this.cookiesBanner) {
            this.cookiesBanner.classList.remove("hidden");
            this.cookiesBanner.classList.add("block");
        }
    }

    closeBanner() {
        if (this.cookiesBanner) {
            this.cookiesBanner.classList.remove("block");
            this.cookiesBanner.classList.add("hidden");
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    if (window.location.pathname === "/") {
        new LandingLoader();
    }
    new CookiesConsentHandler();
});
