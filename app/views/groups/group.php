<?php

include APPROOT . "/views/inc/header.php";
include APPROOT . "/views/inc/nav.php";

$commentObj = new Comment;
$postObj = new Post;
$groupObj = new Group;

if (isset($_GET['d'])) {
    $postObj->delete($_GET['d']);
    flash("post_deleted", "Post have been deleted");

    $currentUrl = $_SERVER['REQUEST_URI'];
    $modifiedUrl = preg_replace('/[?&]d=\d+/', '', $currentUrl);
    $arr = explode("/", $modifiedUrl);

    redirect("groups/group/" . end($arr));
}

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $group_id = $_POST['group_id'];
    $error = "";

    if (!$groupObj->isGroupMember($_SESSION['user_id'], $group_id)) {
        flash("removed_from_group", "You have been removed from group", "errorMsg");
        redirect("posts");
    }

    if (!empty($_FILES['file']['name'])) {
        // Upload image or pdf less than 10mb
        $file = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png', 'pdf');
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 10000000) {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = '../public/uploads/' . $fileNameNew;
                    $fileRes = move_uploaded_file($fileTmpName, $fileDestination);

                    if (!$fileRes) {
                        echo "Error uploading file!";
                    } else {
                        $type = $fileActualExt == "pdf" ? "pdf" : "image";
                        $postObj->addPost($group_id, $title, $fileNameNew, $type);

                        redirect("groups/group/" . $group_id);
                    }
                } else {
                    $error =  "Your file is too big!";
                }
            } else {
                $error = "There was an error uploading your file!";
            }
        } else {
            $error = "You cannot upload files of this type!";
        }
    } else {
        $postObj->addPost($group_id, null, $title, "text");

        redirect("groups/group/" . $group_id);
    }
}

$group = $data["group"];
$user = $data["user"];
$posts = $data["posts"];
$peersNotInGroup = $data["peers"];
$groupPeers = $data["groupPeers"];

$lastCommentTime = '1970-01-01 12:00:00';
$lastReplyTime = '1970-01-01 12:00:00';

?>

<?php if (isset($error)) :
    if (!empty($error)) : ?>
        <div class="errorMsg" id="msg-flash">
            <i class='bi bi-x-circle-fill'></i>
            &nbsp <?php echo $error; ?>
        </div>
    <?php else : ?>
        <div class="successMsg" id="msg-flash">
            <i style='color: #00D26A' class='bi bi-check-circle-fill'></i>
            &nbsp <?php echo 'Post has been added!'; ?>
        </div>
