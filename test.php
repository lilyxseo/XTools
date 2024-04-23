<!DOCTYPE html>
<html>
<head>
    <title>Web Terminal</title>
    <style>
        #terminal-container {
            width: 800px;
            height: 600px;
            border: 1px solid #ccc;
            overflow: auto;
        }
    </style>
</head>
<body>
    <div id="terminal-container"></div>
    <textarea id="command-input" placeholder="Enter command..."></textarea>
    <button onclick="sendCommand()">Send</button>
    <script>
        const terminalContainer = document.getElementById('terminal-container');
        const commandInput = document.getElementById('command-input');

        function sendCommand() {
            const command = commandInput.value.trim();
            if (command !== '') {
                // Kirim perintah ke server PHP menggunakan AJAX
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'terminal.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        const response = xhr.responseText;
                        terminalContainer.innerHTML += '<pre>' + escapeHtml(response) + '</pre>';
                        terminalContainer.scrollTop = terminalContainer.scrollHeight;
                    }
                };
                xhr.send('command=' + encodeURIComponent(command));
                commandInput.value = '';
            }
        }

        // Escape karakter khusus HTML
        function escapeHtml(unsafe) {
            return unsafe
                 .replace(/&/g, "&amp;")
                 .replace(/</g, "&lt;")
                 .replace(/>/g, "&gt;")
                 .replace(/"/g, "&quot;")
                 .replace(/'/g, "&#039;");
        }
    </script>
</body>
</html>
