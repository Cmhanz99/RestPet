// Main JavaScript for PetRest website

// Elements
const viewMoreBtn = document.getElementById('view-more-btn');
const viewLessBtn = document.getElementById('view-less-btn');
const hamburger = document.querySelector('.hamburger');
const navLinks = document.querySelector('.nav-links');
const hiddenProperties = document.querySelectorAll('.hidden-property');

// Hamburger menu toggle
hamburger.addEventListener('click', function() {
    navLinks.classList.toggle('active');
    this.classList.toggle('active');
});

// View more button functionality
viewMoreBtn.addEventListener('click', function() {
    // Show hidden properties
    hiddenProperties.forEach(property => {
        property.classList.remove('hidden-property');
    });

    // Hide the view more button and show the view less button
    this.style.display = 'none';
    viewLessBtn.style.display = 'block';
});

// View less button functionality
viewLessBtn.addEventListener('click', function() {
    // Hide properties beyond the first 6
    hiddenProperties.forEach(property => {
        property.classList.add('hidden-property');
    });

    // Show the view more button and hide the view less button
    viewMoreBtn.style.display = 'block';
    this.style.display = 'none';

    // Scroll back to the properties section to prevent confusion
    document.querySelector('.listing').scrollIntoView({ behavior: 'smooth' });
});

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    // Make sure hidden properties are actually hidden
    hiddenProperties.forEach(property => {
        property.classList.add('hidden-property');
    });

    // Show the view more button and hide the view less button initially
    if (hiddenProperties.length > 0) {
        viewMoreBtn.style.display = 'block';
        viewLessBtn.style.display = 'none';
    } else {
        viewMoreBtn.style.display = 'none';
        viewLessBtn.style.display = 'none';
    }
});
