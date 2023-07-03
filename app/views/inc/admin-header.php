<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $data["title"]; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/css-pro-layout@1.1.0/dist/css/css-pro-layout.css">
    <link href="<?php echo URLROOT; ?>/public/admin-assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- data table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/admin-assets/css/typography.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/admin-assets/css/layout.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/admin-assets/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/admin-assets/css/reponsive.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

    <script>
        function timeAgo(date_time) {
            if (date_time == "none") {
                return "";
            }
            var timestamp = Date.parse(date_time)
            // Get the current time
            var currentTime = new Date();

            // Calculate the difference in milliseconds
            var diff = currentTime.getTime() - timestamp;

            // Calculate the difference in seconds, minutes, hours, days, months, and years
            var seconds = Math.floor(diff / 1000);
            var minutes = Math.floor(seconds / 60);
            var hours = Math.floor(minutes / 60);
            var days = Math.floor(hours / 24);
            var months = Math.floor(days / 30);
            var years = Math.floor(months / 12);

            // Return the appropriate time ago string
            if (years > 0) {
                return years + (years === 1 ? " year ago" : " years ago");
            } else if (months > 0) {
                return months + (months === 1 ? " month ago" : " months ago");
            } else if (days > 0) {
                return days + (days === 1 ? " day ago" : " days ago");
            } else if (hours > 0) {
                return hours + (hours === 1 ? " hour ago" : " hours ago");
            } else if (minutes > 0) {
                return minutes + (minutes === 1 ? " minute ago" : " minutes ago");
            } else {
                return seconds + (seconds === 1 ? " second ago" : " seconds ago");
            }
        }

        function chatTime(timestamp) {
            // Convert the timestamp to a moment object
            var momentObj = moment(timestamp);

            // Get the current time
            var currentTime = moment();

            // Calculate the difference in hours between the current time and the timestamp
            var hoursDiff = currentTime.diff(momentObj, 'hours');

            // Format the time based on the conditions
            var formattedTime;
            if (hoursDiff < 24) {
                // Display time like 9:00 AM
                formattedTime = momentObj.format('h:mm A');
            } else if (hoursDiff >= 24 && hoursDiff < 48) {
                // Display "Yesterday"
                formattedTime = 'Yesterday';
            } else {
                // Display the date
                formattedTime = momentObj.format('D/M/Y');
            }

            return formattedTime;
        }
    </script>

</head>

