export function createTextInput(name, placeholder, required = true) {
    const input = document.createElement("input");
    input.type = "text";
    input.name = name;
    input.required = required;
    input.placeholder = placeholder;
    input.className =
        "border border-dashed border-primary/30 bg-secondary/15 px-3 py-2 rounded focus:outline-2 focus:outline-primary w-full";
    return input;
}

export function createNumberInput(
    name,
    placeholder,
    min = null,
    required = true
) {
    const input = document.createElement("input");
    input.type = "number";
    input.name = name;
    input.required = required;
    input.placeholder = placeholder;
    if (min !== null) input.min = min;
    input.className =
        "border border-dashed border-primary/30 bg-secondary/15 px-3 py-2 rounded focus:outline-2 focus:outline-primary w-full";
    return input;
}

export function createTextarea(
    name,
    placeholder,
    additionalClasses = "",
    required = true
) {
    const textarea = document.createElement("textarea");
    textarea.name = name;
    textarea.required = required;
    textarea.placeholder = placeholder;
    textarea.className = `border border-dashed border-primary/30 bg-secondary/15 px-3 py-2 rounded focus:outline-2 focus:outline-primary w-full resize-none ${additionalClasses}`;
    return textarea;
}

export function createSelect(name, options, required = true) {
    const wrapper = document.createElement("div");
    wrapper.className = "relative";

    const select = document.createElement("select");
    select.name = name;
    select.required = required;
    select.className =
        "border border-dashed border-primary/30 bg-secondary/15 px-3 pr-10 py-2 focus:outline-2 focus:outline-primary rounded w-full appearance-none cursor-pointer text-text";

    options.forEach((option) => {
        const optionElement = document.createElement("option");
        optionElement.value = option.value;
        optionElement.textContent = option.text;
        if (option.value === "") {
            optionElement.disabled = true;
            optionElement.selected = true;
        }
        select.appendChild(optionElement);
    });

    const chevron = document.createElement("div");
    chevron.className =
        "absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none";
    chevron.innerHTML = `
        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    `;

    wrapper.appendChild(select);
    wrapper.appendChild(chevron);

    return wrapper;
}

export function createHiddenInput(name, value) {
    const input = document.createElement("input");
    input.type = "hidden";
    input.name = name;
    input.value = value;
    return input;
}

export function createLabel(text) {
    const label = document.createElement("label");
    label.className = "text-text/60 text-sm";
    label.textContent = text;
    return label;
}

export function createItemHeader(title, removeClassName) {
    const header = document.createElement("div");
    header.className = "flex items-center justify-between mb-3";

    const titleElement = document.createElement("h4");
    titleElement.className = "font-semibold text-gray-700";
    titleElement.textContent = title;

    const removeButton = document.createElement("button");
    removeButton.type = "button";
    removeButton.className = `${removeClassName} text-red-500 hover:text-red-700`;

    const icon = document.createElement("i");
    icon.setAttribute("data-lucide", "trash-2");
    icon.className = "w-4 h-4";

    removeButton.appendChild(icon);
    header.appendChild(titleElement);
    header.appendChild(removeButton);

    return header;
}

export function createRemoveButton(className, iconName = "minus") {
    const removeButton = document.createElement("button");
    removeButton.type = "button";
    removeButton.className = `${className} border border-dashed border-red-300 text-red-600 hover:bg-red-50 p-2 rounded transition cursor-pointer`;

    const removeIcon = document.createElement("i");
    removeIcon.setAttribute("data-lucide", iconName);
    removeIcon.className = "w-4 h-4";
    removeButton.appendChild(removeIcon);

    return removeButton;
}

export function reinitializeLucideIcons() {
    if (typeof lucide !== "undefined") {
        lucide.createIcons();
    }
}

export function createGridColumn(colSpan, additionalClasses = "") {
    const col = document.createElement("div");
    col.className = `${colSpan} ${additionalClasses}`.trim();
    return col;
}

export function createTimeInputWrapper(
    inputName,
    placeholder = "mins",
    min = 1
) {
    const timeWrapper = document.createElement("div");
    timeWrapper.className = "flex items-center gap-2";

    const clockIcon = document.createElement("i");
    clockIcon.setAttribute("data-lucide", "clock");
    clockIcon.className = "w-4 h-4 text-text/60";

    const timeInput = createNumberInput(inputName, placeholder, min);

    timeWrapper.appendChild(clockIcon);
    timeWrapper.appendChild(timeInput);

    return timeWrapper;
}
