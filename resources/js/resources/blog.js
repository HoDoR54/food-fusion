import { toastSuccess, toastError } from "../utils/toast";

class BlogManager {
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

        const toComments = document.querySelectorAll(".to-comments");
        toComments.forEach((button) => {
            button.addEventListener("click", () => {
                console.log("💬 Scroll to comment section triggered");
                this.scrollToCommentSection();
            });
        });

        const commentForm = document.getElementById("comment-upload-form");
        if (commentForm) {
            commentForm.onsubmit = (e) => {
                e.preventDefault();
                const blogId = commentForm.getAttribute("data-blog-id");
                if (!blogId) {
                    console.error("❌ Missing data-blog-id on comment form");
                    return;
                }
                const commentContent =
                    document.getElementById("comment-content")?.value || "";
                console.log(
                    `✍️ Submitting comment for blogId: ${blogId}`,
                    commentContent
                );
                if (commentContent.trim() === "") return;

                this.addComment(blogId, commentContent);
            };
        }
    }

    async upvoteBlog(blogId) {
        console.log(`🔼 Attempting to upvote blogId: ${blogId}`);
        try {
            const response = await fetch(`/blogs/${blogId}/upvote`, {
                method: "POST",
                headers: this.getHeaders(),
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
            const response = await fetch(`/blogs/${blogId}/downvote`, {
                method: "POST",
                headers: this.getHeaders(),
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

    scrollToCommentSection() {
        console.log("💬 Scrolling to comment section...");
        const commentSection = document.getElementById("comment-section");
        const commentInput = document.getElementById("comment-content");

        if (commentSection && commentInput) {
            const observer = new IntersectionObserver(
                (entries, obs) => {
                    if (entries[0].isIntersecting) {
                        console.log(
                            "💡 Comment section in view, focusing input"
                        );
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

    async addComment(blogId, commentContent) {
        console.log(`✍️ Adding comment for blogId: ${blogId}`, commentContent);
        try {
            const response = await fetch(`/blogs/${blogId}/comments/create`, {
                method: "POST",
                headers: this.getHeaders(),
                body: JSON.stringify({ content: commentContent }),
            });

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(errorText);
            }

            const data = await response.json();

            if (data?.success && data?.comment) {
                this.updateCommentDisplay(data.comment);
                if (typeof data.total_comments === "number") {
                    this.updateCommentCount(data.total_comments);
                }
                const commentForm = document.getElementById(
                    "comment-upload-form"
                );
                if (commentForm) {
                    commentForm.reset();
                    const charCount = document.getElementById("char-count");
                    if (charCount) charCount.textContent = "0";
                }
                toastSuccess(data.message || "Comment added successfully!");
            }
        } catch (error) {
            console.error("❌ Error adding comment:", error);
            toastError("Failed to add comment. Please try again.");
        }
    }

    updateCommentDisplay(newComment) {
        console.log("🔄 Updating comment display", newComment);
        this.updateCommentList(newComment);
    }

    updateCommentCount(total) {
        console.log(`🧮 Updating comment count to ${total}`);
        const commentCounter = document.getElementById("comment-count");
        if (commentCounter) commentCounter.textContent = total;
    }

    updateCommentList(newComment) {
        console.log("➕ Adding new comment to list", newComment);
        const commentList = document.getElementById("comments-list");
        if (!commentList) return;

        const noComments = document.getElementById("no-comments");
        if (noComments) noComments.remove();

        const commentItem = document.createElement("div");
        commentItem.classList.add(
            "comment-item",
            "border-l-2",
            "border-primary/20",
            "pl-4",
            "py-2"
        );

        commentItem.innerHTML = `
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 bg-secondary/10 rounded-full flex items-center justify-center flex-shrink-0">
                <i data-lucide="user" class="w-4 h-4 text-secondary/60"></i>
            </div>
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-1">
                    <h4 class="font-medium text-primary text-sm">${newComment.user_name}</h4>
                    <span class="text-xs text-text/50">${newComment.created_at}</span>
                </div>
                <p class="text-text/80 text-sm leading-relaxed">${newComment.content}</p>
            </div>
        </div>
    `;

        commentList.prepend(commentItem);

        if (typeof lucide !== "undefined") {
            lucide.createIcons();
        }
    }

    getHeaders() {
        const token = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content");
        if (!token) {
            console.error("❌ CSRF token missing");
            return {
                "Content-Type": "application/json",
                Accept: "application/json",
            };
        }
        return {
            "Content-Type": "application/json",
            Accept: "application/json",
            "X-CSRF-TOKEN": token,
        };
    }
}

document.addEventListener("DOMContentLoaded", () => {
    new BlogManager();
});
