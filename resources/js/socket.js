import { io } from "socket.io-client";

const socketUrl = import.meta.env.VITE_SOCKET_URL || window.location.origin;
const socketPath = import.meta.env.VITE_SOCKET_PATH || "/crm-development/socket.io";

const socket = io(socketUrl, {
    transports: ["websocket", "polling"],
    path: socketPath,
    secure: true, // Use secure connection for HTTPS
    withCredentials: true
});

socket.on("connect", () => {
    console.log("✅ Connected to Socket.IO:", socket.id);
});

socket.on("disconnect", () => {
    console.log("❌ Disconnected from Socket.IO");
});

export default socket;