<body>

    <div class="layout has-sidebar fixed-sidebar fixed-header">
        <!-- ---------------------Side bar-------------- -->
        <aside id="sidebar" class="sidebar break-point-lg has-bg-image">

            <div class="sidebar-layout">
                <div class="sidebar-header d-flex justify-content-center">

                    <a id="btn-toggle2" href="#" class="sidebar-toggler break-point-lg">
                    </a>
                    <div class="d-flex justify-content-center align-items-center">

                        <img src="<?php echo URLROOT; ?>/public/admin-assets/images/Group 2.png" alt="" class="img-fluid ">
                    </div>
                </div>
                <div class="sidebar-content">
                    <nav class="menu open-current-submenu">
                        <ul>
                            <li class="menu-item">
                                <a href="<?php echo URLROOT; ?>/admin" class="<?php echo $data['active'] == 'dashboard' ? 'active-tab' : ''; ?>">
                                    <span class="menu-icon">
                                        <img src="<?php echo URLROOT; ?>/public/admin-assets/images/dashboard-5481.svg" alt="" height="20px" width="20px">
                                    </span>
                                    <span class="menu-title text-dark-blue mt-1">Dashboard</span>
                                </a>
                            </li>

                        </ul>
                        <div class="menu-item py-3">
                            <span class="ps-4 f-14 w-500 text-light-white ls-3 menu-heading ">Statistics</span>
                        </div>
                        <ul>

                            <li class="menu-item">
                                <a href="<?php echo URLROOT; ?>/admin/users" class="<?php echo $data['active'] == 'users' ? 'active-tab' : ''; ?>">
                                    <span class="menu-icon">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <span class="menu-title">Users</span>
                                </a>
                            </li>
                            <li class="menu-item sub-menu">
                                <a class="<?php echo $data['active'] == 'registered_users' ? 'active-tab' : ''; ?>">
                                    <span class="menu-icon">
                                        <i class="bi bi-person-check"></i>
                                    </span>
                                    <span class="menu-title">Registered Users</span>

                                </a>
                                <div class="sub-menu-list">
                                    <ul>
                                        <li class="menu-item">
                                            <a href="<?php echo URLROOT; ?>/admin/registered_users/daily">
                                                <span class="menu-title">-&nbsp;&nbsp;&nbsp;Daily</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="<?php echo URLROOT; ?>/admin/registered_users/weekly">
                                                <span class="menu-title">-&nbsp;&nbsp;&nbsp;Weekly</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="<?php echo URLROOT; ?>/admin/registered_users/monthly">
                                                <span class="menu-title">-&nbsp;&nbsp;&nbsp;Monthly</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="menu-item">
                                <a href="<?php echo URLROOT; ?>/admin/deleted" class="<?php echo $data['active'] == 'deleted_users' ? 'active-tab' : ''; ?>">
                                    <span class="menu-icon">
                                        <i class="bi bi-person-x"></i>
                                    </span>
                                    <span class="menu-title">Deleted Users</span>
                                </a>
                            </li>


                        </ul>

                        <div class="menu-item py-3">
                            <span class="ps-4 f-14 w-500 text-light-white ls-3 menu-heading ">Chats</span>
                        </div>
                        <ul>
                            <li class="menu-item">
                                <a href="<?php echo URLROOT; ?>/admin/groups" class="<?php echo $data['active'] == 'groups' ? 'active-tab' : ''; ?>">
                                    <span class="menu-icon">
                                        <i class="bi bi-people"></i>
                                    </span>
                                    <span class="menu-title">Groups</span>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="<?php echo URLROOT; ?>/admin/chats" class="<?php echo $data['active'] == 'peers' ? 'active-tab' : ''; ?>">
                                    <span class="menu-icon">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <span class="menu-title">Peers</span>
                                </a>
                            </li>

                        </ul>

                        <div class="menu-item py-3">
                            <span class="ps-4 f-14 w-500 text-light-white ls-3 menu-heading ">Content</span>
                        </div>
                        <ul>
                            <li class="menu-item">
                                <a href="<?php echo URLROOT; ?>/admin/upload" class="<?php echo $data['active'] == 'upload' ? 'active-tab' : ''; ?>">
                                    <span class="menu-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-up" viewBox="0 0 16 16">
                                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.354-5.854 1.5 1.5a.5.5 0 0 1-.708.708L13 11.707V14.5a.5.5 0 0 1-1 0v-2.793l-.646.647a.5.5 0 0 1-.708-.708l1.5-1.5a.5.5 0 0 1 .708 0ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" />
                                            <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z" />
                                        </svg>
                                    </span>
                                    <span class="menu-title">Upload</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="<?php echo URLROOT; ?>/admin/courses" class="<?php echo $data['active'] == 'courses' ? 'active-tab' : ''; ?>">
                                    <span class="menu-icon">
                                        <i class="bi bi-book"></i>
                                    </span>
                                    <span class="menu-title">Courses</span>
                                </a>
                            </li>

                        </ul>
                    </nav>
                </div>
            </div>
        </aside>

        <!-- --------------------Main Side-------------- -->
        <div id="overlay" class="overlay"></div>
        <div class="layout">
            <!-- ----------------Header--------------- -->
            <header class="header">
                <a id="btn-collapse" href="#" class="align-self-center ">
                    <i class="bi bi-filter-left f-28 btn-head"></i>
                </a>
                <a id="btn-toggle" href="#" class="sidebar-toggler break-point-lg align-self-center">
                    <i class="bi bi-filter-left f-28  btn-head"></i>
                </a>
                <!-- <div class="dropdown  notification-dropdown-btn profile-dropdown ms-auto align-self-center px-3 text-dark">
                    <button type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="notifications">
                            <i class="bi bi-bell f-22 "></i>
                            <div class="number">
                                2
                            </div>
                        </div>
                    </button>
                    <ul class="dropdown-menu notification-dropdown" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item " href="notifications.html">
                                <p class="mb-0 pb-0 text-start">Lorem ipsum dolor, sit amet consectetur adipisicing
                                    elit. Unde, a!</p>
                                <div class="d-flex justify-content-end">
                                    <span class="text-right mt-1">Tue,9:50pm</span>
                                </div>
                            </a>
                        </li>
                        <li><a class="dropdown-item " href="#">
                                <p class="mb-0 pb-0 text-start">Lorem ipsum dolor, sit amet consectetur adipisicing
                                    elit. Unde, a!</p>
                                <div class="d-flex justify-content-end">
                                    <span class="text-right mt-1">Tue,9:50pm</span>
                                </div>
                            </a>
                        </li>
                        <li><a class="dropdown-item " href="#">
                                <p class="mb-0 pb-0 text-start">Lorem ipsum dolor, sit amet consectetur adipisicing
                                    elit. Unde, a!</p>
                                <div class="d-flex justify-content-end">
                                    <span class="text-right mt-1">Tue,9:50pm</span>
                                </div>
                            </a>
                        </li>
                        <li><a class="dropdown-item " href="#">
                                <p class="mb-0 pb-0 text-start">Lorem ipsum dolor, sit amet consectetur adipisicing
                                    elit. Unde, a!</p>
                                <div class="d-flex justify-content-end">
                                    <span class="text-right mt-1">Tue,9:50pm</span>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="notifications.html" class="text-center">
                                <div class="see-all">
                                    See All
                                </div>
                            </a>
                        </li>
                    </ul>
                </div> -->

                <div class="d-flex ms-auto user-account px-2">

                    <div class="user-icon">
                        <i class="bi bi-person "></i>
                    </div>
                    <div class="dropdown profile-dropdown">
                        <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $_SESSION['user_name']; ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a target="_blank" class="dropdown-item" href="<?php echo URLROOT; ?>/users/profile"><i class="bi bi-person me-2"></i>Profile</a>
                            </li>
                            <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/users/logout"><i class="bi bi-box-arrow-left me-2"></i>Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>