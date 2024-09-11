# AI-Conversational-Agent-with-Ollama
AI Conversational Agent with Ollama and Google Text-to-Speech
This project is an AI-powered conversational agent that uses Ollama for the language model and Google Text-to-Speech for audio output generation.

## Features

- Interactive chat interface
- Ollama integration for natural language processing
- Google Text-to-Speech integration for audio responses
- Real-time word-by-word display of responses
- Audio playback of AI responses

## Setup

 Clone this repository:
 ```bash
 git clone https://github.com/SK108045/AI-Conversational-Agent-with-Ollama.git
 cd AI-Conversational-Agent-with-Ollama
 ```

## Requirements

Before running this project, please ensure your server meets the following hardware requirements:

 **For Larger Models:**
  - GPU: A dedicated GPU is strongly recommended for optimal performance with larger language 
    models.
  - RAM: 16GB or more is advised for smooth operation.

 **For Smaller Models:**
  - CPU: A modern multi-core processor (e.g., Intel i5/i7 or AMD Ryzen 5/7) is sufficient.
  - RAM: Minimum 8GB, but 16GB or more is recommended for better performance.

## Dependencies and Installation

### 1. Apache Web Server

 You'll need a web server to run your PHP files and the LLM.
 First install and configure Apache:

 For Ubuntu:
 ```bash
 sudo apt update
 sudo apt install apache2
 ```
 The Chat.php file can be run locally or on the server.
 Also install php in the server
### 2. Ollama

 Ollama is required to run the language model. To install Ollama:

 1. Visit the [Ollama website](https://ollama.com/download) and follow the installation instructions for your operating system.
 2. After installation, pull any model eg Gemma:2b:
 3. Create This PHP script (OllamChat.php) to handle POST requests and execute the shell command for running LLM on the server
    ```bash
    sudo nano /var/www/html/OllamaChat.php
    ```
### 3. Composer

 Composer is needed to manage PHP dependencies. Install it globally:

 ``` bash
 php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
 php -r "if (hash_file('sha384', 'composer-setup.php') === 
 '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 
 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
 php composer-setup.php
 php -r "unlink('composer-setup.php');"
 sudo mv composer.phar /usr/local/bin/composer
 ```

### 4. Google Cloud Text to Speech
 -Navigate to the Text_to_Speech_php directory and install the required packages:

 ```bash
 sudo mkdir /var/www/html/Text_to_Speech_php
 cd Text_to_Speech_php
 composer require google/cloud-text-to-speech
 ```
 -This will create a composer.json file and a vendor directory with the necessary dependencies. While in the Text_to_Speech_php folder create 
  the Index.php file which will generate the audio.

### 5. Environment Setup
 Set the environment variable for Google Application Credentials
 ```bash 
 GOOGLE_APPLICATION_CREDENTIALS=/path/to/your/demo_service_account.json
 ```

## Sample UI

Here's a sample image of the chatbot UI:

![Chatbot UI Sample](https://simkafire.com/img/ChatBot.png)

This interface provides an intuitive chat experience with the AI agent. Users can type their questions or prompts in the input field at the bottom, and the AI's responses appear in the chat area above. The speaker icon is generated after the output from the LLM which contains the Audio output

## Live Demo

You can try out a live demo of the AI Conversational Agent here: [Live Demo](https://sk10codebase.online/Chatbot/index.php)

Please note that the live demo may have usage limitations or may not always be available.




