import { setSession, getSession } from "../../utils/general";
import { toastError } from "../../utils/toast";
import { LandingLoader } from "./load-all";

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
            await setSession("cookies_accepted", true);
            this.closeBanner();
        } catch (error) {
            toastError(error.message);
        }
    }

    async isCookiesAccepted() {
        try {
            const cookiesAccepted = await getSession("cookies_accepted");
            return cookiesAccepted === true || cookiesAccepted === "true";
        } catch (error) {
            console.error("Error checking cookies acceptance:", error);
            return false;
        }
    }

    async checkCookiesStatus() {
        try {
            const accepted = await this.isCookiesAccepted();
            console.log("Cookies accepted status:", accepted);

            if (!accepted) {
                console.log("Showing cookie banner");
                this.showBanner();
            } else {
                console.log("Cookies already accepted, banner remains hidden");
            }
        } catch (error) {
            console.error("Error checking cookies status:", error);
            console.log("Error occurred, showing banner as fallback");
            this.showBanner();
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
        new CookiesConsentHandler();
        new LandingLoader();
    }
});
