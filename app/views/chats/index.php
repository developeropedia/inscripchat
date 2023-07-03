<?php

include APPROOT . "/views/inc/header.php";
include APPROOT . "/views/inc/nav.php";

$chats = $data["chats"];
$user = $data["user"];
$admin = $data["admin"];
$familiarPeers = $data["familiar_peers"];
$online_users = $data["online_users"];
$peers = $data["peers"];


$chatObj = new Chat;

?>

<main class="chat-main">
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-lg-3 ">
                <div class="chat-peer-side">
                    <div class="px-1">
                        <div class="profile-details">
                            <div class="profile-img">
                                <img src="<?php echo URLROOT ?>/public/images/<?php echo $user->img; ?>" alt="">
                            </div>
                            <div>
                                <h1 class="m-0 p-0"><?php echo $user->userName; ?></h1>
                                <!-- <p class="mb-0 pb-0">Doctor</p> -->
                                <h2 class="m-0 p-0 mt-1">Online</h2>
                            </div>
                        </div>
                        <div class="chat-add-btn " data-bs-toggle="modal" data-bs-target="#addPeer">
                            <p class="mb-0 pb-0 f-14 w-500">Add peers</p>
                            <img src="<?php echo URLROOT ?>/public/images/button.add.png" alt="">
                        </div>
                        <div class="chat-add-btn mb-1" data-bs-toggle="modal" data-bs-target="#activePeer">
                            <p class="mb-0 pb-0 f-14 w-500">Active Chats</p>
                            <img src="<?php echo URLROOT ?>/public/images/button.add.png" alt="">
                        </div>
                        <div class="chat-add-btn mb-1" data-bs-toggle="modal" data-bs-target="#newChat">
                            <p class="mb-0 pb-0 f-14 w-500">New Chat</p>
                            <img src="<?php echo URLROOT ?>/public/images/button.add.png" alt="">
                        </div>
                        <?php if ($user->userID !== $admin->id) : ?>
                            <a style="color: #000000;" data-admin-name="<?php echo $admin->name; ?>" data-peer-id="<?php echo $admin->id; ?>" class="no-decoration chat-add-btn mb-1 admin-chat-btn">
                                <p class="mb-0 pb-0 f-14 w-500">Contact Admin</p>
                                <i class="bi bi-person text-grey me-1 f-20"></i>
                            </a>
                        <?php endif; ?>
                        <form>
                            <div class="comment-input">
                                <input id="search-box" type="text" class="w-100" placeholder="Search">
                                <i class="bi bi-search"></i>
                            </div>
                        </form>
                    </div>

                    <div class="peer-chats px-1">
                        <span class="mt-2"></span>
                        <?php if (isset($_GET['id'])) : ?>
                            <input type="hidden" value="<?php echo $_GET['id']; ?>" id="make-active">
                        <?php else : ?>
                        <?php endif; ?>
                        <?php if (!empty($chats)) : ?>
                            <?php foreach ($chats as $chat) :
                                if ($chat->user_id === $admin->id) {
                                    continue;
                                }
                            ?>
                                <div class="chat" data-timestamp="<?php echo $chat->timestamp; ?>" data-peer-id="<?php echo $chat->user_id; ?>">
                                    <div class="chat-dp">
                                        <img src="<?php echo URLROOT ?>/public/images/<?php echo $chat->user_img; ?>" alt="">
                                    </div>
                                    <div class="chat-text w-100 ms-2">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <h1 class="mb-0 pb-0 chat-user-name"><?php echo $chat->user_name; ?></h1>
                                            <div>
                                                <p class="mb-0 pb-0 ms-auto">
                                                    <script>
                                                        document.write(chatTime('<?php echo $chat->timestamp; ?>'));
                                                    </script>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center msg-data">
                                            <div class="d-flex align-items-center">
                                                <h2 class="mb-0 pb-0 mt-1 msg-txt"><?php echo $chat->message; ?></h2>
                                            </div>
                                            <?php
                                            $totalUnreadMessages = $chatObj->totalUnreadMessages($chat->user_id);

                                            if (!empty($totalUnreadMessages)) :
                                            ?>
                                                <div class="message-numbers"><?php echo $totalUnreadMessages; ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 chat-peer-messages">
                <?php

                $url = $_SERVER['REQUEST_URI'];
                $path = parse_url($url, PHP_URL_PATH);
                $path = ltrim($path, '/');
                $path = rtrim($path, '/');
                $segments = explode('/', $path);
                if (count($segments) > 2) :
                    $username = end($segments);
                ?>

                <?php else : ?>
                    <div class="chat-peer-messages--box d-flex align-items-center">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <img width="30%" src="<?php echo URLROOT; ?>/public/images/chat.png" alt="chat">
                            <p class="fw-bold" style="color: #2F791C">Select a chat and start conversation</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<div class="verification-message">
    Peers have been added successfully!
