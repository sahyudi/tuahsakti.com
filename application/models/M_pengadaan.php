<?php

class M_pengadaan extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_data()
    {
        $this->db->select('a.*, (a.qty * a.harga_beli) as total, m.satuan, m.nama as nama, v.nama as vendor');
        $this->db->join('material as m', 'm.id = a.material_id', 'left');
        $this->db->join('vendor as v', 'v.id = a.vendor_id', 'left');
        $data = $this->db->get('pengadaan as a');
        return $data;
    }
}
