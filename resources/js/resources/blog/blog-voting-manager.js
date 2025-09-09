import { getHeaders } from "../../utils/general";

export class BlogVotingManager {
    constructor() {
        console.log("🟢 BlogManager initialized");
        this.initEventListeners();
    }

    initEventListeners() {
        console.log("🔹 Initializing event listeners");

        const upvoteButtons = document.querySelectorAll(".blog-upvote-button");
        const downvoteButtons = document.querySelectorAll(
            ".blog-downvote-button"
        );

        upvoteButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const blogId = button.getAttribute("data-blog-id");
                console.log(`🔼 Upvote clicked for blogId: ${blogId}`);
                if (blogId) this.upvoteBlog(blogId);
            });
        });

        downvoteButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const blogId = button.getAttribute("data-blog-id");
                console.log(`🔽 Downvote clicked for blogId: ${blogId}`);
                if (blogId) this.downvoteBlog(blogId);
            });
        });
    }

    async upvoteBlog(blogId) {
        console.log(`🔼 Attempting to upvote blogId: ${blogId}`);
        try {
            const response = await fetch(`/api/blogs/${blogId}/upvote`, {
                method: "POST",
                headers: getHeaders(),
            });

            if (response.status === 401) {
                window.location.href = "/login";
                return;
            }

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || "Failed to upvote");
            }

            console.log(`✅ Upvote successful for blogId: ${blogId}`, data);

            if (data?.success) {
                this.updateVoteDisplay(blogId, data);
            }
        } catch (error) {
            console.error("❌ Error upvoting blog:", error);
            toastError(error.message || "Failed to vote. Please try again.");
        }
    }

    async downvoteBlog(blogId) {
        console.log(`🔽 Attempting to downvote blogId: ${blogId}`);
        try {
            const response = await fetch(`/api/blogs/${blogId}/downvote`, {
                method: "POST",
                headers: getHeaders(),
            });

            if (response.status === 401) {
                window.location.href = "/login";
                return;
            }

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || "Failed to downvote");
            }

            console.log(`✅ Downvote successful for blogId: ${blogId}`, data);

            if (data?.success) {
                this.updateVoteDisplay(blogId, data);
            }
        } catch (error) {
            console.error("❌ Error downvoting blog:", error);
            toastError(error.message || "Failed to vote. Please try again.");
        }
    }

    updateVoteDisplay(blogId, data) {
        console.log(`🔄 Updating vote display for blogId: ${blogId}`, data);

        const blogSection = document.querySelector(
            `#blog-details[data-blog-id="${blogId}"]`
        );
        if (!blogSection) return;

        const voteCountElement = blogSection.querySelector(
            ".vote-count-display"
        );
        if (voteCountElement) voteCountElement.textContent = data.vote_score;

        const upvoteButton = blogSection.querySelector(".blog-upvote-button");
        const downvoteButton = blogSection.querySelector(
            ".blog-downvote-button"
        );

        if (upvoteButton) {
            upvoteButton.classList.remove("border-green-500", "text-green-500");
            upvoteButton.classList.add("border-text/60", "text-text/60");
        }
        if (downvoteButton) {
            downvoteButton.classList.remove("border-red-500", "text-red-500");
            downvoteButton.classList.add("border-text/60", "text-text/60");
        }

        if (data.user_vote === "up" && upvoteButton) {
            upvoteButton.classList.remove("border-text/60", "text-text/60");
            upvoteButton.classList.add("border-green-500", "text-green-500");
        } else if (data.user_vote === "down" && downvoteButton) {
            downvoteButton.classList.remove("border-text/60", "text-text/60");
            downvoteButton.classList.add("border-red-500", "text-red-500");
        }
    }
}
