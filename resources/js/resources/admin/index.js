import { AdminRecipeManager } from "../recipe/admin-recipe-manager";

document.addEventListener("DOMContentLoaded", function () {
    const pathName = window.location.pathname;
    if (pathName === "/admin") {
        window.location.href = "/admin/pending-recipes";
    }

    if (pathName === "/admin/pending-recipes") {
        new AdminRecipeManager();
    }
});
