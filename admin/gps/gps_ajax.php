<?php include ('gps.php');
header('Content-Type: text/html; charset=' . GPS_config::$mbencoding);
echo GPS::get_requested_instance();
