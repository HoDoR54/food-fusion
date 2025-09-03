import { toastError, toastSuccess } from "../../utils/toast";

export class EventRegistrationManager {
    constructor() {
        console.log("EventRegistrationManager initialized");
        this.init();
    }

    init() {
        this.form = document.getElementById("event-registration-form");
        if (!this.form) {
            console.log("form not found");
        }
        this.addEventListeners();
    }

    addEventListeners() {
        if (this.form) {
            this.form.addEventListener("submit", (event) => {
                event.preventDefault();
                this.registerEvent();
            });
            console.log("event listener attached");
        }
    }

    async registerEvent() {
        const formData = new FormData(this.form);
        console.log("form data:", Array.from(formData.entries()));
        const eventId = formData.get("event_id");
        console.log("eventId:", eventId);

        if (!eventId) {
            toastError("Event ID not found");
            return;
        }

        try {
            const response = await axios.post(`/events/${eventId}/register`);

            if (response.status === 200 && response.data?.message) {
                window.PopUpManager.closePopUp();
                toastSuccess(response.data.message);
            }
        } catch (error) {
            console.error("Error registering event:", error);

            if (error.response?.status === 401) {
                window.location.href = "/login";
                return;
            }

            const message =
                error.response?.data?.message || "Failed to register for event";
            toastError(message);
        }
    }
}
