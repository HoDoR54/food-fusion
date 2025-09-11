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
            const hasConsentRes = await axios.get(
                "/sessions/isPopUpConsent/get",
                {
                    headers: getHeaders(),
                    credentials: "include",
                }
            );
            console.log("hasConsentRes:", hasConsentRes.data);
            // If isPopUpConsent is true, it means user consents to see popup
            // If null/undefined (first visit) or true, show popup
            // If false, don't show popup (user checked "don't show again")
            const shouldShow = hasConsentRes.data.value !== false;
            console.log("should show popup:", shouldShow);

            return shouldShow;
        } catch (error) {
            console.error("Error checking popup consent:", error);
            return true;
        }
    }

    showWelcomePopup() {
        console.log("showing welcome popup");
        // Create main container
        const container = document.createElement("div");
        container.className =
            "flex flex-col items-center justify-center gap-6 p-8 bg-white rounded-2xl border-2 border-dashed border-primary/20 max-w-md mx-4 shadow-lg";

        // Header section
        const headerSection = document.createElement("div");
        headerSection.className =
            "flex flex-col items-center justify-center text-center";
        headerSection.innerHTML = `
            <img src="/logo/logo-light.png" alt="Food Fusion Logo" class="w-24 h-24 mb-4 rounded-full border-2 border-dashed border-primary/20 p-2 bg-primary/5">
            <h2 class="text-primary font-bold text-2xl mb-3">Welcome to Food Fusion!</h2>
            <p class="text-text/80 text-base mb-4 text-center leading-relaxed">
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
            "flex items-center gap-3 text-sm text-text/70 bg-primary/5 px-4 py-3 rounded-xl border border-dashed border-primary/15";
        checkboxSection.innerHTML = `
            <input 
                type="checkbox" 
                id="dont-show-again" 
                class="rounded border-primary/30 text-primary focus:ring-primary/20 focus:border-primary/50"
            >
            <label for="dont-show-again" class="cursor-pointer font-medium">Don't show this again</label>
        `;
        container.appendChild(checkboxSection);

        // Maybe later button
        const maybeLaterButton = createButton({
            text: "Maybe later",
            dataAction: "close-popup",
            variant: ButtonVariant.SECONDARY,
            className:
                "text-text/60 hover:text-text/80 text-sm underline bg-transparent border-none px-2 py-1",
        });

        container.appendChild(maybeLaterButton);

        // Get the popup manager instance and show the welcome popup
        if (window.PopUpManager) {
            window.PopUpManager.showPopUp(container.outerHTML);

            setTimeout(() => {
                reinitializeLucideIcons();

                const checkbox = document.getElementById("dont-show-again");
                if (checkbox) {
                    checkbox.addEventListener("change", (e) => {
                        this.handleDoNotShowAgain(e.target.checked);
                    });
                }
            }, 100);
        } else {
            console.error("PopUpManager is not available on window.");
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
