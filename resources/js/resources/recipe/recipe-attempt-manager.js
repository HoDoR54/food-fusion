import axios from "axios";
import { toastError, toastSuccess } from "../../utils/toast.js";
import { getFileUploadHeaders } from "../../utils/general.js";

export class RecipeAttemptManager {
    constructor() {
        this.init();
    }

    init() {
        this.addEventListeners();
    }

    addEventListeners() {
        document.addEventListener("submit", (event) => {
            if (event.target.matches("#recipe-attempt-form")) {
                event.preventDefault();
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
                    headers: getFileUploadHeaders(),
                    withCredentials: true,
                }
            );

            if (response.status === 401) {
                window.location.href = "/login";
                return;
            }

            if (response.status === 201 || response.status === 200) {
                // Close popup
                if (
                    window.PopUpManager &&
                    typeof window.PopUpManager.closePopUp === "function"
                ) {
                    window.PopUpManager.closePopUp();
                }

                // Show success toast
                toastSuccess(
                    response.data?.message ||
                        "Recipe attempt created successfully!"
                );

                // Update the UI to reflect the new attempt
                this.updateAttemptsSection(formData);
            } else {
                toastError("Unexpected response from server");
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
        const attemptsGrid = document.getElementById("recipe-attempts-grid");

        if (!attemptsGrid) {
            window.location.reload();
            return;
        }

        const noAttemptsMessage = document.getElementById(
            "no-attempts-message"
        );

        if (noAttemptsMessage) {
            noAttemptsMessage.remove();
        }

        const newAttemptCard = this.createAttemptCard(formData);

        // Get all direct children and filter out the "no attempts" message and new attempt
        const allChildren = Array.from(attemptsGrid.children);
        const existingAttempts = allChildren.filter(
            (child) =>
                child.id !== "no-attempts-message" &&
                !child.classList.contains("new-attempt")
        );

        if (existingAttempts.length >= 4) {
            existingAttempts[existingAttempts.length - 1].remove();
        }

        attemptsGrid.insertAdjacentHTML("afterbegin", newAttemptCard);

        const newCard = attemptsGrid.querySelector(".new-attempt");
        if (newCard) {
            newCard.style.opacity = "0";
            newCard.style.transform = "translateY(20px)";
            newCard.classList.remove("new-attempt");

            setTimeout(() => {
                newCard.style.transition =
                    "opacity 0.3s ease, transform 0.3s ease";
                newCard.style.opacity = "1";
                newCard.style.transform = "translateY(0)";
            }, 10);
        }

        if (typeof lucide !== "undefined") {
            lucide.createIcons();
        }
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
