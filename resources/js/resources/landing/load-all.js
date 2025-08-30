import { toastError, toastSuccess } from "../../utils/toast";
import { getHeaders, formatDateWithOrdinal } from "../../utils/general";

export class LandingLoader {
    constructor() {
        this.loadOnIntersection();
    }

    loadOnIntersection() {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const elementId = entry.target.id;
                        console.log(elementId + " is intersecting");

                        switch (elementId) {
                            case "next-gathering-display":
                                this.getNextGathering();
                                break;
                            case "previous-events":
                                this.getPreviousEvents();
                                break;
                            case "upcoming-skill-sharing":
                                this.getUpcomingSkillSharingSessions();
                                break;
                            case "top-blogs":
                                this.getTopBlogs();
                                break;
                        }
                    }
                });
            },
            {
                root: null,
                rootMargin: "0px",
                threshold: 0.1,
            }
        );

        document.querySelectorAll(".lazy-load").forEach((element) => {
            observer.observe(element);
        });
    }

    async getNextGathering() {
        try {
            const response = await fetch(
                "/events/all?page=1&size=1&condition=upcoming&type=gathering&sort_by=start_time&sort_direction=asc",
                {
                    method: "GET",
                    headers: getHeaders(),
                }
            );
            const data = await response.json();

            if (!response.ok) {
                throw new Error(
                    data.error || data.message || "Failed to submit form"
                );
            } else {
                this.renderNextGathering(data.data[0].event);
            }
        } catch (error) {
            toastError("Error fetching next gathering", error);
            console.error("Error fetching next gathering:", error);
        }
    }

    renderNextGathering(data) {
        const titleElement = document.getElementById("next-gathering-title");
        if (titleElement) {
            titleElement.textContent = data.name;
        }

        const locationOrPlatform = document.getElementById(
            "next-gathering-location-or-platform"
        );
        if (locationOrPlatform) {
            if (data.venue_type === "online") {
                locationOrPlatform.textContent = data.platform;
            } else {
                locationOrPlatform.textContent = data.location;
            }
        }

        const dateElement = document.getElementById("next-gathering-date");
        if (dateElement && data.start_time) {
            dateElement.textContent = formatDateWithOrdinal(data.start_time);
        }

        const descriptionElement = document.getElementById(
            "next-gathering-description"
        );
        if (descriptionElement) {
            descriptionElement.textContent = data.description;
        }
    }

    getPreviousEvents() {
        console.log("Fetching prev events...");
    }

    getUpcomingSkillSharingSessions() {
        console.log("Fetching skill sharing sessions...");
    }

    getTopBlogs() {
        console.log("Fetching top blogs...");
    }
}
