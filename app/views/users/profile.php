<?php

include APPROOT . "/views/inc/header.php";
include APPROOT . "/views/inc/nav.php";

$user = $data['user'];
$courses = $data["courses"];

?>

<main>
    <div class="container h-100 ">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="sign-heading  text-center mt-4">Profile Settings</h1>
            </div>
        </div>
        <form method="post" action="<?php echo URLROOT; ?>/users/editProfile" enctype="multipart/form-data" class="row  ">

            <div class="col-lg-6 h-100 d-flex flex-column justify-content-center mt-3 order-last order-lg-first">
                <div class="sign-content">

                    <div class="mb-4">
                        <input type="text" name="name" required value="<?php echo $user->userName; ?>" class="sign-input" placeholder="Name">
                    </div>
                    <div class="mb-4">
                        <input type="email" required value="<?php echo $user->email; ?>" name="email" class="sign-input" placeholder="Email">
                    </div>
                    <div class="mb-4">
                        <input type="password" name="password" class="sign-input" placeholder="Password">
                        <small>Leave blank to not change password</small>
                    </div>
                    <div class="mb-4">
                        <select class="sign-input" name="course" id="course">
                            <?php if (!empty($courses)) : ?>
                                <?php foreach ($courses as $course) : ?>
                                    <option <?php echo $course->id == $user->courseID ? 'selected' : '' ?> value="<?php echo $course->id; ?>"><?php echo $course->name; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <select class="sign-input" name="qualification" id="qualification">
                            <option <?php echo $user->qualification == 0 ? 'selected' : ''; ?> value="0">Undergraduate</option>
                            <option <?php echo $user->qualification == 1 ? 'selected' : ''; ?> value="1">Postgraduate</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <input type="text" value="<?php echo $user->institution; ?>" required name="institution" class="sign-input" placeholder="Institution">
                    </div>
                    <div class="mb-4">
                        <a href="<?php echo URLROOT; ?>/chats" class="btn px-5 successfull-btn w-100">Contact Admin</a>
                    </div>
                    <div class="d-flex justify-content-end mb-3">
                        <button type="submit" class="btn px-5 successfull-btn">Save</button>
                    </div>


                </div>
            </div>
            <div class="col-lg-6 order-first order-lg-last">
                <div class="d-flex flex-column align-items-center justify-content-center h-100">
                    <p class="mb-0"><img class="setting-dp " src="<?php echo URLROOT; ?>/public/images/<?php echo $user->img; ?>" id="output" /></p>
                    <p class="mb-0">
                        <input type="file" accept="image/*" name="image" id="file" onchange="loadFile(event)" style="display: none;">
                    </p>
                    <button type="button" class="mt-4 btn-blank mb-4 px-4"><label for="file">Edit Image</label></button>

                </div>
            </div>

        </form>
    </div>

</main>

<?php

include APPROOT . "/views/inc/footer.php";

?>

<script>
    var loadFile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };
</script>