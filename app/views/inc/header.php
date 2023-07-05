<?php

$userObj2 = new User;

$userObj2->updateOnlineUsers();
$userObj2->deleteOfflineUsers();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/emoji.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <link href="https://emoji-css.afeld.me/emoji.css" rel="stylesheet">
    <title><?php echo $data["title"]; ?></title>

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