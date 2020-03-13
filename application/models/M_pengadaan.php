<?php

class M_pengadaan extends CI_Model
{

    public $pengadaan = 'pengadaan';
    public $pengadaan_detail = 'pengadaan_detail';
    public $vendor = 'vendor';
    public $material = 'material';

    function __construct()
    {
        parent::__construct();
    }

    public function get_data()
    {
        $this->db->select('a.*, d.*, m.satuan, m.nama as nama, v.nama as vendor');
        $this->db->join($this->pengadaan_detail . ' as d', 'a.id = d.pengadaan_id', 'left');
        $this->db->join($this->material . ' as m', 'm.id = d.material_id', 'left');
        $this->db->join($this->vendor . ' as v', 'v.id = a.vendor_id', 'left');
        $data = $this->db->get($this->pengadaan . ' as a');
        return $data;
    }
}
