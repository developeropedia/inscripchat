<?php

include APPROOT . "/views/inc/header.php";
include APPROOT . "/views/inc/nav.php";

$posts = $data["posts"];
$postMain = $data["post"];
$comments = $data["comments"];
$groups = $data["groups"];
$peers = $data["peers"];
$user = $data["user"];

$commentObj = new Comment;

?>

<main>
    <div class="container">
        <div class="row ">
            <div class="col-lg-3 mt-4 order-last order-lg-first">
                <div class="row">
                    <?php if (!empty($posts)) : ?>
                        <?php foreach ($posts as $post) :
                            if ($post->id === $postMain->id || $post->type == "text") continue;
                        ?>
                            <div class="col-lg-12 col-md-6 col-sm-8 mx-auto col-12">
                                <div>
                                    <?php if ($post->type == "video") : ?>
                                        <div class="main-video-div">
                                            <video controls width="100%" class="main-video" id="video2">
                                                <source src="<?php echo URLROOT; ?>/public/uploads/<?php echo $post->content; ?>" type="video/mp4">

                                            </video>
                                            <?php if ($post->author_id == $_SESSION['user_id']) : ?>
                                                <div class="menu-icon">
                                                    <div class="dropdown ">
                                                        <button type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-three-dots-vertical text-white"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                            <li class="text-center p-0"><a href="<?php echo URLROOT; ?>/posts/delete/<?php echo $post->id; ?>" class="dropdown-item text-center w-100 p-0">Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                            <?php endif; ?>
                                            <div class="play-btn-div2">
                                                <div class="play-btn2">
                                                </div>
                                            </div>
                                            <div class="pause-btn-div2">
                                                <div class="pause-btn2">
                                                </div>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="main-img-sm w-100">
                                            <a href="<?php echo URLROOT; ?>/posts/post/<?php echo $post->id; ?>" class="no-decoration">
                                                <img src="<?php echo URLROOT; ?>/public/uploads/<?php echo $post->type == 'pdf' ? 'adobe pdf 1.png' : $post->content; ?>" alt="" class="w-100">
                                            </a>
                                            <?php if ($post->author_id == $_SESSION['user_id']) : ?>
                                                <div class="menu-icon">
                                                    <div class="dropdown ">
                                                        <button type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-three-dots-vertical text-white"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                            <li class="text-center p-0"><a href="<?php echo URLROOT; ?>/posts/delete/<?php echo $post->id; ?>" class="dropdown-item text-center w-100 p-0">Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <a href="<?php echo URLROOT; ?>/posts/post/<?php echo $post->id; ?>" class="no-decoration post-link">
                                        <div class="d-flex justify-content-between align-items-center px-1 mb-2 mt-2">
                                            <h2 class="f-14 w-500  ellipsis-1 pt-0 mt-0"><?php echo $post->title; ?></h2>
                                            <h2 class="f-12 w-500  pb-0 pt-0 mt-0 ellipsis-1"><?php echo formatStats($post->views); ?> Views</h2>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-8 mt-4 ms-auto order-first order-lg-last">
                <?php if (!empty($postMain)) : ?>
                    <div class=" main-video-col">
                        <?php if ($postMain->type == "video") : ?>
                            <div class="main-video-div">
                                <video controls width="100%" class="main-video" id="video">
                                    <source src="<?php echo URLROOT; ?>/public/uploads/<?php echo $postMain->content; ?>" type="video/mp4">

                                </video>
                                <?php if ($postMain->author_id == $_SESSION['user_id']) : ?>
                                    <div class="menu-icon">
                                        <div class="dropdown ">
                                            <button type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical text-white"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li class="text-center p-0"><a href="<?php echo URLROOT; ?>/posts/delete/<?php echo $postMain->id; ?>" class="dropdown-item text-center w-100 p-0">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php else : ?>
                                <?php endif; ?>
                                <div class="play-btn-div">
                                    <div class="play-btn">
                                    </div>
                                </div>
                                <div class="pause-btn-div">
                                    <div class="pause-btn">
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="main-img-full w-100">
                                <?php if ($postMain->type === "image") : ?>
                                    <img src="<?php echo URLROOT; ?>/public/uploads/<?php echo $postMain->content; ?>" alt="" class="w-100 mb-1">
                                <?php else : ?>
                                    <iframe src="<?php echo URLROOT; ?>/public/uploads/<?php echo $postMain->content; ?>#toolbar=0&navpanes=0" frameborder="0" width="100%" height="500px"></iframe>
                                <?php endif; ?>
                                <?php if ($postMain->author_id == $_SESSION['user_id']) : ?>
                                    <div class="menu-icon">
                                        <div class="dropdown ">
                                            <button type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical text-white"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li class="text-center p-0"><a href="<?php echo URLROOT; ?>/posts/delete/<?php echo $postMain->id; ?>" class="dropdown-item text-center w-100 p-0">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php else : ?>
                                <?php endif; ?>

                            </div>
                        <?php endif; ?>
                        <div class="d-flex justify-content-between align-items-center px-1 flex-wrap">
                            <div>
                                <h2 class="second-heading py-1 ellipsis-1 mb-0 "><?php echo $postMain->title; ?> </h2>
                            </div>
                            <div class="d-flex align-items-center">
                                <h2 class="second-heading py-1 m-0 p-0 me-2"><?php echo formatStats($postMain->views); ?> Views</h2>
                                <span class="me-2">

                                    <svg id="post-like" data-value="1" xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="<?php echo ($postMain->like_dislike == 1 && $postMain->like_dislike !== null) ? '#2F791C' : 'currentColor'; ?>" class="bi bi-hand-thumbs-up-fill thumb post-liked" viewBox="0 0 16 16">
                                        <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />

                                    </svg>
                                    <small id="post-like-count"><?php echo $postMain->likes > 0 ? formatStats($postMain->likes) : ''; ?></small>
                                </span>
                                <span>

                                    <svg id="post-dislike" data-value="0" xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="<?php echo ($postMain->like_dislike == 0 && $postMain->like_dislike !== null) ? '#2F791C' : 'currentColor'; ?>" class="bi bi-hand-thumbs-down-fill post-disliked thumb" viewBox="0 0 16 16">
                                        <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z" />

                                    </svg>
                                    <small id="post-dislike-count"><?php echo $postMain->dislikes > 0 ? formatStats($postMain->dislikes) : ''; ?></small>
                                </span>
                            </div>
                            <input type="hidden" id="post-id" value="<?php echo $postMain->id; ?>">
                        </div>
                    </div>
                <?php endif; ?>
                <div class="mt-3 ">
                    <h1 class="f-16 w-500 text-grey">
                        <?php echo formatStats(count($comments)); ?> Conversations
                    </h1>
                    <div class="d-flex align-items-center mt-3 w-100">
                        <div class="dp"><img src="<?php echo URLROOT; ?>/public/images/<?php echo $user->img; ?>" alt="" class="img-fluid"></div>
                        <div class="comment-input w-100 ms-2">
                            <!-- <input type="text" class="w-100" placeholder="Comment"> -->
                            <textarea name="" id="comment" width="100" rows="1" placeholder="Comment"></textarea>
                            <i id="emojiBtn" style="color: #989898; cursor: pointer;" class="bi bi-emoji-smile emojiBtnCommentReply"></i>
                            <i id="send-comment" data-post-id="<?php echo $postMain->id; ?>" class="bi bi-send-fill"></i>
                        </div>
                    </div>

                    <div class="comments-container">
                        <?php if (!empty($comments)) : ?>
                            <?php foreach ($comments as $comment) : ?>
                                <?php
                                $comment_likes_dislikes = $commentObj->getCommentLikesDislikes($comment->id);
                                $comment_likes = $comment_likes_dislikes->likes;
                                $comment_dislikes = $comment_likes_dislikes->dislikes;
                                ?>
                                <div class="comment-box mt-4 mb-4">
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
                                                <textarea id="emoji-text-p<?php echo $postMain->id; ?>c<?php echo $comment->id; ?>" class="bg-white reply-textarea1" width="100" rows="1" placeholder="Reply"></textarea>
                                                <i id="emoji-btn-p<?php echo $postMain->id; ?>c<?php echo $comment->id; ?>" style="color: #989898; cursor: pointer;" class="bi bi-emoji-smile emojiBtnCommentReply emoji-reply d-none"></i>
                                                <i data-post-id="<?php echo $postMain->id; ?>" data-comment-id="<?php echo $comment->id; ?>" class="bi bi-send-fill send-reply d-none"></i>
                                            </div>
                                            <div class="reply-box">
                                                <?php $replies = $commentObj->getCommentReplies($comment->id); ?>
                                                <?php if (!empty($replies)) : ?>
                                                    <?php foreach ($replies as $reply) : ?>
                                                        <?php
                                                        $reply_likes_dislikes = $commentObj->getReplyLikesDislikes($reply->id);
                                                        $reply_likes = $reply_likes_dislikes->likes;
                                                        $reply_dislikes = $reply_likes_dislikes->dislikes;
                                                        ?>
                                                        <div class="reply mt-2">
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
                                                                    <textarea id="emoji-text-p<?php echo $postMain->id; ?>c<?php echo $comment->id; ?>sub" class="bg-white reply-textarea2" width="100" rows="1" placeholder="Reply"></textarea>
                                                                    <i id="emoji-btn-p<?php echo $postMain->id; ?>c<?php echo $comment->id; ?>sub" style="color: #989898; cursor: pointer;" class="bi bi-emoji-smile emojiBtnCommentReply emoji-sub-reply d-none"></i>
                                                                    <i data-post-id="<?php echo $postMain->id; ?>" data-comment-id="<?php echo $comment->id; ?>" class="bi bi-send-fill send-reply sub-reply d-none"></i>

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
                            <p class="text-center mt-3 no-comments">No comments yet</p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

        </div>


    </div>
    <div class="fixed-btns">
        <button class="mb-2 " type="button" data-bs-toggle="modal" data-bs-target="#createGroup"><img src="<?php echo URLROOT; ?>/public/images/add-group.png" alt=""> Create Group</button>
        <button class="mb-2" type="button" data-bs-toggle="modal" data-bs-target="#Groups"><img src="<?php echo URLROOT; ?>/public/images/group.png" alt="">Groups</button>
    </div>
