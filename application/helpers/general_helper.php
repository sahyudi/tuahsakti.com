<?php

function get_parent_menu($id)
{
    $CI = get_instance();
    $CI->db->select('title');
    $CI->db->where('id', $id);
    $data = $CI->db->get('menus')->row();

    if (!empty($data->title)) {
        return $data->title;
    } else {
        return 'Parent Menu';
    }
}

function log_r($string = null, $var_dump = false)
{
    if ($var_dump) {
        var_dump($string);
    } else {
        echo "<pre>";
        print_r($string);
    }
    exit;
}