</div>
<div class="verification-message-delete">
    Peers have been deleted successfully!
</div>

<!--add peer Modal -->
<div class="modal fade" id="addPeer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLabel">Add peers you are familiar with</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <?php if (!empty($familiarPeers)) : ?>
                    <?php foreach ($familiarPeers as $peer) : ?>
                        <div class="chat-notification align-items-center add-peers-list delete-peers-list" data-peer-id="<?php echo $peer->id; ?>">
                            <div class="chat-notification-img">
                                <img src="<?php echo URLROOT; ?>/public/images/<?php echo $peer->img; ?>" alt="">
                            </div>
                            <div class="chat-notification-text bg-dange w-100">
                                <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                                    <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                        <?php echo $peer->username; ?>
                                    </label>
                                    <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p class="no-peer">No peers match with your institution</p>
                <?php endif; ?>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn px-5 successfull-btn add-peer-btn">Add</button>
            </div>
        </div>
    </div>
</div>

<!--active peer Modal -->
<div class="modal fade" id="activePeer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLabel">Active Peers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body online-users">
                <?php if (!empty($online_users)) : ?>
                    <?php foreach ($online_users as $online_user) : ?>
                        <div class="chat-notification online-user align-items-center" data-user-name="<?php echo $online_user->name; ?>" data-peer-id="<?php echo $online_user->userID; ?>">
                            <div class="chat-notification-img">
                                <img src="<?php echo URLROOT; ?>/public/images/<?php echo $online_user->img; ?>" alt="">
                            </div>
                            <div class="chat-notification-text w-100">
                                <div class="ms-1 ps-0 d-flex justify-content-between align-items-center form-check w-100">
                                    <label class="form-check-label f-18 w-500 chat-user-name" for="flexCheckChecked">
                                        <?php echo $online_user->name; ?>
                                    </label>
                                    <div class="online-peers me-3"></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p class="text-center no-online">No online users</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!--active peer Modal -->
<div class="modal fade" id="newChat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLabel">Start New Chat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body new-users">
                <?php if (!empty($peers)) : ?>
                    <?php foreach ($peers as $peer) : ?>
                        <div class="chat-notification new-user align-items-center" data-user-name="<?php echo $peer->name; ?>" data-peer-id="<?php echo $peer->id; ?>">
                            <div class="chat-notification-img">
                                <img src="<?php echo URLROOT; ?>/public/images/<?php echo $peer->img; ?>" alt="">
                            </div>
                            <div class="chat-notification-text w-100">
                                <div class="ms-1 ps-0 d-flex justify-content-between align-items-center form-check w-100">
                                    <label class="form-check-label f-18 w-500 chat-user-name" for="flexCheckChecked">
                                        <?php echo $peer->name; ?>
                                    </label>
                                    <!-- <div class="online-peers me-3"></div> -->
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p class="text-center no-online">No peers</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?php

include APPROOT . "/views/inc/footer.php";

?>

