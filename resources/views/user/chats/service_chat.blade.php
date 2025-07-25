@extends('layout.panel_layout.main')
@section('content')
    <style>
        .headername {
            font-size: 16px;
            font-weight: 600;
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
            background-color: #282435;
            color: white;
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
            height: 66vh;
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
            font-size: 20px;
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
                    <div class="col-md-3  ">
                        <div class="row mt-3">
                            <div class="col-12 pe-0 px-4">
                                <p class="chats m-0"><strong>Service Chats</strong></p>
                            </div>

                        </div>
                        <div class="row px-2 mt-2 mb-3">
                            <div class="col-12">
                     <div class="position-relative w-100">
  <input type="text" class="form-control w-100 pe-5" id="chatSearch"
         autocomplete="off" placeholder="Search">
  <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
</div>


                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-12 scrll" id="chatList">

                            </div>

                        </div>






                    </div>
                    <div class="col-md-9  mt-2 " style="border-left: 1px solid rgba(255, 255, 255, 0.2);">
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
                                    <p class="m-0 headername" id="chatTopNav_shopTitle">Mercedes-Benz E400</p>

                                </div>
                                <div><img src=" {{ asset('web/images/image.svg') }}" style="height: 50px; width: 50px;"
                                        alt="..." id="chatTopNav_shopImage">
                                </div>

                            </div>
                        </div>
                        <div class="row mt-1 scrl d-flex justify-content-center" id="chatMessages">
										<img src="{{ asset('web/services/images/nochat.svg') }}" class="img-fluid w-50"
                                        alt="...">
                        </div>


                        <div class="col-12 pb-1">
                            <div class="chat-input-container col-12 d-none" id="sendMessageForm">
                                <form id="chatForm" enctype="multipart/form-data" method="POST" action="/send-message"
                                    class="col-12">
                                    @csrf <!-- Add this line -->
                                    <input type="hidden" name="shop_id" id="shop_id">
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
    <!-- Firebase App (Always Required) -->
    <script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-firestore-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-auth-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-storage-compat.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const authUserId = @json($user->id);
            const authUserName = @json($user->name);
            const authUserEmail = @json($user->email);
            const authUserImage = @json($user->image ? asset('web/profile/' . $user->image) : '');
            const authUserFcmToken = @json($user->fcm_token);

            var base_url = "{{ url('/') }}";
            // Selected chat variables
            let selectedChatId = null;
            let selectedshopId = null;
            let receiverId = null;
            let receiver = null;
            let replyingToMessage = null; //  message id being replied to
            let replyingToMessageContent = null; //  message content being replied to
            let reply_to_attachment = null;
            let reply_meta_data = null;
            const firebaseConfig = {
                apiKey: "AIzaSyAAxmyvtyl7ueLPj5Aj9TYBKj9iSZFHvsQ",
                authDomain: "finder-app-be8d5.firebaseapp.com",
                projectId: "finder-app-be8d5",
                storageBucket: "finder-app-be8d5.appspot.com",
                messagingSenderId: "1083573166983",
                appId: "1:1083573166983:android:8198c3647059ee3168e922"
            };

            // Initialize Firebase
            if (!firebase.apps.length) {
                firebase.initializeApp(firebaseConfig);
            }
            const db = firebase.firestore();

            async function setUserPresence(state) {
                const userId = authUserId; // Replace with authenticated user ID
                const userRef = db.collection("users").doc(userId.toString());

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
            }

            function listenForUserPresence(userId) {
                const userRef = db.collection("users").doc(userId.toString());

                userRef.onSnapshot((doc) => {
                    if (doc.exists) {
                        const userData = doc.data();
                        const userState = userData.state || "Offline";

                        // Update UI: Set "Online" or "Offline" in chat header
                        document.getElementById("chatTopNav_dealerState").innerHTML = `
               <i class="bi bi-circle-fill ${userState === "Online" ? "text-success" : "text-danger"} me-2"></i> ${userState}
                `;
                    }
                });
            }


            // Set user as online
            setUserPresence("Online");
            fetchUserChats();

            // Set offline when the user leaves
            window.addEventListener("beforeunload", () => setUserPresence("Offline"));
            async function fetchUserChats() {
                const senderId = authUserId;
                const chatList = document.getElementById("chatList");

                const chatQuery = await db.collection("service_chats")
                    .where("keys", "array-contains", senderId).get();

                chatList.innerHTML = "";

                if (chatQuery.empty) {
                    chatList.innerHTML = "<p class='text-center py-3'>No chats found</p>";
                    return;
                }

                chatQuery.forEach(doc => {
                    const chat = doc.data();
                    const chatId = doc.id;
                    const shop = chat.shop;

                    // Get participants and determine the other participant
                    const participants = chat.participants || [];
                    const sender = chat.sender;
                    const receiver = chat.receiver;

                    // Determine who is the other participant
                    let otherParticipant;
                    if (sender && sender.id === authUserId) {
                        otherParticipant = receiver;
                    } else if (receiver && receiver.id === authUserId) {
                        otherParticipant = sender;
                    } else {
                        // Fallback: find other participant from participants array
                        otherParticipant = participants.find(p => p.id !== authUserId) || receiver;
                    }

                    // Ensure we have participant data
                    if (!otherParticipant) {
                        console.warn("Could not determine other participant for chat:", chatId);
                        otherParticipant = receiver || sender || {
                            name: "Unknown",
                            image: "",
                            id: 0
                        };
                    }

                    let timestamp = chat.created_at ? new Date(chat.created_at.seconds * 1000)
                        .toLocaleTimeString() : "";

                    const chatHtml = `
                    <div class="row d-flex justify-content-between align-items-center px-2 chatRow" 
                    onclick="openChat('${chatId}', this)" 
                    style="cursor: pointer; padding: 10px 0; border-bottom: 1px solid rgba(255, 255, 255, 0.2);"
                    data-participant_name="${otherParticipant.name || 'Unknown'}"
                    data-participant_image="${otherParticipant.image || base_url + '/web/images/Frame 1171275409.svg'}" 
                    data-participant_id="${otherParticipant.id || 0}"
                    data-shop_title="${shop.title || 'Unknown Shop'}" 
                    data-price="${shop.price || ''}" 
                    data-shop_id="${shop.id || ''}" 
                    data-shop_image="${shop.poster || base_url + '/web/images/Frame 1171275409.svg'}"
                    data-other_participant='${JSON.stringify(otherParticipant).replace(/"/g, '&quot;')}'
                    data-chat_data='${JSON.stringify(chat).replace(/"/g, '&quot;')}'>
                    <div class="col-10 d-flex align-items-center">
                        <div>
                            <img src="${otherParticipant.image || base_url + '/web/images/Frame 1171275409.svg'}" 
                                style="height: 45px; width: 45px; border-radius: 50%;" alt="Participant">
                        </div>
                        <div class="ms-2">
                            <p class="m-0 leftchat text-dark"><strong>${otherParticipant.name || 'Unknown'}</strong></p>
                            <p class="m-0 leftchatname text-dark">${shop.title || 'No shop title'}</p>
                        </div>
                    </div>
                    <div class="col-2 d-flex justify-content-end pb-2">
                        <div class="me-2 text-end">
                            <p class="m-0 leftchatname">${timestamp}</p>
                        </div>
                    </div>
                    </div>`;

                    chatList.innerHTML += chatHtml;
                });
            }

            setupChatSearch();

            async function sendMessage(event) {
                event.preventDefault();
                //   console.log(receiver)
                // if (receiver) receiver = JSON.parse(receiver);
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
                     //   alert("File upload failed. Please try again.");
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
                    message: message || "", // Always string
                    attachment: fileUrl ?? null,
                    meta_data: file ? meta_data : null,
                    reply_message: isReply ? replyingToMessageContent : null,
                    reply_attachment: isReply && (reply_to_attachment != 'null' || null) ?
                        reply_to_attachment : null,
                    reply_meta_data: isReply && reply_meta_data ? JSON.parse(reply_meta_data) : null,
                    reply_to: isReply ? replyingToMessage : null,
                    type: "text",
                    receiver: {
                        // dealer_id: receiver.dealer_id || 0,
                        email: receiver.email,
                        fcm_token: receiver.fcm_token || "",
                        image: receiver.image || base_url + "web/images/Frame 1171275409.svg",
                        id: receiver.id,
                        name: receiver.name,
                        state: "Online"
                    },
                    sender: {
                        // dealer_id: authUserId || 0,
                        email: authUserEmail,
                        fcm_token: authUserFcmToken || "",
                        image: authUserImage || base_url + "web/images/Frame 1171275409.svg",
                        id: authUserId,
                        name: authUserName,
                        state: "Offline"
                    },
                    timestamp: firebase.firestore.FieldValue.serverTimestamp()
                };

                try {
                    await db.collection("service_messages").add(newMessage);
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



            // Handle file upload
            document.getElementById("file-upload").addEventListener("change", function(event) {
                const file = event.target.files[0];
                const previewContainer = document.getElementById("file-preview-container");
                const previewElement = document.getElementById("file-preview");

                if (file) {
                    const fileUrl = URL.createObjectURL(file);
                    previewContainer.classList.remove("d-none");

                    // Detect file type
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

            // Clear File Preview
            window.clearFilePreview = function() {
                document.getElementById("file-preview-container").classList.add("d-none");
                document.getElementById("file-preview").innerHTML = "";
                document.getElementById("file-upload").value = "";
            }

            // Clear Reply Preview
            window.clearReplyPreview = function() {
                document.getElementById("reply-preview-container").classList.add("d-none");
                document.getElementById("reply-preview-text").innerHTML = "";
                // replyingToMessage = null;
            }

            async function uploadFileToServer(file) {
                const formData = new FormData();
                formData.append("file", file);

                try {
                    const response = await fetch("/api/uploadShopAttachment", {
                        method: "POST",
                        body: formData,
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .getAttribute("content")
                        }
                    });

                    const result = await response.json();
                    if (result.status == 200) {
                        return result.data.url; // Return the stored file URL
                    } else {
						alert(result.errors.file);
                        console.error("File upload failed:", result.message);
                        return null;
                    }
                } catch (error) {
					alert(result.error);
                    console.error("Error uploading file:", error);
                    return null;
                }
            }

            // Attach event listener to form
            document.getElementById('chatForm').addEventListener('submit', sendMessage);


            window.replyToMessage = function(messageId, messageContent, senderName, attachment = null, metadata =
                null) {
                replyingToMessage = messageId;
                replyingToMessageContent = messageContent;
                reply_to_attachment = (attachment != null || 'null') ? attachment : NULL;
                reply_meta_data = metadata;
                console.log(reply_to_attachment);

                //reply preview UI
                const replyPreviewContainer = document.getElementById("reply-preview-container");
                const replyPreviewText = document.getElementById("reply-preview-text");

                // Truncate message if too long
                let previewContent = messageContent;
                if (previewContent.length > 50) {
                    previewContent = previewContent.substring(0, 50) + "...";
                }

                replyPreviewText.innerHTML = `<strong>${senderName}:</strong> ${previewContent}`;
                replyPreviewContainer.classList.remove("d-none");
                document.querySelector('.chat-input').focus();
            }

            // Function to delete message
            window.deleteMessage = async function(messageId, forEveryone = false) {
                try {
                    const messageRef = db.collection("service_messages").doc(messageId);
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

                    // Close any open context menu
                    document.querySelectorAll('.message-context-menu').forEach(menu => {
                        menu.remove();
                    });

                } catch (error) {
                    console.error("Error deleting message:", error);
                    alert("Failed to delete message. Please try again.");
                }
            }

            function listenForChatMessages(chatId) {
                const chatMessages = document.getElementById('chatMessages');
                chatMessages.innerHTML = '';

                db.collection("service_messages")
                    .where("key", "==", chatId)
                    .orderBy("timestamp", "asc")
                    .onSnapshot(snapshot => {
                        chatMessages.innerHTML = '';

                        snapshot.forEach(doc => {
                            const msg = doc.data();

                            // Skip rendering if message is deleted and current user is not the sender
                            if (msg.deleted && parseInt(msg.sender.id) !== parseInt(authUserId)) {
                                return;
                            }

                            if (msg.visibleTo && Array.isArray(msg.visibleTo) && !msg.visibleTo
                                .includes(authUserId)) {
                                return;
                            }

                            // Ensure correct sender check
                            const isSender = parseInt(msg.sender.id) === parseInt(authUserId);

                            // Assign correct images for sender and receiver
                            const senderImage = msg.sender.image ? msg.sender.image :
                                base_url + "web/images/Frame 1171275409.svg";
                            const receiverImage = msg.sender.id === authUserId ? authUserImage :
                                senderImage;

                            // CSS class for styling
                            const messageClass = isSender ? 'chatfont' : 'chatfonte';

                            // Handle deleted messages
                            let messageText = msg.message || '';
                            if (msg.deleted) {
                                messageText = '<em class="text-muted">This message was deleted</em>';
                            }

                            // Handle file attachments
                            const fileAttachment = msg.attachment && !msg.deleted ? getFilePreview(msg
                                .attachment) : '';

                            // Handle reply if this message is a reply to another
                            let replyHtml = '';
                            if (msg.reply_to && !msg.deleted) {
                                replyHtml = `
                            <div class="replied-message mb-2 p-2 rounded" 
                                style="background-color: rgba(255,255,255,0.1); border-left: 3px solid #FD5631;" onclick="highlightMessage('${msg.reply_to}', '${msg.reply_to_message}')">
                                <small class="text-white-50">Replying to message</small>
                                <p class="m-0 text-white-50 small">${msg.reply_message}</p>
                            </div>
                        `;
                            }

                            // Message action buttons (only show for sender's messages)
                            const messageActions = isSender ? `
                        <div class="message-actions d-none">
                            <button class="btn btn-sm text-white-50" onclick="showMessageOptions('${doc.id}')">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                        </div>
                    ` : '';

                            // Wrap messages in a container for proper positioning
                            const messageHtml = `
                    <div class="message-container ${isSender ? 'sent' : 'received'}" id="message-${doc.id}" data-message-id="${doc.id}" data-reply_meta_data="${JSON.stringify(msg.metadata ?? null)}">
                        ${!isSender ? `
                                                                                                                        <img src="${receiverImage}" class="chat-avatar me-2" 
                                                                                                                            style="height: 45px; width: 45px; border-radius: 50%;" 
                                                                                                                            alt="Receiver">
                                                                                                                    ` : ''}

                        <div class="${messageClass} p-3 rounded-3 position-relative" 
                             oncontextmenu="showMessageContextMenu(event, '${doc.id}', ${isSender}, '${msg.message?.replace(/'/g, "\\'")}', '${msg.sender.name?.replace(/'/g, "\\'")}', '${msg.attachment ?? null}', '${JSON.stringify(msg.meta_data ?? null).replace(/"/g, '&quot;')}'); return false;"
                             style="max-width: 50%; word-wrap: break-word; ${isSender ? 'background-color: #282435;' : 'background-color: #433B5D;'}" id="messagee-${doc.id}">
                            ${replyHtml}
                            ${messageText ? `<p class="m-0 text-white">${messageText}</p>` : ''}
                            ${fileAttachment}
                            <div class="timestamp text-white-50 mt-1 text-end d-flex align-items-center justify-content-end" style="font-size: 10px;">
                                ${msg.edited ? '<span style="color:white" class="me-1">(edited)</span>' : ''}
                              
                                ${msg.attachment && !msg.message ? '<span class="ms-1">File</span>' :  messageActions}
                            </div>
                        </div>

                        ${isSender ? `
                                                                                                                         <img @if ($user->image) src="{{ asset('web/profile/' . $user->image) }}" @else src="data:image/png;base64,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" @endif
                            style="height:50px ;width:50px;"    alt="Profile Picture">
                                                                                                                    ` : ''}
                    </div>`;

                            chatMessages.innerHTML += messageHtml;
                        });

                        // // Add hover effect for message actions
                        // document.querySelectorAll('.message-container.sent .chatfont').forEach(messageEl => {
                        //     messageEl.addEventListener('mouseenter', function() {
                        //         const actionsEl = this.querySelector('.message-actions');
                        //         if (actionsEl) actionsEl.classList.remove('d-none');
                        //     });

                        //     messageEl.addEventListener('mouseleave', function() {
                        //         const actionsEl = this.querySelector('.message-actions');
                        //         if (actionsEl) actionsEl.classList.add('d-none');
                        //     });
                        // });

                        // Scroll to bottom after rendering messages
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    });
            }

            // Function to show context menu on right click
            window.showMessageContextMenu = function(event, messageId, isSender, messageContent, senderName,
                attachment, metadata = null) {
                event.preventDefault();
                console.log('Right-clicked message');
                console.log(metadata)

                // Remove any existing context menus
                document.querySelectorAll('.message-context-menu').forEach(menu => {
                    menu.remove();
                });

                // Create context menu
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

                // Create menu items
                const menuItems = [];

                // Reply option (available for all messages)
                // menuItems.push({
                //     text: 'Reply',
                //     icon: 'bi-reply-fill',
                //     action: () => replyToMessage(messageId, messageContent, senderName)
                // });

                // Edit option (only for sender's messages)
                // if (isSender) {
                //     menuItems.push({
                //         text: 'Edit',
                //         icon: 'bi-pencil-fill',
                //         action: () => editMessage(messageId, messageContent)
                //     });
                // }

                // Delete options (only for sender's messages)
                if (isSender) {
                    menuItems.push({
                        text: 'Delete',
                        icon: 'bi-trash-fill',
                        action: () => deleteMessage(messageId, false)
                    });

                    // menuItems.push({
                    //     text: 'Delete for everyone',
                    //     icon: 'bi-trash-fill',
                    //     action: () => deleteMessage(messageId, true)
                    // });
                } else {
                    menuItems.push({
                        text: 'Reply',
                        icon: 'bi-reply-fill',
                        action: () => replyToMessage(messageId, messageContent, senderName, attachment,
                            metadata)
                    });
                    // Only delete for me option for received messages
                    // menuItems.push({
                    //     text: 'Delete for me',
                    //     icon: 'bi-trash-fill',
                    //     action: () => deleteMessage(messageId, false)
                    // });
                }

                // Add menu items to context menu
                menuItems.forEach(item => {
                    const menuItem = document.createElement('div');
                    menuItem.className = 'context-menu-item';
                    menuItem.style.padding = '8px 15px';
                    menuItem.style.cursor = 'pointer';
                    menuItem.style.color = 'white';
                    menuItem.style.fontSize = '14px';
                    menuItem.style.display = 'flex';
                    menuItem.style.alignItems = 'center';

                    menuItem.innerHTML = `
                <i class="bi ${item.icon} me-2"></i>
                <span style="color:white">${item.text}</span>
                 `;

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

                // Position the context menu
                document.body.appendChild(contextMenu);

                // Adjust position based on available space
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

                // Close menu when clicking elsewhere
                document.addEventListener('click', function closeMenu() {
                    contextMenu.remove();
                    document.removeEventListener('click', closeMenu);
                });
            }

            // Function to show quick message options
            window.showMessageOptions = function(messageId) {
                const messageElement = document.getElementById(`message-${messageId}`);
                if (!messageElement) return;

                // Get the message content and sender name
                const messageQuery = db.collection("chats").doc(messageId);
                messageQuery.get().then((doc) => {
                    if (doc.exists) {
                        const msgData = doc.data();
                        showMessageContextMenu({
                                preventDefault: () => {},
                                clientX: event.clientX,
                                clientY: event.clientY
                            },
                            messageId,
                            true,
                            msgData.message || '',
                            msgData.sender.name || 'You',
                        );
                    }
                });
            }

            // Function to edit message
            window.editMessage = async function(messageId, currentContent) {
                // Remove any existing context menus
                document.querySelectorAll('.message-context-menu').forEach(menu => {
                    menu.remove();
                });

                // Get the message element
                const messageElement = document.getElementById(`message-${messageId}`);
                if (!messageElement) return;

                // Create edit form
                const messageContainer = messageElement.querySelector('.chatfont');
                const originalContent = messageContainer.innerHTML;

                // Store original content to restore if cancelled
                messageContainer.dataset.originalContent = originalContent;

                // Create edit input field
                messageContainer.innerHTML = `
                    <div class="edit-message-form">
                        <textarea class="form-control bg-dark text-white mb-2 edit-message-textarea">${currentContent}</textarea>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-sm btn-outline-light me-2" onclick="cancelEditMessage('${messageId}')">Cancel</button>
                            <button class="btn btn-sm btn-primary" onclick="saveEditedMessage('${messageId}')">Save</button>
                        </div>
                    </div>
                `;

                // Focus the textarea and put cursor at the end
                const textarea = messageContainer.querySelector('textarea');
                textarea.focus();
                textarea.selectionStart = textarea.value.length;
            }

            // Function to cancel message editing
            window.cancelEditMessage = function(messageId) {
                const messageElement = document.getElementById(`message-${messageId}`);
                if (!messageElement) return;

                const messageContainer = messageElement.querySelector('.chatfont');
                messageContainer.innerHTML = messageContainer.dataset.originalContent;
            }

            // Function to save edited message
            window.saveEditedMessage = async function(messageId) {
                const messageElement = document.getElementById(`message-${messageId}`);
                if (!messageElement) return;

                const textarea = messageElement.querySelector('.edit-message-textarea');
                const newContent = textarea.value.trim();

                if (!newContent) {
                    alert("Message cannot be empty");
                    return;
                }

                try {
                    // Update the message in Firebase
                    await db.collection("chats").doc(messageId).update({
                        message: newContent,
                        edited: true,
                        editedAt: new Date().toISOString()
                    });

                    // The message will be re-rendered by the snapshot listener

                } catch (error) {
                    console.error("Error updating message:", error);
                    alert("Failed to update message. Please try again.");
                    cancelEditMessage(messageId);
                }
            }

            function getFilePreview(fileUrl) {
                const fileExtension = fileUrl.split('.').pop().toLowerCase();

                if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExtension)) {
                    // Image Preview with Download Button
                    return `
                        <div class="image-container mt-2 d-block">
                            <img src="${fileUrl}" class="img-fluid rounded shadow-sm" 
                                style="width: 100%; border-radius: 10px; cursor: pointer;" 
                                alt="Image Attachment"
                                onclick="openFullImage('${fileUrl}')">
                            
                            <a href="${fileUrl}" download class="download-button">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                        `;
                } else if (['pdf', 'doc', 'docx'].includes(fileExtension)) {
                    // File Attachment Link
                    return `
                        <a href="${fileUrl}" download class="d-block text-decoration-none mt-2 text-light">
                            <i class="bi bi-file-earmark-text fs-1 text-danger mb-2"></i> Download File
                        </a>`;
                } else {
                    // Generic File Link
                    return `
                        <a href="${fileUrl}" download class="d-block text-decoration-none mt-2 text-light">
                            <i class="bi bi-file-earmark fs-1 text-warning mb-2"></i> Download File
                        </a>`;
                }
            }

            // Function to open chat
            window.openChat = async function(chatId, element) {
                selectedChatId = chatId;
                selectedshopId = element.getAttribute("data-shop_id") || "";
                receiverId = element.getAttribute("data-participant_id") || "";
                receiver = element.getAttribute("data-other_participant") || "";

                if (!selectedshopId) {
                    console.error("shop ID is missing.");
                }

                listenForUserPresence(receiverId); // Corrected line

                // Update UI elements
                document.getElementById("chatTopNav").classList.remove("d-none");
                document.getElementById("sendMessageForm").classList.remove("d-none");
                document.getElementById("chatTopNav_dealerName").innerText = element.getAttribute(
                    "data-participant_name") || "Unknown";
                document.getElementById("chatTopNav_shopTitle").innerText = element.getAttribute(
                    "data-shop_title") || "No shop";

                document.getElementById("chatTopNav_dealerImage").src = element.getAttribute(
                    "data-participant_image") || "web/images/Final Logo.svg";
                document.getElementById("chatTopNav_shopImage").src = element.getAttribute(
                    "data-shop_image") || "Frame 1171275409.svg";

                // Fetch and display chat messages
                listenForChatMessages(chatId);
            }


            // Function to open full image
            window.openFullImage = function(imageUrl) {
                const modal = document.createElement('div');
                modal.className = 'modal fade';
                modal.id = 'imageModal';
                modal.setAttribute('tabindex', '-1');
                modal.setAttribute('aria-labelledby', 'imageModalLabel');
                modal.setAttribute('aria-hidden', 'true');

                modal.innerHTML = `
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content " style="border-radius: 10px; overflow: hidden;">
                                <div class="modal-header  " style="background-color: #FD5631; color: white;">
                                    <h5 class="modal-title " id="imageModalLabel">Image Preview</h5>
                                    <button type="button" class="btn-close btn-close-white"  style="background-color: white; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center p-0 p-5">
                                    <img src="${imageUrl}" class="img-fluid" style="max-height: 80vh;" alt="Full size image">
                                </div>
                                <div class="modal-footer border-top border-secondary" style="background-color: #FD5631; color: white; border-bottom: none;">
                                    <a href="${imageUrl}" download class="btn btn-primary" style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px;border:none">
                                        <i class="bi bi-download me-1"></i> Download
                                    </a>
                                    <button type="button" class="btn btn-secondary"  style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px;border:none" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    `;

                document.body.appendChild(modal);

                // Initialize and show Bootstrap modal
                const modalInstance = new bootstrap.Modal(modal);
                modalInstance.show();

                // Clean up when modal is hidden
                modal.addEventListener('hidden.bs.modal', function() {
                    document.body.removeChild(modal);
                });
            }

            function formatTimestamp(timestamp) {
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

            function setupChatSearch() {
                const searchInput = document.getElementById("chatSearch");
                const chatList = document.getElementById("chatList");

                searchInput.addEventListener("input", function() {
                    const filter = searchInput.value.toLowerCase().trim();
                    // alert(filter);
                    // Get all chat rows after they've been populated
                    const chatItems = chatList.querySelectorAll(".chatRow");
                    // alert(chatItems.length);

                    chatItems.forEach(chat => {
                        const dealerName = chat.getAttribute("data-dealer_name")?.toLowerCase() ||
                            "";
                        const shopTitle = chat.getAttribute("data-shop_title")?.toLowerCase() || "";

                        if (dealerName.includes(filter) || shopTitle.includes(filter)) {
                            chat.classList.remove("d-none");
                        } else {
                            // alert("not found");
                            chat.classList.add("d-none");
                        }
                    });
                });
            }



            function formatTimestamp() {
                const now = new Date();
                const options = {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    timeZoneName: 'short'
                };
                return now.toLocaleString('en-GB', options).replace(',', ' at');
            }

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
                return mimeTypes[extension] || "application/octet-stream"; // Default if unknown
            }

            window.highlightMessage = async function(messageId, searchTerm = '') {

                const messageElement = document.querySelector('#messagee-' + messageId);
                if (!messageElement) return; // Ensure element exists



                // Add a highlight effect to the message container
                messageElement.style.transition = "background-color 0.5s ease";
                messageElement.style.backgroundColor = "#FD5631"; // Light yellow highlight

                setTimeout(() => {
                    messageElement.style.backgroundColor = ""; // Remove highlight after 2 seconds
                }, 2000);
            }




        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const textarea = document.querySelector(".chat-input");
            const form = document.getElementById("chatForm");

            // Auto-resize on input
            textarea.addEventListener("input", function() {
                this.style.height = "auto";
                this.style.height = this.scrollHeight + "px";
            });

            // Reset height on submit
            form.addEventListener("submit", function() {
                setTimeout(() => {
                    textarea.value = "";
                    textarea.style.height = "auto"; // Reset to default
                }, 0); // Allow time for form submit to process
            });
        });
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const textarea = document.querySelector(".chat-input");
        const form = document.getElementById("chatForm");

        textarea.addEventListener("keydown", function (event) {
            // If Enter is pressed without Shift
            if (event.key === "Enter" && !event.shiftKey) {
                event.preventDefault(); // Prevents newline
                form.requestSubmit(); // Triggers the submit
            }
        });
    });
</script>

@endsection
