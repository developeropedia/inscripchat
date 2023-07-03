<?php

include_once APPROOT . "/views/inc/admin-header.php";

$courses = $data["courses"];

?>

<!-- -----------Main Contents----------- -->
<main class="content pb-4">

    <div class="px-4 mt-1">
        <div class="d-flex justify-content-end align-items-center flex-wrap">
            <div class="d-flex align-items-center btns-row">

                <a href="<?php echo URLROOT; ?>/admin/add_course"><button class="panel-button mt-2">+&nbsp;&nbsp;Add Course</button></a>

            </div>
        </div>

    </div>

    <div class="container-fluid">
        <?php echo flash("delete_course"); ?>
        <?php echo flash("course_added"); ?>
        <div class="row m-0 -0">
            <div class="col-lg-12 mt-4">
                <div class="panel-card">
                    <div class="">
                        <p class="f-20 w-400 mt-3 mb-0 pb-0">Courses</p>
                        <div class="seprator"></div>
                    </div>
                    <div class="products-table-wrapper">
                        <table id="dashboard-table" class="products-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="products-table-head">Name</th>
                                    <th class="products-table-head">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($courses)) : ?>
                                    <?php foreach ($courses as $course) : ?>
                                        <tr>
                                            <td class="product-table-text"><?php echo $course->name; ?></td>
                                            <td class="icons">
                                                <div class="d-flex">
                                                    <a href="<?php echo URLROOT; ?>/admin/edit_course/<?php echo $course->id; ?>"> <i class="bi bi-pencil-square"></i></a>
                                                    <a href="<?php echo URLROOT; ?>/admin/delete_course/<?php echo $course->id; ?>"> <i class="bi bi-trash3-fill"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</main>

<!-- Modal -->
<div class="modal " id="delete-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="d-flex justify-content-end message-popup">
                <button type="button" class="btn-close mt-2 me-2" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <p class="text-center second-heading mb-0 pb-0">Are You Sure?<br> You want to remove <b>UserName</b>
                    ?</p>
                <div class="d-flex justify-content-center mt-3">
                    <button class="panel-button2" data-bs-dismiss="modal">Remove</button>
                </div>
            </div>

        </div>
    </div>
</div>

<?php

include_once APPROOT . "/views/inc/admin-footer.php";

?>