<?php endif;
endif; ?>
<main>
    <?php echo flash("post_deleted"); ?>
    <div class="container">
        <div class="row ">
            <div class="col-lg-7 mx-auto mt-4">
                <form action="" class="postForm" method="post" enctype="multipart/form-data">
                    <div class="transcribe-box">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="dp">
                                <img src="<?php echo URLROOT; ?>/public/images/<?php echo $user->img; ?>" alt="">
                            </div>
                            <h1 class="f-20 w-500 text-grey m-0 p-0 ms-2"><?php echo $user->userName; ?></h1>
                        </div>
                        <div class="add-message w-100 mt-2">
                            <!-- <textarea name="" id="" class="w-100" rows="5" placeholder="Transcribe your thoughts"></textarea> -->
                            <textarea id="emojiarea" name="title" class="w-100" rows="5" placeholder="Transcribe your thoughts"></textarea>
                            <input type="hidden" value="<?php echo $group->id; ?>" name="group_id">
                            <div class="border mb-2"></div>
                            <div id="emojiPicker"></div>
                            <div class="d-flex justify-content-end" style="position: relative;">
                                <label for="inputTag" class="file-label d-flex justify-content-between w-100">
                                    <!-- Select Image <br/> -->
                                    <div><span id="imageName"></span></div>
                                    <img src="<?php echo URLROOT; ?>/public/images/cloud-upload.png" alt="" class="me-1 pe-0" height="20">
                                    <!-- <i style="font-size: 20px; color: #989898;" class="bi bi-cloud-arrow-up me-0 me-lg-4 pe-lg-2 pe-0"></i> -->
                                    <input id="inputTag" name="file" class="file-input" type="file" />
                                </label>
                                <div class="emoji-div" style="top:0; right: 40px;">
                                    <div class="right-arrow"></div>
                                    <div class="emoji-btn">
                                        <i id="emojiBtn" style="color: #989898; cursor: pointer;" class="bi bi-emoji-smile"></i>
                                    </div>
                                    <?php include APPROOT . "/views/inc/emojis.php" ?>
                                </div>
                            </div>

                        </div>
                        <div class="mt-3 d-flex justify-content-center">
                            <button type="submit" name="submit" class="btn px-5 add-post">Send</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-12 mt-2">
                <form class="d-flex  w-100">
                    <div class="nav-form mx-auto nav-form-sm  mt-2">
                        <input class="form-control me-2" type="text" placeholder="Search" aria-label="Search">
                        <a href="result.html" class="no-decoration"><i class="bi bi-search"></i></a>
                    </div>
                </form>
                <h1 class="text center main-heading mt-lg-4 mb-lg-3 mt-2 mb-2">
                    <?php echo $group->name; ?>
                </h1>
                <input type="hidden" id="group-id" value="<?php echo $group->id; ?>">

            </div>

            <?php if (!empty($posts)) : ?>
                <?php foreach ($posts as $key1 => $post) : ?>
                    <?php
                    $post->likes = null;
                    $post->dislikes = null;
                    $likes_dislikes = $postObj->getPostLikesDislikes($post->id);
                    if (!empty($likes_dislikes)) {
                        $post->likes = $likes_dislikes->likes;
                        $post->dislikes = $likes_dislikes->dislikes;
                    }
                    ?>
                    <?php $comments = $commentObj->getPostComments($post->id) ?>
                    <div class="col-lg-8 post  mx-auto post-no-<?php echo $post->id; ?>" data-post-id="<?php echo $post->id; ?>">
                        <div class=" main-video-col">
                            <!-- <div class="main-video-div">
                            <video controls width="100%" class="main-video" id="video">
                                <source src="<?php echo URLROOT ?>/public/images/video/Download the Best Free Nature Videos.mp4"
                                    type="video/mp4">

                            </video>
                            <div class="play-btn-div" onclick="playVid()">
                                <div class="play-btn">
                                </div>
                            </div>
                            <div class="pause-btn-div" onclick="pauseVid()">
                                <div class="pause-btn">
                                </div>
                            </div>
                        </div> -->
                            <div class="main-img-full w-100">
                                <?php if ($post->type === "image") : ?>
                                    <img src="<?php echo URLROOT; ?>/public/uploads/<?php echo $post->content; ?>" alt="" class="w-100 mb-1">
                                <?php elseif ($post->type === "pdf") : ?>
                                    <iframe src="<?php echo URLROOT; ?>/public/uploads/<?php echo $post->content; ?>" frameborder="0" width="100%" height="500px"></iframe>
                                <?php else : ?>
                                    <p style="text-align: justify; border: 1px solid #cecece" class="p-2"><?php echo $post->content; ?></p>
                                <?php endif; ?>
                                <?php if ($post->author_id == $_SESSION['user_id'] || ADMIN_ID == $_SESSION['user_id']) : ?>
                                    <div class="menu-icon">
                                        <div class="dropdown ">
                                            <button type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical text-white"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li class="text-center p-0"><a href="?d=<?php echo $post->id; ?>" class="dropdown-item text-center w-100 p-0 delete-post">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php else : ?>
                                <?php endif; ?>

                            </div>
                            <div class="d-flex justify-content-between align-items-center px-1">
                                <h2 class="second-heading py-1 ellipsis-1 mb-0 "><?php echo $post->title; ?></h2>
                                <div class="d-flex align-items-center">
                                    <!-- <h2 class="second-heading py-1 m-0 p-0 me-2"><?php echo formatStats($post->views); ?> Views</h2> -->
                                    <span class="me-2">

                                        <svg id="post-like" data-value="1" xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="<?php echo ($post->like_dislike == 1 && $post->like_dislike !== null) ? '#2F791C' : 'currentColor'; ?>" class="bi bi-hand-thumbs-up-fill thumb post-liked post-like" viewBox="0 0 16 16">
                                            <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />

                                        </svg>
                                        <small id="post-like-count" class="post-like-count"><?php echo $post->likes > 0 ? formatStats($post->likes) : ''; ?></small>
                                    </span>
                                    <span>

                                        <svg id="post-dislike" data-value="0" xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="<?php echo ($post->like_dislike == 0 && $post->like_dislike !== null) ? '#2F791C' : 'currentColor'; ?>" class="bi bi-hand-thumbs-down-fill post-disliked thumb post-dislike" viewBox="0 0 16 16">
                                            <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z" />

                                        </svg>
                                        <small id="post-dislike-count" class="post-dislike-count"><?php echo $post->dislikes > 0 ? formatStats($post->dislikes) : ''; ?></small>
                                    </span>
                                </div>
                                <input type="hidden" id="post-id" value="<?php echo $post->id; ?>">
                            </div>
                        </div>
                        <div class="mt-3 ">
                            <h1 class="f-16 w-500 text-grey">
                                <?php echo formatStats(count($comments)); ?> Conversations
                            </h1>
                            <div class="d-flex align-items-center mt-3 w-100">
                                <div class="dp"><img src="<?php echo URLROOT; ?>/public/images/<?php echo $user->img; ?>" alt="" class="img-fluid"></div>
                                <div class="comment-input w-100 ms-2">
                                    <!-- <input type="text" class="w-100" placeholder="Comment"> -->
                                    <textarea name="" class="comment-inputs" id="comment" width="100" rows="1" placeholder="Comment"></textarea>
                                    <div class="emoji-div">
                                        <div class="right-arrow"></div>
                                        <div class="emoji-btn">
                                            <i id="emojiBtn" style="color: #989898; cursor: pointer;" class="bi bi-emoji-smile emojiBtnCommentReply"></i>
                                        </div>
                                        <?php include APPROOT . "/views/inc/emojis.php" ?>
                                    </div>
                                    <i id="send-comment" data-post-id="<?php echo $post->id; ?>" class="bi bi-send-fill send-comments"></i>
                                </div>
                            </div>

                            <div class="comments-container">
                                <?php if (!empty($comments)) : ?>
                                    <?php foreach ($comments as $key2 => $comment) : ?>
                                        <?php
                                        $comment_likes_dislikes = $commentObj->getCommentLikesDislikes($comment->id);
                                        $comment_likes = $comment_likes_dislikes->likes;
                                        $comment_dislikes = $comment_likes_dislikes->dislikes;
                                        if ($comment->created_at > $lastCommentTime) {
                                            $lastCommentTime = $comment->created_at;
                                        }
                                        ?>
                                        <div class="comment-box mt-4 mb-4 comment-no-<?php echo $comment->id; ?>">
                                            <div class="comment">
                                                <div class="comment-dp">
                                                    <img src="<?php echo URLROOT; ?>/public/images/<?php echo $comment->img; ?>" alt="Profile image" class="">
                                                </div>
                                                <div class="comment-text">
                                                    <h1 class="mb-1 mt-0 pb-0 py-0"><?php echo $comment->username; ?></h1>
                                                    <p class="mb-0 pb-0"><?php echo $comment->comment; ?></p>
                                                    <div class="border mb-2"></div>
                                                    <div class="d-flex align-items-top justify-content-end">
                                                        <span class="me-2">

                                                            <svg data-value="1" data-comment-id="<?php echo $comment->id; ?>" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="<?php echo ($comment->like_dislike == 1 && $comment->like_dislike !== null) ? '#2F791C' : 'currentColor'; ?>" class="bi bi-hand-thumbs-up-fill thumb comment-like post-liked" viewBox="0 0 16 16">
                                                                <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />

                                                            </svg>
                                                            <small class="comment-like-count"><?php echo $comment_likes > 0 ? formatStats($comment_likes) : ''; ?></small>
                                                        </span>
                                                        <span>

                                                            <svg data-value="0" data-comment-id="<?php echo $comment->id; ?>" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="<?php echo ($comment->like_dislike == 0 && $comment->like_dislike !== null) ? '#2F791C' : 'currentColor'; ?>" class="bi bi-hand-thumbs-down-fill thumb comment-dislike post-disliked" viewBox="0 0 16 16">
                                                                <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z" />

                                                            </svg>
                                                            <small class="comment-dislike-count"><?php echo $comment_dislikes > 0 ? formatStats($comment_dislikes) : ''; ?></small>
                                                        </span>
                                                        <button type="button" class="f-14 text-primary w-500 ms-4 reply-btn">Reply</button>
                                                    </div>
                                                    <div class="comment-input reply-text-container w-100  reply-input">
                                                        <!-- <input type="text" class="w-100 bg-white " placeholder="Reply"> -->
                                                        <textarea id="emoji-text-p<?php echo $post->id; ?>c<?php echo $comment->id; ?>" class="bg-white reply-textarea1" width="100" rows="1" placeholder="Reply"></textarea>
                                                        <div class="emoji-div">
                                                            <div class="right-arrow"></div>
                                                            <div class="emoji-btn">
                                                                <i id="emojiBtn" style="color: #989898; cursor: pointer;" class="bi bi-emoji-smile emojiBtnCommentReply emoji-reply d-none"></i>
                                                            </div>
                                                            <?php include APPROOT . "/views/inc/emojis.php" ?>
                                                        </div>
                                                        <i data-post-id="<?php echo $post->id; ?>" data-comment-id="<?php echo $comment->id; ?>" class="bi bi-send-fill send-reply d-none"></i>
                                                    </div>
                                                    <div class="reply-box reply-box-<?php echo $comment->id; ?>">
                                                        <?php $replies = $commentObj->getCommentReplies($comment->id); ?>
                                                        <?php if (!empty($replies)) : ?>
                                                            <?php foreach ($replies as $reply) : ?>
                                                                <?php
                                                                $reply_likes_dislikes = $commentObj->getReplyLikesDislikes($reply->id);
                                                                $reply_likes = $reply_likes_dislikes->likes;
                                                                $reply_dislikes = $reply_likes_dislikes->dislikes;

                                                                if ($reply->created_at > $lastReplyTime) {
                                                                    $lastReplyTime = $reply->created_at;
                                                                }
                                                                ?>
                                                                <div class="reply mt-2 reply-no-<?php echo $comment->id; ?>">
                                                                    <div class="reply-dp">
                                                                        <img src="<?php echo URLROOT; ?>/public/images/<?php echo $reply->img; ?>" alt="Profile image" class="">
                                                                    </div>
                                                                    <div class="reply-text">
                                                                        <h1 class="mb-1 mt-0 pb-0 py-0"><?php echo $reply->username; ?></h1>
                                                                        <p class="mb-0 pb-0"><?php echo $reply->reply; ?></p>
                                                                        <div class="border mb-2"></div>
                                                                        <div class="d-flex align-items-top justify-content-end">
                                                                            <span class="me-2">

                                                                                <svg data-value="1" data-reply-id="<?php echo $reply->id; ?>" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="<?php echo ($reply->like_dislike == 1 && $reply->like_dislike !== null) ? '#2F791C' : 'currentColor'; ?>" class="bi bi-hand-thumbs-up-fill thumb reply-like post-liked" viewBox="0 0 16 16">
                                                                                    <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />

                                                                                </svg>
                                                                                <small class="reply-likes-count"><?php echo $reply_likes > 0 ? formatStats($reply_likes) : ''; ?></small>
                                                                            </span>
                                                                            <span>

                                                                                <svg data-value="0" data-reply-id="<?php echo $reply->id; ?>" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="<?php echo ($reply->like_dislike == 0 && $reply->like_dislike !== null) ? '#2F791C' : 'currentColor'; ?>" class="bi bi-hand-thumbs-down-fill thumb reply-dislike post-disliked" viewBox="0 0 16 16">
                                                                                    <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z" />

                                                                                </svg>
                                                                                <small class="reply-dislikes-count"><?php echo $reply_dislikes > 0 ? formatStats($reply_dislikes) : ''; ?></small>
                                                                            </span>
                                                                            <button type="button" data-username="<?php echo $reply->username; ?>" class="f-14 text-primary w-500 ms-4 reply-btn reply-btn-sub">Reply</button>
                                                                        </div>
                                                                        <div class="comment-input reply-text-container w-100  reply-input">
                                                                            <textarea id="emoji-text-p<?php echo $post->id; ?>c<?php echo $comment->id; ?>sub" class="bg-white reply-textarea2" width="100" rows="1" placeholder="Reply"></textarea>
                                                                            <div class="emoji-div">
                                                                                <div class="right-arrow"></div>
                                                                                <div class="emoji-btn">
                                                                                    <i id="emojiBtn" style="color: #989898; cursor: pointer;" class="bi bi-emoji-smile emojiBtnCommentReply emoji-sub-reply d-none"></i>
                                                                                </div>
                                                                                <?php include APPROOT . "/views/inc/emojis.php" ?>
                                                                            </div>
                                                                            <i data-post-id="<?php echo $post->id; ?>" data-comment-id="<?php echo $comment->id; ?>" class="bi bi-send-fill send-reply sub-reply d-none"></i>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <p class="text-center mt-3">No comments yet</p>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-center">No posts yet</p>
            <?php endif; ?>
        </div>


    </div>
    <div class="fixed-btns">
        <!-- <button class="mb-2 " type="button" data-bs-toggle="modal" data-bs-target="#createGroup"><img
                    src="<?php echo URLROOT ?>/public/images/add-group.png" alt=""> Create Group</button>
            <button class="mb-2" type="button" data-bs-toggle="modal" data-bs-target="#Groups"><img src="<?php echo URLROOT ?>/public/images/group.png"
                    alt="">Groups</button>
            <button type="button" data-bs-toggle="modal" data-bs-target="#leaveGroup"><img
                        src="<?php echo URLROOT ?>/public/images/del-group.png" alt="">Leave Group</button> -->
        <?php if ($group->owner_id == $_SESSION['user_id']) : ?>
            <button class="mb-2 " type="button" data-bs-toggle="modal" data-bs-target="#addPeer"><img src="<?php echo URLROOT ?>/public/images/user (1).png" alt="">Add Peer</button>
            <button class="mb-2" type="button" data-bs-toggle="modal" data-bs-target="#deletePeer"><img src="<?php echo URLROOT ?>/public/images/user (2).png" alt="">Remove Peer</button>
            <button type="button" data-bs-toggle="modal" data-bs-target="#deleteGroup"><img src="<?php echo URLROOT ?>/public/images/del-group.png" alt="">Delete Group</button>
        <?php else : ?>
            <button type="button" data-bs-toggle="modal" data-bs-target="#leaveGroup"><img src="<?php echo URLROOT ?>/public/images/del-group.png" alt="">Leave Group</button>
        <?php endif; ?>
    </div>
