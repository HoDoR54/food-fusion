class Toast {
    constructor() {
        this.container = document.getElementById("toast-container");
        if (!this.container) {
            console.error(
                "Toast container not found. Make sure the toast container div exists in your HTML."
            );
        }
    }

    show(message, type = "info", duration = 5000) {
        if (!this.container) return null;

        const toast = this.createToast(message, type);
        this.container.appendChild(toast);

        setTimeout(() => {
            toast.classList.remove("translate-x-full", "opacity-0");
            toast.classList.add("translate-x-0", "opacity-100");
        }, 10);

        setTimeout(() => {
            this.remove(toast);
        }, duration);

        return toast;
    }

    createToast(message, type) {
        const toast = document.createElement("div");

        const typeStyles = {
            success: "bg-white border-green-600",
            error: "bg-white border-red-600",
            warning: "bg-white border-yellow-600",
            info: "bg-white border-blue-600",
        };

        const iconMap = {
            success: "check-circle",
            error: "x-circle",
            warning: "alert-triangle",
            info: "info",
        };

        toast.className = `
            flex items-center gap-3 p-4 mb-2 text-text rounded-lg shadow border-l-4 border-2 
            transform transition-all duration-300 ease-in-out translate-x-full opacity-0
            min-w-80 max-w-md cursor-pointer hover:shadow-md
            ${typeStyles[type] || typeStyles.info}
        `;

        toast.innerHTML = `
            <i data-lucide="${
                iconMap[type] || iconMap.info
            }" class="w-5 h-5 flex-shrink-0"></i>
            <span class="flex-1 text-sm font-medium">${this.escapeHtml(
                message
            )}</span>
            <button class="toast-close cursor-pointer ml-2 hover:bg-white/20 rounded p-1 transition-colors">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        `;

        toast.addEventListener("click", () => this.remove(toast));

        return toast;
    }

    remove(toast) {
        toast.classList.add("translate-x-full", "opacity-0");
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }

    escapeHtml(text) {
        const div = document.createElement("div");
        div.textContent = text;
        return div.innerHTML;
    }

    success(message, duration) {
        return this.show(message, "success", duration);
    }
    error(message, duration) {
        return this.show(message, "error", duration);
    }
    warning(message, duration) {
        return this.show(message, "warning", duration);
    }
    info(message, duration) {
        return this.show(message, "info", duration);
    }
}

function initializeToast() {
    window.toast = new Toast();
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initializeToast);
} else {
    initializeToast();
}

export function showToast(message, type = "info", duration = 5000) {
    if (window.toast) {
        return window.toast.show(message, type, duration);
    } else {
        console.warn("Toast system not initialized");
    }
}

export const toastSuccess = (message, duration) =>
    showToast(message, "success", duration);
export const toastError = (message, duration) =>
    showToast(message, "error", duration);
export const toastWarning = (message, duration) =>
    showToast(message, "warning", duration);
export const toastInfo = (message, duration) =>
    showToast(message, "info", duration);
