<footer style="background-color: #f8f9fa; padding: 10px 0px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-md-row flex-column justify-content-md-between justify-content-center align-items-center">
                    <div>
                        <p class=" w-500 mb-0 pb-0 f-12">Copyright © 2023</p>
                    </div>
                    <div class="d-flex align-items-center mt-md-0 mt-3">
                        <p class="f-14 w-400 mb-0 pb-0"><a href="<?php echo URLROOT; ?>/pages/privacyPolicy" class="no-decoration f-12 w-500">Privacy Policy</a></p>
                        <p class="f-14 w-400 mb-0 pb-0 ms-3"><a href="<?php echo URLROOT; ?>/pages/terms" class="no-decoration f-12 w-500">Terms & Conditions</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    const urlRoot = '<?php echo URLROOT; ?>';
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.min.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/emoji.min.js"></script>

<script src="<?php echo URLROOT; ?>/public/js/app.js"></script>
</body>

</html>

<script id="chat-notification-template" type="text/template">
    <li>
        <a href="<?php echo URLROOT; ?>/chats?id={sender_id}">
            <div class="chat-notification" data-sender-id="{sender_id}">
                <div class="chat-notification-img">
                    <img src="<?php echo URLROOT; ?>/public/images/{img}" alt="">
                </div>
                <div class="chat-notification-text">
                    <div class="d-flex justify-content-between">
                        <p class="name mb-0 pb-0">{name}</p>
                        <p class="date pb-0 mb-0">
                            {time}
                        </p>
                    </div>
                    <div class="message-text">
                        <p class="mb-0 pb-0 ">
                            {message}
                        </p>
                        <div class="message-number">{total}</div>
                    </div>

                </div>
            </div>
        </a>
    </li>
</script>

<script id="group-notifications-template" type="text/template">
    <li>
        <a href="<?php echo URLROOT; ?>/groups/group/{group_id}">
            <div class="chat-notification">
                <div class="chat-notification-img">
                    <img src="<?php echo URLROOT; ?>/public/images/group.jpg" alt="">
                </div>
                <div class="chat-notification-text">
                    <div class="d-flex justify-content-between">
                        <p class="name mb-0 pb-0">{name}</p>
                        <p class="date pb-0 mb-0">
                            {time}
                        </p>
                    </div>
                    <div class="message-text">
                        <p class="mb-0 pb-0 ">
                            {comment}
                        </p>
                        <!-- <div class="message-number">15</div> -->
                    </div>

                </div>
            </div>
        </a>
    </li>
</script>

<script>
    const appURL2 = "<?php echo URLROOT; ?>";
    setInterval(function() {
        $.ajax({
            url: appURL2 + '/chats/getNewMessages',
            method: 'POST',
            success: function(response) {
                response = JSON.parse(response)
                var total = 0
                if (response.msgs.length > 0) {
                    response.msgs.forEach(msg => {
                        if ($('.chat-notification[data-sender-id="' + msg.sender_id + '"]').length) {
                            $('.chat-notification[data-sender-id="' + msg.sender_id + '"]').remove()
                        }
                        var msgTemplate = $("#chat-notification-template").html()
                        var html = msgTemplate
                            .replaceAll("{sender_id}", msg.sender_id)
                            .replace("{img}", msg.peer_img)
                            .replace("{name}", msg.peer_name)
                            .replace("{time}", chatTime(msg.timestamp))
                            .replace("{message}", msg.message)
                            .replace("{total}", msg.message_count)

                        $(".peers-heading").after(html)
                        total += parseInt(msg.message_count)

                    })
                    $(".message-number-notification").removeClass("d-none")
                    $(".message-number-notification").text(total)
                }
            }
        });
    }, 1000)

    setInterval(function() {
        $.ajax({
            url: appURL2 + '/groups/getNewComments',
            method: 'POST',
            success: function(response) {
                response = JSON.parse(response)
                var total = 0
                if (response.groups.length > 0) {
                    var groupMain = $(".group-notifications-nav")
                    groupMain.empty()
                    response.groups.forEach(group => {
                        var groupTemplate = $("#group-notifications-template").html()
                        var html = groupTemplate
                                .replaceAll("{group_id}", group.id)
                                .replace("{name}", group.name)
                                .replace("{time}", timeAgo(group.created_at != null ? group.created_at : 'none'))
                                .replace("{comment}", group.comment != null ? group.comment : "No comments yet")

                        groupMain.append(html)
                    })
                }
            }
        });
    }, 1000)
</script>