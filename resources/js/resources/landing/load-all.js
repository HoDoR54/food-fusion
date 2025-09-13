import { toastError, toastSuccess } from "../../utils/toast";
import { getHeaders, formatDateWithOrdinal } from "../../utils/general";
import { BlogManager } from "../blog";
import { EventsCarousel } from "../../interactivity/carousel";
import axios from "axios";

export class LandingLoader {
    constructor() {
        this.blogManager = new BlogManager();
        this.eventsCarousel = new EventsCarousel();
        this.loadOnIntersection();
    }

    getTimeAgo(date) {
        const now = new Date();
        const diffInMs = now - date;
        const diffInMinutes = Math.floor(diffInMs / (1000 * 60));
        const diffInHours = Math.floor(diffInMs / (1000 * 60 * 60));
        const diffInDays = Math.floor(diffInMs / (1000 * 60 * 60 * 24));
        const diffInWeeks = Math.floor(diffInDays / 7);
        const diffInMonths = Math.floor(diffInDays / 30);
        const diffInYears = Math.floor(diffInDays / 365);

        if (diffInMinutes < 1) return "just now";
        if (diffInMinutes < 60) return `${diffInMinutes}m ago`;
        if (diffInHours < 24) return `${diffInHours}h ago`;
        if (diffInDays < 7) return `${diffInDays}d ago`;
        if (diffInWeeks < 4) return `${diffInWeeks}w ago`;
        if (diffInMonths < 12) return `${diffInMonths}mo ago`;
        return `${diffInYears}y ago`;
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
                            case "upcoming-events-carousel":
                                this.getUpcomingEventsForCarousel();
                                break;
                            case "upcoming-skill-sharing":
                                this.getUpcomingSkillSharingSessions();
                                break;
                            case "featured-recipes":
                                this.getFeaturedRecipes();
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
            const response = await axios.get("/api/events/all", {
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
            this.renderNextGatheringError(message);
            toastError("Error fetching next gathering", message);
            console.error("Error fetching next gathering:", message);
        }
    }

    renderNextGathering(data) {
        console.log(data);
        const container = document.getElementById("next-gathering-display");
        if (!container) return;

        // Replace skeleton with actual content
        container.innerHTML = `
            <div class="flex flex-col gap-3 py-4 px-6 items-center justify-center bg-secondary/10 border-2 border-dashed border-primary/10 rounded-lg min-w-[70vw]">
                <h2 class="text-2xl font-bold text-primary">Next Gathering</h2>
                <h3 class="text-lg font-medium text-center">
                    <span class="font-semibold text-center">${data.name}</span>
                    <span class="text-text font-extrabold text-center text-2xl">.</span> 
                    <span class="text-text text-center">Since January 2023</span>
                </h3>
                <p class="text-text/60 text-center">
                    <span>${
                        data.venue_type === "online"
                            ? data.platform
                            : data.location
                    }</span>
                    <span class="font-extrabold text-2xl text-primary/30">.</span>
                    <span>${formatDateWithOrdinal(data.start_time)}</span>
                </p>
                <p class="text-text/60 text-sm">
                    ${data.description}
                </p>
                <button data-action="show-event-registration-popup" data-event-id="${
                    data.id
                }" class="bg-primary text-white border border-primary text-md px-5 py-2 flex items-center justify-center gap-3 hover:brightness-90 rounded transition duration-300 ease-in-out box-border cursor-pointer mt-4">
                    <i data-lucide="calendar-plus"></i>
                    <span>I'll be there</span>
                </button>
            </div>
        `;

        // Re-initialize Lucide icons for the new content
        if (typeof lucide !== "undefined") {
            lucide.createIcons();
        }
    }

    renderNextGatheringError(message) {
        const container = document.getElementById("next-gathering-display");
        if (!container) return;

        // Replace skeleton with error content
        container.innerHTML = `
            <div class="flex flex-col gap-3 p-4 items-center justify-center">
                <i data-lucide="calendar-x" class="w-16 h-16 text-primary/30 mb-2"></i>
                <h2 class="text-2xl font-bold text-text/70">No Upcoming Gathering</h2>
                <p class="text-text/60 text-center max-w-md">
                    ${
                        message === "No upcoming gathering found"
                            ? "Check back soon for exciting community gatherings!"
                            : "Unable to load gathering information. Please try again later."
                    }
                </p>
                <button onclick="window.location.reload()" class="bg-secondary/20 text-primary border border-primary border-dashed text-md px-5 py-2 flex items-center justify-center gap-3 hover:brightness-90 rounded transition duration-300 ease-in-out box-border cursor-pointer mt-4">
                    <i data-lucide="refresh-cw"></i>
                    <span>Retry</span>
                </button>
            </div>
        `;

        // Re-initialize Lucide icons for the new content
        if (typeof lucide !== "undefined") {
            lucide.createIcons();
        }
    }

    async getUpcomingSkillSharingSessions() {
        try {
            const response = await axios.get("/api/events/all", {
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
            this.renderUpcomingSkillSharingError(message);
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

    renderUpcomingSkillSharingError(message) {
        const container = document.getElementById(
            "upcoming-skill-sharing-sessions"
        );
        if (!container) return;

        container.innerHTML = `
            <div class="md:col-span-3 col-span-1 flex flex-col items-center justify-center text-center py-12">
                <i data-lucide="users-x" class="w-16 h-16 text-primary/30 mb-4"></i>
                <h3 class="text-xl font-semibold text-text/70 mb-2">Unable to Load Sessions</h3>
                <p class="text-text/50 mb-4">
                    ${
                        message === "No upcoming skill sharing sessions found"
                            ? "No skill sharing sessions scheduled yet. Be the first to host one!"
                            : "Unable to load skill sharing sessions. Please try again later."
                    }
                </p>
                <button onclick="window.location.reload()" class="bg-secondary/20 text-primary border border-primary border-dashed px-4 py-2 rounded transition-colors">
                    <i data-lucide="refresh-cw" class="w-4 h-4 inline mr-2"></i>
                    Retry
                </button>
            </div>
        `;

        // Re-initialize Lucide icons
        if (typeof lucide !== "undefined") {
            lucide.createIcons();
        }
    }

    renderUpcomingSkillSharingError(message) {
        const container = document.getElementById(
            "upcoming-skill-sharing-sessions"
        );
        if (!container) return;

        container.innerHTML = `
            <div class="md:col-span-3 col-span-1 flex flex-col items-center justify-center text-center py-12">
                <i data-lucide="users-x" class="w-16 h-16 text-primary/30 mb-4"></i>
                <h3 class="text-xl font-semibold text-text/70 mb-2">Unable to Load Sessions</h3>
                <p class="text-text/50 mb-4">
                    ${
                        message === "No upcoming skill sharing sessions found"
                            ? "No skill sharing sessions scheduled. Check back soon!"
                            : "Unable to load sessions. Please try again later."
                    }
                </p>
                <button onclick="window.location.reload()" class="bg-secondary/20 text-primary border border-primary border-dashed px-4 py-2 rounded transition-colors">
                    <i data-lucide="refresh-cw" class="w-4 h-4 inline mr-2"></i>
                    Retry
                </button>
            </div>
        `;

        // Re-initialize Lucide icons
        if (typeof lucide !== "undefined") {
            lucide.createIcons();
        }
    }

    async getTopBlogs() {
        console.log("Fetching top blogs...");
        try {
            const response = await axios.get("/api/blogs/all", {
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
            const message = error.response?.data?.message || error.message;
            this.renderTopBlogsError(message);
            toastError("Error fetching top blogs", message);
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

    async getUpcomingEventsForCarousel() {
        console.log("Fetching upcoming events for carousel...");
        try {
            const response = await axios.get("/api/events/all", {
                params: {
                    page: 1,
                    size: 8, // Get more events for carousel
                    status: "scheduled",
                    sort_by: "start_time",
                    sort_direction: "asc",
                },
                headers: getHeaders(),
            });

            console.log(response.data);
            const responseObj = response.data;
            if (
                !responseObj ||
                !responseObj.data ||
                responseObj.data.length === 0
            ) {
                throw new Error("No upcoming events found");
            }

            this.renderUpcomingEventsCarousel(responseObj.data);
        } catch (error) {
            const message = error.response?.data?.message || error.message;
            this.renderUpcomingEventsCarouselError(message);
            toastError("Error fetching upcoming events", message);
            console.error("Error fetching upcoming events:", message);
        }
    }

    renderUpcomingEventsCarousel(events) {
        const container = document.getElementById("events-carousel-track");
        if (!container) return;

        if (events.length === 0) {
            container.innerHTML = `
                <div class="w-full flex flex-col items-center justify-center text-center py-12">
                    <i data-lucide="calendar-x" class="w-16 h-16 text-primary/30 mb-4"></i>
                    <h3 class="text-xl font-semibold text-text/70 mb-2">No Upcoming Events</h3>
                    <p class="text-text/50">Check back soon for exciting gatherings and skill-sharing sessions!</p>
                </div>
            `;
            return;
        }

        container.innerHTML = "";

        events.forEach((event) => {
            const eventTypeColor =
                event.type === "gathering" ? "bg-primary" : "bg-secondary";
            const eventTypeText =
                event.type.charAt(0).toUpperCase() +
                event.type.slice(1).replace("-", " ");

            container.innerHTML += `
                <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                    <div class="carousel-card bg-white/60 hover:bg-white/80 border-2 border-dashed border-primary/20 hover:border-primary/40 rounded-lg p-6 h-80 flex flex-col justify-between cursor-pointer group"
                         onclick="window.location.href='/events/${event.id}'">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="${eventTypeColor} text-white text-xs px-2 py-1 rounded-full font-medium">
                                    ${eventTypeText}
                                </span>
                                <span class="text-text/60 text-sm">
                                    ${
                                        event.venue_type === "online"
                                            ? "Online"
                                            : "In Person"
                                    }
                                </span>
                            </div>
                            <h3 class="text-lg font-semibold mb-3 group-hover:text-primary transition-colors line-clamp-2">
                                ${event.name}
                            </h3>
                            <p class="text-text/70 text-sm mb-4 line-clamp-3">
                                ${event.description}
                            </p>
                            <div class="text-secondary text-sm">
                                <p class="mb-1">
                                    <i data-lucide="calendar" class="w-4 h-4 inline mr-1"></i>
                                    ${formatDateWithOrdinal(event.start_time)}
                                </p>
                                <p>
                                    <i data-lucide="${
                                        event.venue_type === "online"
                                            ? "monitor"
                                            : "map-pin"
                                    }" class="w-4 h-4 inline mr-1"></i>
                                    ${
                                        event.venue_type === "online"
                                            ? event.platform
                                            : event.location
                                    }
                                </p>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mt-4">
                            <span class="text-primary/70 text-sm font-medium">
                                ${event.participants_count || 0} registered
                            </span>
                            <button class="bg-primary/10 hover:bg-primary/20 text-primary px-4 py-2 rounded-lg text-sm font-medium transition-colors"
                                    onclick="event.stopPropagation(); window.location.href='/events/${
                                        event.id
                                    }/register'">
                                Register
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });

        // Update carousel after rendering
        this.eventsCarousel.updateCarouselData(events);
    }

    renderUpcomingEventsCarouselError(message) {
        const container = document.getElementById("events-carousel-track");
        if (!container) return;

        container.innerHTML = `
            <div class="w-full flex flex-col items-center justify-center text-center py-12">
                <i data-lucide="calendar-x" class="w-16 h-16 text-primary/30 mb-4"></i>
                <h3 class="text-xl font-semibold text-text/70 mb-2">Unable to Load Events</h3>
                <p class="text-text/50 mb-4">
                    ${
                        message === "No upcoming events found"
                            ? "No upcoming events scheduled. Check back soon for exciting gatherings!"
                            : "Unable to load events. Please try again later."
                    }
                </p>
                <button onclick="window.location.reload()" class="bg-secondary/20 text-primary border border-primary border-dashed px-4 py-2 rounded transition-colors">
                    <i data-lucide="refresh-cw" class="w-4 h-4 inline mr-2"></i>
                    Retry
                </button>
            </div>
        `;

        // Re-initialize Lucide icons
        if (typeof lucide !== "undefined") {
            lucide.createIcons();
        }
    }

    async getFeaturedRecipes() {
        console.log("Fetching featured recipes...");
        try {
            const response = await axios.get("/api/recipes/all", {
                params: {
                    page: 1,
                    size: 3,
                    sort_by: "created_at",
                    sort_direction: "desc",
                },
                headers: getHeaders(),
            });

            console.log(response.data);
            const responseObj = response.data;
            if (
                !responseObj ||
                !responseObj.data ||
                responseObj.data.length === 0
            ) {
                throw new Error("No featured recipes found");
            }

            this.renderFeaturedRecipes(responseObj.data);
        } catch (error) {
            const message = error.response?.data?.message || error.message;
            this.renderFeaturedRecipesError(message);
            toastError("Error fetching featured recipes", message);
            console.error("Error fetching featured recipes:", message);
        }
    }

    renderFeaturedRecipes(recipes) {
        const container = document.getElementById("featured-recipes-grid");
        if (!container) return;

        if (recipes.length === 0) {
            container.innerHTML = `
                <div class="md:col-span-3 col-span-1 flex flex-col items-center justify-center text-center py-12">
                    <i data-lucide="chef-hat" class="w-16 h-16 text-primary/30 mb-4"></i>
                    <h3 class="text-xl font-semibold text-text/70 mb-2">No Recipes Yet</h3>
                    <p class="text-text/50">Be the first to share a delicious recipe with the community!</p>
                </div>
            `;
            return;
        }

        container.innerHTML = "";

        recipes.forEach((item) => {
            const recipe = item.recipe;

            // Format creation date
            const createdAt = recipe.created_at
                ? new Date(recipe.created_at)
                : null;
            const timeAgo = createdAt ? this.getTimeAgo(createdAt) : "";

            container.innerHTML += `
                <a href="/recipes/${
                    recipe.id
                }" class="block group bg-secondary/10 border-dashed border-2 rounded-2xl border-primary/20 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 cursor-pointer relative">
                    <div class="relative aspect-[4/3] overflow-hidden">
                        ${
                            recipe.image_url
                                ? `<img src="${recipe.image_url}" 
                                 alt="${recipe.name}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">`
                                : `<div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/30 flex items-center justify-center">
                                <i class="fa-solid fa-utensils text-4xl text-primary/40"></i>
                            </div>`
                        }
                        
                        <div class="absolute top-3 right-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium border backdrop-blur-sm">
                                ${recipe.difficulty}
                            </span>
                        </div>

                        ${
                            recipe.servings
                                ? `<div class="absolute top-3 left-3">
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-black/50 text-white backdrop-blur-sm">
                                    <i class="fa-solid fa-users text-xs mr-1"></i>${recipe.servings}
                                </span>
                            </div>`
                                : ""
                        }
                    </div>

                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-text mb-2 line-clamp-2 group-hover:text-primary transition-colors duration-300">
                            ${recipe.name}
                        </h3>

                        ${
                            recipe.description
                                ? `<p class="text-sm text-text/70 mb-3 line-clamp-1 leading-relaxed">
                                ${recipe.description}
                            </p>`
                                : ""
                        }

                        <div class="flex items-center justify-between pt-3 border-t border-primary/10">
                            <div class="flex items-center gap-2 text-xs text-text/60">
                                <div class="flex items-center gap-1">
                                    <i class="fa-solid fa-user-chef text-primary"></i>
                                    <span>${
                                        recipe.author_name || "Anonymous"
                                    }</span>
                                </div>
                                ${
                                    timeAgo
                                        ? `<span>•</span><span>${timeAgo}</span>`
                                        : ""
                                }
                            </div>
                        </div>
                    </div>

                    <div class="absolute inset-0 bg-secondary/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <div class="bg-white/90 backdrop-blur-sm rounded-full p-3 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                            <i class="fa-solid fa-arrow-right text-primary"></i>
                        </div>
                    </div>
                </a>
            `;
        });
    }

    renderTopBlogsError(message) {
        const container = document.getElementById("top-blogs-list");
        if (!container) return;

        container.innerHTML = `
            <div class="flex flex-col items-center justify-center text-center py-12 w-full">
                <i data-lucide="file-x" class="w-16 h-16 text-primary/30 mb-4"></i>
                <h3 class="text-xl font-semibold text-text/70 mb-2">Unable to Load Blogs</h3>
                <p class="text-text/50 mb-4">
                    ${
                        message === "No top blogs found"
                            ? "No blog posts available yet. Be the first to share!"
                            : "Unable to load blog posts. Please try again later."
                    }
                </p>
                <button onclick="window.location.reload()" class="bg-secondary/20 text-primary border border-primary border-dashed px-4 py-2 rounded transition-colors">
                    <i data-lucide="refresh-cw" class="w-4 h-4 inline mr-2"></i>
                    Retry
                </button>
            </div>
        `;

        // Re-initialize Lucide icons
        if (typeof lucide !== "undefined") {
            lucide.createIcons();
        }
    }

    renderFeaturedRecipesError(message) {
        const container = document.getElementById("featured-recipes-grid");
        if (!container) return;

        container.innerHTML = `
            <div class="md:col-span-3 col-span-1 flex flex-col items-center justify-center text-center py-12">
                <i data-lucide="chef-hat" class="w-16 h-16 text-primary/30 mb-4"></i>
                <h3 class="text-xl font-semibold text-text/70 mb-2">Unable to Load Recipes</h3>
                <p class="text-text/50 mb-4">
                    ${
                        message === "No featured recipes found"
                            ? "No recipes available yet. Be the first to share a delicious recipe!"
                            : "Unable to load recipes. Please try again later."
                    }
                </p>
                <button onclick="window.location.reload()" class="bg-secondary/20 text-primary border border-primary border-dashed px-4 py-2 rounded transition-colors">
                    <i data-lucide="refresh-cw" class="w-4 h-4 inline mr-2"></i>
                    Retry
                </button>
            </div>
        `;

        // Re-initialize Lucide icons
        if (typeof lucide !== "undefined") {
            lucide.createIcons();
        }
    }
}
