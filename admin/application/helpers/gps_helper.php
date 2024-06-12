<?php
require_once (rtrim(FCPATH, '\\') . '/gps/gps.php');
if (!function_exists('gps_get_instance'))
{
    function gps_get_instance($name = false)
    {
        $gps = Gps::get_instance($name);
        return $gps;
    }
}

