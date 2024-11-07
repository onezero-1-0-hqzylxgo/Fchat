# Fchat

This is a web application designed for the dark web, without using JavaScript.

This web application allows users to chat anonymously on the dark web. It works under the safest browser settings, such as Tor Browser. The application does not use any server-side code like JavaScript. It is built using PHP, HTML, and CSS. The application does not use a database management system; chat history and user data are stored in plain text files called `users.txt` and `chats.txt`.

## How to Install

Follow these steps to set up the chat application:

1. **Clone the repository**:
   ```bash
   git clone <repository_url>
2. Install Tor: First, update your package list and install Tor: `sudo apt-get update && sudo apt-get install tor`
3. Copy files to the web server directory: Navigate to the Fchat directory and copy the files to your web server's document root: `cd Fchat`,`cp ./* /var/www/html/` Alternatively, you can change the Apache configuration to point to the location where your files are stored.
4. Start the Apache web server: Run the following command to start Apache: `sudo service apache2 start`
5. Configure Tor for hidden services: Open the Tor configuration file: `sudo nano /etc/tor/torrc` Uncomment the lines related to hidden services and configure them.
6. Start Tor service: Run the following command to start Tor: `sudo systemctl start tor`
7. Get your onion address: Once Tor is running, use the following command to find your Tor hidden service's .onion address `cat /var/lib/tor/hidden_service/hostname`
