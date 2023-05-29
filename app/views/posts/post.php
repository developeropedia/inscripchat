<?php

include APPROOT . "/views/inc/header.php";
include APPROOT . "/views/inc/nav.php";

$posts = $data["posts"];
$postMain = $data["post"];
$comments = $data["comments"];

$commentObj = new Comment;

?>

<main>
    <div class="container">
        <div class="row ">
            <div class="col-lg-3 mt-4 order-last order-lg-first">
                <div class="row">
                    <?php if (!empty($posts)) : ?>
                        <?php foreach ($posts as $post) : ?>
                            <div class="col-lg-12 col-md-6 col-sm-8 mx-auto col-12">
                                <div>
                                    <div class="main-img-sm w-100">
                                        <a href="<?php echo URLROOT; ?>/posts/post/<?php echo $post->id; ?>" class="no-decoration">
                                            <img src="<?php echo URLROOT; ?>/public/uploads/<?php echo $post->type == 'pdf' ? 'adobe pdf 1.png' : $post->content; ?>" alt="" class="w-100">
                                        </a>
                                        <div class="menu-icon">
                                            <div class="dropdown ">
                                                <button type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical text-white"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                    <li class="text-center p-0"><a class="dropdown-item text-center w-100 p-0">Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center px-1 mb-2 mt-2">
                                        <h2 class="f-14 w-500  ellipsis-1 pt-0 mt-0"><?php echo $post->title; ?> </h2>
                                        <h2 class="f-12 w-500 ellipsis-1  pb-0 pt-0 mt-0"><?php echo formatStats($post->views); ?> Views</h2>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-8 mt-4 ms-auto order-first order-lg-last">
                <?php if (!empty($postMain)) : ?>
                    <div class=" main-video-col">
                        <div class="main-img-full w-100">
                            <?php if ($postMain->type === "image") : ?>
                                <img src="<?php echo URLROOT; ?>/public/uploads/<?php echo $postMain->content; ?>" alt="" class="w-100">
                            <?php else : ?>
                                <iframe src="<?php echo URLROOT; ?>/public/uploads/<?php echo $postMain->content; ?>" frameborder="0" width="100%" height="500px"></iframe>
                            <?php endif; ?>
                            <div class="menu-icon">
                                <div class="dropdown ">
                                    <button type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical text-white"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li class="text-center p-0"><a class="dropdown-item text-center w-100 p-0">Delete</a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <div class="d-flex justify-content-between align-items-center px-1 flex-wrap">
                            <div>
                                <h2 class="second-heading py-1 ellipsis-1 mb-0 "><?php echo $postMain->title; ?> </h2>
                            </div>
                            <div class="d-flex align-items-center">
                                <h2 class="second-heading py-1 m-0 p-0 me-2"><?php echo formatStats($postMain->views); ?> Views</h2>
                                <span>

                                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-hand-thumbs-up-fill thumb me-1" viewBox="0 0 16 16">
                                        <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />

                                    </svg></span>
                                <span>

                                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-hand-thumbs-down-fill thumb" viewBox="0 0 16 16">
                                        <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z" />

                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="mt-3 ">
                    <h1 class="f-16 w-500 text-grey">
                        <?php echo formatStats(count($comments)); ?> Conversations
                    </h1>
                    <div class="d-flex align-items-center mt-3 w-100">
                        <div class="dp"><img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="" class="img-fluid"></div>
                        <div class="comment-input w-100 ms-2">
                            <!-- <input type="text" class="w-100" placeholder="Comment"> -->
                            <textarea name="" id="comment" width="100" rows="1" placeholder="Comment"></textarea>
                            <i id="send-comment" data-post-id="<?php echo $postMain->id; ?>" class="bi bi-send-fill"></i>
                        </div>
                    </div>

                    <div class="comments-container">
                        <?php if (!empty($comments)) : ?>
                            <?php foreach ($comments as $comment) : ?>
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
                                                <span>

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-up-fill thumb me-2" viewBox="0 0 16 16">
                                                        <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />

                                                    </svg></span>
                                                <span>

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-down-fill thumb" viewBox="0 0 16 16">
                                                        <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z" />

                                                    </svg>
                                                </span>
                                                <button type="button" class="f-14 text-primary w-500 ms-4 reply-btn">Reply</button>
                                            </div>
                                            <div class="comment-input reply-text-container w-100  reply-input">
                                                <!-- <input type="text" class="w-100 bg-white " placeholder="Reply"> -->
                                                <textarea class="bg-white reply-text" width="100" rows="1" placeholder="Reply"></textarea>
                                                <i data-post-id="<?php echo $postMain->id; ?>" data-comment-id="<?php echo $comment->id; ?>" class="bi bi-send-fill send-reply d-none"></i>
                                            </div>
                                            <div class="reply-box">
                                                <?php $replies = $commentObj->getCommentReplies($comment->id); ?>
                                                <?php if (!empty($replies)) : ?>
                                                    <?php foreach ($replies as $reply) : ?>
                                                        <div class="reply mt-2">
                                                            <div class="reply-dp">
                                                                <img src="<?php echo URLROOT; ?>/public/images/<?php echo $reply->img; ?>" alt="Profile image" class="">
                                                            </div>
                                                            <div class="reply-text">
                                                                <h1 class="mb-1 mt-0 pb-0 py-0"><?php echo $reply->username; ?></h1>
                                                                <p class="mb-0 pb-0"><?php echo $reply->reply; ?></p>
                                                                <div class="border mb-2"></div>
                                                                <div class="d-flex align-items-top justify-content-end">
                                                                    <span>

                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-up-fill thumb me-2" viewBox="0 0 16 16">
                                                                            <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />

                                                                        </svg></span>
                                                                    <span>

                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-down-fill thumb" viewBox="0 0 16 16">
                                                                            <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z" />

                                                                        </svg>
                                                                    </span>
                                                                    <button type="button" class="f-14 text-primary w-500 ms-4 reply-btn">Reply</button>
                                                                </div>
                                                                <div class="comment-input reply-text-container w-100  reply-input">
                                                                    <textarea class="bg-white reply-text" width="100" rows="1" placeholder="Reply"></textarea>
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
                        <?php endif; ?>


                        <div class="comment-box mt-4 mb-4">
                            <div class="comment">
                                <div class="comment-dp">
                                    <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="" class="">
                                </div>
                                <div class="comment-text">
                                    <h1 class="mb-1 mt-0 pb-0 py-0">Jhon Leo</h1>
                                    <p class="mb-0 pb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                        Aliquid voluptate alias maxime ducimus autem?</p>
                                    <div class="border mb-2"></div>
                                    <div class="d-flex align-items-top justify-content-end">
                                        <span>

                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-up-fill thumb me-2" viewBox="0 0 16 16">
                                                <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />

                                            </svg></span>
                                        <span>

                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-down-fill thumb" viewBox="0 0 16 16">
                                                <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z" />

                                            </svg>
                                        </span>
                                        <button type="button" class="f-14 text-primary w-500 ms-4 reply-btn">Reply</button>
                                    </div>
                                    <div class="comment-input w-100  reply-input">
                                        <textarea name="" class="bg-white" id="" width="100" rows="1" placeholder="Reply"></textarea>

                                    </div>
                                    <div class="reply-box">
                                        <div class="reply mt-2">
                                            <div class="reply-dp">
                                                <img src="/public/images/image 1.png" alt="" class="">
                                            </div>
                                            <div class="reply-text">
                                                <h1 class="mb-1 mt-0 pb-0 py-0">Jhon Leo</h1>
                                                <p class="mb-0 pb-0">Lorem ipsum dolor sit amet consectetur adipisicing
                                                    elit. Aliquid voluptate alias maxime ducimus autem?</p>
                                                <div class="border mb-2"></div>
                                                <div class="d-flex align-items-top justify-content-end">
                                                    <span>

                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-up-fill thumb me-2" viewBox="0 0 16 16">
                                                            <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />

                                                        </svg></span>
                                                    <span>

                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-down-fill thumb" viewBox="0 0 16 16">
                                                            <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z" />

                                                        </svg>
                                                    </span>
                                                    <button type="button" class="f-14 text-primary w-500 ms-4 reply-btn">Reply</button>
                                                </div>
                                                <div class="comment-input w-100  reply-input">
                                                    <textarea name="" class="bg-white" id="" width="100" rows="1" placeholder="Reply"></textarea>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="comment-box mt-4 mb-4">
                            <div class="comment">
                                <div class="comment-dp">
                                    <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="" class="">
                                </div>
                                <div class="comment-text">
                                    <h1 class="mb-1 mt-0 pb-0 py-0">Jhon Leo</h1>
                                    <p class="mb-0 pb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                        Aliquid voluptate alias maxime ducimus autem?</p>
                                    <div class="border mb-2"></div>
                                    <div class="d-flex align-items-top justify-content-end">
                                        <span>

                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-up-fill thumb me-2" viewBox="0 0 16 16">
                                                <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />

                                            </svg></span>
                                        <span>

                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-down-fill thumb" viewBox="0 0 16 16">
                                                <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z" />

                                            </svg>
                                        </span>
                                        <button type="button" class="f-14 text-primary w-500 ms-4 reply-btn">Reply</button>
                                    </div>
                                    <div class="comment-input w-100  reply-input">
                                        <textarea name="" class="bg-white" id="" width="100" rows="1" placeholder="Reply"></textarea>

                                    </div>
                                    <div class="reply-box">

                                        <div class="reply mt-2">
                                            <div class="reply-dp">
                                                <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="" class="">
                                            </div>
                                            <div class="reply-text">
                                                <h1 class="mb-1 mt-0 pb-0 py-0">Jhon Leo</h1>
                                                <p class="mb-0 pb-0">Lorem ipsum dolor sit amet consectetur adipisicing
                                                    elit. Aliquid voluptate alias maxime ducimus autem?</p>
                                                <div class="border mb-2"></div>
                                                <div class="d-flex align-items-top justify-content-end">
                                                    <span>

                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-up-fill thumb me-2" viewBox="0 0 16 16">
                                                            <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />

                                                        </svg></span>
                                                    <span>

                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-down-fill thumb" viewBox="0 0 16 16">
                                                            <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z" />

                                                        </svg>
                                                    </span>
                                                    <button type="button" class="f-14 text-primary w-500 ms-4 reply-btn">Reply</button>
                                                </div>
                                                <div class="comment-input w-100  reply-input">
                                                    <textarea name="" class="bg-white" id="" width="100" rows="1" placeholder="Reply"></textarea>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

            </div>

        </div>


    </div>
    <div class="fixed-btns">
        <button class="mb-2 " type="button" data-bs-toggle="modal" data-bs-target="#createGroup"><img src="<?php echo URLROOT; ?>/public/images/add-group.png" alt=""> Create Group</button>
        <button class="mb-2" type="button" data-bs-toggle="modal" data-bs-target="#Groups"><img src="<?php echo URLROOT; ?>/public/images/group.png" alt="">Groups</button>
        <button type="button" data-bs-toggle="modal" data-bs-target="#leaveGroup"><img src="<?php echo URLROOT; ?>/public/images/del-group.png" alt="">Leave Group</button>
        <!-- <button class="mb-2 " type="button" data-bs-toggle="modal" data-bs-target="#addPeer"><img
                    src="<?php echo URLROOT; ?>/public/images/user (1).png" alt="">Add Peer</button>
            <button class="mb-2" type="button" data-bs-toggle="modal" data-bs-target="#deletePeer"><img
                    src="<?php echo URLROOT; ?>/public/images/user (2).png" alt="">Remove Peer</button>
            <button class="mb-2 " type="button" data-bs-toggle="modal" data-bs-target="#createGroup"><img
                    src="<?php echo URLROOT; ?>/public/images/add-group.png" alt=""> Create Group</button>
            <button type="button" data-bs-toggle="modal" data-bs-target="#deleteGroup"><img
                    src="<?php echo URLROOT; ?>/public/images/del-group.png" alt="">Delete Group</button> -->
    </div>
