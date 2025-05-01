// User-specific JavaScript functionality
document.addEventListener("DOMContentLoaded", function () {
    // Initialize the user profile dropdown functionality
    initUserProfileDropdown();

    // Initialize favorite property functionality
    initFavoriteButtons();

    // Initialize booking modal functionality
    initBookingModal();

    // Initialize send message functionality
    initSendMessage();
});

// User Profile Dropdown
function initUserProfileDropdown() {
    const userProfile = document.querySelector(".user-profile");
    const userDropdown = document.querySelector(".user-dropdown");

    if (userProfile && userDropdown) {
        userProfile.addEventListener("click", function (e) {
            e.stopPropagation();
            userDropdown.style.display =
                userDropdown.style.display === "block" ? "none" : "block";
        });

        // Close dropdown when clicking elsewhere
        document.addEventListener("click", function () {
            userDropdown.style.display = "none";
        });
    }
}

// Favorite Property Functionality
function initFavoriteButtons() {
    const favoriteButtons = document.querySelectorAll(".favorite-btn");

    favoriteButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            e.stopPropagation(); // Prevent property card click

            const propertyId = this.getAttribute("data-id");
            const favoriteIcon = this.querySelector("i");

            // Toggle favorite icon
            if (favoriteIcon.classList.contains("far")) {
                // Add to favorites
                favoriteIcon.classList.remove("far");
                favoriteIcon.classList.add("fas");
                addToFavorites(propertyId);
            } else {
                // Remove from favorites
                favoriteIcon.classList.remove("fas");
                favoriteIcon.classList.add("far");
                removeFromFavorites(propertyId);
            }
        });
    });
}

// Add to favorites via AJAX
function addToFavorites(propertyId) {
    fetch("/api/favorites/add", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content"),
        },
        body: JSON.stringify({
            property_id: propertyId,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // Show success notification
                showNotification("Property added to favorites", "success");
            } else {
                // Show error notification
                showNotification("Could not add to favorites", "error");
            }
        })
        .catch((error) => {
            console.error("Error adding favorite:", error);
            showNotification("Error adding to favorites", "error");
        });
}

// Remove from favorites via AJAX
function removeFromFavorites(propertyId) {
    fetch("/api/favorites/remove", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content"),
        },
        body: JSON.stringify({
            property_id: propertyId,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // Show success notification
                showNotification("Property removed from favorites", "success");
            } else {
                // Show error notification
                showNotification("Could not remove from favorites", "error");
            }
        })
        .catch((error) => {
            console.error("Error removing favorite:", error);
            showNotification("Error removing from favorites", "error");
        });
}

// Booking Modal Functionality
function initBookingModal() {
    const bookingModal = document.getElementById("booking-modal");
    const closeBookingModalBtn = document.getElementById("close-booking-modal");
    const confirmBookingBtn = document.getElementById("confirm-booking-btn");

    if (bookingModal && closeBookingModalBtn && confirmBookingBtn) {
        // Close booking modal when clicking the X button
        closeBookingModalBtn.addEventListener("click", function () {
            bookingModal.style.display = "none";
            document.body.style.overflow = "auto";
        });

        // Close booking modal when clicking outside of modal content
        window.addEventListener("click", function (event) {
            if (event.target === bookingModal) {
                bookingModal.style.display = "none";
                document.body.style.overflow = "auto";
            }
        });

        // Handle booking confirmation
        confirmBookingBtn.addEventListener("click", function () {
            submitBooking();
        });
    }
}
