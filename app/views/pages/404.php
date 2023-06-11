<?php

include APPROOT . "/views/inc/header.php";
include APPROOT . "/views/inc/nav.php";

?>

<div style="height: calc(100vh - 70px); width: 100%" class="d-flex justify-content-center align-items-center">
    <div class="text-center">
        <h1 class="text-secondary" style="font-size: 90px;">
            404
        </h1>
        <h3 class="text-secondary"><span class="text-danger">Oops!</span> Page not found.</h3>
        <a style="text-decoration: none; color: #2F791C;" href="<?php echo URLROOT; ?>/posts/index"><i style="display: inline;" class="bi bi-arrow-return-left"></i> Home</a>
    </div>
</div>

<?php

include APPROOT . "/views/inc/footer.php";

?>