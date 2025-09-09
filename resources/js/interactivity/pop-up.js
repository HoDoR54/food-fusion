import { getHeaders } from "../utils/general";
import {
    createButton,
    createSubmitButton,
    createIconButton,
    ButtonVariant,
    createHiddenInput,
    reinitializeLucideIcons,
} from "../utils/components.js";
import axios from "axios";
import { EventRegistrationManager } from "../resources/event/event-registration-manager.js";
class PopUpManager {
    constructor() {
        console.log("PopUpManager initialized");
        this.container = document.getElementById("pop-up-container");
        this.overlay = document.getElementById("pop-up-overlay");
        this.currentContent = null;
        this.initEventListeners();
    }

    async initEventListeners() {
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

        document.addEventListener("click", async (event) => {
            if (
                event.target.closest(
                    '[data-action="show-event-registration-popup"]'
                )
            ) {
                const target = event.target.closest(
                    '[data-action="show-event-registration-popup"]'
                );
                const eventId = target.getAttribute("data-event-id");
                event.preventDefault();
                await this.showEventRegistrationPopUp(eventId);
                new EventRegistrationManager(eventId);
            }
        });

        document.addEventListener("click", (event) => {
            if (event.target.closest('[data-action="show-login-popup"]')) {
                event.preventDefault();
                this.showLoginPopUp();
            }
        });

        document.addEventListener("click", (event) => {
            if (event.target.closest('[data-action="show-register-popup"]')) {
                event.preventDefault();
                this.showRegisterPopUp();
            }
        });

        document.addEventListener("click", (event) => {
            if (
                event.target.closest(
                    '[data-action="show-recipe-attempt-popup"]'
                )
            ) {
                event.preventDefault();
                const target = event.target.closest(
                    '[data-action="show-recipe-attempt-popup"]'
                );
                const recipeId =
                    target.getAttribute("data-recipe-id") ||
                    document
                        .querySelector("#recipe-details")
                        ?.getAttribute("data-recipe-id");
                const recipeName =
                    target.getAttribute("data-recipe-name") || "";
                this.showRecipeAttemptPopUp(recipeId, recipeName);
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

    showPopUp(content = null) {
        if (this.container && this.overlay) {
            if (content) {
                this.setContent(content);
            }
            this.container.classList.remove("hidden");
            this.container.classList.add("flex");
            this.overlay.classList.remove("hidden");
        }
    }

    showLoginPopUp() {
        const form = document.createElement("form");
        form.action = "/auth/login";
        form.method = "POST";
        form.className =
            "flex flex-col md:min-w-[400px] items-center justify-center gap-3 p-4 bg-white rounded-xl border-2 border-primary border-dashed";

        const csrfToken =
            document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content") || "";
        const csrfInput = createHiddenInput("_token", csrfToken);
        form.appendChild(csrfInput);

        const header = document.createElement("div");
        header.className = "w-full flex items-center justify-between mb-2";

        const backButton = createButton({
            icon: "arrow-left",
            text: "Back",
            variant: ButtonVariant.SECONDARY,
            dataAction: "close-popup",
            className:
                "flex items-center gap-2 text-primary hover:text-secondary cursor-pointer bg-transparent border-none",
        });

        const closeButton = createIconButton("x", {
            variant: ButtonVariant.SECONDARY,
            dataAction: "close-popup",
            className:
                "stroke-2 w-[1.2rem] h-[1.2rem] text-primary hover:text-secondary cursor-pointer bg-transparent border-none p-0",
        });

        header.appendChild(backButton);
        header.appendChild(closeButton);
        form.appendChild(header);

        const logoSection = document.createElement("div");
        logoSection.className =
            "flex flex-col items-center justify-center mb-2";
        logoSection.innerHTML = `
            <img src="/logo/logo-light.png" alt="Food Fusion Logo" class="w-12 h-12">
            <h2 class="text-primary font-bold text-xl">Welcome Back</h2>
            <p class="text-text/60 text-sm">Sign in to your account</p>
        `;
        form.appendChild(logoSection);

        const fieldsSection = document.createElement("div");
        fieldsSection.className = "flex flex-col gap-3 w-full";
        fieldsSection.innerHTML = `
            <div class="flex flex-col gap-1">
                <label for="identifier" class="text-text/60 text-xs">Email or Username</label>
                <input type="text" id="identifier" name="identifier" required placeholder="johnDoe123@gmail.com" class="bg-secondary/15 border border-gray-300 px-3 py-2 focus:outline-2 focus:outline-primary rounded w-full text-sm" />
            </div>
            <div class="flex flex-col gap-1">
                <label for="password" class="text-text/60 text-xs">Password</label>
                <input type="password" id="password" name="password" required placeholder="password" class="bg-secondary/15 border border-gray-300 px-3 py-2 focus:outline-2 focus:outline-primary rounded w-full text-sm" />
            </div>
            <div class="w-full">
                <a href="/forgot-password" class="text-primary hover:text-secondary underline text-xs">Forgot Password?</a>
            </div>
        `;
        form.appendChild(fieldsSection);

        const buttonsSection = document.createElement("div");
        buttonsSection.className =
            "w-full flex flex-col items-center justify-center gap-3 mt-2";

        const loginButton = createSubmitButton("Login", {
            className: "w-full",
        });

        const registerText = document.createElement("span");
        registerText.className = "text-xs text-text/60";
        registerText.innerHTML = "Don't have an account? ";

        const registerButton = createButton({
            text: "Sign up here",
            type: "button",
            dataAction: "show-register-popup",
            className:
                "text-primary hover:text-secondary underline text-xs bg-transparent border-none cursor-pointer",
        });

        registerText.appendChild(registerButton);
        buttonsSection.appendChild(loginButton);
        buttonsSection.appendChild(registerText);
        form.appendChild(buttonsSection);

        this.showPopUp(form.outerHTML);
        setTimeout(() => reinitializeLucideIcons(), 100);
    }

    showRegisterPopUp() {
        const form = document.createElement("form");
        form.method = "POST";
        form.action = "/auth/register";
        form.className =
            "flex flex-col md:min-w-[450px] gap-3 p-4 items-center justify-center bg-white rounded-xl border-2 border-primary border-dashed";

        const csrfToken =
            document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content") || "";
        const csrfInput = createHiddenInput("_token", csrfToken);
        form.appendChild(csrfInput);

        const header = document.createElement("div");
        header.className = "w-full flex items-center justify-between mb-2";

        const backButton = createButton({
            icon: "arrow-left",
            text: "Back",
            variant: ButtonVariant.SECONDARY,
            dataAction: "close-popup",
            className:
                "flex items-center gap-2 text-primary hover:text-secondary cursor-pointer bg-transparent border-none",
        });

        const closeButton = createIconButton("x", {
            variant: ButtonVariant.SECONDARY,
            dataAction: "close-popup",
            className:
                "stroke-2 w-[1.2rem] h-[1.2rem] text-primary hover:text-secondary cursor-pointer bg-transparent border-none p-0",
        });

        header.appendChild(backButton);
        header.appendChild(closeButton);
        form.appendChild(header);

        const logoSection = document.createElement("div");
        logoSection.className =
            "flex flex-col items-center justify-center mb-2";
        logoSection.innerHTML = `
            <img src="/logo/logo-light.png" alt="Food Fusion Logo" class="w-12 h-12">
            <h2 class="text-primary font-bold text-xl">Join Us</h2>
            <p class="text-gray-600 text-sm">Create your account</p>
        `;
        form.appendChild(logoSection);

        const fieldsSection = document.createElement("div");
        fieldsSection.className = "flex flex-col gap-2 w-full";
        fieldsSection.innerHTML = `
            <div class="flex gap-2">
                <div class="flex flex-col gap-1 w-full">
                    <label for="firstName" class="text-gray-600 text-xs">First Name</label>
                    <input type="text" id="firstName" name="firstName" required placeholder="John" class="bg-secondary/15 border border-gray-300 px-3 py-2 focus:outline-2 focus:outline-primary rounded w-full text-sm" />
                </div>
                <div class="flex flex-col gap-1 w-full">
                    <label for="lastName" class="text-gray-600 text-xs">Last Name</label>
                    <input type="text" id="lastName" name="lastName" required placeholder="Doe" class="bg-secondary/15 border border-gray-300 px-3 py-2 focus:outline-2 focus:outline-primary rounded w-full text-sm" />
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label for="username" class="text-gray-600 text-xs">Username</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    required 
                    placeholder="johndoe123" 
                    pattern="[a-zA-Z0-9_]+"
                    minlength="3"
                    title="Username must be at least 3 characters and contain only letters, numbers, and underscores"
                    class="bg-secondary/15 border border-gray-300 px-3 py-2 focus:outline-2 focus:outline-primary rounded w-full text-sm" 
                />
            </div>

            <div class="flex flex-col gap-1">
                <label for="email" class="text-gray-600 text-xs">Email</label>
                <input type="email" id="email" name="email" required placeholder="john.doe@example.com" class="bg-secondary/15 border border-gray-300 px-3 py-2 focus:outline-2 focus:outline-primary rounded w-full text-sm" />
            </div>

            <div class="flex flex-col gap-1">
                <label for="phoneNumber" class="text-gray-600 text-xs">Phone</label>
                <input type="tel" id="phoneNumber" name="phoneNumber" required placeholder="+95 9 123456789" class="bg-secondary/15 border border-gray-300 px-3 py-2 focus:outline-2 focus:outline-primary rounded w-full text-sm" />
            </div>

            <div class="flex flex-col gap-1">
                <label for="mastery_level" class="text-gray-600 text-xs">Cooking Level</label>
                <div class="relative">
                    <select
                        id="mastery_level"
                        name="mastery_level"
                        required
                        class="bg-secondary/15 border border-gray-300 px-3 pr-8 py-2 focus:outline-2 focus:outline-primary rounded w-full appearance-none cursor-pointer text-gray-700 text-sm"
                    >
                        <option value="" class="text-gray-500" disabled selected>How cooked are you?</option>
                        <option value="beginner">🍳 Beginner</option>
                        <option value="intermediate">👨‍🍳 Intermediate</option>
                        <option value="advanced">🏆 Advanced</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label for="password" class="text-gray-600 text-xs">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required 
                    placeholder="veryVerySecure123!@#" 
                    minlength="6"
                    title="Password must be at least 6 characters long"
                    class="bg-secondary/15 border border-gray-300 px-3 py-2 focus:outline-2 focus:outline-primary rounded w-full text-sm" 
                />
            </div>
        `;
        form.appendChild(fieldsSection);

        const buttonsSection = document.createElement("div");
        buttonsSection.className =
            "w-full flex flex-col items-center justify-center gap-3 mt-2";

        const registerButton = createSubmitButton("Register", {
            className: "w-full",
        });

        const loginText = document.createElement("span");
        loginText.className = "text-xs text-gray-600";
        loginText.innerHTML = "Already have an account? ";

        const loginButton = createButton({
            text: "Log in here",
            type: "button",
            dataAction: "show-login-popup",
            className:
                "text-primary hover:text-secondary underline bg-transparent border-none cursor-pointer text-xs",
        });

        loginText.appendChild(loginButton);
        buttonsSection.appendChild(registerButton);
        buttonsSection.appendChild(loginText);
        form.appendChild(buttonsSection);

        this.showPopUp(form.outerHTML);
        setTimeout(() => reinitializeLucideIcons(), 100);
    }

    showRecipeAttemptPopUp(recipeId, recipeName) {
        const container = document.createElement("div");
        container.className =
            "border-2 border-dashed border-primary/30 bg-white rounded-xl max-w-lg mx-auto min-w-[400px]";

        const header = document.createElement("div");
        header.className =
            "flex items-center justify-between border-b border-dashed border-primary/20 p-4";

        const title = document.createElement("h2");
        title.className = "text-lg font-bold text-primary";
        title.textContent = "Share Your Attempt";

        const closeButton = createIconButton("x", {
            variant: ButtonVariant.SECONDARY,
            dataAction: "close-popup",
            className:
                "stroke-2 w-[1.5rem] h-[1.5rem] text-primary hover:text-secondary cursor-pointer bg-transparent border-none p-0",
        });

        header.appendChild(title);
        header.appendChild(closeButton);
        container.appendChild(header);

        const form = document.createElement("form");
        form.id = "recipe-attempt-form";
        form.className = "p-4 flex flex-col gap-4 w-full";
        form.enctype = "multipart/form-data";

        const csrfToken =
            document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content") || "";
        const csrfInput = createHiddenInput("_token", csrfToken);
        const recipeIdInput = createHiddenInput("recipe_id", recipeId);

        form.appendChild(csrfInput);
        form.appendChild(recipeIdInput);

        const contentSection = document.createElement("div");
        contentSection.className = "flex flex-col gap-4 md:flex-row md:gap-4";
        contentSection.innerHTML = `
            <!-- Photo Upload Section -->
            <div class="flex flex-col gap-2 md:w-1/3">
                <label class="block text-sm text-gray-600 font-medium">
                    <i data-lucide="camera" class="w-4 h-4 inline mr-1"></i>
                    Photo
                </label>
                
                <div id="attempt-image-preview-container" class="hidden relative">
                    <img id="attempt-image-preview" src="#"
                        alt="Attempt Image Preview"
                        class="w-full h-24 object-cover rounded-lg border border-dashed border-primary/30" />
                    <button type="button" id="remove-attempt-image" 
                        class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center transition cursor-pointer">
                        <i data-lucide="x" class="w-3 h-3"></i>
                    </button>
                </div>

                <label id="attempt-image-label" for="attempt-image"
                    class="flex flex-col items-center justify-center gap-2 border border-dashed border-primary/30 rounded-lg bg-primary/10 hover:bg-primary/20 transition cursor-pointer w-full h-24">
                    <i data-lucide="camera" class="w-6 h-6 text-gray-500"></i>
                    <span class="text-xs text-gray-500">Upload photo</span>
                </label>

                <input type="file" id="attempt-image" name="image" accept="image/*" class="hidden" />
            </div>

            <!-- Notes Section -->
            <div class="flex flex-col gap-2 md:w-2/3">
                <label for="attempt-notes" class="block text-sm text-gray-600 font-medium">
                    <i data-lucide="edit-3" class="w-4 h-4 inline mr-1"></i>
                    How did it go?
                </label>
                <textarea
                    required
                    id="attempt-notes" 
                    name="notes" 
                    placeholder="Share your experience, modifications, or tips..."
                    class="border border-dashed border-primary/30 bg-secondary/15 resize-none px-3 py-2 rounded-lg focus:outline-2 focus:outline-primary w-full h-40 text-sm"
                    rows="6"></textarea>
            </div>
        `;
        form.appendChild(contentSection);

        const buttonSection = document.createElement("div");
        buttonSection.className = "flex gap-2 pt-2";

        const shareButton = createSubmitButton("Share", {
            icon: "upload",
            className: "flex-1 font-semibold",
        });

        buttonSection.appendChild(shareButton);
        form.appendChild(buttonSection);
        container.appendChild(form);

        this.showPopUp(container.outerHTML);
        setTimeout(() => {
            reinitializeLucideIcons();

            const imageInput = document.getElementById("attempt-image");
            const imagePreview = document.getElementById(
                "attempt-image-preview"
            );
            const previewContainer = document.getElementById(
                "attempt-image-preview-container"
            );
            const imageLabel = document.getElementById("attempt-image-label");
            const removeButton = document.getElementById(
                "remove-attempt-image"
            );

            if (
                imageInput &&
                imagePreview &&
                previewContainer &&
                imageLabel &&
                removeButton
            ) {
                imageInput.addEventListener("change", function (e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            imagePreview.src = e.target.result;
                            previewContainer.classList.remove("hidden");
                            imageLabel.classList.add("hidden");
                        };
                        reader.readAsDataURL(file);
                    }
                });

                removeButton.addEventListener("click", function () {
                    imageInput.value = "";
                    imagePreview.src = "#";
                    previewContainer.classList.add("hidden");
                    imageLabel.classList.remove("hidden");
                });
            }
        }, 100);
    }

    async showEventRegistrationPopUp(eventId) {
        try {
            console.log("Fetching event data for ID:", eventId);
            const eventData = await axios.get(
                "/api/events/get-by-id/" + eventId,
                {
                    headers: getHeaders(),
                    withCredentials: true,
                }
            );
            console.log(eventData);

            if (eventData.status !== 200) {
                console.error(
                    "Failed to fetch event data:",
                    eventData.data.message
                );
                return;
            }

            const event = eventData.data.data;
            console.log(event);

            const container = document.createElement("div");
            container.className =
                "flex flex-col md:min-w-[500px] items-center justify-center gap-4 p-6 bg-white rounded-xl border-2 border-primary border-dashed";

            const header = document.createElement("div");
            header.className = "w-full flex items-center justify-between mb-2";

            const backButton = createButton({
                icon: "arrow-left",
                text: "Back",
                variant: ButtonVariant.SECONDARY,
                dataAction: "close-popup",
                className:
                    "flex items-center gap-2 text-primary hover:text-secondary cursor-pointer bg-transparent border-none",
            });

            const closeButton = createIconButton("x", {
                variant: ButtonVariant.SECONDARY,
                dataAction: "close-popup",
                className:
                    "stroke-2 w-[1.2rem] h-[1.2rem] text-primary hover:text-secondary cursor-pointer bg-transparent border-none p-0",
            });

            header.appendChild(backButton);
            header.appendChild(closeButton);
            container.appendChild(header);

            const eventInfoSection = document.createElement("div");
            eventInfoSection.className =
                "flex flex-col items-center justify-center mb-4";
            eventInfoSection.innerHTML = `
                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-3">
                    <i data-lucide="calendar-plus" class="w-8 h-8 text-primary"></i>
                </div>
                <h2 class="text-primary font-bold text-2xl text-center">${event.name}</h2>
                <p class="text-text/60 text-sm text-center">Join this amazing event</p>
            `;
            container.appendChild(eventInfoSection);

            const detailsSection = document.createElement("div");
            detailsSection.className =
                "w-full bg-secondary/10 rounded-lg p-4 space-y-3";
            detailsSection.innerHTML = `
                <div class="flex items-center gap-3">
                    <i data-lucide="calendar" class="w-5 h-5 text-primary"></i>
                    <div class="flex flex-col">
                        <span class="text-sm font-medium">Date & Time</span>
                        <span class="text-xs text-text/60">${new Date(
                            event.start_time
                        ).toLocaleDateString()} at ${new Date(
                event.start_time
            ).toLocaleTimeString()}</span>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <i data-lucide="map-pin" class="w-5 h-5 text-primary"></i>
                    <div class="flex flex-col">
                        <span class="text-sm font-medium">Location</span>
                        <span class="text-xs text-text/60">${
                            event.location || "TBA"
                        }</span>
                    </div>
                </div>
                
                ${
                    event.description
                        ? `
                <div class="flex items-start gap-3">
                    <i data-lucide="info" class="w-5 h-5 text-primary mt-0.5"></i>
                    <div class="flex flex-col">
                        <span class="text-sm font-medium">About</span>
                        <p class="text-xs text-text/60">${event.description}</p>
                    </div>
                </div>
                `
                        : ""
                }
            `;
            container.appendChild(detailsSection);

            const form = document.createElement("form");
            form.id = "event-registration-form";
            form.className = "w-full";

            const csrfToken =
                document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute("content") || "";
            const csrfInput = createHiddenInput("_token", csrfToken);
            const eventIdInput = createHiddenInput("event_id", event.id);

            form.appendChild(csrfInput);
            form.appendChild(eventIdInput);

            const buttonSection = document.createElement("div");
            buttonSection.className =
                "w-full flex flex-col items-center justify-center gap-3";

            const registerButton = createSubmitButton("Register for Event", {
                icon: "calendar-plus",
                className: "w-full font-semibold",
            });

            const disclaimer = document.createElement("p");
            disclaimer.className = "text-xs text-text/60 text-center";
            disclaimer.textContent =
                "By registering, you'll receive event updates and reminders.";

            buttonSection.appendChild(registerButton);
            buttonSection.appendChild(disclaimer);
            form.appendChild(buttonSection);
            container.appendChild(form);

            this.showPopUp(container.outerHTML);
            setTimeout(() => reinitializeLucideIcons(), 100);
        } catch (error) {
            console.error("Error fetching event data:", error);

            const errorContainer = document.createElement("div");
            errorContainer.className =
                "flex flex-col md:min-w-[400px] items-center justify-center gap-4 p-6 bg-white rounded-xl border-2 border-red-500 border-dashed";

            const errorHeader = document.createElement("div");
            errorHeader.className = "w-full flex items-center justify-end mb-2";

            const errorCloseButton = createIconButton("x", {
                variant: ButtonVariant.SECONDARY,
                dataAction: "close-popup",
                className:
                    "stroke-2 w-[1.2rem] h-[1.2rem] text-red-500 hover:text-red-700 cursor-pointer bg-transparent border-none p-0",
            });

            errorHeader.appendChild(errorCloseButton);
            errorContainer.appendChild(errorHeader);

            const errorContent = document.createElement("div");
            errorContent.className =
                "flex flex-col items-center justify-center";
            errorContent.innerHTML = `
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                    <i data-lucide="alert-circle" class="w-8 h-8 text-red-500"></i>
                </div>
                <h2 class="text-red-500 font-bold text-xl text-center">Oops!</h2>
                <p class="text-text/60 text-sm text-center">Unable to load event details. Please try again later.</p>
            `;
            errorContainer.appendChild(errorContent);

            const errorCloseButtonMain = createButton({
                text: "Close",
                dataAction: "close-popup",
                variant: ButtonVariant.PRIMARY,
                className: "w-full bg-red-500 hover:bg-red-600 border-red-500",
            });

            errorContainer.appendChild(errorCloseButtonMain);

            this.showPopUp(errorContainer.outerHTML);
            setTimeout(() => reinitializeLucideIcons(), 100);
        }
    }

    setContent(htmlContent) {
        if (this.container) {
            const contentWrapper = this.container.querySelector(
                ".pointer-events-auto"
            );
            if (contentWrapper) {
                contentWrapper.innerHTML = htmlContent;
                this.currentContent = htmlContent;

                if (window.lucide) {
                    window.lucide.createIcons();
                }
            }
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
    window.PopUpManager = new PopUpManager();
});
