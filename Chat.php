<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>My ChatBot</title>
    <style>
        .hidden {
            display: none;
        }

        .loading {
            display: flex;
            align-items: center;
            margin-left: 10px;
        }

        .loading .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #09f;
            margin: 0 2px;
            animation: bounce 0.6s infinite alternate;
        }

        .loading .dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .loading .dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes bounce {
            to {
                transform: translateY(-100%);
            }
        }

        .new-chat-view {
            max-height: 80vh;
            overflow-y: auto;
        }

        .speaker-icon {
            font-size: 16px;
            color: #007bff;
            cursor: pointer;
            position: relative;
            margin-left: 10px;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .speaker-icon.loading {
            pointer-events: none;
            color: #0056b3;
        }

        .speaker-icon.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            border: 3px solid #007bff;
            border-top: 3px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            transform: translate(-50%, -50%);
        }

        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }
    </style>
    <script>
        function displayWordByWord(content, elementId) {
            content = content.replace(/\*\*(.*?)\*\*/g, '<b>$1</b>');

            let words = content.split(' ');
            let i = 0;

            function displayNextWord() {
                if (i < words.length) {
                    document.getElementById(elementId).innerHTML = words.slice(0, i + 1).join(' ') + ' <span class="writing">|</span>';
                    i++;
                    setTimeout(displayNextWord, 40);
                } else {
                    document.querySelector('.writing').remove();
                }
                scrollToBottom();
            }

            displayNextWord();
        }

        function scrollToBottom() {
            const chatContainer = document.querySelector('.new-chat-view');
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    </script>
</head>
<body>
<main class="main-content">
    <div class="view new-chat-view">
        <div class="model-selector">
            <button class="gpt-3 selected">
                <i class="fa fa-bolt"></i> Gemma:2b
                <div class="model-info">
                    <div class="model-info-box">
                        <p>Our fastest model, great for most everyday tasks.</p>
                        <p class="secondary">Available to all users</p>
                    </div>
                </div>
            </button>
            <button class="gpt-4">
                <i class="fa fa-wand-magic-sparkles"></i> llama:7b
                <div class="model-info">
                    <div class="model-info-box">
                        <p>Our most capable model, great for creative tasks.</p>
                        <p class="secondary">Coming Out Soon</p>
                    </div>
                </div>
            </button>
        </div>
        <div class="logo">
            MyChatBot
        </div>
        
        <div class="user message hidden">
            <div class="identity">
                <i class="user-icon">u</i>
            </div>
            <div class="content">
                <p></p>
            </div>
        </div>
        <div id="output" class="assistant message hidden">
            <div class="identity">
                <i class="gpt user-icon">G</i>
            </div>
            <div id="words" class="content">
                <p id="text"></p>
            </div>
        </div>
        
        <div class="loading hidden" id="loading">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
        <script>
                 var loadingIndicator = document.getElementById('loading');
                 loadingIndicator.style.display = 'none';
        </script>
    </div>
    
    <form id="questionForm" method="post">
        <div id="message-form">
            <div class="message-wrapper">
                <textarea name="question" id="message" rows="1" placeholder="Enter Questions"></textarea>
                <button type="submit" class="send-button"><i class="fa fa-paper-plane"></i></button>
            </div>
            <div class="disclaimer"><a style="color: white;" href="https://sk10codebase.online/">Made by John@sk10</a></div>
        </div>
    </form>

    <script>
    let currentAudio = null;

    document.getElementById('questionForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this);
        var userQuestion = document.getElementById('message').value;

        var userMessageDiv = document.createElement('div');
        userMessageDiv.className = 'user message';

        var userIdentityDiv = document.createElement('div');
        userIdentityDiv.className = 'identity';

        var userIcon = document.createElement('i');
        userIcon.className = 'user-icon';
        userIcon.textContent = 'u';

        userIdentityDiv.appendChild(userIcon);

        var userContentDiv = document.createElement('div');
        userContentDiv.className = 'content';

        var userTextP = document.createElement('p');
        userTextP.textContent = userQuestion;

        userContentDiv.appendChild(userTextP);
        userMessageDiv.appendChild(userIdentityDiv);
        userMessageDiv.appendChild(userContentDiv);

        var loadingIndicator = document.createElement('div');
        loadingIndicator.className = 'loading';
        loadingIndicator.innerHTML = `
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        `;

        userMessageDiv.appendChild(loadingIndicator);
        document.querySelector('.new-chat-view').appendChild(userMessageDiv);
        scrollToBottom();

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'https://yourserverIP/OllamaChat.php', true); // Update URL as needed
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(this.responseText);

                userMessageDiv.removeChild(loadingIndicator);

                if (response.status === 'success') {
                    var newMessageDiv = document.createElement('div');
                    newMessageDiv.className = 'assistant message';

                    var identityDiv = document.createElement('div');
                    identityDiv.className = 'identity';

                    var icon = document.createElement('i');
                    icon.className = 'gpt user-icon';
                    icon.textContent = 'G';

                    identityDiv.appendChild(icon);

                    var contentDiv = document.createElement('div');
                    contentDiv.className = 'content';

                    var textP = document.createElement('p');
                    var textId = 'response-' + Date.now();
                    textP.id = textId;
                    contentDiv.appendChild(textP);

                    newMessageDiv.appendChild(identityDiv);
                    newMessageDiv.appendChild(contentDiv);

                    document.querySelector('.new-chat-view').appendChild(newMessageDiv);
                    scrollToBottom();

                    displayWordByWord(response.output, textId);

                    var plainTextOutput = response.output.replace(/<br\s*\/?>/gi, '\n').replace(/<[^>]+>/g, '');

                    var ttsXhr = new XMLHttpRequest();
                    ttsXhr.open('POST', 'https://yourserverIP/Text_to_Speech_php/index.php', true); // Update URL as needed
                    ttsXhr.setRequestHeader('Content-Type', 'application/json');
                    ttsXhr.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var ttsResponse = JSON.parse(this.responseText);
                            if (currentAudio) {
                                currentAudio.pause();
                            }
                            currentAudio = new Audio(ttsResponse.audioUrl);
                            currentAudio.play();
                        }
                    };
                    ttsXhr.send(JSON.stringify({ text: plainTextOutput }));
                } else {
                    var errorDiv = document.createElement('div');
                    errorDiv.className = 'assistant message';

                    var errorIdentityDiv = document.createElement('div');
                    errorIdentityDiv.className = 'identity';

                    var errorIcon = document.createElement('i');
                    errorIcon.className = 'gpt user-icon';
                    errorIcon.textContent = 'G';

                    errorIdentityDiv.appendChild(errorIcon);

                    var errorContentDiv = document.createElement('div');
                    errorContentDiv.className = 'content';

                    var errorTextP = document.createElement('p');
                    errorTextP.textContent = 'An error occurred: ' + response.error;

                    errorContentDiv.appendChild(errorTextP);
                    errorDiv.appendChild(errorIdentityDiv);
                    errorDiv.appendChild(errorContentDiv);

                    document.querySelector('.new-chat-view').appendChild(errorDiv);
                    scrollToBottom();
                }
            }
        };
        xhr.send(formData);
    });
    </script>
</main>
</body>
</html>
