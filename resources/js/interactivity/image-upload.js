class ImageUploadHandler {
    constructor(config) {
        this.config = {
            inputId: "image",
            previewId: "image-preview",
            previewContainerId: "image-preview-container",
            labelId: "image-label",
            removeButtonId: "remove-image",
            maxFileSize: 5 * 1024 * 1024,
            allowedTypes: [
                "image/jpeg",
                "image/jpg",
                "image/png",
                "image/gif",
                "image/webp",
            ],
            onImageSelected: null,
            onImageRemoved: null,
            onError: null,
            ...config,
        };

        this.init();
    }

    init() {
        this.bindEvents();
    }

    bindEvents() {
        const imageInput = document.getElementById(this.config.inputId);
        const removeButton = document.getElementById(
            this.config.removeButtonId
        );

        if (imageInput) {
            imageInput.addEventListener("change", (e) =>
                this.handleImageSelect(e)
            );
        }

        if (removeButton) {
            removeButton.addEventListener("click", () => this.removeImage());
        }
    }

    handleImageSelect(event) {
        const file = event.target.files[0];

        if (!file) {
            return;
        }

        if (!this.config.allowedTypes.includes(file.type)) {
            this.handleError(
                "Please select a valid image file (JPEG, PNG, GIF, or WebP)."
            );
            this.clearInput();
            return;
        }

        if (file.size > this.config.maxFileSize) {
            const maxSizeMB = this.config.maxFileSize / (1024 * 1024);
            this.handleError(`File size must be less than ${maxSizeMB}MB.`);
            this.clearInput();
            return;
        }

        this.previewImage(file);
    }

    previewImage(file) {
        const reader = new FileReader();

        reader.onload = (e) => {
            const imagePreview = document.getElementById(this.config.previewId);
            const imagePreviewContainer = document.getElementById(
                this.config.previewContainerId
            );
            const imageLabel = document.getElementById(this.config.labelId);

            if (imagePreview) {
                imagePreview.src = e.target.result;
            }

            if (imagePreviewContainer) {
                imagePreviewContainer.classList.remove("hidden");
            }

            if (imageLabel) {
                imageLabel.classList.add("hidden");
            }

            // Call custom callback if provided
            if (
                this.config.onImageSelected &&
                typeof this.config.onImageSelected === "function"
            ) {
                this.config.onImageSelected(file, e.target.result);
            }
        };

        reader.onerror = () => {
            this.handleError("Failed to read the image file.");
        };

        reader.readAsDataURL(file);
    }

    removeImage() {
        const imageInput = document.getElementById(this.config.inputId);
        const imagePreview = document.getElementById(this.config.previewId);
        const imagePreviewContainer = document.getElementById(
            this.config.previewContainerId
        );
        const imageLabel = document.getElementById(this.config.labelId);

        if (imageInput) {
            imageInput.value = "";
        }

        if (imagePreview) {
            imagePreview.src = "#";
        }

        if (imagePreviewContainer) {
            imagePreviewContainer.classList.add("hidden");
        }

        if (imageLabel) {
            imageLabel.classList.remove("hidden");
        }

        if (
            this.config.onImageRemoved &&
            typeof this.config.onImageRemoved === "function"
        ) {
            this.config.onImageRemoved();
        }
    }

    clearInput() {
        const imageInput = document.getElementById(this.config.inputId);
        if (imageInput) {
            imageInput.value = "";
        }
    }

    handleError(message) {
        if (this.config.onError && typeof this.config.onError === "function") {
            this.config.onError(message);
        } else {
            console.error("Image Upload Error:", message);
            alert(message);
        }
    }

    static createRecipeUpload() {
        return new ImageUploadHandler({
            inputId: "image",
            previewId: "image-preview",
            previewContainerId: "image-preview-container",
            labelId: "image-label",
            removeButtonId: "remove-image",
        });
    }

    static createAttemptUpload() {
        return new ImageUploadHandler({
            inputId: "image",
            previewId: "attempt-image-preview",
            previewContainerId: "attempt-image-preview-container",
            labelId: "attempt-image-label",
            removeButtonId: "remove-attempt-image",
        });
    }

    updateConfig(newConfig) {
        this.config = { ...this.config, ...newConfig };
    }

    hasImage() {
        const imagePreview = document.getElementById(this.config.previewId);
        return (
            imagePreview &&
            imagePreview.src &&
            imagePreview.src !== "#" &&
            !imagePreview.src.endsWith("#")
        );
    }

    getCurrentFile() {
        const imageInput = document.getElementById(this.config.inputId);
        return imageInput && imageInput.files ? imageInput.files[0] : null;
    }
}

export { ImageUploadHandler };

document.addEventListener("DOMContentLoaded", function () {
    if (
        document.getElementById("image") &&
        document.getElementById("image-preview")
    ) {
        window.recipeImageUpload = ImageUploadHandler.createRecipeUpload();
    }

    if (
        document.getElementById("image") &&
        document.getElementById("attempt-image-preview")
    ) {
        window.attemptImageUpload = ImageUploadHandler.createAttemptUpload();
    }
});
