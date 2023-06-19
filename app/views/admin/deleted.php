<?php

include_once APPROOT . "/views/inc/admin-header.php";

$users = $data["users"];
$courseObj = new Course;

?>

<!-- -----------Main Contents----------- -->
<main class="content pb-4">


    <div class="container-fluid">
        <div class="row m-0 -0">
            <div class="col-lg-12 mt-4">
                <div class="panel-card">
                    <div class="">
                        <p class="f-20 w-400 mt-3 mb-0 pb-0">Users</p>
                        <div class="seprator"></div>
                    </div>
                    <div class="products-table-wrapper">
                        <table id="dashboard-table" class="products-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="products-table-head">Name</th>
                                    <th class="products-table-head">Username</th>
                                    <th class="products-table-head">Course</th>
                                    <th class="products-table-head">Institution </th>
                                    <th class="products-table-head">Email</th>
                                    <th class="products-table-head">Qualification</th>
                                    <th class="products-table-head">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users)) : ?>
                                    <?php foreach ($users as $user) : ?>
                                        <tr>
                                            <td class="product-table-text"><?php echo $user->name; ?></td>
                                            <td class="product-table-text"><?php echo $user->username; ?></td>
                                            <td class="product-table-text"><?php echo $courseObj->getCourseById($user->course)->name; ?></td>
                                            <td class="product-table-text"><?php echo $user->institution; ?></td>
                                            <td class="product-table-text"><?php echo $user->email; ?></td>
                                            <td class="product-table-text"><?php echo QUALIFICATION[$user->qualification]; ?></td>
                                            <td class="icons">
                                                <div class="d-flex">
                                                    <a href="<?php echo URLROOT; ?>/admin/restore/<?php echo $user->id; ?>" class="p-0"><i class="bi bi-arrow-clockwise"></i></a>
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