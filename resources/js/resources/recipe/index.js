import { RecipeSearchManager } from "./recipe-search-manager";
import { RecipeUploadManager } from "./recipe-upload-manager";
import { SavedRecipesManager } from "./saved-recipe-manager";
import { RecipeAttemptManager } from "./recipe-attempt-manager";

document.addEventListener("DOMContentLoaded", () => {
    const path = window.location.pathname;

    // Initialize RecipeAttemptManager on all recipe-related pages
    console.log("Initializing Recipe Attempt Manager");
    new RecipeAttemptManager();

    if (path.endsWith("/recipes/new-recipe")) {
        console.log("Initializing Recipe Upload Manager");
        new RecipeUploadManager();
    }
    if (
        path.endsWith("/recipes") ||
        path.includes("/recipes?") ||
        path.includes("/recipes/")
    ) {
        console.log("Initializing Saved Recipes Manager");
        new SavedRecipesManager();
    }
    if (path.endsWith("/recipes")) {
        console.log("Initializing Recipe Search Manager");
        new RecipeSearchManager([
            "difficulty_level",
            "dietary_preference",
            "cuisine_type",
            "course",
        ]);
    }
});
