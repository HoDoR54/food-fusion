import { toastError, toastSuccess } from "../../utils/toast";
import { getHeaders } from "../../utils/general";

const submitContactForm = async (form) => {
    try {
        const formData = new FormData(form);
        const isAnonymous = formData.get("is_anonymous") === "on";

        const res = await fetch("/api/contact", {
            method: "POST",
            headers: getHeaders(),
            body: JSON.stringify({
                subject: formData.get("subject"),
                message: formData.get("message"),
                type: formData.get("type"),
                is_anonymous: isAnonymous,
            }),
        });

        const data = await res.json();

        console.log("Raw response object:", res);
        console.log("Parsed JSON data:", data);

        if (!res.ok) {
            // Use message from backend or fallback
            throw new Error(
                data.error || data.message || "Failed to submit form"
            );
        }

        toastSuccess(
            data.message || "Your message has been submitted successfully!"
        );
        form.reset();
    } catch (error) {
        toastError(
            error.message || "Error submitting contact form. Please try again."
        );
        console.error("Error submitting contact form:", error);
    }
};

const initEventListeners = () => {
    const contactForm = document.getElementById("contact-form");
    if (contactForm) {
        contactForm.addEventListener("submit", (event) => {
            event.preventDefault();
            submitContactForm(event.target);
        });
    }
};

document.addEventListener("DOMContentLoaded", initEventListeners);
