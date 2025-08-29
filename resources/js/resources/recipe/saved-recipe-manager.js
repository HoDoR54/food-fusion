import { toastSuccess, toastError } from "../../utils/toast.js";

export class SavedRecipesManager {
    constructor() {
        this.attachEventListeners();
    }

    async attachEventListeners() {
        const saveButtons = document.querySelectorAll(".recipe-save-button");

        for (const button of saveButtons) {
            const recipeId = button.getAttribute("data-recipe-id");
            const isSaved = await this.isRecipeSaved(recipeId);
            this.toggleIcon(saveButtons, recipeId, isSaved);

            button.addEventListener("click", async () => {
                const currentIsSaved = await this.isRecipeSaved(recipeId);
                if (currentIsSaved) {
                    await this.unsaveRecipe(recipeId);
                } else {
                    await this.saveRecipe(recipeId);
                }
                // Update icon after save/unsave
                const newIsSaved = await this.isRecipeSaved(recipeId);
                this.toggleIcon(saveButtons, recipeId, newIsSaved);
            });
        }
    }

    toggleIcon(buttonList, recipeId, isSaved) {
        const button = Array.from(buttonList).find(
            (btn) => btn.getAttribute("data-recipe-id") === recipeId
        );
        if (!button) return;

        const icon = button.querySelector(".save-icon");
        if (isSaved) {
            icon.setAttribute("data-lucide", "bookmark-check");
        } else {
            icon.setAttribute("data-lucide", "bookmark");
        }

        if (window.lucide) {
            window.lucide.createIcons();
        }
    }

    saveRecipe = async (recipeId) => {
        console.log("Saving recipe with ID:", recipeId);

        try {
            const response = await fetch("/recipes/" + recipeId + "/save", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify({ id: recipeId }),
            });

            const data = await response.json();

            console.log(data.message);
            if (data.success) {
                console.log("Recipe saved successfully");
                toastSuccess(data.message);
            } else {
                console.log("Failed to save recipe");
                toastError(data.message);

                // If unauthorized, redirect to login
                if (response.status === 401) {
                    window.location.href = "/auth/login";
                }
            }
        } catch (err) {
            console.error("Error saving recipe:", err);
            toastError(
                "An error occurred while saving the recipe. Please try again."
            );
        }
    };

    unsaveRecipe = async (recipeId) => {
        console.log("Unsaving recipe with ID:", recipeId);

        try {
            const response = await fetch("/recipes/" + recipeId + "/unsave", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify({ id: recipeId }),
            });

            const data = await response.json();

            console.log(data.message);

            if (data.success) {
                console.log("Recipe unsaved successfully");
                toastSuccess(data.message);
            } else {
                console.log("Failed to unsave recipe");
                toastError(data.message);

                // If unauthorized, redirect to login
                if (response.status === 401) {
                    window.location.href = "/auth/login";
                }
            }
        } catch (err) {
            console.error("Error unsaving recipe:", err);
            toastError(
                "An error occurred while unsaving the recipe. Please try again."
            );
        }
    };

    // async getSavedRecipes() {
    //     const savedRecipes = await fetch("/recipes/saved", {
    //         method: "GET",
    //         headers: {
    //             "X-CSRF-TOKEN": document.querySelector(
    //                 'meta[name="csrf-token"]'
    //             ).content,
    //             "Content-Type": "application/json",
    //             Accept: "application/json",
    //         },
    //     });

    //     const data = await savedRecipes.json();
    //     if (data.success) {
    //         this.savedRecipes = new Set(
    //             data.recipes.map((recipe) => recipe.id)
    //         );
    //     } else {
    //         console.error("Failed to fetch saved recipes");
    //     }
    // }

    async isRecipeSaved(recipeId) {
        try {
            const response = await fetch("/recipes/" + recipeId + "/is-saved", {
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
            });

            const data = await response.json();
            return data.success && data.data?.is_saved === true;
        } catch (error) {
            console.error("Error checking if recipe is saved:", error);
            return false;
        }
    }
}
