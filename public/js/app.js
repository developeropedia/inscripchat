

// ===============================================reply conversation
$("body").on("click", ".reply-btn", function(){
    if($(this).closest(".reply-text").length) {
        $(this).closest(".reply-text").find(".reply-text-container").toggleClass("reply-input");
        $(this).closest(".reply-text").find(".send-reply").toggleClass("d-none");
        var textarea = $(this).closest(".reply-text").find(".reply-textarea2")
        textarea.val("@" + $(this).data("username") + " ")
        textarea.focus();
    } else {
        $(this).closest(".comment-text").find(".reply-text-container:first").toggleClass("reply-input");
        $(this).closest(".comment-text").find(".send-reply:first").toggleClass("d-none");
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
var vid = document.getElementById("video");
function playVid() {
    vid.play();
}

function pauseVid() {
    vid.pause();
}
$(".play-btn-div").on("click", function () {
    $(this).css("display", "none");
    $(".pause-btn-div").css("display", "block");

})
$(".pause-btn-div").on("click", function () {
    $(this).css("display", "none");
    $(".play-btn-div").css("display", "block");
})


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


