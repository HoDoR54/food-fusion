import { RecipeSearchManager } from "./recipe-search-manager";
import { RecipeUploadManager } from "./recipe-upload-manager";
import { SavedRecipesManager } from "./saved-recipe-manager";

document.addEventListener("DOMContentLoaded", () => {
    console.log("Recipe Manager loaded");
    currentPageUrl = document.URL;
    if (currentPageUrl.endsWith("/recipes/new-recipe")) {
        new RecipeUploadManager();
    }
    if (
        currentPageUrl.endsWith("/recipes") ||
        currentPageUrl.includes("/recipes?") ||
        currentPageUrl.includes("/recipes/")
    ) {
        new SavedRecipesManager();
    }
    if (currentPageUrl.endsWith("/recipes")) {
        new RecipeSearchManager([
            "difficulty_level",
            "dietary_preference",
            "cuisine_type",
            "course",
        ]);
    }
});
