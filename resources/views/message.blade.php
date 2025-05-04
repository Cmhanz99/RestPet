<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Property Owner</title>
    <link rel="icon" href="{{asset ('logo/logo1.png')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset ('css/message.css')}}">
</head>
<body>
    <div class="chat-container">
        <!-- Contacts Sidebar -->
        <div class="contacts-sidebar">
            <div class="chat-header">
                <h2>Messages</h2>
            </div>
            <a href="/user" style="padding: 10px 20px; display: inline-block; text-decoration: none; color: #4a6fa5;">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search conversations...">
            </div>

            <ul class="contact-list">
                <!-- Active conversation -->
                <li class="contact-item active">
                    <div class="contact-avatar" style="background-image: url('{{asset('profile/' . $owner->profile)}}')"></div>
                    <div class="contact-details">
                        <div class="contact-name">{{$owner->name}}</div>
                        <div class="contact-preview">{{$recent->reply}}</div>
                    </div>
                    <div class="contact-time">{{$recent->created_at->format('h:i A')}}</div>
                </li>
            </ul>
        </div>

        <!-- Chat Main Area -->
        <div class="chat-main">
            <div class="chat-top-bar">
                <div class="chat-top-avatar" style="background-image: url('{{asset('profile/' . $owner->profile)}}')"></div>
                <div class="chat-top-details">
                    <h3>{{$owner->name}}</h3>
                    <p>Garden Owner</p>
                </div>
            </div>

            <div class="chat-messages">
                <div class="date-divider">
                    <span class="date-text">April 26, 2025</span>
                </div>
                <!-- Outgoing message -->
                @foreach ($messages as $message)
                @if ($message['type'] == 'outgoing')
                    <div class="message message-outgoing">
                        <div class="message-bubble">
                            {{ $message['text'] }}
                        </div>
                        <span class="message-time">{{ $message['time']->format('h:i A') }}</span>
                    </div>
                @else
                    <div class="message message-incoming">
                        <div class="message-bubble">
                            {{ $message['text'] }}
                        </div>
                        <span class="message-time">{{ $message['time']->format('h:i A') }}</span>
                    </div>
                @endif
            @endforeach
            <div id="bottomDiv"></div>
            <form class="chat-input-container" action="/form#bottomDiv" method="POST">
                @csrf
                <input hidden type="text" id="contact-name" name="name" placeholder="Name" value="{{ $user->name }}"
                readonly>
                <input hidden type="email" id="contact-email" name="email" placeholder="Email"
                value="{{ $user->email }}" readonly>
                <input hidden type="text" id="contact-phone" name="phone" placeholder="Phone" value="">
                <input type="text" autocomplete="off" class="chat-input" name="message" placeholder="Type your message...">
                <button type="submit" class="send-button">➤</button>
            </form>
        </div>
    </div>
</body>
</html>