</main>
<!-- <div class="contact-icon">
        <a href="contact.html" class="no-decoration">
         <i class="bi bi-chat-dots-fill"></i>
        </a>
     </div> -->
<div class="verification-message">
    Peers have been added successfully!
</div>
<div class="verification-message-delete">
    Peers have been deleted Successfully!
</div>
<!-- Modal -->
<div class="modal fade" id="addPeer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLabel">Add peers to group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <?php if (!empty($peersNotInGroup)) : ?>
                    <?php foreach ($peersNotInGroup as $peer) : ?>
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
                    <p class="no-peer">No peers to add</p>
                <?php endif; ?>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn px-5 successfull-btn add-peer-btn">Add</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="deletePeer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLabel">Remove peers from group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <?php if (!empty($groupPeers)) : ?>
                    <?php foreach ($groupPeers as $peer) : ?>
                        <div class="chat-notification align-items-center add-peers-list delete-peers-list" data-peer-id="<?php echo $peer->id; ?>">
                            <div class="chat-notification-img">
                                <img src="<?php echo URLROOT; ?>/public/images/<?php echo $peer->img; ?>" alt="">
                            </div>
                            <div class="chat-notification-text w-100">
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
                    <p class="no-peer">No peers to remove</p>
                <?php endif; ?>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn px-5 successfull-btn-delete delete-peer-btn" data-bs-dismiss="modal">Remove</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="deleteGroup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLabel">Delete Group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this group?</p>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn px-5 delete-group-btn">Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="leaveGroup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLabel">Leave Group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to leave this group?</p>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn px-5 leave-group-btn">Leave</button>
            </div>
        </div>
    </div>
