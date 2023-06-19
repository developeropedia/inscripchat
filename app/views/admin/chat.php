<?php

include_once APPROOT . "/views/inc/admin-header.php";

$chat = $data["chat"];

?>

<!-- -----------Main Contents----------- -->
<main class="content pb-4">


    <div class="container-fluid">
        <div class="row m-0 -0">
            <div class="col-lg-12  ">
                <?php //echo "<pre>"; 
                ?>
                <?php //print_r($chat); 
                ?>
                <?php //echo "</pre>"; 
                ?>

                <div class="chat-peer-messages--box">
                    <div class="message-header">
                        <a href="<?php echo URLROOT; ?>/admin/chats"><i class="bi bi-arrow-left f-22 me-2"></i></a>
                        <h1 class="m-0 p-0 d-flex align-items-center"><?php echo $chat[0]->sender_name . " - " . $chat[0]->receiver_name ?></h1>
                        <!-- <div class="date ">
                            <p>10 Feb, 2023</p>
                        </div> -->
                    </div>
                    <div class="message-body">

                        <?php if (!empty($chat)) : ?>
                            <?php foreach ($chat as $msg) : ?>
                                <?php if ($msg->sender_id == $_GET['s']) : ?>
                                    <div class="d-flex align-items-start pt-1">
                                        <div class="message-img">
                                            <img src="<?php echo URLROOT; ?>/public/images/<?php echo $msg->sender_img; ?>" alt="">
                                        </div>
                                        <div>
                                            <div class="message-msg mb-1">
                                                <p class="mb-0 pb-0"><?php echo $msg->message; ?></p>
                                            </div>
                                            <p class="msg-time f-12 w-400 text-grey ms-2">
                                                <script>
                                                    document.write(chatTime('<?php echo $msg->timestamp; ?>'));
                                                </script>
                                            </p>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="d-flex justify-content-end pt-1">

                                        <div>
                                            <div class="message-msg message-msg-send mb-1">
                                                <p class="mb-0 pb-0"><?php echo $msg->message; ?></p>
                                            </div>
                                            <p class="msg-time f-12 w-400 text-grey me-2 text-end">
                                                <script>
                                                    document.write(chatTime('<?php echo $msg->timestamp; ?>'));
                                                </script>
                                            </p>
                                        </div>
                                        <div class="message-img ">
                                            <img src="<?php echo URLROOT; ?>/public/images/<?php echo $msg->sender_img; ?>" alt="">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
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