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

    async checkAuthentication() {
        try {
            // Check if user data is available in the page (from blade template)
            // Your app uses window.currentUser in some views
            if (window.currentUser && window.currentUser.id) {
                console.log(
                    "Found authenticated user in window.currentUser:",
                    window.currentUser.id
                );
                return true;
            }

            // Also check window.userData for consistency
            if (window.userData && window.userData.id) {
                console.log(
                    "Found authenticated user in window.userData:",
                    window.userData.id
                );
                return true;
            }

            // Check DOM elements that indicate authentication
            // Look for elements that only exist when user is authenticated
            const userSpecificElements =
                document.querySelector("[data-user-id]") ||
                document.querySelector(".user-avatar") ||
                document.querySelector(".logout-btn") ||
                document.querySelector('a[href*="logout"]');

            if (userSpecificElements) {
                console.log("Found DOM elements indicating authenticated user");
                return true;
            }

            // Check if Laravel's CSRF token exists (indicates potential authentication)
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.log("No CSRF token found, likely not authenticated");
                return false;
            }

            // Fallback: Try to check session for user
            try {
                const userSessionRes = await axios.get("/sessions/user/get", {
                    headers: getHeaders(),
                    credentials: "include",
                });

                const isAuth = !!userSessionRes.data?.value?.id;
                console.log(
                    "Session check result:",
                    isAuth,
                    userSessionRes.data
                );
                return isAuth;
            } catch (sessionError) {
                console.log(
                    "Session user check failed, assuming not authenticated"
                );
                return false;
            }
        } catch (error) {
            console.log("Authentication check failed:", error.message);
            return false;
        }
    }

    async init() {
        console.log("AutoPopupManager initializing...");

        if (await this.shouldShowPopup()) {
            console.log("Popup will be shown in 1 second");
            setTimeout(() => {
                this.showWelcomePopup();
            }, 1000);
        } else {
            console.log("Popup will not be shown");
        }
    }

    async shouldShowPopup() {
        try {
            // Check if user is authenticated first
            const isAuthenticated = await this.checkAuthentication();
            console.log("User is authenticated:", isAuthenticated);

            if (isAuthenticated === true) {
                console.log("User is authenticated, not showing popup");
                return false;
            }

            if (isAuthenticated === null || isAuthenticated === undefined) {
                console.log(
                    "Authentication status unclear, continuing with popup logic"
                );
            }

            // Check localStorage for persistent consent (preferred method)
            const localStorageConsent = localStorage.getItem(
                "popup_consent_dismissed"
            );
            if (localStorageConsent === "true") {
                console.log("Popup consent dismissed in localStorage");
                return false;
            }

            // Fallback: Check session-based consent
            const sessionConsentRes = await axios.get(
                "/sessions/isPopUpConsent/get",
                {
                    headers: getHeaders(),
                    credentials: "include",
                }
            );

            if (sessionConsentRes.data.value === false) {
                console.log("Popup consent dismissed in session");
                return false;
            }

            console.log("Should show popup: true");
            return true;
        } catch (error) {
            console.error("Error checking popup consent:", error);
            // On error, default to not showing popup to avoid spam
            return false;
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
            if (checked) {
                console.log("User opted to not show popup again");

                // Primary storage: localStorage (persists indefinitely)
                localStorage.setItem("popup_consent_dismissed", "true");

                // Secondary storage: session (for current session)
                await setSession("isPopUpConsent", false);

                console.log("Popup consent saved to localStorage and session");
            } else {
                console.log("User wants to see popup again");

                // Remove from localStorage
                localStorage.removeItem("popup_consent_dismissed");

                // Reset session
                await setSession("isPopUpConsent", true);
            }
        } catch (error) {
            console.error("Error setting popup consent:", error);

            // Fallback to localStorage only if session fails
            if (checked) {
                localStorage.setItem("popup_consent_dismissed", "true");
            } else {
                localStorage.removeItem("popup_consent_dismissed");
            }
        }
    }

    // Utility method to clear all popup consent data (useful for testing)
    static clearAllConsentData() {
        localStorage.removeItem("popup_consent_dismissed");
        // Also clear session data if possible
        setSession("isPopUpConsent", null).catch(console.error);
        console.log("All popup consent data cleared");
    }

    // Debug method to test authentication detection
    static async testAuthDetection() {
        const manager = new AutoPopupManager();
        const isAuth = await manager.checkAuthentication();
        console.log("=== Authentication Detection Test ===");
        console.log("window.currentUser:", window.currentUser);
        console.log("window.userData:", window.userData);
        console.log(
            "CSRF Token exists:",
            !!document.querySelector('meta[name="csrf-token"]')
        );
        console.log(
            "User-specific DOM elements found:",
            !!document.querySelector(
                '[data-user-id], .user-avatar, .logout-btn, a[href*="logout"]'
            )
        );
        console.log("Final authentication result:", isAuth);
        console.log("=====================================");
        return isAuth;
    }
}

document.addEventListener("DOMContentLoaded", () => {
    new AutoPopupManager();
});

// Global functions for external usage
window.handleDoNotShowAgain = async function (checked) {
    try {
        if (checked) {
            localStorage.setItem("popup_consent_dismissed", "true");
            await setSession("isPopUpConsent", false);
            console.log("Popup consent dismissed");
        } else {
            localStorage.removeItem("popup_consent_dismissed");
            await setSession("isPopUpConsent", true);
            console.log("Popup consent reset");
        }
    } catch (error) {
        console.error("Error setting popup consent:", error);
        // Fallback to localStorage only
        if (checked) {
            localStorage.setItem("popup_consent_dismissed", "true");
        } else {
            localStorage.removeItem("popup_consent_dismissed");
        }
    }
};

// Expose utility method globally for debugging
window.AutoPopupManager = AutoPopupManager;
