<?php

class M_penjualan extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_data()
    {
        $this->db->select('a.*, m.satuan, m.nama as item');
        $this->db->join('material as m', 'm.id = a.material_id', 'left');
        $data = $this->db->get('penjualan as a');
        return $data;
    }
}
