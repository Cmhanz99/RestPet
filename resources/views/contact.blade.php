<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Property Owner</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        .chat-container {
            max-width: 1000px;
            margin: 40px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            height: 80vh;
        }

        .contacts-sidebar {
            width: 280px;
            background: #f9fbff;
            border-right: 1px solid #eaeef3;
            overflow-y: auto;
        }

        .chat-header {
            padding: 20px;
            border-bottom: 1px solid #eaeef3;
        }

        .chat-header h2 {
            color: #4a6fa5;
            font-size: 18px;
        }

        .search-container {
            padding: 15px;
            border-bottom: 1px solid #eaeef3;
        }

        .search-input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 20px;
            font-size: 14px;
        }

        .contact-list {
            list-style: none;
        }

        .contact-item {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #eaeef3;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .contact-item:hover {
            background: #edf2f9;
        }

        .contact-item.active {
            background: #edf2f9;
            border-left: 3px solid #4a6fa5;
        }

        .contact-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #e1e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4a6fa5;
            font-weight: bold;
            margin-right: 15px;
            font-size: 16px;
        }

        .contact-details {
            flex: 1;
        }

        .contact-name {
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }

        .contact-preview {
            font-size: 13px;
            color: #777;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        .contact-time {
            font-size: 12px;
            color: #999;
        }

        .unread-badge {
            background: #4a6fa5;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            margin-left: 10px;
        }

        .chat-main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .chat-top-bar {
            padding: 15px 20px;
            border-bottom: 1px solid #eaeef3;
            display: flex;
            align-items: center;
            background: #fff;
        }

        .chat-top-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e1e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4a6fa5;
            font-weight: bold;
            margin-right: 15px;
            font-size: 16px;
        }

        .chat-top-details h3 {
            font-size: 16px;
            margin-bottom: 3px;
        }

        .chat-top-details p {
            font-size: 13px;
            color: #777;
        }

        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background: #f9fbff;
        }

        .message {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }

        .message-incoming {
            align-items: flex-start;
        }

        .message-outgoing {
            align-items: flex-end;
        }

        .message-bubble {
            max-width: 80%;
            padding: 12px 15px;
            border-radius: 18px;
            font-size: 14px;
            margin-bottom: 5px;
            position: relative;
        }

        .message-incoming .message-bubble {
            background: white;
            border: 1px solid #eaeef3;
            border-top-left-radius: 0;
        }

        .message-outgoing .message-bubble {
            background: #4a6fa5;
            color: white;
            border-top-right-radius: 0;
        }

        .message-time {
            font-size: 11px;
            color: #999;
            margin-top: 3px;
        }

        .message-outgoing .message-time {
            text-align: right;
        }

        .chat-input-container {
            padding: 15px;
            border-top: 1px solid #eaeef3;
            display: flex;
            align-items: center;
            background: white;
        }

        .chat-input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 24px;
            font-size: 14px;
            margin-right: 10px;
        }

        .send-button {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #4a6fa5;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s ease;
            border: none;
            font-size: 18px;
        }

        .send-button:hover {
            background: #3a5985;
        }

        .chat-welcome {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #f9fbff;
            color: #7a8a9e;
            text-align: center;
            padding: 20px;
        }

        .chat-welcome-icon {
            font-size: 60px;
            margin-bottom: 20px;
            color: #d0dae9;
        }

        .chat-welcome h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #4a6fa5;
        }

        .chat-welcome p {
            max-width: 400px;
            line-height: 1.6;
        }

        .date-divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .date-divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            height: 1px;
            width: 100%;
            background: #eaeef3;
            z-index: 1;
        }

        .date-text {
            position: relative;
            background: #f9fbff;
            padding: 0 15px;
            font-size: 12px;
            color: #999;
            z-index: 2;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .contacts-sidebar {
                width: 80px;
            }

            .contact-details {
                display: none;
            }

            .contact-item {
                justify-content: center;
                padding: 15px 10px;
            }

            .contact-avatar {
                margin-right: 0;
            }

            .unread-badge {
                position: absolute;
                top: 5px;
                right: 5px;
                margin-left: 0;
            }

            .search-container {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <!-- Contacts Sidebar -->
        <div class="contacts-sidebar">
            <div class="chat-header">
                <h2>Messages</h2>
            </div>

            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search conversations...">
            </div>

            <ul class="contact-list">
                <!-- Active conversation -->
                <li class="contact-item active">
                    <div class="contact-avatar">JS</div>
                    <div class="contact-details">
                        <div class="contact-name">John Smith</div>
                        <div class="contact-preview">When is my slot available?</div>
                    </div>
                    <div class="contact-time">12:45 PM</div>
                </li>

                <!-- Other conversations -->
                <li class="contact-item">
                    <div class="contact-avatar">SJ</div>
                    <div class="contact-details">
                        <div class="contact-name">Sarah Johnson</div>
                        <div class="contact-preview">Thank you for approving my reservation...</div>
                    </div>
                    <div class="contact-time">Yesterday</div>
                </li>

                <li class="contact-item">
                    <div class="contact-avatar">MR</div>
                    <div class="contact-details">
                        <div class="contact-name">Maria Rodriguez</div>
                        <div class="contact-preview">I'd like to discuss my upcoming service.</div>
                    </div>
                    <div class="contact-time">Apr 24</div>
                    <div class="unread-badge">2</div>
                </li>

                <li class="contact-item">
                    <div class="contact-avatar">DT</div>
                    <div class="contact-details">
                        <div class="contact-name">David Thompson</div>
                        <div class="contact-preview">Looking forward to the memorial service.</div>
                    </div>
                    <div class="contact-time">Apr 23</div>
                </li>

                <li class="contact-item">
                    <div class="contact-avatar">EB</div>
                    <div class="contact-details">
                        <div class="contact-name">Emma Brown</div>
                        <div class="contact-preview">Can I visit the plot this weekend?</div>
                    </div>
                    <div class="contact-time">Apr 20</div>
                </li>
            </ul>
        </div>

        <!-- Chat Main Area -->
        <div class="chat-main">
            <div class="chat-top-bar">
                <div class="chat-top-avatar">JS</div>
                <div class="chat-top-details">
                    <h3>John Smith</h3>
                    <p>Owner of Plot #A1</p>
                </div>
            </div>

            <div class="chat-messages">
                <div class="date-divider">
                    <span class="date-text">April 26, 2025</span>
                </div>

                <!-- Incoming message -->
                <div class="message message-incoming">
                    <div class="message-bubble">
                        Hello, I'm interested in your property services. I recently lost my pet Max and would like to know more about the memorial options.
                    </div>
                    <span class="message-time">10:30 AM</span>
                </div>

                <!-- Outgoing message -->
                <div class="message message-outgoing">
                    <div class="message-bubble">
                        Hi John, I'm sorry for your loss. We offer various memorial options for beloved pets. Would you like to see our available plots?
                    </div>
                    <span class="message-time">10:35 AM</span>
                </div>

                <!-- Incoming message -->
                <div class="message message-incoming">
                    <div class="message-bubble">
                        Yes, please. I'm particularly interested in plots that have a peaceful view. Max loved sitting by the window watching birds.
                    </div>
                    <span class="message-time">10:38 AM</span>
                </div>

                <!-- Outgoing message -->
                <div class="message message-outgoing">
                    <div class="message-bubble">
                        We have several plots in our garden section with beautiful views of the bird sanctuary. Plot #A5 and #B2 are currently available. Would you like me to send you photos?
                    </div>
                    <span class="message-time">10:42 AM</span>
                </div>

                <!-- Incoming message -->
                <div class="message message-incoming">
                    <div class="message-bubble">
                        That sounds perfect. Yes, please send me photos of both plots. Also, what are the pricing options?
                    </div>
                    <span class="message-time">11:05 AM</span>
                </div>

                <!-- Outgoing message -->
                <div class="message message-outgoing">
                    <div class="message-bubble">
                        Here are the photos of Plot #A5 and #B2. Plot #A5 is $450 and has 3 slots available. Plot #B2 is $550 with 4 slots available. Both include maintenance for 5 years.
                    </div>
                    <span class="message-time">11:15 AM</span>
                </div>

                <!-- Incoming message -->
                <div class="message message-incoming">
                    <div class="message-bubble">
                        Thank you for the information. I think I'm leaning towards Plot #A5. When is the earliest slot available?
                    </div>
                    <span class="message-time">12:45 PM</span>
                </div>
            </div>

            <div class="chat-input-container">
                <input type="text" class="chat-input" placeholder="Type your message...">
                <button class="send-button">➤</button>
            </div>
        </div>
    </div>
</body>
</html>