<script>
    const user = <?php echo json_encode($user); ?>;

    function emojiInit() {
        if (document.getElementById("emojiBtn")) {
            var margin = 0,
                instance1 = new emojiButtonList("emojiBtn", {
                    dropDownXAlign: "left",
                    textBoxID: "emojiarea",
                    yAlignMargin: margin,
                    xAlignMargin: margin
                })

            // ==================================upload
            // let input = document.getElementById("inputTag");
            // let imageName = document.getElementById("imageName")

            // input.addEventListener("change", () => {
            //     let inputImage = document.querySelector("input[type=file]").files[0];

            //     imageName.innerText = inputImage.name;
            // })
        }
    }
</script>

<script>
    window.addEventListener("resize", function() {
        if (window.matchMedia("(max-width: 500px)").matches) {
            $(".chat").on("click", function() {
                $(".chat-peer-side").css("display", "none");
                $(".chat-peer-messages--box").css("display", "block");
                $(".bi-arrow-left").css("display", "block");
            })

            $(".bi-arrow-left").on("click", function() {
                $(".chat-peer-side").css("display", "block");
                $(".chat-peer-messages--box").css("display", "none");
            })
        } else {
            $(".chat").on("click", function() {
                $(".chat-peer-side").css("display", "block");
                $(".chat-peer-messages--box").css("display", "block");
                $(".bi-arrow-left").css("display", "none")
            })
        }
    })
</script>

<script>
    $(document).ready(function() {
        // Get the search box and chat container elements
        var searchBox = $("#search-box");
        var chatContainer = $(".peer-chats");

        // Listen for the input event on the search box
        searchBox.on("input", function() {
            var searchTerm = searchBox.val().toLowerCase();

            // Get all chat messages within the chat container
            var chats = chatContainer.find(".chat");

            // Iterate over the chat messages and show/hide based on the search term
            chats.each(function() {
                var chat = $(this);
                var chatText = chat.find(".chat-user-name").text().toLowerCase();

                if (chatText.includes(searchTerm)) {
                    chat.css("display", "flex"); // Show the chat message
                } else {
                    chat.css("display", "none"); // Hide the chat message
                }
            });
        });
    });
</script>

<script id="chat-template" type="text/template">
    <div class="chat-peer-messages--box">
        <div class="message-header">
            <i class="bi bi-arrow-left f-22 me-2"></i>
            <h1 class="m-0 p-0 d-flex align-items-center">{chat_user_name}</h1>
            <!-- <div class="date ">
                <p>10 Feb, 2023</p>
            </div> -->
        </div>
        <div class="message-body" id="chat-box">
        </div>
        <div class="message-input">
            <input type="text" placeholder="Type your message" id="emojiarea" class="msg-input">

            <div>
                <i id="emojiBtn" style="color: #989898; cursor: pointer;" class="bi bi-emoji-smile"></i>
                <img style="cursor: pointer" id="send-msg-btn" src="<?php echo URLROOT ?>/public/images/Send Button.png" alt="">
            </div>
        </div>
    </div>
</script>

<script id="sender-msg-template" type="text/template">
    <div class="d-flex align-items-start pt-1">
        <div class="message-img">
            <img src="<?php echo URLROOT ?>/public/images/{user_img}" alt="">
        </div>
        <div>
            <div class="message-msg mb-1">
                <p class="mb-0 pb-0">{msg}</p>
            </div>
            <p class="msg-time f-12 w-400 text-grey ms-2">{time}</p>
        </div>
    </div>
</script>

<script id="receiver-msg-template" type="text/template">
    <div class="d-flex justify-content-end pt-1">
        <div>
            <div class="message-msg message-msg-send mb-1">
                <p class="mb-0 pb-0">{msg}</p>
            </div>
            <p class="msg-time f-12 w-400 text-grey me-2 text-end">{time}</p>
        </div>
        <div class="message-img ">
            <img src="<?php echo URLROOT ?>/public/images/{user_img}" alt="">
        </div>
    </div>
</script>

