<?php

class M_material extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_material($id = null)
    {
        if ($id != 0) {
            $this->db->where('id', $id);
        }
        $data = $this->db->get('material');
        return $data;
    }
}