</main>
<div class="contact-icon">
    <a href="contact.html" class="no-decoration">
        <i class="bi bi-chat-dots-fill"></i>
    </a>
</div>
<div class="verification-message">
    Peers have been added Successfully!
</div>
<div class="verification-message-delete">
    Peers have been deleted Successfully!
</div>
<div class="verification-message-left">
    You Left Nature Beauty Group!
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
                <a href="" class="no-decoration">
                    <div class="chat-notification mb-2">
                        <div class="chat-notification-img">
                            <img src="<?php echo URLROOT; ?>/public/images/group.jpg" alt="">
                        </div>
                        <div class="chat-notification-text  " style="width: 82%;">
                            <div class="d-flex justify-content-between">
                                <p class="name mb-0 pb-0">The Incredibles</p>
                                <p class="date pb-0 mb-0">10 Sec</p>
                            </div>
                            <div class="message-text">
                                <p class="mb-0 pb-0 ">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit
                                    itaque at asperiores, et odio deserunt facere doloremque
                                    recusandae tempore repudiandae?</p>
                                <div class="message-number ms-2">15</div>
                            </div>

                        </div>
                    </div>
                </a>
                <a href="" class="no-decoration">
                    <div class="chat-notification mb-2">
                        <div class="chat-notification-img">
                            <img src="<?php echo URLROOT; ?>/public/images/group.jpg" alt="">
                        </div>
                        <div class="chat-notification-text  " style="width: 82%;">
                            <div class="d-flex justify-content-between">
                                <p class="name mb-0 pb-0">The Incredibles</p>
                                <p class="date pb-0 mb-0">10 Sec</p>
                            </div>
                            <div class="message-text">
                                <p class="mb-0 pb-0 ">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit
                                    itaque at asperiores, et odio deserunt facere doloremque
                                    recusandae tempore repudiandae?</p>
                                <div class="message-number ms-2">15</div>
                            </div>

                        </div>
                    </div>
                </a>
                <a href="" class="no-decoration">
                    <div class="chat-notification mb-2">
                        <div class="chat-notification-img">
                            <img src="<?php echo URLROOT; ?>/public/images/group.jpg" alt="">
                        </div>
                        <div class="chat-notification-text  " style="width: 82%;">
                            <div class="d-flex justify-content-between">
                                <p class="name mb-0 pb-0">The Incredibles</p>
                                <p class="date pb-0 mb-0">10 Sec</p>
                            </div>
                            <div class="message-text">
                                <p class="mb-0 pb-0 ">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit
                                    itaque at asperiores, et odio deserunt facere doloremque
                                    recusandae tempore repudiandae?</p>
                                <div class="message-number ms-2">15</div>
                            </div>

                        </div>
                    </div>
                </a>
                <a href="" class="no-decoration">
                    <div class="chat-notification mb-2">
                        <div class="chat-notification-img">
                            <img src="<?php echo URLROOT; ?>/public/images/group.jpg" alt="">
                        </div>
                        <div class="chat-notification-text  " style="width: 82%;">
                            <div class="d-flex justify-content-between">
                                <p class="name mb-0 pb-0">The Incredibles</p>
                                <p class="date pb-0 mb-0">10 Sec</p>
                            </div>
                            <div class="message-text">
                                <p class="mb-0 pb-0 ">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit
                                    itaque at asperiores, et odio deserunt facere doloremque
                                    recusandae tempore repudiandae?</p>
                            </div>

                        </div>
                    </div>
                </a>



            </div>

        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addPeer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLabel">Add Peers You Are Familiar With</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <div class="chat-notification align-items-center ">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text bg-dange w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked" checked>
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label second-heading  " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn px-5 successfull-btn" data-bs-dismiss="modal">Add</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="deletePeer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLabel">Remove Peer or Peers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked" checked>
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label second-heading  " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn px-5 successfull-btn-delete" data-bs-dismiss="modal">Remove</button>
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
                        <input class="form-control mb-3" type="text" placeholder="Write Group Name">
                    </div>
                </form>
                <p class="text-center second-heading">Add Peers to Your Group</p>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked" checked>
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label second-heading  " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn px-5 " data-bs-toggle="modal" data-bs-target="#created" data-bs-dismiss="modal">Create</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="created" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="d-flex justify-content-end message-popup">
                <button type="button" class="btn-close mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <p class="text-center second-heading mb-0 pb-0">Group has been created and will only be available
                    online for a month you can renew it 3 days before
                    it disappears.</p>

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
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked" checked>
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn px-5 " data-bs-toggle="modal" data-bs-target="#no-member" data-bs-dismiss="modal">Delete</button>
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
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked" checked>
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="chat-notification align-items-center">
                    <div class="chat-notification-img">
                        <img src="<?php echo URLROOT; ?>/public/images/image 1.png" alt="">
                    </div>
                    <div class="chat-notification-text w-100">
                        <div class="ms-1 ps-0 d-flex justify-content-between form-check w-100">
                            <label class="form-check-label f-18 w-500 " for="flexCheckChecked">
                                Lissa Expoy
                            </label>
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn px-5 " data-bs-toggle="modal" data-bs-target="#group-left" data-bs-dismiss="modal">Leave</button>
            </div>
        </div>
    </div>
