export function formatTimeAgo(dateString) {
    const diff = Math.floor((Date.now() - new Date(dateString)) / 1000);
    if (diff < 60) return `${diff} sec ago`;
    if (diff < 3600) return `${Math.floor(diff / 60)} min ago`;
    if (diff < 86400) return `${Math.floor(diff / 3600)} hr ago`;
    return `${Math.floor(diff / 86400)} day${
        Math.floor(diff / 86400) > 1 ? "s" : ""
    } ago`;
}
