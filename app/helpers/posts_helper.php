<?php

function formatViews($views) {
    if ($views >= 1000 && $views < 1000000) {
        return number_format($views / 1000, 1) . 'K';
    } elseif ($views >= 1000000 && $views < 1000000000) {
        return number_format($views / 1000000, 1) . 'M';
    } elseif ($views >= 1000000000) {
        return number_format($views / 1000000000, 1) . 'B';
    } else {
        return $views;
    }
}


?>