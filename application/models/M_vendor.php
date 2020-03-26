<?php

class M_vendor extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_vendor($id = null)
    {
        $this->db->select('*');
        if ($id) {
            $this->db->where('id', $id);
        }
        $data = $this->db->get('vendor');
        return $data;
    }
}
