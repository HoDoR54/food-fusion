import {
    createTextInput,
    createTextarea,
    createSelect,
    createHiddenInput,
    createRemoveButton,
    createGridColumn,
    createTimeInputWrapper,
    reinitializeLucideIcons,
} from "../utils/components.js";

class RecipeUploadManager {
    constructor() {
        this.stepCounter = 0;
        this.ingredientCounter = 0;
        this.tagCounter = 0;
        this.init();
    }

    init() {
        this.initImageHandling();
        this.initEventListeners();
        this.addInitialItems();
    }

    initImageHandling() {
        const imageInput = document.getElementById("image");
        const removeImageBtn = document.getElementById("remove-image");

        if (imageInput) {
            imageInput.addEventListener("change", (e) => this.previewImage(e));
        }

        if (removeImageBtn) {
            removeImageBtn.addEventListener("click", () => this.removeImage());
        }
    }

    previewImage(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const imagePreview = document.getElementById("image-preview");
                const imagePreviewContainer = document.getElementById(
                    "image-preview-container"
                );
                const imageLabel = document.getElementById("image-label");

                imagePreview.src = e.target.result;
                imagePreviewContainer?.classList.remove("hidden");
                imageLabel?.classList.add("hidden");
            };
            reader.readAsDataURL(file);
        }
    }

    removeImage() {
        const imageInput = document.getElementById("image");
        const imagePreview = document.getElementById("image-preview");
        const imagePreviewContainer = document.getElementById(
            "image-preview-container"
        );
        const imageLabel = document.getElementById("image-label");

        imageInput.value = "";
        imagePreview.src = "#";
        imagePreviewContainer?.classList.add("hidden");
        imageLabel?.classList.remove("hidden");
    }

    createStepComponent(stepIndex) {
        const container = document.createElement("div");
        container.className =
            "step-item border border-dashed border-primary/30 rounded-lg p-4 bg-white/40";
        container.setAttribute("data-step", stepIndex);

        const grid = document.createElement("div");
        grid.className = "grid md:grid-cols-12 gap-3 items-start";

        const stepNumberCol = createGridColumn("md:col-span-1");
        const stepNumber = document.createElement("div");
        stepNumber.className =
            "w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center font-semibold text-sm";
        stepNumber.textContent = stepIndex + 1;
        stepNumberCol.appendChild(stepNumber);

        const descriptionCol = createGridColumn("md:col-span-6");
        const descTextarea = createTextarea(
            `steps[${stepIndex}][description]`,
            "Describe this step in detail...",
            "min-h-[80px]"
        );
        descriptionCol.appendChild(descTextarea);

        const typeCol = createGridColumn("md:col-span-2");
        const typeSelect = createSelect(`steps[${stepIndex}][step_type]`, [
            { value: "", text: "Select type" },
            { value: "preparation", text: "Prep" },
            { value: "cooking", text: "Cooking" },
            { value: "plating", text: "Plating" },
        ]);
        typeCol.appendChild(typeSelect);

        const timeCol = createGridColumn("md:col-span-2");
        const timeWrapper = createTimeInputWrapper(
            `steps[${stepIndex}][estimated_time_taken]`
        );
        timeCol.appendChild(timeWrapper);

        const removeCol = createGridColumn("md:col-span-1");
        const removeButton = createRemoveButton("remove-step");
        removeCol.appendChild(removeButton);

        grid.appendChild(stepNumberCol);
        grid.appendChild(descriptionCol);
        grid.appendChild(typeCol);
        grid.appendChild(timeCol);
        grid.appendChild(removeCol);
        container.appendChild(grid);

        const orderInput = createHiddenInput(
            `steps[${stepIndex}][order]`,
            stepIndex + 1
        );
        container.appendChild(orderInput);

        return container;
    }

    createIngredientComponent(ingredientIndex) {
        const container = document.createElement("div");
        container.className =
            "ingredient-item grid grid-cols-12 gap-2 items-end";
        container.setAttribute("data-ingredient", ingredientIndex);

        const nameCol = createGridColumn("col-span-5");
        const nameInput = createTextInput(
            `ingredients[${ingredientIndex}][name]`,
            "Ingredient name"
        );
        nameCol.appendChild(nameInput);

        const amountCol = createGridColumn("col-span-3");
        const amountInput = createTextInput(
            `ingredients[${ingredientIndex}][amount]`,
            "Amount"
        );
        amountCol.appendChild(amountInput);

        const unitCol = createGridColumn("col-span-3");
        const unitSelect = createSelect(
            `ingredients[${ingredientIndex}][unit]`,
            [
                { value: "", text: "Unit" },
                { value: "cups", text: "cups" },
                { value: "tbsp", text: "tbsp" },
                { value: "tsp", text: "tsp" },
                { value: "lbs", text: "lbs" },
                { value: "oz", text: "oz" },
                { value: "pieces", text: "pieces" },
                { value: "cloves", text: "cloves" },
            ]
        );
        unitCol.appendChild(unitSelect);

        const removeCol = createGridColumn("col-span-1");
        const removeButton = createRemoveButton("remove-ingredient");
        removeButton.className +=
            " w-full h-[42px] flex items-center justify-center";
        removeCol.appendChild(removeButton);

        container.appendChild(nameCol);
        container.appendChild(amountCol);
        container.appendChild(unitCol);
        container.appendChild(removeCol);

        return container;
    }

    createTagComponent(tagIndex) {
        const container = document.createElement("div");
        container.className = "tag-item grid grid-cols-12 gap-2 items-end";
        container.setAttribute("data-tag", tagIndex);

        const nameCol = createGridColumn("col-span-5");
        const nameInput = createTextInput(
            `tags[${tagIndex}][name]`,
            "e.g., vegetarian, quick, comfort-food"
        );
        nameCol.appendChild(nameInput);

        const typeCol = createGridColumn("col-span-6");
        const typeSelect = createSelect(`tags[${tagIndex}][type]`, [
            { value: "", text: "Select tag type" },
            { value: "origin", text: "🌍 Origin" },
            { value: "dietary", text: "🥗 Dietary" },
            { value: "course", text: "🍽️ Course" },
            { value: "method", text: "👨‍🍳 Cooking Method" },
            { value: "occasion", text: "🎉 Occasion" },
        ]);
        typeCol.appendChild(typeSelect);

        const removeCol = createGridColumn("col-span-1");
        const removeButton = createRemoveButton("remove-tag");
        removeButton.className +=
            " w-full h-[42px] flex items-center justify-center";
        removeCol.appendChild(removeButton);

        container.appendChild(nameCol);
        container.appendChild(typeCol);
        container.appendChild(removeCol);

        return container;
    }

    addStep() {
        const container = document.getElementById("steps-container");
        const stepComponent = this.createStepComponent(this.stepCounter);
        container.appendChild(stepComponent);
        this.stepCounter++;
        reinitializeLucideIcons();
    }

    addIngredient() {
        const container = document.getElementById("ingredients-container");
        const ingredientComponent = this.createIngredientComponent(
            this.ingredientCounter
        );
        container.appendChild(ingredientComponent);
        this.ingredientCounter++;
        reinitializeLucideIcons();
    }

    addTag() {
        const container = document.getElementById("tags-container");
        const tagComponent = this.createTagComponent(this.tagCounter);
        container.appendChild(tagComponent);
        this.tagCounter++;
        reinitializeLucideIcons();
    }

    initEventListeners() {
        document
            .getElementById("add-step")
            ?.addEventListener("click", () => this.addStep());
        document
            .getElementById("add-ingredient")
            ?.addEventListener("click", () => this.addIngredient());
        document
            .getElementById("add-tag")
            ?.addEventListener("click", () => this.addTag());

        document.addEventListener("click", (e) => {
            if (e.target.closest(".remove-step")) {
                const stepItems = document.querySelectorAll(".step-item");
                if (stepItems.length > 1) {
                    e.target.closest(".step-item").remove();
                    this.updateStepNumbers();
                }
            }
            if (e.target.closest(".remove-ingredient")) {
                const ingredientItems =
                    document.querySelectorAll(".ingredient-item");
                if (ingredientItems.length > 1) {
                    e.target.closest(".ingredient-item").remove();
                    this.updateIngredientNumbers();
                }
            }
            if (e.target.closest(".remove-tag")) {
                const tagItems = document.querySelectorAll(".tag-item");
                if (tagItems.length > 1) {
                    e.target.closest(".tag-item").remove();
                    this.updateTagNumbers();
                }
            }
        });
    }

    updateStepNumbers() {
        const stepItems = document.querySelectorAll(".step-item");
        stepItems.forEach((item, index) => {
            const stepNumber = item.querySelector(".w-8.h-8.bg-primary");
            if (stepNumber) {
                stepNumber.textContent = index + 1;
            }

            const orderInput = item.querySelector('input[name*="[order]"]');
            if (orderInput) {
                orderInput.value = index + 1;
            }
        });
    }

    addInitialItems() {
        this.addStep();
        this.addIngredient();
        this.addTag();
    }
}

document.addEventListener("DOMContentLoaded", function () {
    new RecipeUploadManager();
});
