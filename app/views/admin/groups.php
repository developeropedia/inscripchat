<?php

include_once APPROOT . "/views/inc/admin-header.php";

$admin = $data["admin"];
$groups = $data["groups"];

?>

<!-- -----------Main Contents----------- -->
<main class="content pb-4">


    <div class="container-fluid">
        <div class="row m-0 -0">
            <div class="col-lg-12 mt-4 ">
                <div class="panel-card">
                    <div class="row chat-main px-0">
                        <div class="col-lg-12 px-0">
                            <div class="chat-peer-side">
                                <div class="d-flex align-content-center flex-wrap">
                                    <div class="profile-details">
                                        <div class="profile-img">
                                            <img src="<?php echo URLROOT; ?>/public/images/<?php echo $admin->img; ?>" alt="">
                                        </div>
                                        <div>
                                            <h1 class="m-0 p-0 mb-1"><?php echo $admin->name; ?></h1>
                                            <h2 class="m-0 p-0">Online</h2>
                                        </div>
                                    </div>
                                    <form class="comment-input-div  mx-auto">
                                        <div class="comment-input mt-2 ">
                                            <input id="search-box" type="text" class="w-100" placeholder="Search">
                                            <i class="bi bi-search"></i>
                                        </div>
                                    </form>
                                </div>

                                <div class="seprator w-100 mt-2"></div>



                                <div class="peer-chats px-1">
                                    <?php if (!empty($groups)) : ?>
                                        <?php foreach ($groups as $group) : ?>
                                            <?php if (!empty($group->comment)) : ?>
                                                <a target="_blank" href="<?php echo URLROOT; ?>/posts/post/<?php echo $group->postID; ?>">
                                                    <div class="chat mt-2 ">
                                                        <div class="chat-dp">
                                                            <img src="<?php echo URLROOT; ?>/public/uploads/<?php echo $group->content; ?>" alt="">
                                                        </div>
                                                        <div class="chat-text w-100 ms-2">
                                                            <div class="d-flex justify-content-between align-items-center w-100">
                                                                <h1 class="mb-0 pb-0 chat-user-name"><?php echo $group->name; ?></h1>
                                                                <div>
                                                                    <p class="mb-0 pb-0 ms-auto">
                                                                        <script>
                                                                            document.write(timeAgo('<?php echo $group->created_at ?? "none"; ?>'));
                                                                        </script>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-between align-items-center ">
                                                                <h2 class="mb-0 pb-0 mt-1">
                                                                    <?php echo $group->comment ?>
                                                                </h2>
                                                                <!-- <div class="message-numbers">03</div> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <div class="seprator"></div>
                                            <?php else : ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <p class="text-center mt-2">No conversations yet</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


</main>

<?php

include_once APPROOT . "/views/inc/admin-footer.php";

?>

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