<?php

include APPROOT . "/views/inc/header.php";

?>

<body class="sign-body">
    <div class="d-flex h-100 w-100">
        <form method="post" class="sign-form w-100">
            <div class="w-60  h-100">
                <img src="<?php echo URLROOT; ?>/public/images/LogIn.png" alt="" class=" w-100 sign-img">
                <img src="<?php echo URLROOT; ?>/public/images/logo.png" alt="" class="logo img-fluid">
            </div>
            <div class="w-40 h-100 ms-auto  d-flex flex-column justify-content-center">
                <div class="sign-content">
                    <?php flash('email_not_found', '', 'errorMsg'); ?>
                    <h1 class="sign-heading mb-3">Forgot password</h1>
                    <p class="text-danger"><?php echo $data['error']; ?></p>
                    <div class="mb-4">
                        <input type="email" name="email" class="sign-input" placeholder="Email">
                    </div>
                    <div class="mb-4">
                        <button type="submit" name="submit" class="btn w-100">Send</button>
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


    <div style="position: sticky; z-index: 1000;">
        <?php

        include APPROOT . "/views/inc/footer.php";

        ?>
    </div>