</div>

<?php

include APPROOT . "/views/inc/footer.php";

?>

<script>
    $(document).ready(function() {

        // var margin = 0,
        //     instance1 = new emojiButtonList("emojiBtn", {
        //         dropDownXAlign: "left",
        //         textBoxID: "emojiarea",
        //         yAlignMargin: margin,
        //         xAlignMargin: margin
        //     })

        // function initEmojis() {
        //     $(".emoji-reply, .emoji-sub-reply").each(function() {
        //         var btnID = $(this).attr("id");
        //         var textID = btnID.replace("btn", "text")
        //         var instance = new emojiButtonList(btnID, {
        //             dropDownXAlign: "left",
        //             textBoxID: textID,
        //             yAlignMargin: margin,
        //             xAlignMargin: margin
        //         })
        //     })
        // }
        // initEmojis();

        // $(document).on("click", ".emoji-reply, .emoji-sub-reply", function() {
        //     initEmojis()
        // });

        // ==================================upload
        let input = document.getElementById("inputTag");
        let imageName = document.getElementById("imageName")

        input.addEventListener("change", () => {
            let inputImage = document.querySelector("input[type=file]").files[0];

            imageName.innerText = inputImage.name;
        })

    });
</script>

<!-- Comment template -->
<script id="comment-template" type="text/template">
    <div class="comment-box mt-4 mb-4 comment-no-{comment_id}">
        <div class="comment">
            <div class="comment-dp">
                <img src="<?php echo URLROOT; ?>/public/images/{image}" alt="" class="">
            </div>
            <div class="comment-text">
                <h1 class="mb-1 mt-0 pb-0 py-0">{username}</h1>
                <p class="mb-0 pb-0">{comment}</p>
                <div class="border mb-2"></div>
                <div class="d-flex align-items-top justify-content-end">
                    <span class="me-2">

                        <svg data-value="1" data-comment-id="{comment_id}" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-up-fill thumb me-2 comment-like post-liked" viewBox="0 0 16 16">
                            <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"></path>

                        </svg>
                        <small class="comment-like-count"></small>
                    </span>
                    <span>

                        <svg data-value="0" data-comment-id="{comment_id}" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-down-fill thumb comment-dislike post-disliked" viewBox="0 0 16 16">
                            <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z"></path>

                        </svg>
                        <small class="comment-dislike-count"></small>
                    </span>
                    <button type="button" class="f-14 text-primary w-500 ms-4 reply-btn">Reply</button>
                </div>
                <div class="comment-input reply-text-container w-100  reply-input">
                    <!-- <input type="text" class="w-100 bg-white " placeholder="Reply"> -->
                    <textarea id="emoji-text-p{post_id}c{comment_id}" class="bg-white reply-textarea1" width="100" rows="1" placeholder="Reply"></textarea>
                    <div class="emoji-div">
                        <div class="right-arrow"></div>
                        <div class="emoji-btn">
                            <i id="emojiBtn" style="color: #989898; cursor: pointer;" class="bi bi-emoji-smile emojiBtnCommentReply emoji-reply d-none"></i>
                        </div>
                        <div class="emoji-dashboard">
                            <ul class="emojis">
                                <!-- Smile Emojis -->
                                <li class="emoji" data-emoji="1f604"><i class="em em-smile"></i></li>
                                <li class="emoji" data-emoji="1f603"><i class="em em-grinning"></i></li>
                                <li class="emoji" data-emoji="1f601"><i class="em em-grin"></i></li>
                                <li class="emoji" data-emoji="1f602"><i class="em em-joy"></i></li>
                                <li class="emoji" data-emoji="1f642"><i class="em em-slightly_smiling_face"></i></li>
                                <li class="emoji" data-emoji="1f60a"><i class="em em-smiley"></i></li>
                                <li class="emoji" data-emoji="1f60f"><i class="em em-smirk"></i></li>
                                <li class="emoji" data-emoji="1f606"><i class="em em-laughing"></i></li>
                                <li class="emoji" data-emoji="1f644"><i class="em em-face_with_rolling_eyes"></i></li>
                                <li class="emoji" data-emoji="1f60d"><i class="em em-heart_eyes"></i></li>

                                <!-- Sad Emojis -->
                                <li class="emoji" data-emoji="1f62d"><i class="em em-sob"></i></li>
                                <li class="emoji" data-emoji="1f622"><i class="em em-cry"></i></li>
                                <li class="emoji" data-emoji="1f61e"><i class="em em-disappointed"></i></li>
                                <li class="emoji" data-emoji="1f614"><i class="em em-pensive"></i></li>
                                <li class="emoji" data-emoji="1f629"><i class="em em-weary"></i></li>
                                <li class="emoji" data-emoji="1f616"><i class="em em-confounded"></i></li>
                                <li class="emoji" data-emoji="1f62b"><i class="em em-tired_face"></i></li>
                                <li class="emoji" data-emoji="1f620"><i class="em em-angry"></i></li>
                                <li class="emoji" data-emoji="1f631"><i class="em em-scream"></i></li>
                                <li class="emoji" data-emoji="1f47f"><i class="em em-imp"></i></li>

                                <!-- Love Emojis -->
                                <li class="emoji" data-emoji="2764"><i class="em em-heart"></i></li>
                                <li class="emoji" data-emoji="1f494"><i class="em em-broken_heart"></i></li>
                                <li class="emoji" data-emoji="1f48b"><i class="em em-kissing_heart"></i></li>
                                <li class="emoji" data-emoji="1f48c"><i class="em em-love_letter"></i></li>
                                <li class="emoji" data-emoji="1f496"><i class="em em-sparkling_heart"></i></li>
                                <li class="emoji" data-emoji="1f495"><i class="em em-two_hearts"></i></li>
                                <li class="emoji" data-emoji="1f49e"><i class="em em-revolving_hearts"></i></li>
                                <li class="emoji" data-emoji="1f493"><i class="em em-heartbeat"></i></li>
                                <li class="emoji" data-emoji="1f498"><i class="em em-cupid"></i></li>
                                <li class="emoji" data-emoji="1f497"><i class="em em-heartpulse"></i></li>

                                <!-- Food Emojis -->
                                <li class="emoji" data-emoji="1f355"><i class="em em-pizza"></i></li>
                                <li class="emoji" data-emoji="1f354"><i class="em em-hamburger"></i></li>
                                <li class="emoji" data-emoji="1f369"><i class="em em-doughnut"></i></li>
                                <li class="emoji" data-emoji="1f366"><i class="em em-ice_cream"></i></li>
                                <li class="emoji" data-emoji="1f353"><i class="em em-strawberry"></i></li>
                                <li class="emoji" data-emoji="1f32e"><i class="em em-taco"></i></li>
                                <li class="emoji" data-emoji="1f363"><i class="em em-sushi"></i></li>
                                <li class="emoji" data-emoji="1f32d"><i class="em em-hotdog"></i></li>
                                <li class="emoji" data-emoji="1f35f"><i class="em em-fries"></i></li>
                                <li class="emoji" data-emoji="1f382"><i class="em em-cake"></i></li>

                                <!-- Animal Emojis -->
                                <li class="emoji" data-emoji="1f436"><i class="em em-dog"></i></li>
                                <li class="emoji" data-emoji="1f431"><i class="em em-cat"></i></li>
                                <li class="emoji" data-emoji="1f430"><i class="em em-rabbit"></i></li>
                                <li class="emoji" data-emoji="1f43c"><i class="em em-panda_face"></i></li>
                                <li class="emoji" data-emoji="1f42f"><i class="em em-tiger"></i></li>
                                <li class="emoji" data-emoji="1f43b"><i class="em em-bear"></i></li>
                                <li class="emoji" data-emoji="1f418"><i class="em em-elephant"></i></li>
                                <li class="emoji" data-emoji="1f428"><i class="em em-koala"></i></li>
                                <li class="emoji" data-emoji="1f435"><i class="em em-monkey"></i></li>
                                <li class="emoji" data-emoji="1f984"><i class="em em-unicorn_face"></i></li>

                                <!-- Additional Emojis -->
                                <li class="emoji" data-emoji="2615"><i class="em em-coffee"></i></li>
                                <li class="emoji" data-emoji="1f37a"><i class="em em-beer"></i></li>
                                <li class="emoji" data-emoji="1f680"><i class="em em-rocket"></i></li>
                                <li class="emoji" data-emoji="1f525"><i class="em em-fire"></i></li>
                            </ul>

                        </div>
                    </div>
                    <i data-post-id="{post_id}" data-comment-id="{comment_id}" class="bi bi-send-fill send-reply d-none"></i>
                </div>
                <div class="reply-box reply-box-{comment_id}"></div>
            </div>
        </div>
    </div>
