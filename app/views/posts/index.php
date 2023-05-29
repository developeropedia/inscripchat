<?php

include APPROOT . "/views/inc/header.php";
include APPROOT . "/views/inc/nav.php";

$posts = $data["posts"];
$postsMain = $posts;

$imagePost = "";
if(!empty($posts)) {
    $imagePosts = array_filter($posts, function($post) {
        return $post->type === 'image';
    });

    $imagePost = current($imagePosts);

    if(!empty($imagePost)) {
        $posts = array_filter($posts, function($post) use ($imagePost) {
            return $post !== $imagePost;
        });
    }
}

?>

    <main>
        <div class="container">
            <div class="col-lg-12">
                <form class="d-flex  w-100">
                    <div class="nav-form mx-auto nav-form-sm  mt-2">
                        <input class="form-control me-2" type="text" placeholder="Search" aria-label="Search">
                        <a href="result.html" class="no-decoration"><i class="bi bi-search"></i></a>
                    </div>
                </form>
                <h1 class="text center main-heading mt-lg-4 mb-lg-3 mt-2 mb-2">
                    <?php echo $data['title']; ?>
                </h1>

            </div>
            <div class="col-lg-11 mx-auto">
                <div class="row posts">
                    <?php if(!empty($imagePost)): ?>
                        <div class="col-lg-12 mb-4 main-video-col">
                            <div class="main-img-full w-100">
                            <a href="<?php echo URLROOT; ?>/posts/post/<?php echo $imagePost->id; ?>">
                                <img src="<?php echo URLROOT; ?>/public/uploads/<?php echo $imagePost->content; ?>" alt="" class="w-100">
                            </a>
                            <div class="menu-icon">
                                    <div class="dropdown ">
                                        <button type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical text-white"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li class="text-center p-0"><a
                                                    class="dropdown-item text-center w-100 p-0">Delete</a></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex justify-content-between px-1 ">
                                <h2 class="second-heading py-1 ellipsis-1"><?php echo $imagePost->title; ?></h2>
                                <h2 class="second-heading py-1 ellipsis-1"><?php echo formatStats($imagePost->views); ?> Views</h2>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(!empty($posts)): ?>
                        <?php foreach($posts as $post): ?>
                            <div class="col-lg-4 col-md-6 col-sm-10 col-12 mx-auto mb-3 ">
                                <div class="main-img w-100">
                                    <a href="<?php echo URLROOT; ?>/posts/post/<?php echo $post->id; ?>" class="no-decoration">
                                        <img src="<?php echo URLROOT; ?>/public/uploads/<?php echo $post->type == 'pdf' ? 'adobe pdf 1.png' : $post->content; ?>" alt="" class="w-100">
                                    </a>
                                    <div class="menu-icon">
                                        <div class="dropdown ">
                                            <button type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical text-white"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                <li class="text-center p-0"><a
                                                        class="dropdown-item text-center w-100 p-0">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center px-1 mb-2 mt-2">
                                    <h2 class="f-14 w-500  ellipsis-1 pt-0 mt-0"><?php echo $post->title; ?></h2>
                                    <h2 class="f-12 w-500  pb-0 pt-0 mt-0 ellipsis-1"><?php echo formatStats($post->views); ?> Views</h2>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if(empty($postsMain)): ?>
                        <div class="text-center">No post found</div>
                    <?php endif; ?>
                </div>

            </div>

        </div>

        <div class="fixed-btns">
            <button class="mb-2 " type="button" data-bs-toggle="modal" data-bs-target="#createGroup"><img
                    src="<?php echo URLROOT; ?>/public/images/add-group.png" alt=""> Create Group</button>
            <button class="mb-2" type="button" data-bs-toggle="modal" data-bs-target="#Groups"><img
                    src="<?php echo URLROOT; ?>/public/images/group.png" alt="">Groups</button>
            <button type="button" data-bs-toggle="modal" data-bs-target="#leaveGroup"><img
                    src="<?php echo URLROOT; ?>/public/images/del-group.png" alt="">Leave Group</button>
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
    <!-- <div class="contact-icon">
        <a href="contact.html" class="no-decoration">
         <i class="bi bi-chat-dots-fill"></i>
        </a>
     </div> -->
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="bi bi-x-lg"></i></button>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="bi bi-x-lg"></i></button>
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
                                <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked"
                                    checked>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="bi bi-x-lg"></i></button>
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
                                <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked"
                                    checked>
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
                    <button type="button" class="btn px-5 successfull-btn-delete"
                        data-bs-dismiss="modal">Remove</button>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="bi bi-x-lg"></i></button>
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
                                <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked"
                                    checked>
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
                    <button type="button" class="btn px-5 " data-bs-toggle="modal" data-bs-target="#created"
                        data-bs-dismiss="modal">Create</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="created" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content ">
                <div class="d-flex justify-content-end message-popup">
                    <button type="button" class="btn-close mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"><i
                            class="bi bi-x-lg"></i></button>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="bi bi-x-lg"></i></button>
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
                                <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked"
                                    checked>
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
                    <button type="button" class="btn px-5 " data-bs-toggle="modal" data-bs-target="#no-member"
                        data-bs-dismiss="modal">Delete</button>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="bi bi-x-lg"></i></button>
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
                                <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckChecked"
                                    checked>
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
                    <button type="button" class="btn px-5 " data-bs-dismiss="modal">Leave</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="no-member" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content ">
                <div class="d-flex justify-content-end message-popup">
                    <button type="button" class="btn-close mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"><i
                            class="bi bi-x-lg"></i></button>
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

<script>
    $(document).ready(function() {
    var page = 1;
    var isLoading = false;

    // Load initial posts
    // loadPosts();

    // Scroll event listener
    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
            // Fetch more posts if not already loading
            if (!isLoading) {
                page++;
                loadPosts();
            }
        }
    });

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


    // Function to load posts via AJAX
    function loadPosts() {
        isLoading = true;
        // $('.posts').append('<p>Loading posts...</p>');

        const appURL = "<?php echo URLROOT; ?>";
        const adminID = "<?php echo ADMIN_ID; ?>";

        $.ajax({
            url: appURL + '/posts/fetch',
            method: 'POST',
            data: { action: 'fetch_posts', page: page, author_id: adminID },
            dataType: 'html',
            success: function(response) {
                // console.log(response);
                response = JSON.parse(response);

                if(response.posts) {
                    response.posts.forEach((post) => {
                        $('.posts').append(`<div class="col-lg-4 col-md-6 col-sm-10 col-12 mx-auto mb-3 ">
                                <div class="main-img w-100">
                                    <a href="${appURL}/posts/post/${post.id}" class="no-decoration">
                                        <img src="${appURL}/public/uploads/${ post.type == 'pdf' ? 'adobe pdf 1.png' : post.content }" alt="" class="w-100">
                                    </a>
                                    <div class="menu-icon">
                                        <div class="dropdown ">
                                            <button type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical text-white"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                <li class="text-center p-0"><a
                                                        class="dropdown-item text-center w-100 p-0">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center px-1 mb-2 mt-2">
                                    <h2 class="f-14 w-500  ellipsis-1 pt-0 mt-0">${ post.title }</h2>
                                    <h2 class="f-12 w-500  pb-0 pt-0 mt-0 ellipsis-1">${ formatStats(post.views) } Views</h2>
                                </div>
                            </div>`);
                    })
                }
                isLoading = false;
            },
            error: function() {
                $('.posts').append('<p>Error loading posts.</p>');
                isLoading = false;
            }
        });
    }
});

</script>