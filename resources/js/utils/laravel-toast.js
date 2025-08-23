function handleLaravelToast() {
    const toastData = window.laravelToastData;

    if (toastData && window.toast) {
        if (Array.isArray(toastData)) {
            toastData.forEach((data) => {
                window.toast[data.type](data.message);
            });
        } else if (toastData.message && toastData.type) {
            window.toast[toastData.type](toastData.message);
        }

        window.laravelToastData = null;
        if (typeof lucide !== "undefined" && lucide.createIcons) {
            lucide.createIcons();
        }
    }
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", handleLaravelToast);
} else {
    handleLaravelToast();
}
