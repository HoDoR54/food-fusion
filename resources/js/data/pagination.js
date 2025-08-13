const routeToPage = (page) => {
    const params = new URLSearchParams(window.location.search);
    params.set("page", page);
    window.location.search = params.toString();
};

const initPagination = () => {
    document.addEventListener("click", (event) => {
        const button = event.target.closest("[data-page]");

        if (button) {
            event.preventDefault();
            const page = button.dataset.page;

            if (page && !isNaN(page)) {
                routeToPage(page);
            }
        }
    });

    const prevButton = document.getElementById("prev-button");
    const nextButton = document.getElementById("next-button");

    if (prevButton) {
        prevButton.addEventListener("click", (event) => {
            if (!prevButton.disabled) {
                handlePrev();
            }
        });
    }

    if (nextButton) {
        nextButton.addEventListener("click", (event) => {
            if (!nextButton.disabled) {
                handleNext();
            }
        });
    }
};

const handlePrev = () => {
    const params = new URLSearchParams(window.location.search);
    const currentPage = parseInt(params.get("page")) || 1;
    if (currentPage > 1) {
        routeToPage(currentPage - 1);
    }
};

const handleNext = () => {
    const params = new URLSearchParams(window.location.search);
    const currentPage = parseInt(params.get("page")) || 1;
    const totalPages =
        parseInt(
            document.querySelector("[data-total-pages]").dataset.totalPages
        ) || 1;

    if (currentPage < totalPages) {
        routeToPage(currentPage + 1);
    }
};

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initPagination);
} else {
    initPagination();
}
