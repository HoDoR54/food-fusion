import { toastSuccess, toastError } from "../../utils/toast";
import { getHeaders } from "../../utils/general";

export class BlogCommentManager {
    constructor() {
        this.initEventListeners();
    }

    initEventListeners() {
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

    async addComment(blogId, commentContent) {
        console.log(`✍️ Adding comment for blogId: ${blogId}`, commentContent);
        try {
            const response = await fetch(`/blogs/${blogId}/comments/create`, {
                method: "POST",
                headers: getHeaders(),
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
}
