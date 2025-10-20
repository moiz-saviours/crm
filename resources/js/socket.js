import { io } from "socket.io-client";

const socketUrl = import.meta.env.VITE_SOCKET_URL;
const socketPath = import.meta.env.VITE_SOCKET_PATH || "/socket.io/";

const socket = io(socketUrl, {
    transports: ["websocket", "polling"],
    path: socketPath,
});

socket.on("connect", () => {
    console.log("✅ Connected to Socket.IO:", socket.id);
});

socket.on("disconnect", () => {
    console.log("❌ Disconnected from Socket.IO");
});

export default socket;
