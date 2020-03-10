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
        // $this->db->join('menus B', 'A.id = B.parent_id');
        // $this->db->where('B.parent_id !=', 0);
        if ($id != 0) {
            $this->db->where('A.id', $id);
        }
        $menu = $this->db->get();
        return $menu;
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
