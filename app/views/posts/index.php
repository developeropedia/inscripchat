<?php

include APPROOT . "/views/inc/header.php";
include APPROOT . "/views/inc/nav.php";

$posts = $data["posts"];
$familiarPeers = $data["familiar_peers"];
$peers = $data["peers"];
$groups = $data["groups"];
$postsMain = $posts;

// $imagePost = "";
// if (!empty($posts)) {
//     $imagePosts = array_filter($posts, function ($post) {
//         return $post->type === 'image';
//     });

//     $imagePost = current($imagePosts);

//     if (!empty($imagePost)) {
//         $posts = array_filter($posts, function ($post) use ($imagePost) {
//             return $post !== $imagePost;
//         });
//     }
// }

?>

<main>
    <?php echo flash("group_deleted"); ?>
    <?php echo flash("group_left"); ?>
    <?php echo flash("post_added"); ?>
    <?php echo flash("removed_from_group", "", "errorMsg"); ?>
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
                <?php if (!empty($posts)) : ?>
                    <div class="col-lg-12 mb-4 main-video-col">
                        <?php if ($posts[0]->type == "video") : ?>
                            <div class="main-video-div">
                                <video controls width="100%" class="main-video" id="video">
                                    <source src="<?php echo URLROOT; ?>/public/uploads/<?php echo $posts[0]->content; ?>" type="video/mp4">

                                </video>
                                <?php if ($posts[0]->author_id == $_SESSION['user_id']) : ?>
                                    <div class="menu-icon">
                                        <div class="dropdown ">
                                            <button type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical text-white"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li class="text-center p-0"><a href="<?php echo URLROOT; ?>/posts/delete/<?php echo $posts[0]->id; ?>" class="dropdown-item text-center w-100 p-0">Delete</a></li>
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
                                <a href="<?php echo URLROOT; ?>/posts/post/<?php echo $posts[0]->id; ?>">
                                    <?php if ($posts[0]->type === "image") : ?>
                                        <img src="<?php echo URLROOT; ?>/public/uploads/<?php echo $posts[0]->content; ?>" alt="" class="w-100 mb-1">
                                    <?php else : ?>
                                        <iframe src="<?php echo URLROOT; ?>/public/uploads/<?php echo $posts[0]->content; ?>#toolbar=0&navpanes=0" frameborder="0" width="100%" height="500px"></iframe>
                                    <?php endif; ?>
                                </a>
                                <?php if ($posts[0]->author_id == $_SESSION['user_id']) : ?>
                                    <div class="menu-icon">
                                        <div class="dropdown ">
                                            <button type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical text-white"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li class="text-center p-0"><a href="<?php echo URLROOT; ?>/posts/delete/<?php echo $posts[0]->id; ?>" class="dropdown-item text-center w-100 p-0">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php else : ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <a class="no-decoration" href="<?php echo URLROOT; ?>/posts/post/<?php echo $posts[0]->id; ?>">
                            <div class="d-flex justify-content-between px-1 ">
                                <h2 class="second-heading py-1 ellipsis-1"><?php echo $posts[0]->title; ?></h2>
                                <h2 class="second-heading py-1 ellipsis-1"><?php echo formatStats($posts[0]->views); ?> Views</h2>
                            </div>
                        </a>
                    </div>
                    <?php unset($posts[0]) ?>
                <?php endif; ?>
                <?php if (!empty($posts)) : ?>
                    <?php foreach ($posts as $post) : ?>
                        <div class="col-lg-4 col-md-6 col-sm-10 col-12 mx-auto mb-3 ">
                            <?php if ($post->type == "video") : ?>
                                <div class="main-video-div main-video2 d-flex justify-content-center align-items-center">
                                    <video controls width="100%" class="" id="video2">
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
                                <div class="<?php echo $post->type == 'pdf' ? 'doc-img' : 'main-img'; ?> w-100">
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
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if (empty($postsMain)) : ?>
                    <div class="text-center">No post found</div>
                <?php endif; ?>
            </div>

        </div>

    </div>

    <div class="fixed-btns">
        <button class="mb-2 " type="button" data-bs-toggle="modal" data-bs-target="#createGroup"><img src="<?php echo URLROOT; ?>/public/images/add-group.png" alt=""> Create Group</button>
        <button class="mb-2" type="button" data-bs-toggle="modal" data-bs-target="#Groups"><img src="<?php echo URLROOT; ?>/public/images/group.png" alt="">Groups</button>
        <!-- <button type="button" data-bs-toggle="modal" data-bs-target="#leaveGroup"><img src="<?php echo URLROOT; ?>/public/images/del-group.png" alt="">Leave Group</button> -->
        <button class="mb-2 " type="button" data-bs-toggle="modal" data-bs-target="#addPeer"><img src="<?php echo URLROOT; ?>/public/images/user (1).png" alt="">Add Peer</button>
        <button class="mb-2" type="button" data-bs-toggle="modal" data-bs-target="#deletePeer"><img src="<?php echo URLROOT; ?>/public/images/user (2).png" alt="">Remove Peer</button>
        <!-- <button class="mb-2 " type="button" data-bs-toggle="modal" data-bs-target="#createGroup"><img
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
    Peers have been added successfully!
