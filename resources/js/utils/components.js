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

// Button utility methods - matches the x-button Blade component styling
export const ButtonVariant = {
    PRIMARY: "primary",
    SECONDARY: "secondary",
};

export const ButtonSize = {
    SMALL: "sm",
    MEDIUM: "md",
    LARGE: "lg",
};

export function createButton(options = {}) {
    const {
        text = "",
        icon = null,
        variant = ButtonVariant.PRIMARY,
        size = ButtonSize.MEDIUM,
        type = "button",
        className = "",
        attributes = {},
        onClick = null,
        dataAction = null,
    } = options;

    const button = document.createElement("button");
    button.type = type;

    // Style classes based on variant
    const primaryStyle = "bg-primary text-white border border-primary";
    const secondaryStyle =
        "text-text bg-background/95 border border-primary border-dashed";

    const styleClass =
        variant === ButtonVariant.PRIMARY ? primaryStyle : secondaryStyle;

    // Size classes
    const sizeClasses = {
        [ButtonSize.SMALL]: "text-sm",
        [ButtonSize.MEDIUM]: "text-base",
        [ButtonSize.LARGE]: "text-md",
    };

    const sizeClass = sizeClasses[size] || sizeClasses[ButtonSize.MEDIUM];

    // Base classes (matching the Blade component)
    const baseClasses =
        "px-3 py-2 flex items-center justify-center gap-3 hover:brightness-90 rounded transition duration-300 ease-in-out box-border cursor-pointer";

    // Combine all classes
    button.className =
        `${styleClass} ${sizeClass} ${baseClasses} ${className}`.trim();

    // Add data-action if provided
    if (dataAction) {
        button.setAttribute("data-action", dataAction);
    }

    // Add any additional attributes
    Object.entries(attributes).forEach(([key, value]) => {
        button.setAttribute(key, value);
    });

    // Add click handler if provided
    if (onClick) {
        button.addEventListener("click", onClick);
    }

    // Add icon if provided
    if (icon) {
        if (typeof icon === "string") {
            // If icon is a string (lucide icon name)
            const iconElement = document.createElement("i");
            iconElement.setAttribute("data-lucide", icon);
            iconElement.className = "w-4 h-4";
            button.appendChild(iconElement);
        } else if (icon instanceof HTMLElement) {
            // If icon is already an HTML element
            button.appendChild(icon);
        } else if (typeof icon === "object" && icon.name) {
            // If icon is an object with name and optional classes
            const iconElement = document.createElement("i");
            iconElement.setAttribute("data-lucide", icon.name);
            iconElement.className = icon.className || "w-4 h-4";
            button.appendChild(iconElement);
        }
    }

    // Add text if provided
    if (text) {
        const textSpan = document.createElement("span");
        textSpan.textContent = text;
        button.appendChild(textSpan);
    }

    return button;
}

export function createPrimaryButton(text, options = {}) {
    return createButton({
        text,
        variant: ButtonVariant.PRIMARY,
        ...options,
    });
}

export function createSecondaryButton(text, options = {}) {
    return createButton({
        text,
        variant: ButtonVariant.SECONDARY,
        ...options,
    });
}

export function createIconButton(iconName, options = {}) {
    return createButton({
        icon: iconName,
        ...options,
    });
}

export function createCloseButton(options = {}) {
    return createButton({
        icon: "x",
        variant: ButtonVariant.SECONDARY,
        dataAction: "close-popup",
        className: "w-8 h-8 p-0",
        ...options,
    });
}

export function createSubmitButton(text = "Submit", options = {}) {
    return createButton({
        text,
        type: "submit",
        variant: ButtonVariant.PRIMARY,
        ...options,
    });
}
