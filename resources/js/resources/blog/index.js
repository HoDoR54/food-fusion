import { BlogCommentManager } from "./blog-comment-manager";
import { BlogVotingManager } from "./blog-voting-manager";

document.addEventListener("DOMContentLoaded", () => {
    const path = window.location.pathname;
    if (path.includes("/blogs")) {
        new BlogVotingManager();
        new BlogCommentManager();
    }
});