</div>
<div class="verification-message-delete">
    Peers have been deleted successfully!
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
<div class="modal fade" id="addPeer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLabel">Add peers you are familiar with</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <?php if (!empty($familiarPeers)) : ?>
                    <?php foreach ($familiarPeers as $peer) : ?>
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
                    <p class="no-peer">No peers match with your institution</p>
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
                <h5 class="modal-title text-center" id="exampleModalLabel">Remove peers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <?php if (!empty($peers)) : ?>
                    <?php foreach ($peers as $peer) : ?>
                        <div class="chat-notification align-items-center add-peers-list delete-peers-list" data-peer-id="<?php echo $peer->peerID; ?>">
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
                    <p class="no-peer">No peers added</p>
                <?php endif; ?>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn px-5 successfull-btn-delete delete-peer-btn" data-bs-dismiss="modal">Remove</button>
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
                    <p class="no-peer">You don't have any peers to add to the Group</p>
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
        var page = 1;
        var isLoading = false;
        const appURL = "<?php echo URLROOT; ?>";
        const adminID = "<?php echo ADMIN_ID; ?>";
        const currentUserID = "<?php echo $_SESSION['user_id']; ?>";

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


        // Function to load posts via AJAX
        function loadPosts() {
            isLoading = true;
            // $('.posts').append('<p class="loading-posts">Loading posts...</p>');

            $.ajax({
                url: appURL + '/posts/fetch',
                method: 'POST',
                data: {
                    action: 'fetch_posts',
                    page: page,
                    author_id: adminID
                },
                dataType: 'html',
                success: function(response) {
                    // console.log(response);
                    response = JSON.parse(response);
                    // $(".posts .loading-posts").remove()

                    if (response.posts) {
                        response.posts.forEach((post) => {

                            var postTemplate = `<div class="col-lg-4 col-md-6 col-sm-10 col-12 mx-auto mb-3 ">
                                <div class="main-img w-100">
                                    <a href="${appURL}/posts/post/${post.id}" class="no-decoration">
                                        <img src="${appURL}/public/uploads/${ post.type == 'pdf' ? 'adobe pdf 1.png' : post.content }" alt="" class="w-100">
                                    </a>`

                            if (post.author_id == currentUserID) {
                                postTemplate += `<div class="menu-icon">
                                        <div class="dropdown ">
                                            <button type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical text-white"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                <li class="text-center p-0"><a  href="${appURL}/posts/delete/${post.id}"
                                                        class="dropdown-item text-center w-100 p-0">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>`
                            }

                            postTemplate += `</div>
                                <div class="d-flex justify-content-between align-items-center px-1 mb-2 mt-2">
                                    <h2 class="f-14 w-500  ellipsis-1 pt-0 mt-0">${ post.title }</h2>
                                    <h2 class="f-12 w-500  pb-0 pt-0 mt-0 ellipsis-1">${ formatStats(post.views) } Views</h2>
                                </div>
                            </div>`

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
                                                <li class="text-center p-0"><a  href="${appURL}/posts/delete/${post.id}"
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
                error: function(response) {
                    console.log(response)
                    $('.posts').append('<p>Error loading posts.</p>');
                    isLoading = false;
                }
            });
        }

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
                url: appURL + "/users/addPeers",
                method: "POST",
                data: {
                    action: "add_peers",
                    peerIDs
                },
                success: function(response) {
                    if (response) {
                        var addedPeers = $("#addPeer .add-peers-list:has(:checkbox:checked)").map(function() {
                            // Uncheck the checkbox
                            $(this).addClass("group-peers-list")
                            $(this).find(':checkbox').prop('checked', false);
                            return this;
                        }).get();

                        $("#addPeer .add-peers-list:has(:checkbox:checked)").remove();

                        // Append the removed peers to another list
                        if ($("#deletePeer .no-peer").length) {
                            $("#deletePeer .modal-body").empty()
                        }
                        if ($("#createGroup .no-peer").length) {
                            $("#createGroup .no-peer").remove()
                        }
                        $("#deletePeer .modal-body").append(addedPeers);
                        $("#createGroup .modal-body").append(addedPeers)

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
                url: appURL + "/users/deletePeers",
                method: "POST",
                data: {
                    action: "delete_peers",
                    peerIDs
                },
                success: function(response) {
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

                        $("#createGroup .group-peers-list").filter(function() {
                            var peerId = $(this).data("peer-id");
                            console.log(peerIDs);

                            return removedPeers.some(function(removedPeer) {
                                return $(removedPeer).data("peer-id") === peerId;
                            });
                        }).remove();

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

        // Create group
        $(".create-group-btn").click(function() {
            var groupName = $("#createGroup .group-name").val();
            if (groupName === "") {
                alert("Please enter group name")
                return;
            }

            console.log($("#createGroup .group-peers-list"));
            var groupPeers = $("#createGroup .group-peers-list:has(:checkbox:checked)").map(function() {
                return $(this).data("peer-id");
            }).get();

            console.log(groupPeers);

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
    });
</script>