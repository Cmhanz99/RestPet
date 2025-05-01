// Chatbot functionality

// Elements
const chatbotIcon = document.getElementById("chatbot-icon");
const chatbotContainer = document.getElementById("chatbot-container");
const closeChatbotBtn = document.getElementById("close-chatbot");
const chatbotMessages = document.querySelector(".chatbot-messages");
const userInput = document.getElementById("user-input");
const sendMessageBtn = document.getElementById("send-message");

// Simple responses for the chatbot
const chatbotResponses = {
    greeting: [
        "Hello! How can I help you find the perfect pet-friendly property today?",
        "Hi there! Looking for a place for you and your furry friend?",
        "Welcome to PetRest! I can help you find pet-friendly accommodations.",
    ],
    location: [
        "We have properties in Downtown, Suburbs, Waterfront, and Rural areas. Which location interests you?",
        "Our most popular pet-friendly locations are Downtown and the Waterfront areas. Would you like to see properties there?",
    ],
    price: [
        "Our properties range from $120 to $200 per night. Do you have a specific budget in mind?",
        "We have options for all budgets! The average price is around $160 per night.",
    ],
    pets: [
        "All our properties are pet-friendly! Some may have specific policies regarding size or type of pets.",
        "Yes, we specialize in pet-friendly accommodations! What type of pet do you have?",
    ],
    amenities: [
        "Our properties offer amenities like fenced yards, nearby parks, and pet washing stations.",
        "Many of our properties have pet-specific amenities like pet beds, food bowls, and toys.",
    ],
    default: [
        "I'd be happy to help you with that. Could you provide more details?",
        "Let me check that for you. In the meantime, you can browse our featured properties.",
        "That's a great question! Our customer service team would have the most accurate information.",
    ],
};

// Toggle chatbot visibility
chatbotIcon.addEventListener("click", function () {
    chatbotContainer.style.display = "flex";
    chatbotIcon.style.display = "none";
});

// Close chatbot
closeChatbotBtn.addEventListener("click", function () {
    chatbotContainer.style.display = "none";
    chatbotIcon.style.display = "flex";
});

// Send message when clicking the send button
sendMessageBtn.addEventListener("click", sendUserMessage);

// Send message when pressing Enter in input field
userInput.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        sendUserMessage();
    }
});

// Function to send user message and get chatbot response
function sendUserMessage() {
    const message = userInput.value.trim();

    if (message === "") return;

    // Add user message to chat
    addMessage(message, "user");

    // Clear input field
    userInput.value = "";

    // Add typing indicator
    addMessage("Typing...", "bot");

    // Simulate chatbot thinking
    setTimeout(() => {
        // Remove typing indicator
        removeLastBotMessage();

        // Get chatbot response
        const response = getChatbotResponse(message);

        // Add chatbot response to chat
        addMessage(response, "bot");

        // Scroll to bottom of chat
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }, 1000);
}

// Function to add a message to the chat
function addMessage(text, sender) {
    const messageElement = document.createElement("div");
    messageElement.className = `message ${sender}`;
    messageElement.textContent = text;
    chatbotMessages.appendChild(messageElement);

    // Scroll to bottom of chat
    chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
}

// Add this new function after the addMessage function
function removeLastBotMessage() {
    const messages = chatbotMessages.getElementsByClassName("message bot");
    if (messages.length > 0) {
        messages[messages.length - 1].remove();
    }
}

// Function to get a response from the chatbot
function getChatbotResponse(message) {
    message = message.toLowerCase();

    // Check for keywords in the message
    if (
        message.includes("hello") ||
        message.includes("hi") ||
        message.includes("hey")
    ) {
        return "Hello! How can I help you find the perfect resting place for your pet?";
    } else if (
        message.includes("price") ||
        message.includes("cost") ||
        message.includes("how much")
    ) {
        return "Our prices range from ₱800 to ₱15,500 depending on the location, size, and type of memorial space you're looking for. Would you like to learn about our different options?";
    } else if (message.includes("location") || message.includes("where")) {
        return "We have properties in the North, South, East, and West regions. Each offers unique features like meadows, gardens, riverside spots, or shaded areas. Which would you prefer for your pet?";
    } else if (
        message.includes("type") ||
        message.includes("options") ||
        message.includes("different")
    ) {
        return "We offer individual plots, communal garden spaces, and memorial park options. Individual plots are private spaces, communal gardens offer shared beautiful surroundings, and memorial parks include additional features like benches or statues.";
    } else if (
        message.includes("visit") ||
        message.includes("tour") ||
        message.includes("see")
    ) {
        return "We'd be happy to arrange a visit for you to see our properties. You can schedule a tour through our contact form, or I can help you book a time right now. When would be convenient for you?";
    } else if (
        message.includes("services") ||
        message.includes("ceremony") ||
        message.includes("burial")
    ) {
        return "We offer complete memorial services including eco-friendly burial options, ceremony spaces, perpetual care, and customized memorials. Would you like more information about any specific service?";
    } else if (message.includes("thank") || message.includes("thanks")) {
        return "You're very welcome. Feel free to ask if you have any other questions!";
    } else if (message.includes("goodbye") || message.includes("bye")) {
        return "Thank you for chatting with us. We're here whenever you need assistance. Take care!";
    } else if (
        message.includes("owner") ||
        message.includes("develop") ||
        message.includes("make")
    ) {
        return "The developer of this website is Handzome Christian Angelo G. Magbal.";
    } else if (
        message.includes("recommendation") ||
        message.includes("recommend")
    ) {
        return (
            "I'll help you for reccomendation : Shared Memorial Wall is the" +
            " best choice and the Cheapest"
        );
    } else if (message.includes("clear")) {
        document.getElementById(
            "chatbot-messages"
        ).innerHTML = `<div class = "bot-message">Hello! How can I help you find the perfect resting place for your pet?</div>`;
        return;
    } else {
        return "I'd be happy to help with that. but i was built for only quick inquires for this website my apologies.";
    }
}

// Function to get a random response from a category
function getRandomResponse(category) {
    const responses = chatbotResponses[category];
    const randomIndex = Math.floor(Math.random() * responses.length);
    return responses[randomIndex];
}
