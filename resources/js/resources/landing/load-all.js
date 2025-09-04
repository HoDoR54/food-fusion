import { toastError, toastSuccess } from "../../utils/toast";
import { getHeaders, formatDateWithOrdinal } from "../../utils/general";
import { BlogManager } from "../blog";
import axios from "axios";

export class LandingLoader {
    constructor() {
        this.blogManager = new BlogManager();
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
        console.log("Fetching next gathering...");
        try {
            const response = await axios.get("/events/all", {
                params: {
                    page: 1,
                    size: 1,
                    status: "scheduled",
                    type: "gathering",
                    sort_by: "start_time",
                    sort_direction: "asc",
                },
                headers: getHeaders(),
            });

            console.log(response.data);
            const nextGathering = response.data?.data[0];
            console.log(nextGathering);
            if (!nextGathering) {
                throw new Error("No upcoming gathering found");
            }

            this.renderNextGathering(nextGathering);
        } catch (error) {
            const message = error.response?.data?.message || error.message;
            toastError("Error fetching next gathering", message);
            console.error("Error fetching next gathering:", message);
        }
    }

    renderNextGathering(data) {
        console.log(data);
        const titleElement = document.getElementById("next-gathering-title");
        if (titleElement) titleElement.textContent = data.name;

        const locationOrPlatform = document.getElementById(
            "next-gathering-location-or-platform"
        );
        if (locationOrPlatform) {
            locationOrPlatform.textContent =
                data.venue_type === "online" ? data.platform : data.location;
        }

        const dateElement = document.getElementById("next-gathering-date");
        if (dateElement && data.start_time) {
            dateElement.textContent = formatDateWithOrdinal(data.start_time);
        }

        const descriptionElement = document.getElementById(
            "next-gathering-description"
        );
        if (descriptionElement)
            descriptionElement.textContent = data.description;

        const nextGatheringButton = document.getElementById(
            "next-event-register"
        );
        if (nextGatheringButton) {
            nextGatheringButton.setAttribute("data-event-id", data.id);
        }
    }

    async getUpcomingSkillSharingSessions() {
        try {
            const response = await axios.get("/events/all", {
                params: {
                    page: 1,
                    size: 5,
                    status: "scheduled",
                    type: "skill-sharing",
                    sort_by: "start_time",
                    sort_direction: "asc",
                },
                headers: getHeaders(),
            });

            console.log(response.data);
            const responseObj = response.data;
            if (!responseObj || responseObj.length === 0) {
                throw new Error("No upcoming skill sharing sessions found");
            }

            this.renderUpcomingSkillSharingSessions(responseObj);
        } catch (error) {
            const message = error.response?.data?.message || error.message;
            toastError(
                "Error fetching upcoming skill sharing sessions",
                message
            );
            console.error(
                "Error fetching upcoming skill sharing sessions:",
                message
            );
        }
    }

    renderUpcomingSkillSharingSessions(responseObj) {
        const upcomingSessions = responseObj.data || [];
        const paginationData = responseObj.pagination || {};
        console.log("rendering hit");
        console.log(upcomingSessions);
        const container = document.getElementById(
            "upcoming-skill-sharing-sessions"
        );
        if (container) {
            container.innerHTML = "";
            upcomingSessions.forEach((session) => {
                container.innerHTML += `
                    <div class="bg-secondary/10 border-2 border-dashed border-primary/10 rounded-lg p-5 flex flex-col justify-between h-full">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">${
                                session.name
                            }</h3>
                            <p class="text-text/60 text-sm">${
                                session.description
                            }</p>
                        </div>
                        <p class="text-secondary text-xs mt-4">Start Time: ${formatDateWithOrdinal(
                            session.start_time
                        )}</p>
                        <p class="text-secondary text-xs mt-4">Location: ${
                            session.location || session.platform
                        }</p>
                    </div>
                `;
            });
            if (paginationData.total >= 6) {
                container.innerHTML += `
                    <div
                        class="bg-background/10 border-2 border-dashed border-primary/20 rounded-lg p-5 flex items-center justify-center cursor-pointer text-primary font-semibold text-lg transition-colors duration-200 hover:bg-primary/10 hover:text-primary/90"
                        onclick="window.location.href='/events?type=skill-sharing'"
                    >
                        See ${paginationData.total - 5} More
                    </div>
                `;
            }
        }
    }

    async getTopBlogs() {
        console.log("Fetching top blogs...");
        try {
            const response = await axios.get("/blogs/all", {
                params: {
                    page: 1,
                    size: 3,
                    sort_by: "popularity",
                    sort_direction: "desc",
                },
                headers: getHeaders(),
            });

            const responseObj = response.data;
            console.log(responseObj);
            if (
                !responseObj ||
                !responseObj.data ||
                responseObj.data.items === 0
            ) {
                throw new Error("No top blogs found");
            }
            console.log(responseObj.data.items);

            this.renderTopBlogs(responseObj.data.items);
        } catch (error) {
            toastError("Error fetching top blogs", error.message);
            console.error("Error fetching top blogs:", error);
        }
    }

    renderTopBlogs(topBlogs) {
        const container = document.getElementById("top-blogs-list");
        if (!container) return;

        container.innerHTML = "";

        topBlogs.forEach((blog) => {
            console.log(blog.votes);
            container.innerHTML += `
            <a href="/blogs/${
                blog.id
            }" class="border-l-8 border-dashed border-primary/10 pl-6 pr-4 py-4 bg-white/40 rounded-r-lg">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <img
                            src="${
                                blog.author?.profile_image ||
                                "/images/default-profile.webp"
                            }"
                            alt="Author ${blog.author?.name || "Unknown"}"
                            class="w-16 h-16 rounded-full object-cover opacity-90 cursor-pointer border-2 border-dashed border-primary/20"
                        />
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-foreground cursor-pointer hover:underline">${
                                blog.title
                            }</h3>
                            <p class="text-primary/70 max-w-[70%] line-clamp-1">${
                                blog.author?.name || "Unknown"
                            }</p>
                            <p class="text-text/60 text-sm">${formatDateWithOrdinal(
                                blog.created_at
                            )}</p>
                        </div>
                    </div>
                    <div class="text-right font-medium text-primary">
                        ${this.blogManager.getNetVotes(blog)} Votes
                    </div>
                </div>
            </a>
        `;
        });
    }
}
