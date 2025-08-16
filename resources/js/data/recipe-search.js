function handleFilterChange(selectId, paramName) {
    const selectElement = document.getElementById(selectId);

    selectElement.addEventListener("change", (event) => {
        const value = event.target.value;
        const params = new URLSearchParams(window.location.search);

        if (value) {
            params.set(paramName, value);
        } else {
            params.delete(paramName);
        }

        params.set("page", "1");

        window.location.href = `${
            window.location.pathname
        }?${params.toString()}`;
    });
}

handleFilterChange("difficulty_level", "difficulty_level");
handleFilterChange("dietary_preference", "dietary_preference");
handleFilterChange("cuisine_type", "cuisine_type");
handleFilterChange("course", "course");
handleFilterChange("order_by", "order_by");

function clearFilters() {
    const baseUrl = window.location.pathname;
    const params = new URLSearchParams(window.location.search);

    const searchTerm = params.get("search_term");

    let newUrl = baseUrl;
    if (searchTerm) {
        newUrl += "?search_term=" + encodeURIComponent(searchTerm);
    }

    window.location.href = newUrl;
}

const clearFiltersButton = document.getElementById("clear-filters");
clearFiltersButton.addEventListener("click", clearFilters);

document.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);

    // Set selected values for all filters
    const filters = [
        "difficulty_level",
        "dietary_preference",
        "cuisine_type",
        "course",
        "order_by",
    ];

    filters.forEach((filter) => {
        const element = document.getElementById(filter);
        const value = params.get(filter);
        if (element && value) {
            element.value = value;
        }
    });
});
