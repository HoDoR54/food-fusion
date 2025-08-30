export function formatTimeAgo(dateString) {
    const diff = Math.floor((Date.now() - new Date(dateString)) / 1000);
    if (diff < 60) return `${diff} sec ago`;
    if (diff < 3600) return `${Math.floor(diff / 60)} min ago`;
    if (diff < 86400) return `${Math.floor(diff / 3600)} hr ago`;
    return `${Math.floor(diff / 86400)} day${
        Math.floor(diff / 86400) > 1 ? "s" : ""
    } ago`;
}

export function formatDateWithOrdinal(dateString) {
    const date = new Date(dateString);
    const day = date.getDate();
    let ordinal = "th";

    if (day % 10 === 1 && day !== 11) ordinal = "st";
    else if (day % 10 === 2 && day !== 12) ordinal = "nd";
    else if (day % 10 === 3 && day !== 13) ordinal = "rd";

    const month = date.toLocaleString("default", { month: "long" });
    const year = date.getFullYear();

    return `${month} ${day}${ordinal}, ${year}`;
}

export function getHeaders() {
    const token = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");
    if (!token) {
        console.error("❌ CSRF token missing");
        return {
            "Content-Type": "application/json",
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
        };
    }
    return {
        "Content-Type": "application/json",
        Accept: "application/json",
        "X-CSRF-TOKEN": token,
        "X-Requested-With": "XMLHttpRequest",
    };
}
