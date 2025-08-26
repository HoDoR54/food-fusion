import { toastSuccess, toastError } from "../utils/toast";

const saveRecipe = async (recipeId) => {
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
        }
    } catch (err) {
        console.error("Error saving recipe:", err);
        toastError(
            "An error occurred while saving the recipe. Please try again."
        );
    }
};

document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM fully loaded and parsed");
    const saveButtons = document.querySelectorAll(".recipe-save-button");
    if (!saveButtons.length) {
        console.log("No save buttons found");
        return;
    } else {
        saveButtons.forEach(function (button) {
            const recipeId = button.getAttribute("data-recipe-id");
            console.log(
                "Attaching event listener to button for recipe ID:",
                recipeId
            );
            button.addEventListener("click", () => saveRecipe(recipeId));
        });
    }
});
