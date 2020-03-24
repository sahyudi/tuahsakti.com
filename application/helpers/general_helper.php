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

function check_persmission_pages($id_group, $menu_id)
{
    $CI = get_instance();
    $CI->db->select('*');
    $CI->db->from('user_access_role');
    $CI->db->where('group_id', $id_group);
    $CI->db->where('menu_id', $menu_id);
    $data = $CI->db->get();

    if ($data->num_rows() > 0) {
        return true;
    } else {
        redirect('home');
    }
}

function check_persmission_views($id_group, $menu_id)
{
    $CI = get_instance();
    $CI->db->select('*');
    $CI->db->from('user_access_role');
    $CI->db->where('group_id', $id_group);
    $CI->db->where('menu_id', $menu_id);
    $data = $CI->db->get();

    if ($data->num_rows() > 0) {
        return true;
    } else {
        return false;
    }
}

function check_menu($id_group, $menu_id)
{
    $CI = get_instance();
    $CI->db->select('*');
    $CI->db->from('user_access_role');
    $CI->db->where('group_id', $id_group);
    $CI->db->where('menu_id', $menu_id);
    $data = $CI->db->get();

    if ($data->num_rows() > 0) {
        return 'checked';
    }
}