</script>

<!-- Reply Template -->
<script id="reply-template" type="text/template">
    <div class="reply mt-2 reply-no-{comment_id}">
        <div class="reply-dp">
            <img src="<?php echo URLROOT; ?>/public/images/{image}" alt="" class="">
        </div>
        <div class="reply-text">
            <h1 class="mb-1 mt-0 pb-0 py-0">{name}</h1>
            <p class="mb-0 pb-0">{reply}</p>
            <div class="border mb-2"></div>
            <div class="d-flex align-items-top justify-content-end">
                <span class="me-2">

                    <svg data-value="1" data-reply-id="{reply_id}" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-up-fill thumb reply-like post-liked" viewBox="0 0 16 16">
                        <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />

                    </svg>
                    <small class="reply-likes-count"></small>
                </span>
                <span>

                    <svg data-value="0" data-reply-id="{reply_id}" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-down-fill thumb reply-dislike post-disliked" viewBox="0 0 16 16">
                        <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z" />

                    </svg>
                    <small class="reply-dislikes-count"></small>
                </span>
                <button type="button" data-username="{username}" class="f-14 text-primary w-500 ms-4 reply-btn reply-btn-sub">Reply</button>
            </div>
            <div class="comment-input reply-text-container w-100  reply-input">
                <textarea id="emoji-text-p{post_id}c{comment_id}sub" class="bg-white reply-textarea2" width="100" rows="1" placeholder="Reply"></textarea>
                <div class="emoji-div">
                        <div class="right-arrow"></div>
                        <div class="emoji-btn">
                            <i id="emojiBtn" style="color: #989898; cursor: pointer;" class="bi bi-emoji-smile emojiBtnCommentReply emoji-reply d-none"></i>
                        </div>
                        <div class="emoji-dashboard">
                            <ul class="emojis">
                                <!-- Smile Emojis -->
                                <li class="emoji" data-emoji="1f604"><i class="em em-smile"></i></li>
                                <li class="emoji" data-emoji="1f603"><i class="em em-grinning"></i></li>
                                <li class="emoji" data-emoji="1f601"><i class="em em-grin"></i></li>
                                <li class="emoji" data-emoji="1f602"><i class="em em-joy"></i></li>
                                <li class="emoji" data-emoji="1f642"><i class="em em-slightly_smiling_face"></i></li>
                                <li class="emoji" data-emoji="1f60a"><i class="em em-smiley"></i></li>
                                <li class="emoji" data-emoji="1f60f"><i class="em em-smirk"></i></li>
                                <li class="emoji" data-emoji="1f606"><i class="em em-laughing"></i></li>
                                <li class="emoji" data-emoji="1f644"><i class="em em-face_with_rolling_eyes"></i></li>
                                <li class="emoji" data-emoji="1f60d"><i class="em em-heart_eyes"></i></li>

                                <!-- Sad Emojis -->
                                <li class="emoji" data-emoji="1f62d"><i class="em em-sob"></i></li>
                                <li class="emoji" data-emoji="1f622"><i class="em em-cry"></i></li>
                                <li class="emoji" data-emoji="1f61e"><i class="em em-disappointed"></i></li>
                                <li class="emoji" data-emoji="1f614"><i class="em em-pensive"></i></li>
                                <li class="emoji" data-emoji="1f629"><i class="em em-weary"></i></li>
                                <li class="emoji" data-emoji="1f616"><i class="em em-confounded"></i></li>
                                <li class="emoji" data-emoji="1f62b"><i class="em em-tired_face"></i></li>
                                <li class="emoji" data-emoji="1f620"><i class="em em-angry"></i></li>
                                <li class="emoji" data-emoji="1f631"><i class="em em-scream"></i></li>
                                <li class="emoji" data-emoji="1f47f"><i class="em em-imp"></i></li>

                                <!-- Love Emojis -->
                                <li class="emoji" data-emoji="2764"><i class="em em-heart"></i></li>
                                <li class="emoji" data-emoji="1f494"><i class="em em-broken_heart"></i></li>
                                <li class="emoji" data-emoji="1f48b"><i class="em em-kissing_heart"></i></li>
                                <li class="emoji" data-emoji="1f48c"><i class="em em-love_letter"></i></li>
                                <li class="emoji" data-emoji="1f496"><i class="em em-sparkling_heart"></i></li>
                                <li class="emoji" data-emoji="1f495"><i class="em em-two_hearts"></i></li>
                                <li class="emoji" data-emoji="1f49e"><i class="em em-revolving_hearts"></i></li>
                                <li class="emoji" data-emoji="1f493"><i class="em em-heartbeat"></i></li>
                                <li class="emoji" data-emoji="1f498"><i class="em em-cupid"></i></li>
                                <li class="emoji" data-emoji="1f497"><i class="em em-heartpulse"></i></li>

                                <!-- Food Emojis -->
                                <li class="emoji" data-emoji="1f355"><i class="em em-pizza"></i></li>
                                <li class="emoji" data-emoji="1f354"><i class="em em-hamburger"></i></li>
                                <li class="emoji" data-emoji="1f369"><i class="em em-doughnut"></i></li>
                                <li class="emoji" data-emoji="1f366"><i class="em em-ice_cream"></i></li>
                                <li class="emoji" data-emoji="1f353"><i class="em em-strawberry"></i></li>
                                <li class="emoji" data-emoji="1f32e"><i class="em em-taco"></i></li>
                                <li class="emoji" data-emoji="1f363"><i class="em em-sushi"></i></li>
                                <li class="emoji" data-emoji="1f32d"><i class="em em-hotdog"></i></li>
                                <li class="emoji" data-emoji="1f35f"><i class="em em-fries"></i></li>
                                <li class="emoji" data-emoji="1f382"><i class="em em-cake"></i></li>

                                <!-- Animal Emojis -->
                                <li class="emoji" data-emoji="1f436"><i class="em em-dog"></i></li>
                                <li class="emoji" data-emoji="1f431"><i class="em em-cat"></i></li>
                                <li class="emoji" data-emoji="1f430"><i class="em em-rabbit"></i></li>
                                <li class="emoji" data-emoji="1f43c"><i class="em em-panda_face"></i></li>
                                <li class="emoji" data-emoji="1f42f"><i class="em em-tiger"></i></li>
                                <li class="emoji" data-emoji="1f43b"><i class="em em-bear"></i></li>
                                <li class="emoji" data-emoji="1f418"><i class="em em-elephant"></i></li>
                                <li class="emoji" data-emoji="1f428"><i class="em em-koala"></i></li>
                                <li class="emoji" data-emoji="1f435"><i class="em em-monkey"></i></li>
                                <li class="emoji" data-emoji="1f984"><i class="em em-unicorn_face"></i></li>

                                <!-- Additional Emojis -->
                                <li class="emoji" data-emoji="2615"><i class="em em-coffee"></i></li>
                                <li class="emoji" data-emoji="1f37a"><i class="em em-beer"></i></li>
                                <li class="emoji" data-emoji="1f680"><i class="em em-rocket"></i></li>
                                <li class="emoji" data-emoji="1f525"><i class="em em-fire"></i></li>
                            </ul>

                        </div>
                    </div>
                <i data-post-id="{post_id}" data-comment-id="{comment_id}" class="bi bi-send-fill send-reply sub-reply d-none"></i>

            </div>
        </div>
    </div>
