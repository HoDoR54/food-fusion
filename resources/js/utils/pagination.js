const routeToPage = (page) => {
    window.scrollTo({ top: 0, behavior: "smooth" });

    const params = new URLSearchParams(window.location.search);
    params.set("page", page);
    window.location.search = params.toString();
};

const initPagination = () => {
    document.addEventListener("click", (event) => {
        const paginationLink = event.target.closest("[data-paginator] a");
        if (paginationLink) {
            event.preventDefault();

            const href = paginationLink.getAttribute("href");
            if (href && href !== "#") {
                const url = new URL(href, window.location.origin);
                const pageParam = url.searchParams.get("page");
                if (pageParam) {
                    routeToPage(pageParam);
                }
            }
            return;
        }

        const prevBtn = event.target.closest(".paginator-prev");
        const nextBtn = event.target.closest(".paginator-next");
        const paginator = document.querySelector("[data-paginator]");
        const currentPage = parseInt(paginator?.dataset?.currentPage) || 1;
        const totalPages = parseInt(paginator?.dataset?.totalPages) || 1;

        if (prevBtn) {
            event.preventDefault();
            if (currentPage > 1) {
                routeToPage(currentPage - 1);
            }
        }

        if (nextBtn) {
            event.preventDefault();
            if (currentPage < totalPages) {
                routeToPage(currentPage + 1);
            }
        }
    });
};

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initPagination);
} else {
    initPagination();
}
