// Modal functionality for property details
document.addEventListener("DOMContentLoaded", function () {
    // Elements
    const propertyModal = document.getElementById("property-modal");
    const closeModalBtn = document.querySelector(".close-modal");

    // Function to open property modal with details
    window.openPropertyModal = function (propertyId) {
        const propertyCard = document.querySelector(
            `.property-card[data-id="${propertyId}"]`
        );

        if (propertyCard) {
            // Get information from the property card
            const title = propertyCard.querySelector("h3").textContent;
            const location =
                propertyCard.querySelector(".location").textContent;
            const price = propertyCard.querySelector(".price").textContent;
            const description = propertyCard.getAttribute("data-description");
            const image = propertyCard
                .querySelector(".property-image")
                .style.backgroundImage.slice(5, -2);

            // Set modal content
            document.getElementById("modal-title").textContent = title;
            document.getElementById("modal-location").textContent = location;
            document.getElementById("modal-price").textContent = price;
            document.getElementById("modal-description").textContent =
                description;
            document.getElementById("modal-image").src = image;

            // Show modal
            propertyModal.style.display = "block";
            document.body.style.overflow = "hidden";
        }
    };

    // Add click handlers to all details buttons
    document.querySelectorAll(".details-btn").forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            const propertyId = this.getAttribute("data-id");
            openPropertyModal(propertyId);
        });
    });

    // Close modal handlers
    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", function () {
            propertyModal.style.display = "none";
            document.body.style.overflow = "auto";
        });
    }

    // Close on outside click
    window.addEventListener("click", function (event) {
        if (event.target === propertyModal) {
            propertyModal.style.display = "none";
            document.body.style.overflow = "auto";
        }
    });
});
