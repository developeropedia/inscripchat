<?php

$groupObj2 = new Group;
$userObj2 = new User;
$chatObj2 = new Chat;

$groups = $groupObj2->getRecentGroups();

if (count($groups) > 3) {
    $groups = array_slice($groups, 0, 3);
}

$currentUser = $userObj2->getUserById($_SESSION['user_id']);

$chats = $chatObj2->getNotifications();
$chats = array_slice($chats, 0, 3);

?>

<body>
    <header>
        <nav class="navbar navbar-expand navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?php echo URLROOT; ?>/pages/index">
                    <img src="<?php echo URLROOT; ?>/public/images/logo.png" alt="" class=" navbar-logo">
                </a>

                <div class="d-flex w-100">
                    <div class="nav-form mx-auto">
                        <input class="form-control me-2 search-input" type="text" placeholder="Search">
                        <a class="search-btn"><i class="bi bi-search"></i></a>
                    </div>
                </div>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">

                    <div class="ms-auto d-flex align-items-center">
                        <div class="parent">

                            <a href="#" class="nav-link ">
                                <img src="<?php echo URLROOT; ?>/public/images/<?php echo $currentUser->img; ?>" alt="">
                            </a>
                            <ul class="child">
                                <div class="up-arrow"></div>
                                <?php if ($_SESSION['user_is_admin'] == 1) : ?>
                                    <li>
                                        <a href="<?php echo URLROOT; ?>/posts/upload">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="me-2 bi bi-person-up" viewBox="0 0 16 16">
                                                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.354-5.854 1.5 1.5a.5.5 0 0 1-.708.708L13 11.707V14.5a.5.5 0 0 1-1 0v-2.793l-.646.647a.5.5 0 0 1-.708-.708l1.5-1.5a.5.5 0 0 1 .708 0ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z">
                                                </path>
                                                <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z">
                                                </path>
                                            </svg>
                                            Upload
                                        </a>
                                    </li>
                                <?php else : ?>
                                <?php endif; ?>
                                <li><a href="<?php echo URLROOT; ?>/users/profile"><i class="bi bi-people me-2 f-20"></i>Profile</a>
                                </li>
                                <li><a href="<?php echo URLROOT; ?>/users/logout"><i class="bi bi-box-arrow-left me-2 f-20"></i>Logout</a></li>


                            </ul>
                        </div>
                        <div class="parent">
                            <a href="<?php echo URLROOT; ?>/chats" class="nav-link peer-icons "><i class="bi bi-person-fill"></i>
                                <div class="message-number-notification d-none">0</div>
                            </a>

                            <ul class="child chat-notifications-nav">
                                <div class="up-arrow"></div>
                                <div class="peers-heading">
                                    <h1 class="drop-heading text-center">Peers</h1>
                                </div>
                                <?php
                                $totalUnreadMessages = 0;
                                if (!empty($chats)) : ?>
                                    <?php foreach ($chats as $key => $chat) :
                                        $total = $chatObj2->totalUnreadMessages($chat->user_id);
                                        if (!empty($total)) {
                                            $totalUnreadMessages += $total;
                                        }
                                    ?>
                                        <li>
                                            <a href="<?php echo URLROOT; ?>/chats?id=<?php echo $chat->sender_id; ?>">
                                                <div class="chat-notification" data-sender-id="<?php echo $chat->sender_id; ?>">
                                                    <div class="chat-notification-img">
                                                        <img src="<?php echo URLROOT; ?>/public/images/<?php echo $chat->user_img; ?>" alt="">
                                                    </div>
                                                    <div class="chat-notification-text">
                                                        <div class="d-flex justify-content-between">
                                                            <p class="name mb-0 pb-0"><?php echo $chat->user_name; ?></p>
                                                            <p class="date pb-0 mb-0">
                                                                <script>
                                                                    document.write(chatTime('<?php echo $chat->timestamp; ?>'));
                                                                </script>
                                                            </p>
                                                        </div>
                                                        <div class="message-text">
                                                            <p class="mb-0 pb-0 ">
                                                                <?php echo $chat->message; ?>
                                                            </p>
                                                            <?php if (!empty($total)) : ?>
                                                                <div class="message-number"><?php echo $total; ?></div>
                                                            <?php else : ?>
                                                            <?php endif; ?>
                                                        </div>

                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <p class="text-center">No chats yet</p>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <input type="hidden" id="total-unread-msgs" value="<?php echo isset($totalUnreadMessages) ? $totalUnreadMessages : 0; ?>">
                        <div class="parent">
                            <a href="#" class="nav-link peer-icons "> <i class="bi bi-people-fill"></i></a>
                            <ul class="child">
                                <div class="up-arrow"></div>
                                <div>
                                    <h1 class="drop-heading text-center">Groups</h1>
                                </div>
                                <div class="group-notifications-nav">
                                <?php if (!empty($groups)) : ?>
                                    <?php foreach ($groups as $group) : ?>
                                        <li>
                                            <a href="<?php echo URLROOT; ?>/groups/group/<?php echo $group->id; ?>">
                                                <div class="chat-notification">
                                                    <div class="chat-notification-img">
                                                        <img src="<?php echo URLROOT; ?>/public/images/group.jpg" alt="">
                                                    </div>
                                                    <div class="chat-notification-text">
                                                        <div class="d-flex justify-content-between">
                                                            <p class="name mb-0 pb-0"><?php echo $group->name; ?></p>
                                                            <p class="date pb-0 mb-0">
                                                                <script>
                                                                    document.write(timeAgo('<?php echo $group->created_at ?? "none"; ?>'));
                                                                </script>
                                                            </p>
                                                        </div>
                                                        <div class="message-text">
                                                            <p class="mb-0 pb-0 ">
                                                                <?php echo $group->comment ?? "No comments yet"; ?>
                                                            </p>
                                                            <!-- <div class="message-number">15</div> -->
                                                        </div>

                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <p class="text-center">No comments</p>
                                <?php endif; ?>
                                </div>
                            </ul>
                        </div>
                    </div>


                </div>
            </div>
        </nav>
    </header>