</script>

<script>
    const appURL = "<?php echo URLROOT; ?>";
    const groupID = $("#group-id").val();
    var lastCommentTime = "<?php echo $lastCommentTime; ?>";
    var lastReplyTime = "<?php echo $lastReplyTime; ?>";

    $("body").on("keypress", ".comment-inputs", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault()
            $(this).parent().find(".send-comments").click()
        }
    })

    // Add comment
    $("body").on("click", ".send-comments", function(event) {
        const postElement = $(this).closest(".post");
        const postID = postElement.data("post-id");
        const comment = $(this).parent().find(".comment-inputs").val();

        if (comment === "") {
            return;
        }

        $.ajax({
            url: appURL + "/comments/insert",
            method: "POST",
            data: {
                action: "add_comment",
                postID,
                comment,
                groupID
            },
            success: function(response) {
                if (response == "not_member") {
                    alert("You have been removed from group");
                    window.location.href = appURL + "/posts"
                    return;
                }
                response = JSON.parse(response);

                if (response.result !== "error") {
                    var username = response.result.username;
                    var img = response.result.img;
                    var commentID = response.result.commentID;

                    const commentTemplate = $("#comment-template").html();
                    var html = commentTemplate
                        .replace("{comment}", comment)
                        .replace("{username}", username)
                        .replace("{image}", img)
                        .replaceAll("{post_id}", postID)
                        .replaceAll("{comment_id}", commentID);
                    postElement.find(".comments-container").prepend(html);
                    postElement.find(".comment-inputs").val("");


                    const emojiDashboard = $('.emoji-dashboard');
                    const rightArrow = $('.right-arrow');
                    emojiDashboard.removeClass('emoji-display');
                    rightArrow.removeClass('emoji-display');
                } else {
                    alert("There is some error in adding comment!");
                }
            }
        });
    });

    // Add reply
    $("body").on("click", ".send-reply", function() {
        const postElement = $(this).closest(".post");
        const replyContainer = $(this).closest(".comment-text").find(".reply-box");
        const postID = postElement.data("post-id");
        const commentID = $(this).data("comment-id");
        const username = $(this).data("username");

        let replyText;
        if ($(this).hasClass("sub-reply")) {
            replyText = $(this).closest(".reply-text").find(".reply-textarea2");
        } else {
            replyText = $(this).closest(".comment-text").find(".reply-textarea1");
        }

        let reply = replyText.val();

        if (reply === "") {
            return;
        }

        var that = $(this)

        $.ajax({
            url: appURL + "/comments/reply",
            method: "POST",
            data: {
                action: "add_reply",
                postID,
                commentID,
                reply,
                groupID
            },
            success: function(response) {
                if (response == "not_member") {
                    alert("You have been removed from group");
                    window.location.href = appURL + "/posts"
                    return;
                }
                console.log(response);
                response = JSON.parse(response);

                if (response.result !== "error") {
                    var username = response.result.username;
                    var img = response.result.img;
                    var replyID = response.result.replyID;

                    const replyTemplate = $("#reply-template").html();
                    var html = replyTemplate
                        .replace("{reply}", reply)
                        .replace("{name}", username)
                        .replace("{username}", username)
                        .replace("{image}", img)
                        .replaceAll("{post_id}", postID)
                        .replaceAll("{comment_id}", commentID)
                        .replaceAll("{reply_id}", replyID);
                    replyContainer.append(html);
                    replyText.val("");

                    that.parent().toggleClass("reply-input");
                    that.closest(".reply-input").find(".send-reply").toggleClass("d-none");
                    that.closest(".reply-input").find(".emoji-reply").toggleClass("d-none");
                    that.closest(".reply-input").find(".emoji-sub-reply").toggleClass("d-none");

                    const emojiDashboard = $('.emoji-dashboard');
                    const rightArrow = $('.right-arrow');
                    emojiDashboard.removeClass('emoji-display');
                    rightArrow.removeClass('emoji-display');

                    postElement.find(".comments-container").markRegExp(/@(\w+)/g, {
                        className: "highlight"
                    });
                } else {
                    alert("There is some error in adding reply!");
                }
            }
        });
    });

    $("body").on("keypress", ".reply-textarea1", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault()
            $(this).parent().find(".send-reply").click()
        }
    })

    $("body").on("keypress", ".reply-textarea2", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault()
            $(this).parent().find(".sub-reply").click()
        }
    })

    // Post likes
    $("body").on("click", ".post-like, .post-dislike", function() {
        const postElement = $(this).closest(".post");
        const postID = postElement.data("post-id");
        const likeDislike = $(this).data("value");
        const that = $(this);

        $.ajax({
            url: appURL + "/posts/like_dislike",
            method: "post",
            data: {
                action: "like_post",
                post_id: postID,
                like_dislike: likeDislike,
                groupID
            },
            success: function(response) {
                if (response == "not_member") {
                    alert("You have been removed from group");
                    window.location.href = appURL + "/posts"
                    return;
                }
                response = JSON.parse(response);

                if (response.result) {
                    that.css("fill", "#2E751B");
                    if (that.hasClass("post-liked")) {
                        postElement.find(".post-disliked").css("fill", "currentColor");
                    } else if (that.hasClass("post-disliked")) {
                        postElement.find(".post-liked").css("fill", "currentColor");
                    }

                    postElement.find(".post-like-count").text(formatStats(response.likes));
                    postElement.find(".post-dislike-count").text(formatStats(response.dislikes));
                }
            }
        });
    });

    // Comment likes
    $("body").on("click", ".comment-like, .comment-dislike", function() {
        const commentElement = $(this).closest(".comment-text");
        const commentID = $(this).data("comment-id");
        const likeDislike = $(this).data("value");
        const that = $(this);

        $.ajax({
            url: appURL + "/comments/like_dislike",
            method: "post",
            data: {
                action: "like_comment",
                commentID,
                like_dislike: likeDislike,
                groupID
            },
            success: function(response) {
                if (response == "not_member") {
                    alert("You have been removed from group");
                    window.location.href = appURL + "/posts"
                    return;
                }
                response = JSON.parse(response);

                if (response.result) {
                    that.css("fill", "#2E751B");
                    if (that.hasClass("post-liked")) {
                        commentElement.find(".post-disliked").css("fill", "currentColor");
                    } else if (that.hasClass("post-disliked")) {
                        commentElement.find(".post-liked").css("fill", "currentColor");
                    }

                    commentElement.find(".comment-like-count").text(formatStats(response.likes));
                    commentElement.find(".comment-dislike-count").text(formatStats(response.dislikes));
                }
            }
        });
    });

    // Reply likes
    $("body").on("click", ".reply-like, .reply-dislike", function() {
        const replyElement = $(this).closest(".reply-text");
        const replyID = $(this).data("reply-id");
        const likeDislike = $(this).data("value");
        const that = $(this);

        $.ajax({
            url: appURL + "/comments/reply_like_dislike",
            method: "post",
            data: {
                action: "like_reply",
                replyID,
                like_dislike: likeDislike,
                groupID
            },
            success: function(response) {
                if (response == "not_member") {
                    alert("You have been removed from group");
                    window.location.href = appURL + "/posts"
                    return;
                }
                response = JSON.parse(response);

                if (response.result) {
                    that.css("fill", "#2E751B");
                    if (that.hasClass("post-liked")) {
                        replyElement.find(".post-disliked").css("fill", "currentColor");
                    } else if (that.hasClass("post-disliked")) {
                        replyElement.find(".post-liked").css("fill", "currentColor");
                    }

                    replyElement.find(".reply-likes-count").text(formatStats(response.likes));
                    replyElement.find(".reply-dislikes-count").text(formatStats(response.dislikes));
                }
            }
        });
    });

    // Mark usernames
    $(".comments-container").markRegExp(/@(\w+)/g, {
        className: "highlight"
    });

    // Add post
    // $(".add-post").click(function(e) {
    //     e.preventDefault();

    //     if ($("#emojiarea").val() == "") {
    //         alert("Please enter title")
    //         return;
    //     }

    //     if ($("#inputTag").val() == "") {
    //         alert("Please choose an image or a pdf")
    //         return;
    //     }

    //     $(".postForm").submit()
    // })
