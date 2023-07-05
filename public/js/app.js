

// ===============================================reply conversation
$("body").on("click", ".reply-btn", function(){
    if($(this).closest(".reply-text").length) {
        $(this).closest(".reply-text").find(".reply-text-container").toggleClass("reply-input");
        $(this).closest(".reply-text").find(".send-reply").toggleClass("d-none");
        $(this).closest(".reply-text").find(".emoji-reply").toggleClass("d-none");
        if($(this).hasClass("reply-btn-sub")) {
            $(this).closest(".reply-text").find(".emoji-sub-reply").toggleClass("d-none");
        }
        var textarea = $(this).closest(".reply-text").find(".reply-textarea2")
        textarea.val("@" + $(this).data("username") + " ")
        textarea.focus();
    } else {
        $(this).closest(".comment-text").find(".reply-text-container:first").toggleClass("reply-input");
        $(this).closest(".comment-text").find(".send-reply:first").toggleClass("d-none");
        $(this).closest(".comment-text").find(".emoji-reply:first").toggleClass("d-none");
        if ($(this).hasClass("reply-btn-sub")) {
            $(this).closest(".comment-text").find(".emoji-sub-reply:first").toggleClass("d-none");
        }
    }
  });
 
// ==============================================messages notificatiob popups
$(".successfull-btn").click(function () {
    $(".verification-message").css("display", "block");
    setTimeout(function () {
        $(".verification-message").css("display", "none");
    }, 2000);
});
$(".successfull-btn-delete").click(function () {
    $(".verification-message-delete").css("display", "block");
    setTimeout(function () {
        $(".verification-message-delete").css("display", "none");
    }, 2000);
});
$(".successfull-btn-left").click(function () {
    $(".verification-message-left").css("display", "block");
    setTimeout(function () {
        $(".verification-message-left").css("display", "none");
    }, 2000);
});

// ====================================video play/pause
$(document).on("click", ".play-btn-div, .play-btn-div2", function() {
    $(this).css("display", "none")
    var vidMain = $(this).parents(".main-video-div")
    vidMain.find(".pause-btn-div").css("display", "block")
    vidMain.find(".pause-btn-div2").css("display", "block")
    vidMain.find("video")[0].play()
})

$(document).on("click", ".pause-btn-div, .pause-btn-div2", function () {
    $(this).css("display", "none")
    var vidMain = $(this).parents(".main-video-div")
    vidMain.find(".play-btn-div").css("display", "block")
    vidMain.find(".play-btn-div2").css("display", "block")
    vidMain.find("video")[0].pause()
})

// var vid = document.getElementById("video");
// function playVid() {
//     vid.play();
// }

// function pauseVid() {
//     vid.pause();
// }
// $(".play-btn-div").on("click", function () {
//     $(this).css("display", "none");
//     $(".pause-btn-div").css("display", "block");

// })
// $(".pause-btn-div").on("click", function () {
//     $(this).css("display", "none");
//     $(".play-btn-div").css("display", "block");
// })


// var vid = document.getElementById("video2");
// function playVid2() {
//     vid.play();
// }

// function pauseVid2() {
//     vid.pause();
// }
// $(".play-btn-div2").on("click", function () {
//     $(this).css("display", "none");
//     $(".pause-btn-div2").css("display", "block");

// })
// $(".pause-btn-div2").on("click", function () {
//     $(this).css("display", "none");
//     $(".play-btn-div2").css("display", "block");
// })

function formatStats(views) {
    if (views >= 1000 && views < 1000000) {
        return (views / 1000).toFixed(1) + 'K';
    } else if (views >= 1000000 && views < 1000000000) {
        return (views / 1000000).toFixed(1) + 'M';
    } else if (views >= 1000000000) {
        return (views / 1000000000).toFixed(1) + 'B';
    } else {
        return views;
    }
}

$(document).ready(function() {
    // Scroll chat-box to bottom
    if($("#chat-box").length) {
        $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);
    }
    
})

$(".search-input").keypress(function(e) {
    if(e.which == 13) {
        $(".search-btn").click()
    }
})

$(".search-btn").click(function(e) {
    e.preventDefault();

    var q = $(".search-input").val()
    if(q === "") {
        return;
    }

    q = q.replace(/\s+/g, "*");
    window.location.href = urlRoot + "/posts/search/" + q;
})

$(".group-name").keypress(function(e) {
    if (e.which == 13) {
        e.preventDefault()
        $(".create-group-btn").click()
    }
})

// Show total notifications
$(document).ready(function() {
    var total = $("#total-unread-msgs").val();
    if(total > 0) {
        $(".message-number-notification").removeClass("d-none")
        $(".message-number-notification").text(total)
    }
})

$(document).on("click", ".emoji-btn", function (event) {
    event.stopPropagation();
    $(this).next('.emoji-dashboard').toggleClass("emoji-display");
    $(this).prev('.right-arrow').toggleClass("emoji-display");
})

$(document).on('click', function (event) {
    const emojiDashboard = $('.emoji-dashboard');
    const rightArrow = $('.right-arrow');

    // Check if the clicked element is outside the emoji dashboard
    if (!emojiDashboard.has(event.target).length && !$(event.target).hasClass('emoji-btn')) {
        // Remove the .emoji-display class
        emojiDashboard.removeClass('emoji-display');
        rightArrow.removeClass('emoji-display');
    }
});


$(document).ready(function () {
    // Event handler for emoji click
    $(document).on('click', '.emojis li', function () {
        if (!$(this).closest(".transcribe-box").length) {
            // Get the emoji code point
            var emojiCodePoint = $(this).data('emoji');
            console.log(emojiCodePoint);

            // Convert code point to actual emoji character
            var emojiCharacter = String.fromCodePoint(parseInt(emojiCodePoint, 16));

            // Insert emoji into textarea at current cursor position
            var textarea = $(this).closest(".comment-input").find("textarea")[0]
            var startPos = textarea.selectionStart;
            var endPos = textarea.selectionEnd;
            var text = textarea.value;
            var emoji = emojiCharacter;
            textarea.value = text.substring(0, startPos) + emoji + text.substring(endPos);

            // Set cursor position after the inserted emoji
            var newCursorPos = startPos + emoji.length;
            textarea.setSelectionRange(newCursorPos, newCursorPos);
            textarea.focus();
        } else {
            // Get the emoji code point
            var emojiCodePoint = $(this).data('emoji');
            console.log(emojiCodePoint);

            // Convert code point to actual emoji character
            var emojiCharacter = String.fromCodePoint(parseInt(emojiCodePoint, 16));

            // Insert emoji into textarea at current cursor position
            var textarea = $(this).closest(".transcribe-box").find("textarea")[0]
            var startPos = textarea.selectionStart;
            var endPos = textarea.selectionEnd;
            var text = textarea.value;
            var emoji = emojiCharacter;
            textarea.value = text.substring(0, startPos) + emoji + text.substring(endPos);

            // Set cursor position after the inserted emoji
            var newCursorPos = startPos + emoji.length;
            textarea.setSelectionRange(newCursorPos, newCursorPos);
            textarea.focus();
        }
    });
});

