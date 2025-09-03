import axios from "axios";
import { toastError, toastSuccess } from "../../utils/toast";
import { getHeaders } from "../../utils/general";

export class RecipeAttemptManager {
    constructor() {
        console.log("RecipeAttemptManager initialized");
        this.init();
    }

    init() {
        this.addEventListeners();
    }

    addEventListeners() {
        document.addEventListener("submit", (event) => {
            if (event.target.matches("#recipe-attempt-form")) {
                event.preventDefault();
                console.log("event listener hit");
                this.handleAttemptSubmission(event.target);
            }
        });
    }

    async handleAttemptSubmission(form) {
        const formData = new FormData(form);
        const recipeId = formData.get("recipe_id");

        if (!recipeId) {
            toastError("Recipe ID not found");
            return;
        }

        try {
            const response = await axios.post(
                `/recipes/attempts/create`,
                formData,
                {
                    headers: getHeaders(),
                    withCredentials: true,
                }
            );

            console.log("Response status:", response.status);

            if (response.status === 401) {
                window.location.href = "/login";
                return;
            }

            if (response.status === 201) {
                console.log("Recipe attempt created successfully");

                // Close popup
                if (
                    window.PopUpManager &&
                    typeof window.PopUpManager.closePopUp === "function"
                ) {
                    window.PopUpManager.closePopUp();
                } else {
                    console.error(
                        "PopUpManager not found or closePopUp method missing"
                    );
                }

                // Show success toast
                toastSuccess(
                    response.data?.message ||
                        "Recipe attempt created successfully!"
                );

                // Update the UI to reflect the new attempt
                this.updateAttemptsSection(formData);
            } else {
                console.log("Unexpected status code:", response.status);
            }
        } catch (error) {
            console.error("Error creating recipe attempt:", error);

            if (error.response?.status === 401) {
                window.location.href = "/login";
                return;
            }

            const message =
                error.response?.data?.message ||
                "Failed to create recipe attempt";
            toastError(message);
        }
    }

    updateAttemptsSection(formData) {
        console.log("Starting UI update...");
        const attemptsGrid = document.querySelector(".grid.md\\:grid-cols-4");

        if (!attemptsGrid) {
            console.log("Attempts grid not found, refreshing page...");
            window.location.reload();
            return;
        }

        console.log("Attempts grid found:", attemptsGrid);

        const noAttemptsMessage =
            attemptsGrid.querySelector(".md\\:col-span-4");
        if (noAttemptsMessage) {
            console.log("Removing no attempts message...");
            noAttemptsMessage.remove();
        }

        console.log("Creating new attempt card...");
        const newAttemptCard = this.createAttemptCard(formData);
        console.log("New attempt card HTML:", newAttemptCard);

        const existingAttempts = attemptsGrid.querySelectorAll(
            "div.border-2.border-dashed.border-primary\\/20.rounded-lg.overflow-hidden:not(.md\\:col-span-4)"
        );
        console.log("Existing attempts found:", existingAttempts.length);

        if (existingAttempts.length >= 4) {
            console.log("Removing last attempt to make room...");
            existingAttempts[existingAttempts.length - 1].remove();
        }

        console.log("Adding new attempt to grid...");
        attemptsGrid.insertAdjacentHTML("afterbegin", newAttemptCard);

        const newCard = attemptsGrid.querySelector(".new-attempt");
        if (newCard) {
            console.log("Animating new card...");
            newCard.style.opacity = "0";
            newCard.style.transform = "translateY(20px)";
            newCard.classList.remove("new-attempt");

            setTimeout(() => {
                newCard.style.transition =
                    "opacity 0.3s ease, transform 0.3s ease";
                newCard.style.opacity = "1";
                newCard.style.transform = "translateY(0)";
            }, 10);
        } else {
            console.log("New card not found for animation");
        }

        if (typeof lucide !== "undefined") {
            console.log("Reinitializing Lucide icons...");
            lucide.createIcons();
        }

        console.log("UI update completed");
    }

    createAttemptCard(formData) {
        const notes = formData.get("notes") || "";
        const imageFile = formData.get("image");
        const userName = window.currentUser?.name || "You"; // Assuming you have current user info available

        // Create a temporary URL for the uploaded image if available
        const imageUrl =
            imageFile && imageFile.size > 0
                ? URL.createObjectURL(imageFile)
                : "/images/example-recipe.jpg";

        const truncatedNotes =
            notes.length > 80 ? notes.substring(0, 80) + "..." : notes;
        const notesDisplay = notes
            ? `<p class="text-sm text-text/70 text-center leading-relaxed">${truncatedNotes}</p>`
            : `<p class="text-sm text-text/70 text-center leading-relaxed italic">No notes provided</p>`;

        return `
            <div class="border-2 border-dashed border-primary/20 rounded-lg overflow-hidden bg-white/30 flex flex-col new-attempt">
                <div class="w-full py-5 flex items-center justify-center">
                    <img 
                        src="${imageUrl}" 
                        alt="Attempt by ${userName}" 
                        class="rounded-full border-primary/20 border-2 border-dashed w-24 h-24 object-cover"
                    >
                </div>
                <div class="py-5 px-3 flex flex-col gap-2 items-center justify-center">
                    ${notesDisplay}
                    <span class="text-sm font-semibold text-primary">—${userName}—</span>
                </div>
            </div>
        `;
    }
}
