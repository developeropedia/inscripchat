<?php 

include APPROOT . "/views/inc/header.php";

$course = new Course();

$courses = $course->getCourses();

?>

<body class="sign-body">
    <div class="d-flex h-100 w-100">
        <form action="<?php echo URLROOT; ?>/users/register" method="post" class="sign-form w-100">
            <div class="w-60  h-100">
                <img src="<?php echo URLROOT; ?>/public/images/LogIn.png" alt="" class=" w-100 sign-img">
                <img src="<?php echo URLROOT; ?>/public/images/logo.png" alt="" class="logo img-fluid">
            </div>
            <!-- <div class="verification-message">
                An Email link is sent to Your email address to Verify Your account!
            </div> -->
            <div class="w-40 h-100 ms-auto  d-flex flex-column justify-content-center">
                <div class="sign-content">

                    <h1 class="sign-heading mb-3">Sign Up</h1>
                    <p class="text-danger"><?php echo $data['error']; ?></p>
                    <div class="mb-4">
                        <input type="text" name="name" class="sign-input" placeholder="Name">
                    </div>
                    <div class="mb-4">
                        <input type="text" name="username" class="sign-input" placeholder="Username">
                    </div>
                    <div class="mb-4">
                        <input type="email" name="email" class="sign-input" placeholder="Email">
                    </div>
                    <div class="mb-4">
                        <input type="password" name="password" class="sign-input" placeholder="Password">
                    </div>
                    <div class="mb-4">
                        <select class="sign-input" name="course" id="course">
                            <?php if(!empty($courses)): ?>
                                <?php foreach($courses as $course): ?>
                                    <option value="<?php echo $course->id; ?>"><?php echo $course->name; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <select class="sign-input" name="qualification" id="qualification">
                            <option value="0">Undergraduate</option>
                            <option value="1">Postgraduate</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <input type="text" name="institution" class="sign-input" placeholder="Institution">
                    </div>

                    <div class="mb-4">
                        <button type="submit" name="submit" class="btn w-100 successfull-btn">Sign Up</button>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="line"></div>
                        <div class="or-tag mx-2">or</div>
                        <div class="line"></div>
                    </div>
                    <div class="mt-4">
                        <button type="button" class="btn-blank w-100" onclick="window.location.href='<?php echo URLROOT; ?>/users/login'">Sign
                            In</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


<?php

include APPROOT . "/views/inc/footer.php";

?>