</main>
<div class="verification-message">
    Peers have been added Successfully!
</div>
<div class="verification-message-delete">
    Peers have been deleted Successfully!
</div>
<!-- Modal -->
<div class="modal fade" id="Groups" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLabel">All Groups</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <?php if (!empty($groups)) : ?>
                    <?php foreach ($groups as $group) : ?>
                        <a href="<?php echo URLROOT . '/groups/group/' . $group->id; ?>" class="no-decoration">
                            <div class="chat-notification mb-2">
                                <div class="chat-notification-img">
                                    <img src="<?php echo URLROOT; ?>/public/images/group.jpg" alt="">
                                </div>
                                <div class="chat-notification-text  " style="width: 82%;">
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
                                        <!-- <div class="message-number ms-2">15</div> -->
                                    </div>

                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p class="text-center">No groups</p>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="createGroup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLabel">Create New Group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <form class="d-flex  w-100">
                    <div class="nav-form mx-auto">
                        <input class="form-control mb-3 group-name" type="text" placeholder="Write Group Name">
                    </div>
                </form>
                <p class="text-center second-heading">Add Peers to Your Group</p>
                <?php if (!empty($peers)) : ?>
                    <?php foreach ($peers as $peer) : ?>
                        <div class="chat-notification align-items-center group-peers-list" data-peer-id="<?php echo $peer->peerID; ?>">
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
                    <p class="no-peer">You don't have added any peer</p>
                <?php endif; ?>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn px-5 create-group-btn">Create</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="createdGroup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="d-flex justify-content-end message-popup">
                <button type="button" class="btn-close mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <p class="verification-group text-center second-heading mb-0 pb-0">Group has been created and will only be available
                    online for a month you can renew it 3 days before
                    it disappears.</p>

            </div>

        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="no-member" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="d-flex justify-content-end message-popup">
                <button type="button" class="btn-close mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <p class="text-center second-heading mb-0 pb-0">You don't have any peers to create a group
                    add at least 1 peer to create a group</p>

            </div>

        </div>
    </div>
