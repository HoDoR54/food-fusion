import axios from "axios";
import { getHeaders, setSession } from "../utils/general";
import {
    createButton,
    createPrimaryButton,
    createSecondaryButton,
    ButtonVariant,
    reinitializeLucideIcons,
} from "../utils/components.js";

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
        // Create main container
        const container = document.createElement("div");
        container.className =
            "flex flex-col items-center justify-center gap-6 p-8 bg-white rounded-xl border-2 border-primary border-dashed max-w-md mx-4";

        // Header section
        const headerSection = document.createElement("div");
        headerSection.className =
            "flex flex-col items-center justify-center text-center";
        headerSection.innerHTML = `
            <img src="/logo/logo-light.png" alt="Food Fusion Logo" class="w-20 h-20 mb-4">
            <h2 class="text-primary font-bold text-2xl mb-2">Welcome to Food Fusion!</h2>
            <p class="text-gray-600 text-base mb-4">
                Join our community of food enthusiasts. Share recipes, learn new skills, and connect with fellow cooks from around the world.
            </p>
        `;
        container.appendChild(headerSection);

        // Buttons section
        const buttonsSection = document.createElement("div");
        buttonsSection.className = "flex flex-col gap-3 w-full";

        const joinButton = createPrimaryButton("Join Our Community", {
            dataAction: "show-register-popup",
            className: "w-full font-medium",
        });

        const loginButton = createSecondaryButton("I Already Have an Account", {
            dataAction: "show-login-popup",
            className: "w-full font-medium",
        });

        buttonsSection.appendChild(joinButton);
        buttonsSection.appendChild(loginButton);
        container.appendChild(buttonsSection);

        // Checkbox section
        const checkboxSection = document.createElement("div");
        checkboxSection.className =
            "flex items-center gap-2 text-sm text-gray-500";
        checkboxSection.innerHTML = `
            <input 
                type="checkbox" 
                id="dont-show-again" 
                class="rounded border-gray-300 text-primary focus:ring-primary"
            >
            <label for="dont-show-again" class="cursor-pointer">Don't show this again</label>
        `;
        container.appendChild(checkboxSection);

        // Maybe later button
        const maybeLaterButton = createButton({
            text: "Maybe later",
            dataAction: "close-popup",
            variant: ButtonVariant.SECONDARY,
            className:
                "text-gray-400 hover:text-gray-600 text-sm underline bg-transparent border-none",
        });

        container.appendChild(maybeLaterButton);

        // Get the popup manager instance and show the welcome popup
        if (window.popupManager) {
            window.popupManager.showPopUp(container.outerHTML);

            // Reinitialize Lucide icons and add event listener for the "don't show again" checkbox
            setTimeout(() => {
                reinitializeLucideIcons();

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
        await setSession("isPopUpConsent", !checked);
        console.log(`Popup consent set to: ${!checked}`);
    } catch (error) {
        console.error("Error setting popup consent:", error);
    }
};
