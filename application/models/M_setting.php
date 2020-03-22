<?php

class M_setting extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_menu($id = null)
    {
        $this->db->select('A.*');
        $this->db->from('menus A');
        if ($id != 0) {
            $this->db->where('A.id', $id);
        }
        // $this->db->order_by('A.parent_id');
        $menu = $this->db->get();
        return $menu;
    }

    function get_group($id = null)
    {
        $this->db->select('A.*');
        $this->db->from('groups A');
        if ($id != 0) {
            $this->db->where('A.id', $id);
        }
        // $this->db->order_by('A.parent_id');
        $menu = $this->db->get();
        return $menu;
    }

    function get_parent_menu()
    {
        $this->db->where('parent_id', 0);
        return $this->db->get('menus');
    }

    public function get_users($id = null)
    {
        $this->db->select('A.*');
        $this->db->from('users A');
        if ($id != 0) {
            $this->db->where('A.id', $id);
        }
        $menu = $this->db->get();
        return $menu;
    }
}
