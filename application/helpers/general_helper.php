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

function cek_status($status)
{
    if ($status == 1) {
        return '<span class="badge badge-succees">Done</span>';
    } else if ($status == 2) {
        return '<span class="badge badge-danger">Pending</span>';
    } else {
        return '<span class="badge badge-warning">On progress</span>';
    }
}

function cek_pengeluaran_project($id_project)
{
    $CI = get_instance();
    $CI->db->select('SUM(harga * qty) AS pengeluaran');
    $CI->db->where('proyek_id', $id_project);
    // $CI->db->group_by('proyek_id');
    $data_material = $CI->db->get('proyek_detail')->row();


    $CI->db->select('SUM(total) AS pengeluaran');
    $CI->db->where('proyek_id', $id_project);
    // $CI->db->group_by('proyek_id');
    $data_dana = $CI->db->get('proyek_dana')->row();
    return ($data_dana->pengeluaran + $data_material->pengeluaran);
}


function get_user_name($id)
{
    $CI = get_instance();
    $CI->db->select('name');
    $CI->db->where('id', $id);
    $data = $CI->db->get('users')->row();
    if ($data->name) {
        return $data->name;
    } else {
        return 'default';
    }
}
