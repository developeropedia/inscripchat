<?php

include_once APPROOT . "/views/inc/admin-header.php";

?>

<!-- -----------Main Contents----------- -->
<main class="content pb-4">


    <div class="container-fluid">
        <?php echo flash("course_edited"); ?>
        <div class="row m-0 -0">
            <div class="col-lg-12 mt-4">
                <div class="panel-card">
                    <form id="profileForm" action="<?php echo URLROOT; ?>/admin/addCourse" method="post" enctype="multipart/form-data">
                        <div class="">
                            <p class="f-20 w-400 mt-3 mb-0 pb-0">Add Course</p>
                            <p class="f-14 text-gray mb-0 pb-0 f-14 mb-3">
                                Add a new course
                            <div class="seprator"></div>
                        </div>
                        <div class="profile-card mx-auto mt-4 flex-column">
                            <div class="mb-3 w-100">
                                <label for="" class="form-label f-14 w-500">Name</label>
                                <input required type="text" name="name" class="form-control" id="">
                            </div>


                        </div>

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <a id="submitForm" style="cursor: pointer;" class="panel-button2 text-center">Save</a>
                            <a href="<?php echo URLROOT; ?>/admin/courses" class="panel-button2 text-center ms-2">Go Back</a>
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