const saveRecipe = (recipeId) => {
    console.log("Save recipe clicked for ID:", recipeId);

    const form = document.getElementById("save-recipe-form");
    if (form) {
        console.log("Submitting form to:", form.action);
        form.submit();
    } else {
        console.error("Save recipe form not found");
    }
};

document.addEventListener("DOMContentLoaded", function () {
    const saveButton = document.getElementById("save-recipe");
    if (saveButton) {
        const detailsSection = document.getElementById("recipe-details");
        const recipeId = detailsSection
            ? detailsSection.dataset.recipeId
            : null;
        saveButton.addEventListener("click", () => saveRecipe(recipeId));
    } else {
        console.error("Save recipe button not found");
    }
});