</script>

<script>
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
            url: appURL + "/groups/addPeers",
            method: "POST",
            data: {
                action: "add_peers",
                peerIDs,
                groupID
            },
            success: function(response) {
                if (response) {
                    var addedPeers = $("#addPeer .add-peers-list:has(:checkbox:checked)").map(function() {
                        // Uncheck the checkbox
                        $(this).find(':checkbox').prop('checked', false);
                        return this;
                    }).get();

                    $("#addPeer .add-peers-list:has(:checkbox:checked)").remove();

                    console.log(addedPeers);

                    // Append the removed peers to another list
                    if ($("#deletePeer .no-peer").length) {
                        $("#deletePeer .modal-body").empty()
                    }
                    // if ($("#createGroup .no-peer").length) {
                    //     $("#createGroup .no-peer").remove()
                    // }
                    $("#deletePeer .modal-body").append(addedPeers);
                    // $("#createGroup .modal-body").append(addedPeers)

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

    // Delete Peers
    $(".delete-peer-btn").click(function() {
        if ($("#deletePeer").find(".no-peer").length) {
            $(".verification-message-delete").text("No peers to delete")
            $("#deletePeer").modal("hide")
            return;
        }

        const peerIDs = $("#deletePeer .delete-peers-list:has(:checkbox:checked)").map(function() {
            return $(this).data("peer-id");
        }).get();

        if (!$("#deletePeer").find(".no-peer").length && !peerIDs.length) {
            $(".verification-message-delete").text("No peers selected to delete")
            $("#deletePeer").modal("hide")
            return;
        }

        $.ajax({
            url: appURL + "/groups/deletePeers",
            method: "POST",
            data: {
                action: "delete_peers",
                peerIDs,
                groupID
            },
            success: function(response) {
                console.log(response);
                if (response) {
                    var removedPeers = $("#deletePeer .delete-peers-list:has(:checkbox:checked)").map(function() {
                        // Uncheck the checkbox
                        $(this).find(':checkbox').prop('checked', false);
                        return this;
                    }).get();

                    $("#deletePeer .delete-peers-list:has(:checkbox:checked)").remove();

                    // Append the removed peers to another list
                    if ($("#addPeer .no-peer").length) {
                        $("#addPeer .modal-body").empty()
                    }
                    $("#addPeer .modal-body").append(removedPeers);

                    // $("#createGroup .group-peers-list").filter(function() {
                    //     var peerId = $(this).data("peer-id");
                    //     console.log(peerIDs);

                    //     return removedPeers.some(function(removedPeer) {
                    //         return $(removedPeer).data("peer-id") === peerId;
                    //     });
                    // }).remove();

                    $("#deletePeer").modal("hide")
                    $(".verification-message-delete").text("Peers have been deleted successfully!");

                    if (!$("#deletePeer .delete-peers-list").length) {
                        $("#deletePeer .modal-body").append('<p class="no-peer">No peers to delete</p>')
                    }
                } else {
                    $("#deletePeer").modal("hide")
                    $(".verification-message").text("Error removing peers!");
                }
            }
        })
    })

    // Delete group
    $(".delete-group-btn").click(function() {
        $.ajax({
            url: appURL + "/groups/deleteGroup",
            method: "POST",
            data: {
                action: "delete_group",
                groupID
            },
            success: function(response) {
                if (!response) {
                    alert("There is some error please try again");
                } else {
                    $("#deleteGroup").modal("hide")
                    window.location.href = appURL + "/posts"
                }
            }
        })
    })

    // Leave group
    $(".leave-group-btn").click(function() {
        $.ajax({
            url: appURL + "/groups/leaveGroup",
            method: "POST",
            data: {
                action: "leave_group",
                groupID
            },
            success: function(response) {
                if (!response) {
                    alert("There is some error please try again");
                } else {
                    $("#leaveGroup").modal("hide")
                    window.location.href = appURL + "/posts"
                }
            }
        })
    })

    // Check new comments
    setInterval(function() {
        $.ajax({
            url: appURL + "/comments/checkNewComments",
            method: "POST",
            data: {
                action: "check_new_comments",
                groupID,
                lastCommentTime
            },
            success: function(response) {
                // console.log(response);
                response = JSON.parse(response)
                if (response.result) {
                    response.comments.forEach(comment => {
                        if (comment.created_at > lastCommentTime) {
                            lastCommentTime = comment.created_at;
                        }
                        // console.log(comment);
                        // return;

                        var postElement = $(".post-no-" + comment.postID);

                        var username = comment.username;
                        var img = comment.img;
                        var commentID = comment.id;

                        const commentTemplate = $("#comment-template").html();
                        var html = commentTemplate
                            .replace("{comment}", comment.comment)
                            .replace("{username}", comment.username)
                            .replace("{image}", comment.img)
                            .replaceAll("{post_id}", comment.postID)
                            .replaceAll("{comment_id}", commentID);
                        postElement.find(".comments-container").prepend(html);
                        postElement.find(".comment-inputs").val("");


                        const emojiDashboard = $('.emoji-dashboard');
                        const rightArrow = $('.right-arrow');
                        emojiDashboard.removeClass('emoji-display');
                        rightArrow.removeClass('emoji-display');
                    })
                }
            }
        })
    }, 1000);

    // Check new replies
    var replyIds = []
    setInterval(function() {
        $.ajax({
            url: appURL + "/comments/checkNewReplies",
            method: "POST",
            data: {
                action: "check_new_replies",
                groupID,
                lastReplyTime
            },
            success: function(response) {
                // console.log(response);
                response = JSON.parse(response)
                if (response.result) {
                    console.log(response.replies.length);
                    response.replies.forEach(reply => {
                        if (replyIds.includes(reply.id)) {
                            return;
                        } else {
                            replyIds.push(reply.id)
                        }
                        if (reply.created_at > lastReplyTime) {
                            lastReplyTime = reply.created_at;
                        }
                        // console.log(reply);
                        // return;

                        var postElement = $(".post-no-" + reply.postID);
                        var replyBox = postElement.find(".reply-box-" + reply.commentID);

                        var username = reply.username;
                        var img = reply.img;
                        var replyID = reply.id;

                        const replyTemplate = $("#reply-template").html();
                        var html = replyTemplate
                            .replace("{reply}", reply.reply)
                            .replace("{name}", reply.username)
                            .replace("{username}", reply.username)
                            .replace("{image}", reply.img)
                            .replaceAll("{post_id}", reply.postID)
                            .replaceAll("{comment_id}", reply.commentID)
                            .replaceAll("{reply_id}", reply.id);
                        replyBox.append(html);


                        const emojiDashboard = $('.emoji-dashboard');
                        const rightArrow = $('.right-arrow');
                        emojiDashboard.removeClass('emoji-display');
                        rightArrow.removeClass('emoji-display');

                        postElement.find(".comments-container").markRegExp(/@(\w+)/g, {
                            className: "highlight"
                        });
                    })
                }
            }
        })
    }, 1000);
</script>