<script id="admin-msg-template" type="text/template">
    <div class="d-flex justify-content-end pt-1">
        <div>
            <div class="message-msg message-msg-send mb-1">
                <p class="mb-0 pb-0">Hello, Thanks for Contacting Us</p>
            </div>
            <div class="message-msg message-msg-send mb-1">
                <p class="mb-0 pb-0">
                    Leave a message and we'll get back to you!
                </p>
            </div>
            <p class="msg-time f-12 w-400 text-grey me-2 text-end">00:00 AM</p>
        </div>
        <div class="message-img">
            <img class="admin-msg-img" src="<?php echo URLROOT; ?>/public/images/<?php echo $admin->img; ?>" alt="">
        </div>
    </div>
</script>

<script id="chat-menu-template" type="text/template">
    <div class="chat" data-timestamp="{timestamp}" data-peer-id="{user_id}">
        <div class="chat-dp">
            <img src="<?php echo URLROOT ?>/public/images/{user_img}" alt="">
        </div>
        <div class="chat-text w-100 ms-2">
            <div class="d-flex justify-content-between align-items-center w-100">
                <h1 class="mb-0 pb-0 chat-user-name">{user_name}</h1>
                <div>
                    <p class="mb-0 pb-0 ms-auto">
                        {time}
                    </p>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center msg-data">
                <div class="d-flex align-items-center">
                    <h2 class="mb-0 pb-0 mt-1 msg-txt">{msg_text}</h2>
                </div>
                    <div class="message-numbers">{total_unread_msgs}</div>
            </div>
        </div>
    </div>
</script>

<script id="online-user-template" type="text/template">
    <div class="chat-notification align-items-center online-user" data-peer-id="{peer_id}">
        <div class="chat-notification-img">
            <img src="<?php echo URLROOT; ?>/public/images/{img}" alt="">
        </div>
        <div class="chat-notification-text w-100">
            <div class="ms-1 ps-0 d-flex justify-content-between align-items-center form-check w-100">
                <label class="form-check-label f-18 w-500 chat-user-name" for="flexCheckChecked">
                    {name}
                </label>
                <div class="online-peers me-3"></div>
            </div>
        </div>
    </div>
</script>

