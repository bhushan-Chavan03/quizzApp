<?php

$conn = mysqli_connect("https://server5.dnspark.in:2083/cpsess6276711494/3rdparty/phpMyAdmin/index.php?route=/database/structure&db=opspvtlt_db_quiz", "root", "", "opspvtlt_db_quiz");

if (!$conn) {
    echo "Connection Failed";
}