import { BlogCommentManager } from "./blog-comment-manager";
import { BlogVotingManager } from "./blog-voting-manager";

document.addEventListener("DOMContentLoaded", () => {
    if (document.URL.includes("/blogs")) {
        new BlogVotingManager();
        new BlogCommentManager();
    }
});
