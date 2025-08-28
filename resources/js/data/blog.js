class BlogManager {
    constructor() {
        this.initEventListeners();
    }

    initEventListeners() {
        const upvoteButtons = document.querySelectorAll(".blog-upvote-button");
        const downvoteButtons = document.querySelectorAll(
            ".blog-downvote-button"
        );

        upvoteButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const blogId = button.getAttribute("data-blog-id");
                this.upvoteBlog(blogId);
            });
        });

        downvoteButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const blogId = button.getAttribute("data-blog-id");
                this.downvoteBlog(blogId);
            });
        });

        const toComments = document.querySelectorAll(".to-comments");
        toComments.forEach((button) => {
            button.addEventListener("click", () => {
                this.scrollToCommentSection();
            });
        });
    }

    async upvoteBlog(blogId) {
        try {
            const response = await fetch(`/blogs/${blogId}/upvote`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            });

            if (!response.ok) {
                const errorText = await response.text();
                console.error("Response error:", errorText);
                throw new Error("Network response was not ok");
            }

            const data = await response.json();
            if (!data) {
                console.error("No data returned from server");
                return;
            }
            this.updateVoteDisplay(blogId, data);
        } catch (error) {
            console.error("Error upvoting blog:", error);
        }
    }

    async downvoteBlog(blogId) {
        console.log(`Downvoting blog with ID: ${blogId}`);
        try {
            const response = await fetch(`/blogs/${blogId}/downvote`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            });

            if (!response.ok) {
                const errorText = await response.text();
                console.error("Response error:", errorText);
                throw new Error("Network response was not ok");
            }

            const data = await response.json();
            if (!data) {
                console.error("No data returned from server");
                return;
            }
            this.updateVoteDisplay(blogId, data);
        } catch (error) {
            console.error("Error downvoting blog:", error);
        }
    }

    scrollToCommentSection() {
        const commentSection = document.getElementById("comment-section");
        const commentInput = document.getElementById("comment-content");

        if (commentSection && commentInput) {
            const observer = new IntersectionObserver(
                (entries, obs) => {
                    if (entries[0].isIntersecting) {
                        commentInput.focus();
                        obs.disconnect();
                    }
                },
                { threshold: 0.5 }
            );

            observer.observe(commentSection);
            commentSection.scrollIntoView({ behavior: "smooth" });
        }
    }

    updateVoteDisplay(blogId, data) {
        const blogSection = document.querySelector(
            `#blog-details[data-blog-id="${blogId}"]`
        );
        if (blogSection) {
            const voteCountElement = blogSection.querySelector(
                ".vote-count-display"
            );
            if (voteCountElement) {
                voteCountElement.textContent = data.vote_score;
            }

            const upvoteButton = blogSection.querySelector(
                ".blog-upvote-button"
            );
            const downvoteButton = blogSection.querySelector(
                ".blog-downvote-button"
            );

            if (upvoteButton) {
                upvoteButton.classList.remove(
                    "border-green-500",
                    "text-green-500"
                );
                upvoteButton.classList.add("border-text/60", "text-text/60");
            }
            if (downvoteButton) {
                downvoteButton.classList.remove(
                    "border-red-500",
                    "text-red-500"
                );
                downvoteButton.classList.add("border-text/60", "text-text/60");
            }

            if (data.user_vote === "up" && upvoteButton) {
                upvoteButton.classList.remove("border-text/60", "text-text/60");
                upvoteButton.classList.add(
                    "border-green-500",
                    "text-green-500"
                );
            } else if (data.user_vote === "down" && downvoteButton) {
                downvoteButton.classList.remove(
                    "border-text/60",
                    "text-text/60"
                );
                downvoteButton.classList.add("border-red-500", "text-red-500");
            }
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    new BlogManager();
});
