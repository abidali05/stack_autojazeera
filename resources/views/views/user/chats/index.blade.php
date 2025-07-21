@extends('layout.panel_layout.main')
@section('content')
    <style>
        .headername {
            font-size: 16px;
            font-weight: 600;
        }
.main-container {
	display:none;
		}
        .message-container.received {
            max-width: 100% !important;
        }


        .message-container.sent {
            justify-content: flex-end;
            margin-top: 20px !important;
        }

        .message-context-menu {
            position: static;
            z-index: 1000;
            background-color: rgb(31, 27, 45);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            padding: 5px 0px;
            min-width: 40px !important;
            box-shadow: rgba(0, 0, 0, 0.5) 0px 2px 5px;
            left: 1130px;
            top: 0px;
        }

        .form-control {
            background-color: #282435 !important;
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: white !important;
            font-size: 13px;
        }

        .message-container.sent,
        .message-container.received {
            max-width: 100%;
        }

        #chatMessages {
            display: flex;
            flex-direction: row !important;
            justify-content: flex-end;
            min-height: 60vh;
            max-height: 78vh;
            overflow-y: auto;
            overflow-x: hidden;
            word-wrap: break-word;
        }

        .form-select {
            --bs-form-select-bg-img: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='white' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            display: block;
            width: 100%;
            padding: .375rem 2.25rem .375rem .75rem;
            font-size: 16px;
            font-weight: 700;
            line-height: 1;
            color: white;
            background-color: transparent !important;
            background-image: white !important;
            background-repeat: no-repeat;
            background-position: right .75rem center;
            background-size: 12px 12px;
            border: none;
        }

        .online {
            font-size: 13px;
            font-weight: 500;
        }

        select.form-select option {
            background-color: #1F1B2D;
            color: white;
        }

        .chat-input-container {

            bottom: 10px;


            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.4);
            background-color: #282435;
            border-radius: 10px;
            padding: 7px 15px;
            display: flex;
            align-items: center;
        }

        .chat-input {
            flex-grow: 1;
            background-color: #282435;
            border: none;
            outline: none;
            color: white;
            font-size: 16px;
            width: 90%;
            resize: none;
            /* Prevents manual resizing */
            overflow-y: auto;
            /* Enables scroll if needed */
            line-height: 1.5;
        }


        .chat-input::placeholder {
            color: #aaaaaa;
        }

        .send-button {
            background: transparent;
            border: none;
            color: white;
            cursor: pointer;
        }

        .chatfont,
        .chatfonte {
            font-size: 12px;
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 60%;
        }

        .chatfont {
            background-color: #433B5D;
        }

        .chatfonte {
            background-color: #282435;
        }

        .leftchat {
            font-size: 14px;
        }

        .leftchatname {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.4);
        }

        .scrl,
        .scrll {
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #433B5D transparent;
        }

        .scrl {
            height: 68vh;
        }

        .scrll {
            height: 70vh;
        }

        /* Scrollbar Styling */
        .scrl::-webkit-scrollbar,
        .scrll::-webkit-scrollbar {
            width: 8px;
        }

        .scrl::-webkit-scrollbar-thumb,
        .scrll::-webkit-scrollbar-thumb {
            background-color: #433B5D;
            border-radius: 10px;
        }

        .scrl::-webkit-scrollbar-track,
        .scrll::-webkit-scrollbar-track {
            background-color: transparent !important;
        }

        #chatSearch::placeholder {
            color: white;
            opacity: 1;
        }

        .chats {
            font-size: 26px;
            font-weight: 600;
        }

        #chatMessages {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            min-height: 60vh;
            max-height: 78vh;
            overflow-y: auto;
            overflow-x: hidden;
            word-wrap: break-word;
        }

        .message-container {
            display: flex;
            align-items: center;
            margin: 5px 0;
            max-width: 100%;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .message-container.sent,
        .message-container.received {
            max-width: 85%;
        }

        /* Image preview styling */
        .message-container img,
        .image-container img {
            max-width: 250px;
            height: auto;
            border-radius: 10px;
            object-fit: cover;
            cursor: pointer;
        }

        .image-container {
            position: relative;
            display: inline-block;
            max-width: 100%;
            text-align: center;
        }

        /* Download Button Overlay */
        .image-container .download-button {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 5px 8px;
            border-radius: 50%;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s;
        }

        .image-container .download-button i {
            font-size: 18px;
        }

        .image-container .download-button:hover {
            background: rgba(0, 0, 0, 0.9);
        }

        .message-container.sent {
            justify-content: flex-end;
        }

        .message-container.received {
            justify-content: flex-start;
        }

        /* Reply and Context Menu Styling */
        .replied-message,
        .reply-preview-container {
            font-size: 12px;
            background: rgba(255, 255, 255, 0.1);
            padding: 5px;
            margin-bottom: 5px;
            border-left: 3px solid #FD5631;
        }

        .replied-message:hover {
            cursor: pointer;
        }

        .reply-preview-container {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 5px 10px;
        }

        .reply-preview {
            padding-left: 10px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            flex-grow: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .reply-close-button {
            background: transparent;
            border: none;
            color: white;
            cursor: pointer;
            padding: 0 5px;
        }

        .edited-tag {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.5);
            margin-right: 5px;
        }

        /* Message Context Menu */
        .message-context-menu {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .context-menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Message actions on hover */
        .message-container .message-actions {
            opacity: 0;
        }

        .message-container:hover .message-actions {
            opacity: 1;
        }
    </style>


    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-md-3" id="chatSearchSide">
                        <div class="row mt-3">
                            <div class="col-12 pe-0 px-4">
                                <p class="chats m-0"><strong>Ads chats</strong></p>
                            </div>

                        </div>
                        <div class="row px-2 mt-2 mb-3 d-none" id="chatSearchRow">
                            <div class="col-12">
                                <div class="position-relative w-100">
                                    <input type="text" class="form-control pe-5" id="chatSearch" autocomplete="off"
                                        placeholder="Search">
                                    <i
                                        class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 scrll" id="chatList">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-9" id="chatContent" style="border-left: 1px solid rgba(255, 255, 255, 0.2);s">
                        <div class="row d-flex justify-content-between d-none" id="chatTopNav"
                            style="border-bottom: 1px solid rgba(255, 255, 255, 0.2);">
                            <div class="col-5 d-flex">
                                <div><img src="" class="" id="chatTopNav_dealerImage"
                                        style="height: 50px; width: 50px;" alt="..."></div>
                                <div class="ms-2 ">
                                    <p class="m-0 headername" id="chatTopNav_dealerName"></p>
                                    <p class="m-0 d-flex align-items-center online" id="chatTopNav_dealerState"><img
                                            src=" {{ asset('web/images/Ellipse 1.svg') }}" id="chatTopNav_dealerImage"
                                            class="img-fluid me-2" alt="...">Online</p>
                                </div>
                            </div>
                            <div class="col-5 d-flex justify-content-end pb-2">
                                <div class="me-2 text-end">
                                    <p class="m-0 headername" id="chatTopNav_carTitle">Mercedes-Benz E400</p>
                                    <p class="m-0 online" style="color: #FD5631;" id="chatTopNav_carPrice">PKR 34,353.00</p>
                                </div>
                                <div><img src=" {{ asset('web/images/image.svg') }}" style="height: 50px; width: 50px;"
                                        alt="..." id="chatTopNav_carImage">
                                </div>

                            </div>
                        </div>
                        <div class="row mt-1 scrl d-flex justify-content-center" id="chatMessages">
                            <img src="{{ asset('web/services/images/nochat.svg') }}" class="img-fluid w-25" alt="...">
                            <p class="text-center" style="color:#281F48;font-size:18px; font-weight:500">Your chat history
                                is empty. Start a chat with seller to see it here</p>
                        </div>


                        <div class="col-12 pb-1">
                            <div class="chat-input-container col-12 d-none" id="sendMessageForm">
                                <form id="chatForm" enctype="multipart/form-data" method="POST" action="/send-message"
                                    class="col-12">
                                    @csrf <!-- Add this line -->
                                    <input type="hidden" name="car_id" id="car_id">
                                    <input type="file" id="file-upload" class="d-none"
                                        accept="image/*,video/*,application/pdf" />

                                    <!-- File Preview Container -->
                                    <div id="file-preview-container" class="d-none mt-2">
                                        <div id="file-preview" class="border p-2 rounded d-inline-block"></div>
                                        <button type="button" class="btn btn-danger btn-sm ms-2"
                                            onclick="clearFilePreview()">❌</button>
                                    </div>
                                    <!-- Add HTML for reply preview -->
                                    <div class="reply-preview-container d-none" id="reply-preview-container">
                                        <div class="reply-preview" id="reply-preview-text"></div>
                                        <button class="reply-close-button" onclick="clearReplyPreview()">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                    <button class="send-button ps-0" type="button"
                                        onclick="document.getElementById('file-upload').click()">
                                        <img src="{{ asset('web/images/attachment-svgrepo-com (1).svg') }}"
                                            class="img-fluid" style="width:20px" alt="...">
                                    </button>
                                    <textarea class="chat-input" name="message" placeholder="Type a message" rows="1"></textarea>
                                    <input type="hidden" name="sender_id" value="1">
                                    <!-- Replace with dynamic sender ID -->
                                    <input type="hidden" name="receiver_id" value="2">
                                    <!-- Replace with dynamic receiver ID -->
                                    <button class="send-button" type="submit" style="float: right">
                                        <img src="{{ asset('web/images/Vector.svg') }}" class="img-fluid" alt="...">
                                    </button>
                                </form>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-firestore-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-auth-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-storage-compat.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Authentication data from Laravel
        const authUserId = @json(auth()->id());
        const authUserName = @json(auth()->user()->name);
        const authUserEmail = @json(auth()->user()->email);
        const authUserImage = @json(auth()->user()->image ? asset('web/profile/' . auth()->user()->image) : '');
        const authUserFcmToken = @json(auth()->user()->fcm_token);

        // Selected chat variables
        let selectedChatId = null;
        let selectedCarId = null;
        let receiverId = null;
        let receiver = null;
        let replyingToMessage = null; // Message ID being replied to
        let replyingToMessageContent = null; // Message content being replied to
        let reply_to_attachment = null;
        let reply_meta_data = null;

        // Firebase configuration
        const firebaseConfig = {
            apiKey: "AIzaSyAAxmyvtyl7ueLPj5Aj9TYBKj9iSZFHvsQ",
            authDomain: "finder-app-be8d5.firebaseapp.com",
            projectId: "finder-app-be8d5",
            storageBucket: "finder-app-be8d5.appspot.com",
            messagingSenderId: "1083573166983",
            appId: "1:1083573166983:android:8198c3647059ee3168e922"
        };

        // Initialize Firebase with error handling
        let db;
        if (typeof firebase === 'undefined') {
            console.error("Firebase SDK not loaded.");
        } else if (!firebase.apps.length) {
            firebase.initializeApp(firebaseConfig);
            db = firebase.firestore();
        } else {
            db = firebase.firestore();
        }

        // HTML sanitization function to prevent XSS
        function escapeHtml(unsafe) {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // Set user presence in Firestore
        async function setUserPresence(state) {
            if (!db) return;
            const userId = authUserId;
            const userRef = db.collection("users").doc(userId.toString());

            try {
                await userRef.set({
                    id: userId,
                    name: authUserName,
                    email: authUserEmail,
                    image: authUserImage,
                    last_seen: firebase.firestore.FieldValue.serverTimestamp(),
                    platform: "web",
                    state: state
                }, {
                    merge: true
                });
            } catch (error) {
                console.error("Error setting user presence:", error);
            }
        }

        // Listen for user presence updates
        function listenForUserPresence(userId) {
            if (!db) return;
            const userRef = db.collection("users").doc(userId.toString());

            userRef.onSnapshot((doc) => {
                if (doc.exists) {
                    const userData = doc.data();
                    const userState = userData.state || "Offline";
                    document.getElementById("chatTopNav_dealerState").innerHTML = `
                    <i class="bi bi-circle-fill ${userState === "Online" ? "text-success" : "text-danger"} me-2"></i> ${escapeHtml(userState)}
                `;
                }
            }, (error) => {
                console.error("Error listening for user presence:", error);
            });
        }

        // Create a new chat or return existing chat ID
        async function createChat(carId, dealerId) {
            if (!db) return;
            const senderId = authUserId;
            const users = [senderId, dealerId].sort();

            try {
                const chatQuery = await db.collection("chats")
                    .where("users", "array-contains", senderId)
                    .get();

                let existingChat = null;
                chatQuery.forEach(doc => {
                    const chatData = doc.data();
                    if (chatData.users.includes(dealerId) && chatData.car.id === carId) {
                        existingChat = doc;
                    }
                });

                if (existingChat) {
                    return existingChat.id;
                }

                const chatRef = await db.collection("chats").add({
                    car: {
                        id: carId,
                        title: carTitle,
                        make: carMake,
                        model: carModel,
                        year: carYear,
                        price: carPrice,
                        image: carImage
                    },
                    created_at: firebase.firestore.FieldValue.serverTimestamp(),
                    last_message: "",
                    users: users,
                    participants: [{
                            id: senderId,
                            name: authUserName,
                            email: authUserEmail,
                            image: authUserImage,
                            state: "Online"
                        },
                        {
                            id: dealerId,
                            name: dealerName,
                            email: dealerEmail,
                            image: dealerImage,
                            state: "Offline"
                        }
                    ]
                });

                return chatRef.id;
            } catch (error) {
                console.error("Error creating chat:", error);
                return null;
            }
        }

        // Fetch user chats
        async function fetchUserChats() {
            if (!db) return;
            const senderId = authUserId;
            const chatList = document.getElementById("chatList");
            const chatSearchRow = document.getElementById("chatSearchRow");

            try {
                const chatQuery = await db.collection("chats")
                    .where("users", "array-contains", senderId)
                    .get();

                chatList.innerHTML = "";

                const chatContent = document.getElementById("chatContent");

                if (chatQuery.empty) {
                    chatContent.classList.remove('col-md-9'); // Remove col-md-9
                    chatContent.classList.add('col-md-12'); // Set to full width
                    chatSearchSide.classList.add('d-none'); // Hide the entire sidebar
                    chatList.classList.add('d-none'); // Hide chatList
                    if (chatSearchRow) chatSearchRow.classList.add('d-none'); // Hide search bar
                    noChatMessage.classList.remove('d-none'); // Show "No chat found" message
                    chatMessages.classList.add('d-none'); // Hide chat messages
                    chatTopNav.classList.add('d-none'); // Hide chat header
                    sendMessageForm.classList.add('d-none'); // Hide input form
                    return;
                } else {
                    chatSearchSide.classList.remove('d-none'); // Show the entire sidebar
                    chatList.classList.remove('d-none'); // Show chatList
                    if (chatSearchRow) chatSearchRow.classList.remove('d-none'); // Show search bar
                    noChatMessage.classList.add('d-none'); // Hide "No chat found" message
                    chatContent.classList.remove('col-md-12'); // Remove full width
                    chatContent.classList.add('col-md-9'); // Restore col-md-9
                }

                chatQuery.forEach(doc => {
                    const chat = doc.data();
                    const chatId = doc.id;
                    const car = chat.vehicle || {};
                    const receiver = chat.receiver || {};

                    const carTitle = car.title || "Unknown Car";
                    const carPrice = car.price || "0";
                    const carImage = car.poster || "default-car.png";
                    const receiverName = receiver.name || "Unknown";
                    const receiverImage = receiver.image || "web/images/default-avatar.png";
                    const receiverId = receiver.id || "";
                    const timestamp = chat.created_at ?
                        new Date(chat.created_at.seconds * 1000).toLocaleTimeString() :
                        "";

                    const chatHtml = `
                    <div class="row d-flex justify-content-between align-items-center px-2 chatRow" 
                        onclick="openChat('${chatId}', this)" 
                        style="cursor: pointer; padding: 10px 0; border-bottom: 1px solid rgba(255, 255, 255, 0.2);"
                        data-dealer_name="${escapeHtml(receiverName)}"
                        data-dealer_image="${escapeHtml(receiverImage)}" 
                        data-car_title="${escapeHtml(carTitle)}" 
                        data-price="${escapeHtml(carPrice)}" 
                        data-car_id="${car.id || ''}" 
                        data-receiver_id="${receiverId}" 
                        data-car_image="${escapeHtml(carImage)}"
                        data-receiver='${JSON.stringify(receiver).replace(/"/g, '&quot;')}'>
                        <div class="col-10 d-flex align-items-center">
                            <div>
                                <img src="${escapeHtml(carImage)}" 
                                    style="height: 45px; width: 45px; border-radius: 50%;" alt="Chat User">
                            </div>
                            <div class="ms-2">
                                <p class="m-0 leftchat text-dark"><strong>${escapeHtml(receiverName)}</strong></p>
                                <p class="m-0 leftchatname text-dark">${escapeHtml(carTitle)}</p>
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-end pb-2">
                            <div class="me-2 text-end">
                                <p class="m-0 leftchatname text-dark">${escapeHtml(timestamp)}</p>
                            </div>
                        </div>
                    </div>`;

                    chatList.innerHTML += chatHtml;
                });
            } catch (error) {
                console.error("Error fetching chats:", error);
                chatList.innerHTML = "<p class='text-center py-3'>Error loading chats</p>";
            }
        }

        // Send message
        async function sendMessage(event) {
            event.preventDefault();
            if (!db) return;

            if (typeof receiver === 'string') {
                receiver = JSON.parse(receiver);
            }

            const messageInput = document.querySelector('.chat-input');
            const message = messageInput.value.trim();
            const fileInput = document.getElementById('file-upload');
            const file = fileInput.files[0];

            let fileUrl = null;
            let meta_data = null;

            if (file) {
                fileUrl = await uploadFileToServer(file);
                if (!fileUrl) {
                    return;
                }

                const fileExtension = file.name.split('.').pop().toLowerCase();
                const mimeType = getMimeType(file.name);
                meta_data = {
                    file_extension: fileExtension,
                    file_name: file.name,
                    mime_type: mimeType,
                    is_image: mimeType.startsWith("image/")
                };
            }

            if (!message && !file) return;

            const isReply = replyingToMessage !== null;

            const newMessage = {
                key: selectedChatId,
                message: message || "",
                attachment: fileUrl ?? null,
                meta_data: file ? meta_data : null,
                reply_message: isReply ? replyingToMessageContent : null,
                reply_attachment: isReply && reply_to_attachment ? reply_to_attachment : null,
                reply_meta_data: isReply && reply_meta_data ? JSON.parse(reply_meta_data) : null,
                reply_to: isReply ? replyingToMessage : null,
                type: "text",
                receiver: {
                    email: receiver.email || "",
                    fcm_token: receiver.fcm_token || "",
                    image: receiver.image || "web/images/default-avatar.png",
                    id: receiver.id || "",
                    name: receiver.name || "",
                    state: "Online"
                },
                sender: {
                    email: authUserEmail,
                    fcm_token: authUserFcmToken || "",
                    image: authUserImage || "web/images/default-avatar.png",
                    id: authUserId,
                    name: authUserName,
                    state: "Online"
                },
                timestamp: firebase.firestore.FieldValue.serverTimestamp()
            };

            try {
                await db.collection("messages").add(newMessage);
                messageInput.value = '';
                fileInput.value = '';
                clearFilePreview();
                clearReplyPreview();
                replyingToMessage = null;
                replyingToMessageContent = null;
                reply_to_attachment = null;
                reply_meta_data = null;
            } catch (error) {
                console.error('Error sending message:', error);
            }
        }

        // Handle file upload preview
        document.getElementById("file-upload")?.addEventListener("change", function(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById("file-preview-container");
            const previewElement = document.getElementById("file-preview");

            if (file && previewContainer && previewElement) {
                const fileUrl = URL.createObjectURL(file);
                previewContainer.classList.remove("d-none");

                if (file.type.startsWith("image/")) {
                    previewElement.innerHTML =
                        `<img src="${fileUrl}" class="img-fluid rounded" style="width: 100px;">`;
                } else if (file.type === "application/pdf") {
                    previewElement.innerHTML =
                        `<i class="bi bi-file-earmark-pdf fs-1 text-danger"></i>`;
                } else {
                    previewElement.innerHTML = `<i class="bi bi-file-earmark fs-1 text-warning"></i>`;
                }
            }
        });

        // Clear file preview
        window.clearFilePreview = function() {
            const previewContainer = document.getElementById("file-preview-container");
            const previewElement = document.getElementById("file-preview");
            const fileInput = document.getElementById("file-upload");

            if (previewContainer && previewElement && fileInput) {
                previewContainer.classList.add("d-none");
                previewElement.innerHTML = "";
                fileInput.value = "";
            }
        };

        // Clear reply preview
        window.clearReplyPreview = function() {
            const replyPreviewContainer = document.getElementById("reply-preview-container");
            const replyPreviewText = document.getElementById("reply-preview-text");

            if (replyPreviewContainer && replyPreviewText) {
                replyPreviewContainer.classList.add("d-none");
                replyPreviewText.innerHTML = "";
            }
        };

        // Upload file to server
        async function uploadFileToServer(file) {
            const formData = new FormData();
            formData.append("file", file);

            try {
                const response = await fetch("/api/uploadAttachment", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                            ?.getAttribute("content")
                    }
                });

                const result = await response.json();
                if (result.status === 200) {
                    return result.data.url;
                } else {
                    alert(result.errors?.file || "File upload failed.");
                    console.error("File upload failed:", result.errors);
                    return null;
                }
            } catch (error) {
                console.error("Error uploading file:", error);
                alert("Error uploading file.");
                return null;
            }
        }

        // Reply to message
        window.replyToMessage = function(messageId, messageContent, senderName, attachment = null, metadata =
            null) {
            replyingToMessage = messageId;
            replyingToMessageContent = messageContent;
            reply_to_attachment = attachment ?? null;
            reply_meta_data = metadata;

            const replyPreviewContainer = document.getElementById("reply-preview-container");
            const replyPreviewText = document.getElementById("reply-preview-text");

            if (replyPreviewContainer && replyPreviewText) {
                let previewContent = escapeHtml(messageContent);
                if (previewContent.length > 50) {
                    previewContent = previewContent.substring(0, 50) + "...";
                }

                replyPreviewText.innerHTML =
                    `<strong>${escapeHtml(senderName)}:</strong> ${previewContent}`;
                replyPreviewContainer.classList.remove("d-none");
                document.querySelector('.chat-input')?.focus();
            }
        };

        // Delete message
        window.deleteMessage = async function(messageId, forEveryone = false) {
            if (!db) return;

            try {
                const messageRef = db.collection("messages").doc(
                    messageId); // Fixed collection to "messages"
                const messageDoc = await messageRef.get();

                if (!messageDoc.exists) {
                    console.error("Message not found");
                    return;
                }

                const messageData = messageDoc.data();
                if (parseInt(messageData.sender.id) !== parseInt(authUserId)) {
                    return;
                }

                if (forEveryone) {
                    await messageRef.update({
                        deleted: true,
                        deletedAt: new Date().toISOString(),
                        deletedBy: authUserId
                    });
                } else {
                    const currentViewers = messageData.visibleTo || [];
                    const updatedViewers = currentViewers.filter(id => id !== authUserId);

                    await messageRef.update({
                        visibleTo: updatedViewers
                    });
                }

                document.querySelectorAll('.message-context-menu').forEach(menu => menu.remove());
            } catch (error) {
                console.error("Error deleting message:", error);
                alert("Failed to delete message. Please try again.");
            }
        };

        // Listen for chat messages
        function listenForChatMessages(chatId) {
            if (!db) return;
            const chatMessages = document.getElementById('chatMessages');
            if (!chatMessages) return;

            chatMessages.innerHTML = '';

            db.collection("messages")
                .where("key", "==", chatId)
                .orderBy("timestamp", "asc")
                .onSnapshot(snapshot => {
                    chatMessages.innerHTML = '';

                    snapshot.forEach(doc => {
                        const msg = doc.data();

                        if (msg.deleted && parseInt(msg.sender.id) !== parseInt(authUserId)) {
                            return;
                        }

                        if (msg.visibleTo && Array.isArray(msg.visibleTo) && !msg.visibleTo
                            .includes(authUserId)) {
                            return;
                        }

                        const isSender = parseInt(msg.sender.id) === parseInt(authUserId);
                        const senderImage = msg.sender.image || "web/images/default-avatar.png";
                        const receiverImage = isSender ? authUserImage : senderImage;
                        const messageClass = isSender ? 'chatfont' : 'chatfonte';
                        let messageText = msg.message || '';
                        if (msg.deleted) {
                            messageText = '<em class="text-muted">This message was deleted</em>';
                        }

                        const fileAttachment = msg.attachment && !msg.deleted ? getFilePreview(msg
                            .attachment) : '';
                        let replyHtml = '';
                        if (msg.reply_to && !msg.deleted) {
                            replyHtml = `
                            <div class="replied-message mb-2 p-2 rounded" 
                                style="background-color: rgba(255,255,255,0.1); border-left: 3px solid #FD5631;" 
                                onclick="highlightMessage('${msg.reply_to}', '${escapeHtml(msg.reply_message)}')">
                                <small class="text-white-50">Replying to message</small>
                                <p class="m-0 text-white-50 small">${escapeHtml(msg.reply_message)}</p>
                            </div>`;
                        }

                        const messageActions = isSender ? `
                        <div class="message-actions d-none">
                            <button class="btn btn-sm text-white-50" onclick="showMessageOptions('${doc.id}')">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                        </div>` : '';

                        const messageHtml = `
                        <div class="message-container ${isSender ? 'sent' : 'received'}" id="message-${doc.id}" data-message-id="${doc.id}" data-reply_meta_data="${JSON.stringify(msg.meta_data ?? null)}">
                            ${!isSender ? `
                                <img src="${escapeHtml(receiverImage)}" class="chat-avatar me-2" 
                                    style="height: 45px; width: 45px; border-radius: 50%;" 
                                    alt="Receiver">` : ''}
                            <div class="${messageClass} p-3 rounded-3 position-relative" 
                                oncontextmenu="showMessageContextMenu(event, '${doc.id}', ${isSender}, '${escapeHtml(msg.message?.replace(/'/g, "\\'") || '')}', '${escapeHtml(msg.sender.name?.replace(/'/g, "\\'") || '')}', '${msg.attachment ?? null}', '${JSON.stringify(msg.meta_data ?? null).replace(/"/g, '&quot;')}'); return false;"
                                style="max-width: 50%; word-wrap: break-word; ${isSender ? 'background-color: #282435;' : 'background-color: #433B5D;'}" id="messagee-${doc.id}">
                                ${replyHtml}
                                ${messageText ? `<p class="m-0 text-white">${escapeHtml(messageText)}</p>` : ''}
                                ${fileAttachment}
                                <div class="timestamp text-white-50 mt-1 text-end d-flex align-items-center justify-content-end" style="font-size: 10px;">
                                    ${msg.edited ? '<span style="color:white" class="me-1">(edited)</span>' : ''}
                                    ${msg.attachment && !msg.message ? '<span class="ms-1">File</span>' : messageActions}
                                </div>
                            </div>
                            ${isSender ? `
                                <img src="${escapeHtml(senderImage)}" class="chat-avatar" 
                                    style="height:50px; width:50px; border-radius:50%;" 
                                    alt="Profile Picture">` : ''}
                        </div>`;

                        chatMessages.innerHTML += messageHtml;
                    });

                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }, (error) => {
                    console.error("Error listening for messages:", error);
                    chatMessages.innerHTML = "<p class='text-center py-3'>Error loading messages</p>";
                });
        }

        // Show context menu on right-click
        window.showMessageContextMenu = function(event, messageId, isSender, messageContent, senderName,
            attachment, metadata = null) {
            event.preventDefault();

            document.querySelectorAll('.message-context-menu').forEach(menu => menu.remove());

            const contextMenu = document.createElement('div');
            contextMenu.className = 'message-context-menu';
            contextMenu.style.position = 'absolute';
            contextMenu.style.zIndex = '1000';
            contextMenu.style.backgroundColor = '#1F1B2D';
            contextMenu.style.border = '1px solid rgba(255, 255, 255, 0.2)';
            contextMenu.style.borderRadius = '5px';
            contextMenu.style.padding = '5px 0';
            contextMenu.style.minWidth = '60px';
            contextMenu.style.boxShadow = '0 2px 5px rgba(0, 0, 0, 0.5)';

            const menuItems = [];

            if (isSender) {
                menuItems.push({
                    text: 'Delete',
                    icon: 'bi-trash-fill',
                    action: () => deleteMessage(messageId, false)
                });
            } else {
                menuItems.push({
                    text: 'Reply',
                    icon: 'bi-reply-fill',
                    action: () => replyToMessage(messageId, messageContent, senderName, attachment,
                        metadata)
                });
            }

            menuItems.forEach(item => {
                const menuItem = document.createElement('div');
                menuItem.className = 'context-menu-item';
                menuItem.style.padding = '8px 15px';
                menuItem.style.cursor = 'pointer';
                menuItem.style.color = 'white';
                menuItem.style.fontSize = '14px';
                menuItem.style.display = 'flex';
                menuItem.style.alignItems = 'center';

                menuItem.innerHTML =
                    `<i class="bi ${item.icon} me-2"></i><span style="color:white">${item.text}</span>`;

                menuItem.addEventListener('mouseenter', () => {
                    menuItem.style.backgroundColor = 'rgba(255, 255, 255, 0.1)';
                });
                menuItem.addEventListener('mouseleave', () => {
                    menuItem.style.backgroundColor = 'transparent';
                });
                menuItem.addEventListener('click', () => {
                    item.action();
                    contextMenu.remove();
                });

                contextMenu.appendChild(menuItem);
            });

            document.body.appendChild(contextMenu);

            const rect = contextMenu.getBoundingClientRect();
            let x = event.clientX;
            let y = event.clientY;

            if (x + rect.width > window.innerWidth) {
                x = window.innerWidth - rect.width;
            }
            if (y + rect.height > window.innerHeight) {
                y = window.innerHeight - rect.height;
            }

            contextMenu.style.left = `${x}px`;
            contextMenu.style.top = `${y}px`;

            document.addEventListener('click', function closeMenu() {
                contextMenu.remove();
                document.removeEventListener('click', closeMenu);
            });
        };

        // Show message options
        window.showMessageOptions = async function(messageId) {
            if (!db) return;
            const messageElement = document.getElementById(`message-${messageId}`);
            if (!messageElement) return;

            try {
                const messageQuery = db.collection("messages").doc(
                    messageId); // Fixed collection to "messages"
                const doc = await messageQuery.get();
                if (doc.exists) {
                    const msgData = doc.data();
                    showMessageContextMenu({
                            preventDefault: () => {},
                            clientX: window.innerWidth / 2,
                            clientY: window.innerHeight / 2
                        },
                        messageId,
                        true,
                        msgData.message || '',
                        msgData.sender.name || 'You'
                    );
                }
            } catch (error) {
                console.error("Error fetching message for options:", error);
            }
        };

        // Edit message
        window.editMessage = async function(messageId, currentContent) {
            if (!db) return;
            document.querySelectorAll('.message-context-menu').forEach(menu => menu.remove());

            const messageElement = document.getElementById(`message-${messageId}`);
            if (!messageElement) return;

            const messageContainer = messageElement.querySelector('.chatfont');
            if (!messageContainer) return;

            const originalContent = messageContainer.innerHTML;
            messageContainer.dataset.originalContent = originalContent;

            messageContainer.innerHTML = `
            <div class="edit-message-form">
                <textarea class="form-control bg-dark text-white mb-2 edit-message-textarea">${escapeHtml(currentContent)}</textarea>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-sm btn-outline-light me-2" onclick="cancelEditMessage('${messageId}')">Cancel</button>
                    <button class="btn btn-sm btn-primary" onclick="saveEditedMessage('${messageId}')">Save</button>
                </div>
            </div>`;

            const textarea = messageContainer.querySelector('textarea');
            textarea.focus();
            textarea.selectionStart = textarea.value.length;
        };

        // Cancel message editing
        window.cancelEditMessage = function(messageId) {
            const messageElement = document.getElementById(`message-${messageId}`);
            if (!messageElement) return;

            const messageContainer = messageElement.querySelector('.chatfont');
            if (messageContainer && messageContainer.dataset.originalContent) {
                messageContainer.innerHTML = messageContainer.dataset.originalContent;
            }
        };

        // Save edited message
        window.saveEditedMessage = async function(messageId) {
            if (!db) return;
            const messageElement = document.getElementById(`message-${messageId}`);
            if (!messageElement) return;

            const textarea = messageElement.querySelector('.edit-message-textarea');
            const newContent = textarea.value.trim();

            if (!newContent) {
                alert("Message cannot be empty");
                return;
            }

            try {
                await db.collection("messages").doc(messageId).update({
                    message: newContent,
                    edited: true,
                    editedAt: new Date().toISOString()
                });
            } catch (error) {
                console.error("Error updating message:", error);
                alert("Failed to update message. Please try again.");
                cancelEditMessage(messageId);
            }
        };

        // Get file preview
        function getFilePreview(fileUrl) {
            const fileExtension = fileUrl.split('.').pop().toLowerCase();

            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExtension)) {
                return `
                <div class="image-container mt-2 d-block">
                    <img src="${escapeHtml(fileUrl)}" class="img-fluid rounded shadow-sm" style="width: 100%; border-radius: 10px; cursor: pointer;" alt="Image Attachment" onclick="openFullImage('${escapeHtml(fileUrl)}')">
                    <a href="${escapeHtml(fileUrl)}" download class="download-button"><i class="bi bi-download"></i></a>
                </div>`;
            } else if (['pdf', 'doc', 'docx'].includes(fileExtension)) {
                return `
                <a href="${escapeHtml(fileUrl)}" download class="d-block text-decoration-none mt-2 text-light">
                    <i class="bi bi-file-earmark-text fs-1 text-danger mb-2"></i> Download File
                </a>`;
            } else {
                return `
                <a href="${escapeHtml(fileUrl)}" download class="d-block text-decoration-none mt-2 text-light">
                    <i class="bi bi-file-earmark fs-1 text-warning mb-2"></i> Download File
                </a>`;
            }
        }

        // Open chat
        window.openChat = async function(chatId, element) {
            selectedChatId = chatId;
            selectedCarId = element.getAttribute("data-car_id") || "";
            receiverId = element.getAttribute("data-receiver_id") || "";
            receiver = element.getAttribute("data-receiver") || "";

            if (!selectedCarId) {
                console.error("Car ID is missing.");
            }

            const dealerId = element.getAttribute("data-receiver_id");
            listenForUserPresence(dealerId);

            // Update form input fields
            document.querySelector('input[name="sender_id"]').value = authUserId;
            document.querySelector('input[name="receiver_id"]').value = receiverId;

            // Update UI elements
            document.getElementById("chatTopNav")?.classList.remove("d-none");
            document.getElementById("sendMessageForm")?.classList.remove("d-none");
            document.getElementById("chatTopNav_dealerName").innerText = element.getAttribute(
                "data-dealer_name") || "Unknown";
            document.getElementById("chatTopNav_carTitle").innerText = element.getAttribute(
                "data-car_title") || "No Car";
            document.getElementById("chatTopNav_carPrice").innerText =
                `PKR ${element.getAttribute("data-price") || "0"}`;
            document.getElementById("chatTopNav_dealerImage").src = element.getAttribute(
                "data-dealer_image") || "web/images/Final Logo.svg";
            document.getElementById("chatTopNav_carImage").src = element.getAttribute(
                "data-car_image") || "default-car.png";

            listenForChatMessages(chatId);
        };

        // Open full image
        window.openFullImage = function(imageUrl) {
            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.id = 'imageModal';
            modal.setAttribute('tabindex', '-1');
            modal.setAttribute('aria-labelledby', 'imageModalLabel');
            modal.setAttribute('aria-hidden', 'true');

            modal.innerHTML = `
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                    <div class="modal-header" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                        <h5 class="modal-title" id="imageModalLabel"><strong> Image Preview</strong></h5>
                        <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center p-0 p-5" style="background-color: #F0F3F6; color: #FD5631;">
                        <img src="${escapeHtml(imageUrl)}" class="img-fluid" style="max-height: 80vh;" alt="Full size image">
                    </div>
                    <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                        <a href="${escapeHtml(imageUrl)}" download class="btn btn-light px-4 py-2 " style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px;">
                            <i class="bi bi-download me-1"></i> Download
                        </a>
                        <button type="button" class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>`;

            document.body.appendChild(modal);
            const modalInstance = new bootstrap.Modal(modal);
            modalInstance.show();

            modal.addEventListener('hidden.bs.modal', () => {
                document.body.removeChild(modal);
            });
        };

        // Format timestamp
        function formatTimestamp(timestamp) {
            if (!timestamp) return "";
            const date = new Date(timestamp);
            return date.toLocaleString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            });
        }

        // Setup chat search
        function setupChatSearch() {
            const searchInput = document.getElementById("chatSearch");
            const chatList = document.getElementById("chatList");

            if (searchInput && chatList) {
                searchInput.addEventListener("input", function() {
                    const filter = searchInput.value.toLowerCase().trim();
                    const chatItems = chatList.querySelectorAll(".chatRow");

                    chatItems.forEach(chat => {
                        const dealerName = chat.getAttribute("data-dealer_name")
                            ?.toLowerCase() || "";
                        const carTitle = chat.getAttribute("data-car_title")?.toLowerCase() ||
                            "";

                        if (dealerName.includes(filter) || carTitle.includes(filter)) {
                            chat.classList.remove("d-none");
                        } else {
                            chat.classList.add("d-none");
                        }
                    });
                });
            }
        }

        // Get MIME type
        function getMimeType(fileName) {
            const extension = fileName.split('.').pop().toLowerCase();
            const mimeTypes = {
                "jpg": "image/jpeg",
                "jpeg": "image/jpeg",
                "png": "image/png",
                "gif": "image/gif",
                "bmp": "image/bmp",
                "webp": "image/webp",
                "svg": "image/svg+xml",
                "pdf": "application/pdf",
                "doc": "application/msword",
                "docx": "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                "xls": "application/vnd.ms-excel",
                "xlsx": "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                "ppt": "application/vnd.ms-powerpoint",
                "pptx": "application/vnd.openxmlformats-officedocument.presentationml.presentation",
                "txt": "text/plain",
                "csv": "text/csv",
                "mp4": "video/mp4",
                "mov": "video/quicktime",
                "avi": "video/x-msvideo",
                "mp3": "audio/mpeg",
                "wav": "audio/wav",
                "zip": "application/zip",
                "rar": "application/vnd.rar"
            };
            return mimeTypes[extension] || "application/octet-stream";
        }

        // Highlight message
        window.highlightMessage = function(messageId, searchTerm = '') {
            const messageElement = document.querySelector(`#messagee-${messageId}`);
            if (!messageElement) return;

            messageElement.style.transition = "background-color 0.5s ease";
            messageElement.style.backgroundColor = "#FD5631";

            setTimeout(() => {
                messageElement.style.backgroundColor = "";
            }, 2000);
        };

        // Textarea auto-resize and submit on Enter
        const textarea = document.querySelector(".chat-input");
        const form = document.getElementById("chatForm");

        if (textarea && form) {
            textarea.addEventListener("input", function() {
                this.style.height = "auto";
                this.style.height = this.scrollHeight + "px";
            });

            form.addEventListener("submit", function() {
                setTimeout(() => {
                    textarea.value = "";
                    textarea.style.height = "auto";
                }, 0);
            });

            textarea.addEventListener("keydown", function(event) {
                if (event.key === "Enter" && !event.shiftKey) {
                    event.preventDefault();
                    form.requestSubmit();
                }
            });
        }

        // Initialize
        setUserPresence("Online");
        fetchUserChats();
        window.addEventListener("beforeunload", () => setUserPresence("Offline"));
        document.getElementById('chatForm')?.addEventListener('submit', sendMessage);
    });
</script>
