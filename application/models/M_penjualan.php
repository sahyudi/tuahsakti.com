<?php

class M_penjualan extends CI_Model
{

    public $material = 'material';
    public $penjualan = 'penjualan';
    public $penjualan_detail = 'penjualan_detail';


    function __construct()
    {
        parent::__construct();
    }

    public function get_data()
    {
        $this->db->select('a.*, m.satuan, m.nama as item, d.*, d.id as detail_id');
        $this->db->join($this->penjualan_detail . ' as d', 'a.id = d.penjualan_id', 'left');
        $this->db->join($this->material . ' as m', 'm.id = d.material_id', 'left');
        $data = $this->db->get($this->penjualan . ' as a');
        return $data;
    }
}
