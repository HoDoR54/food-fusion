import axios from "axios";
import { getHeaders, setSession } from "../utils/general";

class AutoPopupManager {
    constructor() {
        this.init();
    }

    async init() {
        if (await this.shouldShowPopup()) {
            console.log("should show,", await this.shouldShowPopup());
            setTimeout(() => {
                this.showWelcomePopup();
            }, 1000);
        }
    }

    async shouldShowPopup() {
        try {
            const authCheckRes = await axios.post("/auth/check", {
                headers: getHeaders(),
                credentials: "include",
            });
            if (authCheckRes.data.authenticated) {
                return false;
            }

            const hasConsentRes = await axios.get(
                "/sessions/isPopUpConsent/get",
                {
                    headers: getHeaders(),
                    credentials: "include",
                }
            );
            const shouldShow =
                hasConsentRes.data.value === true &&
                authCheckRes.data.authenticated === false;

            return shouldShow;
        } catch (error) {
            console.error("Error checking popup consent:", error);
            return true;
        }
    }

    showWelcomePopup() {
        const welcomeContent = `
            <div class="flex flex-col items-center justify-center gap-6 p-8 bg-white rounded-xl border-2 border-primary border-dashed max-w-md mx-4">
                <div class="flex flex-col items-center justify-center text-center">
                    <img src="/logo/logo-light.png" alt="Food Fusion Logo" class="w-20 h-20 mb-4">
                    <h2 class="text-primary font-bold text-2xl mb-2">Welcome to Food Fusion!</h2>
                    <p class="text-gray-600 text-base mb-4">
                        Join our community of food enthusiasts. Share recipes, learn new skills, and connect with fellow cooks from around the world.
                    </p>
                </div>
                
                <div class="flex flex-col gap-3 w-full">
                    <button 
                        type="button" 
                        data-action="show-register-popup"
                        class="cursor-pointer w-full px-4 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition font-medium"
                    >
                        Join Our Community
                    </button>
                    <button 
                        type="button" 
                        data-action="show-login-popup"
                        class="cursor-pointer w-full px-4 py-2 bg-transparent border-2 border-primary text-primary rounded-lg hover:bg-primary hover:text-white transition font-medium"
                    >
                        I Already Have an Account
                    </button>
                </div>
                
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <input 
                        type="checkbox" 
                        id="dont-show-again" 
                        class="rounded border-gray-300 text-primary focus:ring-primary"
                    >
                    <label for="dont-show-again" class="cursor-pointer">Don't show this again</label>
                </div>
                
                <button 
                    type="button" 
                    data-action="close-popup"
                    class="text-gray-400 hover:text-gray-600 text-sm underline"
                >
                    Maybe later
                </button>
            </div>
        `;

        // Get the popup manager instance and show the welcome popup
        if (window.popupManager) {
            window.popupManager.showPopUp(welcomeContent);

            // Add event listener for the "don't show again" checkbox after popup is shown
            setTimeout(() => {
                const checkbox = document.getElementById("dont-show-again");
                if (checkbox) {
                    checkbox.addEventListener("change", (e) => {
                        this.handleDoNotShowAgain(e.target.checked);
                    });
                }
            }, 100);
        }
    }

    async handleDoNotShowAgain(checked) {
        try {
            console.log(`Setting popup consent to: ${!checked}`);
            await setSession("isPopUpConsent", !checked);
            console.log(`Popup consent set to: ${!checked}`);
            const sessionSet = await axios.get("/sessions/isPopUpConsent/get", {
                headers: getHeaders(),
                credentials: "include",
            });
            console.log("session set: ", sessionSet.data.value);
        } catch (error) {
            console.error("Error setting popup consent:", error);
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    new AutoPopupManager();
});

window.handleDoNotShowAgain = async function (checked) {
    try {
        const { setSession } = await import("../utils/general");
        await setSession("isPopUpConsent", !checked);
        console.log(`Popup consent set to: ${!checked}`);
    } catch (error) {
        console.error("Error setting popup consent:", error);
    }
};
