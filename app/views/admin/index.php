<?php

include_once APPROOT . "/views/inc/admin-header.php";

$totalUsers = $data['totalUsers'];
$totalDailyUsers = $data['totalDailyUsers'];
$totalWeeklyUsers = $data['totalWeeklyUsers'];
$totalMonthlyUsers = $data['totalMonthlyUsers'];

?>

<!-- -----------Main Contents----------- -->
<main class="content pb-4">
    <div class="p-20">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <p class="mb-0 pb-0 text-dark-light f-16 w-500">Welcome, <?php echo $_SESSION['user_name']; ?>!</p>
                <p class="f-14 text-gray mb-0 pb-0 f-14 ">Here's what's happening with your website today.
                </p>
            </div>
            <div class="d-flex align-items-center btns-row">

                <a target="_blank" href="<?php echo URLROOT; ?>/posts/upload"><button class="panel-button mt-2">+&nbsp;&nbsp;Add /
                        Upload</button></a>

            </div>
        </div>

    </div>

    <div class="container-fluid mt-3">
        <div class="row p-0 m-0 ">
            <div class="col-lg-12 col-md-6 col-sm-10 mx-auto">
                <div class="panel-card-total-users mt-2 total-card1">
                    <p class="f-18 w-400 mb-0 pb-0 ">Total </p>
                    <p class="f-32 w-500 mb-0 pb-0"><?php echo $totalUsers->totalUsers; ?></p>
                    <div class="d-flex justify-content-between align-items-end mt-3">
                        <a href="<?php echo URLROOT; ?>/admin/users" class="px-4 f-14 detail-btn">View All</a>
                    </div>

                    <i class="bi bi-people-fill card-icon"></i>
                </div>
            </div>
            <div class="col-lg-12 mt-3">
                <div>
                    <p class="mb-0 pb-0 text-dark-light f-16 w-500">Number of Users Registered</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-10 mx-auto">
                <div class="panel-card-start mt-2 panel-card4">
                    <p class="f-16 w-400 mb-0 pb-0">Daily</p>
                    <p class="f-28 w-500 mt-3"><?php echo ceil($totalDailyUsers->totalDailyUsers); ?></p>
                    <div class="d-flex justify-content-between align-items-end">
                        <a href="<?php echo URLROOT; ?>/admin/registered_users/daily" class=" f-14 detail-btn">View All</a>
                    </div>

                    <i class="bi bi-people-fill card-icon"></i>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-10 mx-auto">
                <div class="panel-card-start mt-2">
                    <p class="f-16 w-400 mb-0 pb-0 my-3">Weekly</p>
                    <p class="f-28 mt-3 w-500"><?php echo ceil($totalWeeklyUsers->totalWeeklyUsers); ?></p>
                    <div class="d-flex justify-content-between align-items-end">
                        <a href="<?php echo URLROOT; ?>/admin/registered_users/weekly" class=" f-14 detail-btn">View All</a>
                    </div>

                    <i class="bi bi-people-fill card-icon"></i>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-10 mx-auto">
                <div class="panel-card-start mt-2 panel-card2">
                    <p class="f-16 w-400 mb-0 pb-0 my-3">Monthly</p>
                    <p class="f-28 mt-3 w-500"><?php echo ceil($totalMonthlyUsers->totalMonthlyUsers); ?></p>
                    <div class="d-flex justify-content-between align-items-end">
                        <a href="<?php echo URLROOT; ?>/admin/registered_users/monthly" class=" f-14 detail-btn">View All</a>
                    </div>

                    <i class="bi bi-people-fill card-icon"></i>
                </div>
            </div>

            <!-- <div class="col-lg-12 mt-4">
                <div>
                    <p class="mb-0 pb-0 text-dark-light f-16 w-500">Number of Users Who Use Website</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-10 mx-auto">
                <div class="panel-card-start mt-2 panel-card3">
                    <p class="f-16 w-400 mb-0 pb-0 my-3">Daily</p>
                    <p class="f-28 mt-3 w-500">50</p>
                    <div class="d-flex justify-content-between align-items-end">
                        <a href="website-user.html" class=" f-14 detail-btn">View All</a>
                    </div>

                    <i class="bi bi-people-fill card-icon"></i>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-10 mx-auto">
                <div class="panel-card-start mt-2 total-card2">
                    <p class="f-16 w-400 mb-0 pb-0 my-3">Weekly</p>
                    <p class="f-28 mt-3 w-500">1.5K</p>
                    <div class="d-flex justify-content-between align-items-end">
                        <a href="website-user.html" class=" f-14 detail-btn">View All</a>
                    </div>

                    <i class="bi bi-people-fill card-icon"></i>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-10 mx-auto">
                <div class="panel-card-start mt-2 total-card4">
                    <p class="f-16 w-400 mb-0 pb-0 my-3">Monthly</p>
                    <p class="f-22 mt-3 w-500">5K</p>
                    <div class="d-flex justify-content-between align-items-end">
                        <a href="website-user.html" class=" f-14 detail-btn">View All</a>
                    </div>

                    <i class="bi bi-people-fill card-icon"></i>
                </div>
            </div> -->

        </div>
    </div>

    <!-- <div class="container-fluid">
        <div class="row m-0 p-0">
            <div class="col-lg-6 mt-4 ">
                <div class="panel-card">
                    <div class="d-flex justify-content-between chats-cards">
                        <p class="f-14 w-400 ">Complete Cvents Trends <i class="bi bi-info-circle"></i></p>
                        <p class="f-14 w-300">15 Aug - 15 Sep</p>
                    </div>
                    <canvas id="myChart" style="width:100%;max-width:600px"></canvas>

                </div>
            </div>
            <div class="col-lg-6 mt-4">
                <div class="panel-card">
                    <div class="d-flex justify-content-between chats-cards">
                        <p class="f-14 w-400 ">Complete Cvents Trends <i class="bi bi-info-circle"></i></p>
                        <p class="f-14 w-300">15 Aug - 15 Sep</p>
                    </div>
                    <canvas id="myChart2" style="width:100%;max-width:600px"></canvas>

                </div>
            </div>
        </div>
    </div> -->

</main>

<?php

include_once APPROOT . "/views/inc/admin-footer.php";

?>