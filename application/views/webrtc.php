<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P2P File Sharing</title>
    <script src="https://unpkg.com/peerjs@1.3.1/dist/peerjs.min.js"></script> <!-- PeerJS for WebRTC -->
</head>
<body>

<h2>P2P File Sharing with WebRTC</h2>

<div>
    <h3>Your Peer ID: <span id="peer-id">...</span></h3>

    <input type="text" id="peer-id-input" placeholder="Enter Peer ID to connect">
    <button onclick="connectToPeer()">Connect to Peer</button>

    <h4>Send a File:</h4>
    <input type="file" id="file-input">
    <button onclick="sendFile()">Send File</button>

    <div id="received-file"></div>
</div>

<script>
    // Initialize PeerJS and WebRTC signaling connection
    const peer = new Peer(); // Creates a new peer instance

    let conn; // Connection variable

    // Display the Peer ID once connected
    peer.on('open', (id) => {
        document.getElementById('peer-id').innerText = id;
    });

    // Listen for incoming connections
    peer.on('connection', (connection) => {
        conn = connection;

        conn.on('data', (data) => {
            // Handle received file data
            const blob = new Blob([data], { type: 'application/octet-stream' });
            const url = URL.createObjectURL(blob);

            // Create a download link
            const link = document.createElement('a');
            link.href = url;
            link.download = 'received_file.txt'; // You can set dynamic file names here
            link.textContent = 'Click to download the received file';
            document.getElementById('received-file').appendChild(link);
        });
    });

    // Connect to another peer by their Peer ID
    function connectToPeer() {
        const peerId = document.getElementById('peer-id-input').value;
        conn = peer.connect(peerId);

        conn.on('open', () => {
            alert("Connected to peer: " + peerId);
        });
    }

    // Send file to the connected peer
    function sendFile() {
        const fileInput = document.getElementById('file-input');
        const file = fileInput.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = () => {
                conn.send(reader.result); // Send the file as binary data
            };
            reader.readAsArrayBuffer(file);
        } else {
            alert("Please select a file to send.");
        }
    }
</script>

</body>
</html>