</div>

<?php

include APPROOT . "/views/inc/footer.php";

?>

<!-- Comment template -->
<script id="comment-template" type="text/template">
    <div class="comment-box mt-4 mb-4">
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
                    <i id="emoji-btn-p{post_id}c{comment_id}" style="color: #989898; cursor: pointer;" class="bi bi-emoji-smile emojiBtnCommentReply emoji-reply d-none"></i>
                    <i data-post-id="{post_id}" data-comment-id="{comment_id}" class="bi bi-send-fill send-reply d-none"></i>
                </div>
                <div class="reply-box"></div>
            </div>
        </div>
    </div>
</script>

<!-- Reply Template -->
<script id="reply-template" type="text/template">
    <div class="reply mt-2">
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
                <i id="emoji-btn-p{post_id}c{comment_id}sub" style="color: #989898; cursor: pointer;" class="bi bi-emoji-smile emojiBtnCommentReply emoji-sub-reply d-none"></i>
                <i data-post-id="{post_id}" data-comment-id="{comment_id}" class="bi bi-send-fill send-reply sub-reply d-none"></i>

            </div>
        </div>
    </div>
</script>

<script id="group-template" type="text/template">
    <a href="{group_link}" class="no-decoration">
        <div class="chat-notification mb-2">
            <div class="chat-notification-img">
                <img src="<?php echo URLROOT; ?>/public/images/group.jpg" alt="">
            </div>
            <div class="chat-notification-text  " style="width: 82%;">
                <div class="d-flex justify-content-between">
                    <p class="name mb-0 pb-0">{group_name}</p>
                    <p class="date pb-0 mb-0">
                        No comments yet
                    </p>
                </div>
                <div class="message-text">
                    <p class="mb-0 pb-0 ">
                    <!-- <div class="message-number ms-2">15</div> -->
                </div>

            </div>
        </div>
    </a>
