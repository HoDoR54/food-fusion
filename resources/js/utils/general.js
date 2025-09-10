import axios from "axios";

export async function setSession(key, value) {
    try {
        const res = await axios.post(
            "/api/sessions/set",
            {
                key,
                value,
            },
            {
                headers: getHeaders(),
                credentials: "include",
            }
        );
        return res.data;
    } catch (error) {
        console.error("Error setting session:", error);
        throw error;
    }
}

export async function getSession(key) {
    try {
        const res = await axios.get(`/api/sessions/get/${key}`, {
            headers: getHeaders(),
            credentials: "include",
        });
        console.log(res);
        console.log(`Session value for ${key}:`, res.data.value);
        return res.data.value;
    } catch (error) {
        console.error("Error getting session:", error);
        throw error;
    }
}

export function setCookie(name, value, days = 365) {
    const date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${value};expires=${date.toUTCString()};path=/`;
}

export function getCookie(name) {
    const match = document.cookie.match(
        new RegExp("(^| )" + name + "=([^;]+)")
    );
    if (match) return match[2];
    return null;
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

export function getFileUploadHeaders() {
    const token = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");
    if (!token) {
        console.error("❌ CSRF token missing");
        return {
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
        };
    }
    return {
        Accept: "application/json",
        "X-CSRF-TOKEN": token,
        "X-Requested-With": "XMLHttpRequest",
    };
}
