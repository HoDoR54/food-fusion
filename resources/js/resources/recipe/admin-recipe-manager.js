import { getHeaders } from "../../utils/general";
import { showToast } from "../../utils/toast";

export class AdminRecipeManager {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
    }

    setupEventListeners() {
        document.querySelectorAll('form[id^="approve-"]').forEach((form) => {
            form.addEventListener("submit", this.handleApprove.bind(this));
        });
        document.querySelectorAll('form[id^="reject-"]').forEach((form) => {
            form.addEventListener("submit", this.handleReject.bind(this));
        });
    }

    async handleApprove(event) {
        const form = event.target;
        const recipeId = form.id.replace("approve-", "");

        try {
            event.preventDefault();
            console.log(`Approving recipe: ${recipeId}`);

            const response = await axios.patch(
                `/admin/recipes/${recipeId}/approve`,
                {},
                {
                    headers: getHeaders(),
                }
            );

            if (response.data.success) {
                console.log(`Recipe ${recipeId} approved successfully`);
                this.removeRecipeFromList(recipeId);
                showToast(response.data.message, "success");
            }
        } catch (error) {
            console.error(`Failed to approve recipe ${recipeId}:`, error);
            showToast("Failed to approve recipe", "error");
        }
    }

    async handleReject(event) {
        const form = event.target;
        const recipeId = form.id.replace("reject-", "");

        try {
            event.preventDefault();
            console.log(`Rejecting recipe: ${recipeId}`);

            const response = await axios.patch(
                `/admin/recipes/${recipeId}/reject`,
                {},
                {
                    headers: getHeaders(),
                }
            );

            if (response.data.success) {
                console.log(`Recipe ${recipeId} rejected successfully`);
                this.removeRecipeFromList(recipeId);
                showToast(response.data.message, "success");
            }
        } catch (error) {
            console.error(`Failed to reject recipe ${recipeId}:`, error);
            showToast("Failed to reject recipe", "error");
        }
    }

    removeRecipeFromList(recipeId) {
        const recipeElement = document
            .querySelector(`#approve-${recipeId}`)
            .closest("li");
        if (recipeElement) {
            recipeElement.remove();
        }

        const remainingRecipes = document.querySelectorAll(
            "ul.flex.flex-col li"
        );
        if (remainingRecipes.length === 0) {
            const listContainer = document.querySelector("ul.flex.flex-col");
            if (listContainer) {
                listContainer.innerHTML = "<p>No pending recipes found.</p>";
            }
        }
    }
}
