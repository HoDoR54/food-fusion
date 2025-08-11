function handleLaravelToast() {
    const toastData = window.laravelToastData;

    if (toastData && toastData.message && window.toast) {
        setTimeout(() => {
            window.toast[toastData.type](toastData.message);
            if (typeof lucide !== "undefined" && lucide.createIcons) {
                lucide.createIcons();
            }
        }, 100);

        window.laravelToastData = null;
    }
}
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", handleLaravelToast);
} else {
    handleLaravelToast();
}