<script>
    var timeTag = '';
    const appURL = "<?php echo URLROOT; ?>";

    $(document).ready(function() {
        var makeActive = $("#make-active");
        if (makeActive.length) {
            var makeActiveChat = makeActive.val()
            $(".chat[data-peer-id='" + makeActiveChat + "']").click()
        }
    })

    // Show selected user chat
    $(document).on("click", ".peer-chats .chat, .admin-chat-btn, .online-user, .new-user", function() {
        if ($(this).hasClass("active-chat")) {
            return;
        }

        $("#activePeer").modal("hide")
        $("#newChat").modal("hide")

        var isAdmin = $(this).hasClass("admin-chat-btn");
        $(".chat, .admin-chat-btn").removeClass("active-chat");
        $(this).addClass("active-chat");
        const peerID = $(this).data("peer-id")

        var currentUrl = window.location.href;
        var urlObj = new URL(currentUrl);
        if (urlObj.searchParams.has("id")) {
            var newIdValue = peerID;
            urlObj.searchParams.set("id", newIdValue);
            var updatedUrl = urlObj.href;
            history.pushState(null, "", updatedUrl);
        }

        var chatTemplate = $("#chat-template").html()
        if (isAdmin) {
            chatTemplate = chatTemplate.replace("{chat_user_name}", $(this).data("admin-name"))
        } else {
            chatTemplate = chatTemplate.replace("{chat_user_name}", $(this).find(".chat-user-name").text())
        }

        if ($(this).hasClass("online-user") || $(this).hasClass("new-user")) {
            var onlinePeerId = $(this).data("peer-id");
            if (!$(".peer-chats .chat[data-peer-id='" + onlinePeerId + "']").length) {
                $(".chat, .admin-chat-btn").removeClass("active-chat")
                $(".chat[data-peer-id='" + onlinePeerId + "']").addClass("active-chat")
                var img = $(this).find("img").attr("src").split("/")
                img = img[img.length - 1];

                var momentObj = moment();
                var timestamp = momentObj.format("YYYY-MM-DD HH:mm:ss");

                var chatMenuTemplate = $("#chat-menu-template").html()
                chatMenuTemplate = chatMenuTemplate
                    .replace("{user_name}", $(this).find(".chat-user-name").text())
                    .replace("{user_img}", img)
                    .replace("{user_id}", onlinePeerId)
                    .replace("{time}", chatTime(Date.now()))
                    .replace("{timestamp}", timestamp)
                    .replace("{msg_text}", "");

                $(".peer-chats").append(chatMenuTemplate)
                sortChatsByTimestamp();
            }
            $(".chat, .admin-chat-btn").removeClass("active-chat");
            $(".chat[data-peer-id='" + onlinePeerId + "']").addClass("active-chat")
        }

        var chatBox = $(".chat-peer-messages");
        chatBox.empty()
        chatBox.append(chatTemplate)
        emojiInit()

        var msgBody = $(".message-body");
        var senderMsgTemplate, receiverMsgTemplate;

        var adminMsgTemplate = $("#admin-msg-template").html();
        if (isAdmin) {
            msgBody.append(adminMsgTemplate)
        }

        $.ajax({
            url: appURL + "/chats/fetchChat",
            method: "post",
            data: {
                action: "fetch_chat",
                peerID
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.chat) {
                    var currentDate = null;
                    response.chat.forEach(msg => {
                        var msgDate = new Date(msg.timestamp).setHours(0, 0, 0, 0); // Get the message date at midnight
                        var formattedDate = new Date(msg.timestamp).toLocaleDateString([], {
                            day: 'numeric',
                            month: 'short',
                            year: 'numeric'
                        });

                        if (msgDate !== currentDate) {
                            var today = new Date().setHours(0, 0, 0, 0); // Get the current date at midnight
                            if (msgDate === today) {
                                timeTag = 'Today';
                            } else if (msgDate === today - (24 * 60 * 60 * 1000)) {
                                timeTag = 'Yesterday';
                            } else {
                                timeTag = formattedDate;
                            }
                            var timeTagTemplate = `<div id="time-tag-main"><div class="time-tag">${timeTag}</div></div>`;
                            msgBody.append(timeTagTemplate);
                            currentDate = msgDate;
                        }

                        if (msg.sender_id == peerID) {
                            var date = new Date(msg.timestamp);
                            var time = date.toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                            senderMsgTemplate = $("#sender-msg-template").html();
                            senderMsgTemplate = senderMsgTemplate
                                .replace("{user_name}", msg.peer_name)
                                .replace("{user_img}", msg.peer_img)
                                .replace("{msg}", msg.message)
                                .replace("{time}", time);
                            msgBody.append(senderMsgTemplate);
                        } else {
                            var date = new Date(msg.timestamp);
                            var time = date.toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                            receiverMsgTemplate = $("#receiver-msg-template").html();
                            receiverMsgTemplate = receiverMsgTemplate
                                .replace("{user_name}", msg.user_name)
                                .replace("{user_img}", msg.user_img)
                                .replace("{msg}", msg.message)
                                .replace("{time}", time);
                            msgBody.append(receiverMsgTemplate);
                        }
                    });

                    if ($("#chat-box").length) {
                        $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);
                    }
                    $(".chat.active-chat .message-numbers").remove()
                }
            }
        });

    })

    // Send message
    $(document).keypress(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == 13) {
            $('#send-msg-btn').click();
        }
    });


    $("body").on("click", "#send-msg-btn", function() {
        var msgBody = $(".message-body");
        var receiverMsgTemplate;

        const peerID = $(".active-chat").data("peer-id")
        const msg = $(".msg-input").val()
        if (msg.length > 0) {
            $.ajax({
                url: appURL + "/chats/sendChat",
                method: "post",
                data: {
                    action: "send_chat",
                    peerID,
                    msg
                },
                success: function(response) {
                    if (response) {
                        var date = new Date();
                        var time = date.toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                        if (timeTag !== 'Today') {
                            var timeTagTemplate = `<div id="time-tag-main"><div class="time-tag">Today</div></div>`;
                            msgBody.append(timeTagTemplate);
                            timeTag = 'Today'
                        }

                        receiverMsgTemplate = $("#receiver-msg-template").html()
                        receiverMsgTemplate = receiverMsgTemplate
                            .replace("{user_name}", user.name)
                            .replace("{user_img}", user.img)
                            .replace("{msg}", msg)
                            .replace("{time}", time)
                        msgBody.append(receiverMsgTemplate)
                        $(".msg-input").val("")
                        if ($("#chat-box").length) {
                            $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);
                        }
                    }
                }
            })
        }
    })

    function checkForNewMessages() {
        if ($(".active-chat").length) {
            var msgBody = $(".message-body");
            var senderMsgTemplate;
            const peerID = $(".active-chat").data("peer-id")

            $.ajax({
                url: appURL + "/chats/newMsgs",
                method: "post",
                data: {
                    action: "check_new_messages",
                    peerID
                },
                success: function(response) {
                    console.log(response);
                    response = JSON.parse(response)
                    if (response.msgs) {
                        response.msgs.forEach((msg) => {
                            var date = new Date(msg.timestamp);
                            var time = date.toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                            senderMsgTemplate = $("#sender-msg-template").html();
                            senderMsgTemplate = senderMsgTemplate
                                .replace("{user_name}", msg.peer_name)
                                .replace("{user_img}", msg.peer_img)
                                .replace("{msg}", msg.message)
                                .replace("{time}", time);
                            msgBody.append(senderMsgTemplate);
                            $(".chat[data-peer-id='" + msg.sender_id + "'] .msg-txt").text(msg.message)
                        })
                        if ($("#chat-box").length && response.msgs.length > 0) {
                            var chatBox = $("#chat-box");
                            chatBox.scrollTop(chatBox[0].scrollHeight);
                            // var isScrolledToBottom = chatBox[0].scrollHeight - chatBox.scrollTop() === chatBox.outerHeight();

                            // // Check if the scroll bar is at the bottom
                            // if (isScrolledToBottom) {
                            //     chatBox.scrollTop(chatBox[0].scrollHeight);
                            // }
                        }
                    }
                }
            });
        }
    }

    checkForNewMessages();
    var intervalID = setInterval(checkForNewMessages, 1000);

    function checkForAllNewMessages() {
        var prevMsgsLength = 0

        $.ajax({
            url: appURL + "/chats/newMsgsAll",
            method: "post",
            data: {
                action: "check_new_messages_all",
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.msgs.length !== prevMsgsLength) {
                    sortChatsByTimestamp();
                }
                prevMsgsLength = response.msgs.length
                response.msgs.forEach(msg => {
                    if (!$(".chat[data-peer-id='" + msg.sender_id + "']").length) {
                        var date = new Date(msg.timestamp);
                        var time = date.toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                        var chatMenuTemplate = $("#chat-menu-template").html()
                        chatMenuTemplate = chatMenuTemplate
                            .replace("{user_name}", msg.peer_name)
                            .replace("{user_img}", msg.peer_img)
                            .replace("{user_id}", msg.sender_id)
                            .replace("{time}", time)
                            .replace("{timestamp}", msg.timestamp);
                        $(".peer-chats").append(chatMenuTemplate)
                    }

                    if ($(".chat[data-peer-id='" + msg.sender_id + "'] .message-numbers").length) {
                        $(".chat[data-peer-id='" + msg.sender_id + "'] .message-numbers").text(msg.total_new_msgs)
                    } else {
                        $(".chat[data-peer-id='" + msg.sender_id + "'] .msg-data").append(
                            "<div class='message-numbers'>" + msg.total_new_msgs + "</div>"
                        )
                    }

                    $(".chat[data-peer-id='" + msg.sender_id + "'] .msg-txt").text(msg.message)
                    $(".chat[data-peer-id='" + msg.sender_id + "']").data("timestamp", msg.timestamp)
                })
            }
        });
    }

    checkForAllNewMessages();
    var intervalID = setInterval(checkForAllNewMessages, 1000);

    function sortChatsByTimestamp() {
        var chatContainer = $('.peer-chats');
        var chatElements = chatContainer.find('.chat');

        chatElements.sort(function(a, b) {
            var aTimestamp = $(a).data('timestamp');
            var bTimestamp = $(b).data('timestamp');

            // Convert the timestamps to Date objects for comparison
            var aDate = new Date(aTimestamp);
            var bDate = new Date(bTimestamp);

            // Sort in descending order (latest first)
            return bDate - aDate;
        });

        chatElements.detach().appendTo(chatContainer);
    }

    sortChatsByTimestamp();

    // setInterval(sortChatsByTimestamp, 1000);
    // Add Peers
    $(".add-peer-btn").click(function() {
        if ($("#addPeer").find(".no-peer").length) {
            $(".verification-message").text("No peers to add")
            $("#addPeer").modal("hide")
            return;
        }

        const peerIDs = $("#addPeer .add-peers-list:has(:checkbox:checked)").map(function() {
            return $(this).data("peer-id");
        }).get();

        if (!$("#addPeer").find(".no-peer").length && !peerIDs.length) {
            $(".verification-message").text("No peers selected to add")
            $("#addPeer").modal("hide")
            return;
        }

        $.ajax({
            url: appURL + "/users/addPeers",
            method: "POST",
            data: {
                action: "add_peers",
                peerIDs
            },
            success: function(response) {
                if (response) {

                    $("#addPeer .add-peers-list:has(:checkbox:checked)").remove();

                    $("#addPeer").modal("hide")
                    $(".verification-message").text("Peers have been added successfully!");

                    if (!$("#addPeer .add-peers-list").length) {
                        $("#addPeer .modal-body").append('<p class="no-peer">No peers to add</p>')
                    }
                } else {
                    $("#addPeer").modal("hide")
                    $(".verification-message").text("Error adding peers!");
                }
            }
        })
    })

    // Get online users
    function fetchOnlineUsers() {
        $.ajax({
            url: appURL + '/users/getOnlineUsers',
            method: 'POST',
            success: function(response) {
                response = JSON.parse(response)
                if (response.onlineUsers) {
                    // Create an array to store the online peer IDs
                    var onlinePeerIds = [];

                    // Iterate over the online users and populate the onlinePeerIds array
                    response.onlineUsers.forEach(user => {
                        onlinePeerIds.push(user.userID);
                    });

                    // Remove the online-user div if its data-peer-id is not in the onlinePeerIds array
                    $('.online-user').each(function() {
                        var peerId = $(this).data('peer-id');
                        if (!onlinePeerIds.includes(peerId)) {
                            $(this).remove();
                        }
                    });

                    // Check if there are online users
                    if (onlinePeerIds.length > 0) {
                        $('.no-online').remove(); // Remove the .no-online div
                    } else {
                        // Append the .no-online div if there are no online users
                        if (!$(".no-online").length) {
                            $(".online-users").append('<div class="text-center no-online">No online users</div>');
                        }
                    }

                    // Append the online users to the online-users div
                    response.onlineUsers.forEach(user => {
                        var peerId = user.userID;
                        if (!$(`.online-user[data-peer-id=${peerId}]`).length) {
                            var onlineUserTemplate = $("#online-user-template").html();
                            onlineUserTemplate = onlineUserTemplate
                                .replace("{peer_id}", user.userID)
                                .replaceAll("{name}", user.name)
                                .replace("{img}", user.img);
                            $(".online-users").append(onlineUserTemplate);
                        }
                    });
                }
            }
        });

    }

    setInterval(fetchOnlineUsers, 1000);
</script>

<!-- Admin chat -->
<!-- <script>
    $(".admin-chat-btn").click(function() {
        $(".chat").removeClass("active-chat")
        $(this).addClass("active-chat")
    })
</script> -->