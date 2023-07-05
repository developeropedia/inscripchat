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
                    <h1 class="sign-heading mb-3">Reset password</h1>
                    <p class="text-danger"><?php echo $data['error']; ?></p>
                    <div class="mb-4">
                        <input type="password" id="password" name="password" class="sign-input" placeholder="New password">
                        <small id="passError"></small>
                    </div>
                    <div class="mb-4">
                        <button type="submit" name="submit" class="btn w-100">Reset</button>
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

    <script>
        $(document).ready(function() {
            $('form').submit(function(event) {
                var inputs = $(this).find('input');
                var emptyInputs = inputs.filter(function() {
                    return !$(this).val();
                });

                if (emptyInputs.length > 0) {
                    event.preventDefault();
                    alert("Please fill all fields")
                } else {
                    var password = $('#password').val();
                    var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

                    if (!passwordRegex.test(password)) {
                        event.preventDefault();
                        $("#passError").addClass("text-danger")
                        $("#passError").text("Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, and one number")
                    }
                }
            });
        });
    </script>