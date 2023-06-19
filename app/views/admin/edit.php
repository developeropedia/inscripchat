<?php

include_once APPROOT . "/views/inc/admin-header.php";

$user = $data["user"];
$courses = $data["courses"];

?>

<!-- -----------Main Contents----------- -->
<main class="content pb-4">


    <div class="container-fluid">
        <?php echo flash("user_edited"); ?>
        <div class="row m-0 -0">
            <div class="col-lg-12 mt-4">
                <div class="panel-card">
                    <form id="profileForm" action="<?php echo URLROOT; ?>/admin/editUser/<?php echo $user->userID; ?>" method="post" enctype="multipart/form-data">
                        <div class="">
                            <p class="f-20 w-400 mt-3 mb-0 pb-0">Edit Profile</p>
                            <p class="f-14 text-gray mb-0 pb-0 f-14 mb-3">
                                Edit Profile Information
                            <div class="seprator"></div>
                        </div>
                        <div class="profile-card mx-auto mt-4 flex-column">
                            <div class="mb-3 w-100">
                                <label for="" class="form-label f-14 w-500">Name</label>
                                <input required type="text" name="name" class="form-control" id="" value="<?php echo $user->userName; ?>">
                            </div>
                            <div class="mb-3 w-100">
                                <label for="" class="form-label f-14 w-500">Email</label>
                                <input required type="email" name="email" class="form-control" id="" value="<?php echo $user->email; ?>">
                            </div>
                            <div class="mb-3 w-100">
                                <label for="" class="form-label f-14 w-500">Course</label>
                                <select class="form-select" name="course" id="course">
                                    <?php if (!empty($courses)) : ?>
                                        <?php foreach ($courses as $course) : ?>
                                            <option <?php echo $course->id == $user->courseID ? 'selected' : '' ?> value="<?php echo $course->id; ?>"><?php echo $course->name; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="mb-3 w-100">
                                <label for="" class="form-label f-14 w-500">Qualification</label>
                                <select class="form-select" name="qualification" id="qualification">
                                    <option <?php echo $user->qualification == 0 ? 'selected' : ''; ?> value="0">Undergraduate</option>
                                    <option <?php echo $user->qualification == 1 ? 'selected' : ''; ?> value="1">Postgraduate</option>
                                </select>
                            </div>
                            <div class="mb-3 w-100">
                                <label for="" class="form-label f-14 w-500">Institution</label>
                                <input required name="institution" type="text" class="form-control" id="" value="<?php echo $user->institution; ?>">
                            </div>


                        </div>

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <input type="hidden" name="id" value="<?php echo $user->userID; ?>">
                            <a id="submitForm" style="cursor: pointer;" class="panel-button2 text-center">Save</a>
                            <a href="<?php echo URLROOT; ?>/admin/users" class="panel-button2 text-center ms-2">Go Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</main>

<?php

include_once APPROOT . "/views/inc/admin-footer.php";

?>

<script>
    $("#submitForm").click(function() {
        $("#profileForm").submit()
    })
</script>