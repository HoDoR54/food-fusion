export class RecipeSearchManager {
    constructor(
        filters,
        sortFilter = "sort_by",
        clearButtonId = "clear-filters",
        searchInputId = "search-input",
        searchButtonId = "search-button"
    ) {
        this.filters = filters;
        this.sortFilter = sortFilter;
        this.clearButtonId = clearButtonId;
        this.searchInputId = searchInputId;
        this.searchButtonId = searchButtonId;

        this.init();
    }

    init() {
        // Attach change listeners for all filters
        this.filters.forEach((filter) => {
            this.handleFilterChange(filter, filter);
        });

        // Attach sort_by listener
        this.handleFilterChange(this.sortFilter, this.sortFilter);

        // Handle clear button
        const clearButton = document.getElementById(this.clearButtonId);
        if (clearButton) {
            clearButton.addEventListener("click", () => this.clearFilters());
        }

        // Handle search functionality
        this.handleSearch();

        // Restore state on page load
        document.addEventListener("DOMContentLoaded", () =>
            this.restoreFilters()
        );
    }

    handleFilterChange(selectId, paramName) {
        const selectElement = document.getElementById(selectId);

        if (!selectElement) return;

        selectElement.addEventListener("change", (event) => {
            const value = event.target.value;
            const params = new URLSearchParams(window.location.search);

            if (paramName === this.sortFilter && value) {
                // Handle combined sort_by + sort_direction
                const [sortBy, sortDirection] = value.split(",");
                params.set("sort_by", sortBy);
                params.set("sort_direction", sortDirection);
            } else if (value) {
                params.set(paramName, value);
            } else {
                params.delete(paramName);
                if (paramName === this.sortFilter) {
                    params.delete("sort_direction");
                }
            }

            // Always reset page back to 1
            params.set("page", "1");

            window.location.href = `${
                window.location.pathname
            }?${params.toString()}`;
        });
    }

    handleSearch() {
        const searchInput = document.getElementById(this.searchInputId);
        const searchButton = document.getElementById(this.searchButtonId);

        if (!searchInput || !searchButton) return;

        const performSearch = () => {
            const searchTerm = searchInput.value.trim();
            const params = new URLSearchParams(window.location.search);

            if (searchTerm) {
                params.set("search_term", searchTerm);
            } else {
                params.delete("search_term");
            }

            // Always reset page back to 1
            params.set("page", "1");

            window.location.href = `${
                window.location.pathname
            }?${params.toString()}`;
        };

        // Handle search button click
        searchButton.addEventListener("click", performSearch);

        // Handle Enter key in search input
        searchInput.addEventListener("keypress", (event) => {
            if (event.key === "Enter") {
                event.preventDefault();
                performSearch();
            }
        });
    }

    clearFilters() {
        const baseUrl = window.location.pathname;
        const params = new URLSearchParams(window.location.search);

        const searchTerm = params.get("search_term");

        let newUrl = baseUrl;
        if (searchTerm) {
            newUrl += "?search_term=" + encodeURIComponent(searchTerm);
        }

        window.location.href = newUrl;
    }

    restoreFilters() {
        const params = new URLSearchParams(window.location.search);

        // Restore normal filters
        this.filters.forEach((filter) => {
            const element = document.getElementById(filter);
            const value = params.get(filter);
            if (element && value) {
                element.value = value;
            }
        });

        // Handle special case for sort_by + sort_direction
        const sortBy = params.get("sort_by");
        const sortDirection = params.get("sort_direction");
        const sortElement = document.getElementById(this.sortFilter);

        if (sortElement && sortBy && sortDirection) {
            const combinedValue = `${sortBy},${sortDirection}`;
            const option = sortElement.querySelector(
                `option[value="${combinedValue}"]`
            );
            if (option) {
                sortElement.value = combinedValue;
            }
        }
    }
}
