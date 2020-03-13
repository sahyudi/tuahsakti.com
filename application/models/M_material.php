<?php

class M_material extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_material($id = null)
    {
        $this->db->select('A.*, B.stock');
        $this->db->join('stock B', 'A.id = B.material_id');
        if ($id != 0) {
            $this->db->where('A.id', $id);
        }
        $data = $this->db->get('material A');
        return $data;
    }

    function get_material_penjualan($id = null)
    {
        $this->db->select('A.*, B.stock');
        $this->db->join('stock B', 'A.id = B.material_id');
        $this->db->where('B.stock >=', 1);
        if ($id) {
            $this->db->where('A.id', $id);
        }
        $data = $this->db->get('material A');
        return $data;
    }
}
