import { BlogCommentManager } from "./blog-comment-manager";
import { BlogVotingManager } from "./blog-voting-manager";
import { BlogSearchManager } from "./blog-search-manager";

export class BlogManager {
    constructor() {
        this.path = window.location.pathname;
        this.init();
    }

    init() {
        console.log("Initializing BlogManager for path:", this.path);
        if (this.path.includes("/blogs")) {
            new BlogVotingManager();
            new BlogCommentManager();

            // Initialize search manager on blog index page
            if (this.path === "/blogs") {
                new BlogSearchManager(
                    ["category", "topic"], // select filters
                    "sort_by",
                    "clear-filters",
                    "search-input",
                    "search-button",
                    [] // no input filters
                );
            }
        }
    }

    getNetVotes(blog) {
        const upvotes = blog.votes.filter(
            (vote) => vote.direction === "up"
        ).length;
        const downvotes = blog.votes.filter(
            (vote) => vote.direction === "down"
        ).length;
        return upvotes - downvotes;
    }
}

document.addEventListener("DOMContentLoaded", () => {
    new BlogManager();
});
