

// ===============================================reply conversation
$(".reply-btn").click(function(){
    $(".comment-input").removeClass("reply-input");
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