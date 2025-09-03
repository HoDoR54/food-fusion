class PopUpManager {
    constructor() {
        this.container = document.getElementById("pop-up-container");
        this.overlay = document.getElementById("pop-up-overlay");
        this.currentContent = null;
        this.initEventListeners();
    }

    initEventListeners() {
        document.addEventListener("click", (event) => {
            if (event.target.closest('[data-action="close-popup"]')) {
                event.preventDefault();
                this.closePopUp();
            }
        });

        document.addEventListener("click", (event) => {
            if (event.target.closest('[data-action="show-popup"]')) {
                event.preventDefault();
                this.showPopUp();
            }
        });

        document.addEventListener("click", (event) => {
            if (event.target.closest('[data-action="show-login-popup"]')) {
                event.preventDefault();
                this.showLoginPopUp();
            }
        });

        document.addEventListener("click", (event) => {
            if (event.target.closest('[data-action="show-register-popup"]')) {
                event.preventDefault();
                this.showRegisterPopUp();
            }
        });

        document.addEventListener("click", (event) => {
            if (
                event.target.closest(
                    '[data-action="show-recipe-attempt-popup"]'
                )
            ) {
                event.preventDefault();
                const target = event.target.closest(
                    '[data-action="show-recipe-attempt-popup"]'
                );
                const recipeId =
                    target.getAttribute("data-recipe-id") ||
                    document
                        .querySelector("#recipe-details")
                        ?.getAttribute("data-recipe-id");
                const recipeName =
                    target.getAttribute("data-recipe-name") || "";
                this.showRecipeAttemptPopUp(recipeId, recipeName);
            }
        });

        if (this.overlay) {
            this.overlay.addEventListener("click", (event) => {
                this.closePopUp();
            });
        }

        if (this.container) {
            this.container.addEventListener("click", (event) => {
                if (event.target === this.container) {
                    this.closePopUp();
                }
            });
        }
    }

    showPopUp(content = null) {
        if (this.container && this.overlay) {
            if (content) {
                this.setContent(content);
            }
            this.container.classList.remove("hidden");
            this.container.classList.add("flex");
            this.overlay.classList.remove("hidden");
        }
    }

    showLoginPopUp() {
        const loginFormHTML = `
<form 
  action="/auth/login" 
  method="POST"
  class="flex flex-col md:min-w-[400px] items-center justify-center gap-3 p-4 bg-white rounded-xl border-2 border-primary border-dashed"
>
  <input type="hidden" name="_token" value="${
      document
          .querySelector('meta[name="csrf-token"]')
          ?.getAttribute("content") || ""
  }">
  
  <div class="w-full flex items-center justify-between mb-2">
    <span 
      class="flex items-center gap-2 text-primary hover:text-secondary cursor-pointer" 
      data-action="close-popup"
    >
      <i data-lucide="arrow-left" class="stroke-2 w-[1.2rem] h-[1.2rem]"></i>
      <span class="text-sm">Back</span>
    </span>
    <i data-lucide="x" class="stroke-2 w-[1.2rem] h-[1.2rem] text-primary hover:text-secondary cursor-pointer" data-action="close-popup"></i>
  </div>

  <div class="flex flex-col items-center justify-center mb-2">
    <img src="/logo/logo-light.png" alt="Food Fusion Logo" class="w-12 h-12">
    <h2 class="text-primary font-bold text-xl">Welcome Back</h2>
    <p class="text-text/60 text-sm">Sign in to your account</p>
  </div>

  <div class="flex flex-col gap-3 w-full">
    <div class="flex flex-col gap-1">
      <label for="identifier" class="text-text/60 text-xs">Email or Username</label>
      <input type="text" id="identifier" name="identifier" required placeholder="johnDoe123@gmail.com" class="bg-secondary/15 border border-gray-300 px-3 py-2 focus:outline-2 focus:outline-primary rounded w-full text-sm" />
    </div>
    <div class="flex flex-col gap-1">
      <label for="password" class="text-text/60 text-xs">Password</label>
      <input type="password" id="password" name="password" required placeholder="password" class="bg-secondary/15 border border-gray-300 px-3 py-2 focus:outline-2 focus:outline-primary rounded w-full text-sm" />
    </div>
    <div class="w-full">
      <a href="/forgot-password" class="text-primary hover:text-secondary underline text-xs">Forgot Password?</a>
    </div>
  </div>

  <div class="w-full flex flex-col items-center justify-center gap-3 mt-2">
    <button type="submit" class="w-full px-3 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition text-sm">Login</button>
    <span class="text-xs text-text/60">
      Don't have an account? <button type="button" data-action="show-register-popup" class="text-primary hover:text-secondary underline text-xs bg-transparent border-none cursor-pointer">Sign up here</button>
    </span>
  </div>
</form>
`;
        this.showPopUp(loginFormHTML);
    }

    showRegisterPopUp() {
        const registerFormHtml = `
<form
    method="POST"
    action="/auth/register"
    class="flex flex-col md:min-w-[450px] gap-3 p-4 items-center justify-center bg-white rounded-xl border-2 border-primary border-dashed"
>
    <input type="hidden" name="_token" value="${
        document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content") || ""
    }">

    <div class="w-full flex items-center justify-between mb-2">
        <span 
          class="flex items-center gap-2 text-primary hover:text-secondary cursor-pointer" 
          data-action="close-popup"
        >
          <i data-lucide="arrow-left" class="stroke-2 w-[1.2rem] h-[1.2rem]"></i>
          <span class="text-sm">Back</span>
        </span>
        <i data-lucide="x" class="stroke-2 w-[1.2rem] h-[1.2rem] text-primary hover:text-secondary cursor-pointer" data-action="close-popup"></i>
    </div>

    <div class="flex flex-col items-center justify-center mb-2">
        <img src="/logo/logo-light.png" alt="Food Fusion Logo" class="w-12 h-12">
        <h2 class="text-primary font-bold text-xl">Join Us</h2>
        <p class="text-gray-600 text-sm">Create your account</p>
    </div>

    <div class="flex flex-col gap-2 w-full">
        <div class="flex gap-2">
            <div class="flex flex-col gap-1 w-full">
                <label for="firstName" class="text-gray-600 text-xs">First Name</label>
                <input type="text" id="firstName" name="firstName" required placeholder="John" class="bg-secondary/15 border border-gray-300 px-3 py-2 focus:outline-2 focus:outline-primary rounded w-full text-sm" />
            </div>
            <div class="flex flex-col gap-1 w-full">
                <label for="lastName" class="text-gray-600 text-xs">Last Name</label>
                <input type="text" id="lastName" name="lastName" required placeholder="Doe" class="bg-secondary/15 border border-gray-300 px-3 py-2 focus:outline-2 focus:outline-primary rounded w-full text-sm" />
            </div>
        </div>

        <div class="flex flex-col gap-1">
            <label for="username" class="text-gray-600 text-xs">Username</label>
            <input 
                type="text" 
                id="username" 
                name="username" 
                required 
                placeholder="johndoe123" 
                pattern="[a-zA-Z0-9_]+"
                minlength="3"
                title="Username must be at least 3 characters and contain only letters, numbers, and underscores"
                class="bg-secondary/15 border border-gray-300 px-3 py-2 focus:outline-2 focus:outline-primary rounded w-full text-sm" 
            />
        </div>

        <div class="flex flex-col gap-1">
            <label for="email" class="text-gray-600 text-xs">Email</label>
            <input type="email" id="email" name="email" required placeholder="john.doe@example.com" class="bg-secondary/15 border border-gray-300 px-3 py-2 focus:outline-2 focus:outline-primary rounded w-full text-sm" />
        </div>

        <div class="flex flex-col gap-1">
            <label for="phoneNumber" class="text-gray-600 text-xs">Phone</label>
            <input type="tel" id="phoneNumber" name="phoneNumber" required placeholder="+95 9 123456789" class="bg-secondary/15 border border-gray-300 px-3 py-2 focus:outline-2 focus:outline-primary rounded w-full text-sm" />
        </div>

        <div class="flex flex-col gap-1">
            <label for="mastery_level" class="text-gray-600 text-xs">Cooking Level</label>
            <div class="relative">
                <select
                    id="mastery_level"
                    name="mastery_level"
                    required
                    class="bg-secondary/15 border border-gray-300 px-3 pr-8 py-2 focus:outline-2 focus:outline-primary rounded w-full appearance-none cursor-pointer text-gray-700 text-sm"
                >
                    <option value="" class="text-gray-500" disabled selected>How cooked are you?</option>
                    <option value="beginner">🍳 Beginner</option>
                    <option value="intermediate">👨‍🍳 Intermediate</option>
                    <option value="advanced">🏆 Advanced</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-1">
            <label for="password" class="text-gray-600 text-xs">Password</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                required 
                placeholder="veryVerySecure123!@#" 
                minlength="6"
                title="Password must be at least 6 characters long"
                class="bg-secondary/15 border border-gray-300 px-3 py-2 focus:outline-2 focus:outline-primary rounded w-full text-sm" 
            />
        </div>
    </div>

    <div class="w-full flex flex-col items-center justify-center gap-3 mt-2">
        <button type="submit" class="w-full px-3 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition text-sm">
            Register
        </button>
        <span class="text-xs text-gray-600">
            Already have an account? 
            <button type="button" data-action="show-login-popup" class="text-primary hover:text-secondary underline bg-transparent border-none cursor-pointer text-xs">Log in here</button>
        </span>
    </div>
</form>
`;
        this.showPopUp(registerFormHtml);
    }

    showRecipeAttemptPopUp(recipeId, recipeName) {
        const attemptFormHtml = `
<div class="border-2 border-dashed border-primary/30 bg-white rounded-xl max-w-lg mx-auto min-w-[400px]">
    <div class="flex items-center justify-between border-b border-dashed border-primary/20 p-4">
        <h2 class="text-lg font-bold text-primary">Share Your Attempt</h2>
        <i data-lucide="x" class="stroke-2 w-[1.5rem] h-[1.5rem] text-primary hover:text-secondary cursor-pointer" data-action="close-popup"></i>
    </div>

    <form action="/recipes/attempt" method="POST" enctype="multipart/form-data" class="p-4 flex flex-col gap-4 w-full">
        <input type="hidden" name="_token" value="${
            document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content") || ""
        }">
        <input type="hidden" name="recipe_id" value="${recipeId}" />

        <div class="flex flex-col gap-4 md:flex-row md:gap-4">
            <!-- Photo Upload Section -->
            <div class="flex flex-col gap-2 md:w-1/3">
                <label class="block text-sm text-gray-600 font-medium">
                    <i data-lucide="camera" class="w-4 h-4 inline mr-1"></i>
                    Photo
                </label>
                
                <div id="attempt-image-preview-container" class="hidden relative">
                    <img id="attempt-image-preview" src="#"
                        alt="Attempt Image Preview"
                        class="w-full h-24 object-cover rounded-lg border border-dashed border-primary/30" />
                    <button type="button" id="remove-attempt-image" 
                        class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center transition cursor-pointer">
                        <i data-lucide="x" class="w-3 h-3"></i>
                    </button>
                </div>

                <label id="attempt-image-label" for="attempt-image"
                    class="flex flex-col items-center justify-center gap-2 border border-dashed border-primary/30 rounded-lg bg-primary/10 hover:bg-primary/20 transition cursor-pointer w-full h-24">
                    <i data-lucide="camera" class="w-6 h-6 text-gray-500"></i>
                    <span class="text-xs text-gray-500">Upload photo</span>
                </label>

                <input type="file" id="attempt-image" name="image" accept="image/*" class="hidden" />
            </div>

            <!-- Notes Section -->
            <div class="flex flex-col gap-2 md:w-2/3">
                <label for="attempt-notes" class="block text-sm text-gray-600 font-medium">
                    <i data-lucide="edit-3" class="w-4 h-4 inline mr-1"></i>
                    How did it go?
                </label>
                <textarea
                    required
                    id="attempt-notes" 
                    name="notes" 
                    placeholder="Share your experience, modifications, or tips..."
                    class="border border-dashed border-primary/30 bg-secondary/15 resize-none px-3 py-2 rounded-lg focus:outline-2 focus:outline-primary w-full h-40 text-sm"
                    rows="6"></textarea>
            </div>
        </div>

        <div class="flex gap-2 pt-2">
            <button type="submit" class="flex-1 bg-primary hover:bg-primary/90 text-white py-2 px-4 rounded-lg transition text-sm font-semibold flex items-center justify-center gap-1">
                <i data-lucide="upload" class="w-4 h-4"></i>
                Share
            </button>
        </div>
    </form>
</div>
`;
        this.showPopUp(attemptFormHtml);

        // Add image preview functionality
        setTimeout(() => {
            const imageInput = document.getElementById("attempt-image");
            const imagePreview = document.getElementById(
                "attempt-image-preview"
            );
            const previewContainer = document.getElementById(
                "attempt-image-preview-container"
            );
            const imageLabel = document.getElementById("attempt-image-label");
            const removeButton = document.getElementById(
                "remove-attempt-image"
            );

            if (
                imageInput &&
                imagePreview &&
                previewContainer &&
                imageLabel &&
                removeButton
            ) {
                imageInput.addEventListener("change", function (e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            imagePreview.src = e.target.result;
                            previewContainer.classList.remove("hidden");
                            imageLabel.classList.add("hidden");
                        };
                        reader.readAsDataURL(file);
                    }
                });

                removeButton.addEventListener("click", function () {
                    imageInput.value = "";
                    imagePreview.src = "#";
                    previewContainer.classList.add("hidden");
                    imageLabel.classList.remove("hidden");
                });
            }
        }, 100);
    }

    setContent(htmlContent) {
        if (this.container) {
            const contentWrapper = this.container.querySelector(
                ".pointer-events-auto"
            );
            if (contentWrapper) {
                contentWrapper.innerHTML = htmlContent;
                this.currentContent = htmlContent;

                // Re-initialize Lucide icons for the new content
                if (window.lucide) {
                    window.lucide.createIcons();
                }
            }
        }
    }

    closePopUp() {
        if (this.container && this.overlay) {
            this.container.classList.add("hidden");
            this.container.classList.remove("flex");
            this.overlay.classList.add("hidden");
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    window.popupManager = new PopUpManager();
});
