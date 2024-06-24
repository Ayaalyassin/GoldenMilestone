{{-- @extends('voyager::master')

@section('content')
<head>
    <title>Chat Channel</title>
    <!-- Add your CSS and JavaScript links here -->
    <style>
        /* Add your custom CSS styles here */
        .container {
            display: flex;
        }

        .sidebar {
            width: 200px;
            padding: 20px;
            background-color: #f2f2f2;
        }

        .chat-list {
            list-style-type: none;
            padding: 0;
        }

        .chat-item {
            margin-bottom: 10px;
        }

        .chat-avatar img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .chat-info {
            margin-left: 10px;
        }

        .chat-title {
            margin: 0;
            font-size: 16px;
        }

        .chat-last-message {
            margin: 0;
            font-size: 14px;
            color: #888888;
        }

        .chat-container {
            flex: 1;
            padding: 20px;
            background-color: #ffffff;
        }

        .chat-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .chat-avatar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .chat-info {
            margin-left: 10px;
        }

        .chat-title {
            margin: 0;
            font-size: 18px;
        }

        .chat-status {
            margin: 0;
            font-size: 14px;
            color: #888888;
        }

        .chat-messages {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 10px;
            padding-right: 10px;
        }

        .message {
            margin-bottom: 10px;
        }

        .message-user {
            font-weight: bold;
            color: #333333;
        }

        .message-body {
            margin-top: 5px;
            margin-left: 20px;
            color: #555555;
        }

        .chat-input {
            display: flex;
        }

        .chat-input input[type="text"] {
            flex: 1;
            padding: 5px;
            border: 1px solid #dddddd;
            border-radius: 5px;
        }

        .chat-input button {
            margin-left: 10px;
            padding: 5px 10px;
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="logo">
                <!-- Your logo or branding -->
            </div>
            <ul class="chat-list">
                @foreach ($chats as $chat)
                    <li class="chat-item">
                        <a href="{{ route('chat', ['id' => $chat['id']]) }}">
                            <div class="chat-avatar">
                                <img src="{{ $chat['avatar'] }}" alt="Avatar">
                            </div>
                            <div class="chat-info">
                                <h4 class="chat-title">{{ $chat['name'] }}</h4>
                                <p class="chat-last-message">{{ $chat['lastMessage'] }}</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="chat-container">
            <div class="chat-header">
                <div class="chat-avatar">
                    <img src="{{ $currentChat['avatar'] }}" alt="Avatar">
                </div>
                <div class="chat-info">
                    <h2 class="chat-title">{{ $currentChat['name'] }}</h2>
                    <p class="chat-status">{{ $currentChat['status'] }}</p>
                </div>
            </div>
            <div class="chat-messages">
                @foreach ($messages as $message)
                    <div class="message">
                        <div class="message-user">{{ $message['user'] }}</div>
                        <div class="message-body">{{ $message['body'] }}</div>
                    </div>
                @endforeach
            </div>
            <div class="chat-input">
                <form action="{{ route('sendMessage', ['id' => $currentChat['id']]) }}" method="POST">
                    @csrf
                    <input type="text" name="message" placeholder="Type your message...">
                    <button type="submit">Send</button>
                </form>
            </div>

        </div>
    </div>
</body>
@endsection --}}
