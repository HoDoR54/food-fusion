import { LandingLoader } from "./load-all";
document.addEventListener("DOMContentLoaded", () => {
    if (window.location.pathname === "/") {
        new LandingLoader();
    }
});