</script>

<script>
    $(document).ready(function() {

        var margin = 0,
            instance1 = new emojiButtonList("emojiBtn", {
                dropDownXAlign: "left",
                textBoxID: "comment",
                yAlignMargin: margin,
                xAlignMargin: margin
            })

        function initEmojis() {
            $(".emoji-reply, .emoji-sub-reply").each(function() {
                var btnID = $(this).attr("id");
                var textID = btnID.replace("btn", "text")
                var instance = new emojiButtonList(btnID, {
                    dropDownXAlign: "left",
                    textBoxID: textID,
                    yAlignMargin: margin,
                    xAlignMargin: margin
                })
            })
        }
        initEmojis();

        $(document).on("click", ".emoji-reply, .emoji-sub-reply", function() {
            initEmojis()
        }); 

        // ==================================upload
        // let input = document.getElementById("inputTag");
        // let imageName = document.getElementById("imageName")

        // input.addEventListener("change", () => {
        //     let inputImage = document.querySelector("input[type=file]").files[0];

        //     imageName.innerText = inputImage.name;
        // })

    });
</script>

<script>
    var post_id = $("#post-id").val();
    const appURL = "<?php echo URLROOT; ?>";

    $("#comment").keypress(function(event) {

        if (event.keyCode === 13) {
            event.preventDefault()
            $("#send-comment").click()
        }
    })

    $("body").on("click", "#send-comment", function() {
        const postID = $(this).data("post-id");
        const comment = $("#comment").val();

        if (comment === "") {
            return 0;
        }

        const commentTemplate = $("#comment-template").html();

        $.ajax({
            url: appURL + "/comments/insert",
            method: "POST",
            data: {
                action: "add_comment",
                postID,
                comment
            },
            success: function(response) {
                console.log(response);
                response = JSON.parse(response)

                if (response.result !== "error") {
                    var username = response.result.username
                    var img = response.result.img
                    var commentID = response.result.commentID
                    var html = commentTemplate
                        .replace("{comment}", comment)
                        .replace("{username}", username)
                        .replace("{image}", img)
                        .replaceAll("{post_id}", postID)
                        .replaceAll("{comment_id}", commentID)
                    $(".comments-container").prepend(html)
                    $("#comment").val("")
                    $(".no-comments").remove()

                    var btnID = `emoji-btn-p${postID}c${commentID}`
                    var textID = btnID.replace("btn", "text")
                    var instance = new emojiButtonList(btnID, {
                        dropDownXAlign: "left",
                        textBoxID: textID,
                        yAlignMargin: 0,
                        xAlignMargin: 0
                    })
                } else {
                    alert("There is some error in adding comment!")
                }
            }
        })
    })

    // Add Reply
    $("body").on("click", ".send-reply", function() {
        const replyMain = $(this).closest(".comment-text");

        const postID = $(this).data("post-id");
        const commentID = $(this).data("comment-id");
        const username = $(this).data("username");

        let replyText;
        if ($(this).hasClass("sub-reply")) {
            replyText = $(this).closest(".reply-text").find(".reply-textarea2");
        } else {
            replyText = replyMain.find(".reply-textarea1");
        }

        let reply = replyText.val()

        if (reply === "") {
            return 0;
        }

        const replyTemplate = $("#reply-template").html();
        const that = $(this);

        $.ajax({
            url: appURL + "/comments/reply",
            method: "POST",
            data: {
                action: "add_reply",
                postID,
                commentID,
                reply
            },
            success: function(response) {
                console.log(response);
                response = JSON.parse(response)

                if (response.result !== "error") {
                    var username = response.result.username
                    var img = response.result.img
                    var replyID = response.result.replyID
                    var html = replyTemplate
                        .replace("{reply}", reply)
                        .replace("{name}", username)
                        .replace("{username}", username)
                        .replace("{image}", img)
                        .replaceAll("{post_id}", postID)
                        .replaceAll("{comment_id}", commentID)
                        .replaceAll("{reply_id}", replyID)
                    replyMain.find(".reply-box").append(html)
                    replyText.val("");

                    that.parent().toggleClass("reply-input");
                    that.closest(".reply-input").find(".send-reply").toggleClass("d-none");
                    that.closest(".reply-input").find(".emoji-reply").toggleClass("d-none");
                    that.closest(".reply-input").find(".emoji-sub-reply").toggleClass("d-none");

                    var btnID = `emoji-btn-p${postID}c${commentID}sub`
                    var textID = btnID.replace("btn", "text")
                    var instance = new emojiButtonList(btnID, {
                        dropDownXAlign: "left",
                        textBoxID: textID,
                        yAlignMargin: 0,
                        xAlignMargin: 0
                    })

                    $(".comments-container").markRegExp(/@(\w+)/g, {
                        className: "highlight"
                    });
                } else {
                    alert("There is some error in adding reply!")
                }
            }
        })
    })

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

    // Mark usernames
    $(".comments-container").markRegExp(/@(\w+)/g, {
        className: "highlight"
    });

    // Post likes
    $("#post-like, #post-dislike").click(function() {
        var like_dislike = $(this).data("value");
        var that = $(this);

        $.ajax({
            url: appURL + "/posts/like_dislike",
            method: "post",
            data: {
                action: "like_post",
                post_id,
                like_dislike
            },
            success: function(response) {
                response = JSON.parse(response);

                if (response.result) {
                    that.css("fill", "#2E751B")
                    if (that.hasClass("post-liked")) {
                        $("#post-dislike").css("fill", "currentColor")
                    } else if (that.hasClass("post-disliked")) {
                        $("#post-like").css("fill", "currentColor")
                    }

                    $("#post-like-count").text(formatStats(response.likes))
                    $("#post-dislike-count").text(formatStats(response.dislikes))
                }
            }
        })
    })

    // Comment likes
    $("body").on("click", ".comment-like, .comment-dislike", function() {
        var like_dislike = $(this).data("value");
        var that = $(this);
        var commentID = $(this).data("comment-id")

        $.ajax({
            url: appURL + "/comments/like_dislike",
            method: "post",
            data: {
                action: "like_comment",
                commentID,
                like_dislike
            },
            success: function(response) {
                console.log(response);
                response = JSON.parse(response);

                if (response.result) {
                    that.css("fill", "#2E751B")
                    if (that.hasClass("post-liked")) {
                        that.closest(".comment-text").find(".post-disliked").css("fill", "currentColor")
                    } else if (that.hasClass("post-disliked")) {
                        that.closest(".comment-text").find(".post-liked").css("fill", "currentColor")
                    }

                    that.closest(".comment-text").find(".comment-like-count").text(formatStats(response.likes))
                    that.closest(".comment-text").find(".comment-dislike-count").text(formatStats(response.dislikes))
                }
            }
        })
    })

    // Reply likes
    $("body").on("click", ".reply-like, .reply-dislike", function() {
        var like_dislike = $(this).data("value");
        var that = $(this);
        var replyID = $(this).data("reply-id")

        $.ajax({
            url: appURL + "/comments/reply_like_dislike",
            method: "post",
            data: {
                action: "like_reply",
                replyID,
                like_dislike
            },
            success: function(response) {
                console.log(response);
                response = JSON.parse(response);

                if (response.result) {
                    that.css("fill", "#2E751B")
                    if (that.hasClass("post-liked")) {
                        that.closest(".reply-text").find(".post-disliked").css("fill", "currentColor")
                    } else if (that.hasClass("post-disliked")) {
                        that.closest(".reply-text").find(".post-liked").css("fill", "currentColor")
                    }

                    that.closest(".reply-text").find(".reply-likes-count").text(formatStats(response.likes))
                    that.closest(".reply-text").find(".reply-dislikes-count").text(formatStats(response.dislikes))
                }
            }
        })
    })

    // Create group
    $(".create-group-btn").click(function() {
        var groupName = $("#createGroup .group-name").val();
        if (groupName === "") {
            alert("Please enter group name")
            return;
        }
        var groupPeers = $("#createGroup .group-peers-list:has(:checkbox:checked)").map(function() {
            return $(this).data("peer-id");
        }).get();

        if (!groupPeers.length) {
            alert("No peers to add")
            return;
        }

        console.log(groupPeers);

        $.ajax({
            url: appURL + "/groups/create",
            type: "POST",
            data: {
                groupName: groupName,
                peers: groupPeers
            },
            success: function(response) {
                console.log(response);
                response = JSON.parse(response)
                if (response.error) {
                    $("#createGroup").modal("hide")
                    // $(".verification-group").text("Error creating group!");
                    // $("#createdGroup").modal("show");
                } else {
                    $("#createGroup").modal("hide")
                    $("#createGroup .group-name").val("");
                    $("#createGroup .group-peers-list:has(:checkbox:checked)").find(":checkbox").prop("checked", false);
                    $("#createdGroup").modal("show");

                    // Append group to groups list
                    var groupTemplate = $("#group-template").html();
                    groupTemplate = groupTemplate
                        .replace("{group_link}", appURL + "/groups/group/" + response.group_id)
                        .replace("{group_name}", response.group_name)
                    $("#Groups .modal-body").append(groupTemplate)
                }
            }
        })
    })
</script>