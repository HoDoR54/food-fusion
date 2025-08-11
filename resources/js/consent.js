const doNotShowAgainCheckbox = document.getElementById("doNotShowAgain");

if (doNotShowAgainCheckbox) {
    doNotShowAgainCheckbox.addEventListener("change", function () {
        if (this.checked) {
            const formData = new FormData();
            formData.append("isPopUpConsent", "false");

            fetch("/set-session", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: formData,
            }).then((response) => {
                return response.json();
            });
        }
    });
}