</div>
<!-- -----------------------------Group left================ -->
<div class="modal fade" id="group-left" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="d-flex justify-content-end message-popup">
                <button type="button" class="btn-close mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <p class="text-center second-heading mb-0 pb-0">You Have Left The Nature Beauty!</p>

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
                    <span>

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-up-fill thumb me-2" viewBox="0 0 16 16">
                            <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"></path>

                        </svg></span>
                    <span>

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-down-fill thumb" viewBox="0 0 16 16">
                            <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z"></path>

                        </svg>
                    </span>
                    <button type="button" class="f-14 text-primary w-500 ms-4 reply-btn">Reply</button>
                </div>
                <div class="comment-input reply-text-container w-100  reply-input">
                    <!-- <input type="text" class="w-100 bg-white " placeholder="Reply"> -->
                    <textarea class="bg-white reply-text" width="100" rows="1" placeholder="Reply"></textarea>
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
                <span>

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-up-fill thumb me-2" viewBox="0 0 16 16">
                        <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />

                    </svg></span>
                <span>

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-down-fill thumb" viewBox="0 0 16 16">
                        <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z" />

                    </svg>
                </span>
                <button type="button" class="f-14 text-primary w-500 ms-4 reply-btn">Reply</button>
            </div>
            <div class="comment-input w-100  reply-input">
                <textarea name="" class="bg-white" id="" width="100" rows="1" placeholder="Reply"></textarea>

            </div>
        </div>
    </div>
</script>

<script>
    $("#comment").keypress(function(event) {

        if (event.keyCode === 13) {
            event.preventDefault()
            $("#send-comment").click()
        }
    })

    const appURL = "<?php echo URLROOT; ?>";

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
                        .replace("{post_id}", postID)
                        .replace("{comment_id}", commentID)
                    $(".comments-container").prepend(html)
                    $("#comment").val("")
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

        let reply;
        if ($(this).hasClass("sub-reply")) {
            reply = $(this).closest(".reply-text").find(".reply-text").val();
        } else {
            reply = replyMain.find(".reply-text").val();
        }

        if (reply === "") {
            return 0;
        }

        const replyTemplate = $("#reply-template").html();

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
                    var html = replyTemplate
                        .replace("{reply}", reply)
                        .replace("{name}", username)
                        .replace("{image}", img)
                    replyMain.find(".reply-box").prepend(html)
                    replyMain.find(".reply-text").val("");
                } else {
                    alert("There is some error in adding reply!")
                }
            }
        })
    })

    $("body").on("keypress", ".reply-text", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault()
            $(this).parent().find(".send-reply").click()
        }
    })
</script>