function handleFilterChange(selectId, paramName) {
    const selectElement = document.getElementById(selectId);

    // Only add event listener if element exists
    if (selectElement) {
        selectElement.addEventListener("change", (event) => {
            const value = event.target.value;
            const params = new URLSearchParams(window.location.search);

            if (paramName === "sort_by" && value) {
                // Handle combined sort_by and sort_direction
                const [sortBy, sortDirection] = value.split(",");
                params.set("sort_by", sortBy);
                params.set("sort_direction", sortDirection);
            } else if (value) {
                params.set(paramName, value);
            } else {
                params.delete(paramName);
                if (paramName === "sort_by") {
                    params.delete("sort_direction");
                }
            }

            params.set("page", "1");

            window.location.href = `${
                window.location.pathname
            }?${params.toString()}`;
        });
    }
}

handleFilterChange("difficulty_level", "difficulty_level");
handleFilterChange("dietary_preference", "dietary_preference");
handleFilterChange("cuisine_type", "cuisine_type");
handleFilterChange("course", "course");
handleFilterChange("sort_by", "sort_by");

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
if (clearFiltersButton) {
    clearFiltersButton.addEventListener("click", clearFilters);
}

document.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);

    const filters = [
        "difficulty_level",
        "dietary_preference",
        "cuisine_type",
        "course",
    ];

    filters.forEach((filter) => {
        const element = document.getElementById(filter);
        const value = params.get(filter);
        if (element && value) {
            element.value = value;
        }
    });

    // Handle sort_by specially since it's a combined value
    const sortBy = params.get("sort_by");
    const sortDirection = params.get("sort_direction");
    const sortElement = document.getElementById("sort_by");

    if (sortElement && sortBy && sortDirection) {
        const combinedValue = `${sortBy},${sortDirection}`;
        // Find the option that matches this combined value
        const option = sortElement.querySelector(
            `option[value="${combinedValue}"]`
        );
        if (option) {
            sortElement.value = combinedValue;
        }
    }
});
