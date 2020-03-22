<?php

class M_pos extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_pos_penjualan($id = null)
    {
        $this->db->select('a.*, m.satuan, m.nama as item, d.*');
        $this->db->join($this->penjualan_detail . ' as d', 'a.id = d.penjualan_id', 'left');
        $this->db->join($this->material . ' as m', 'm.id = d.material_id', 'left');
        if ($id) {
            $this->db->where('a.id', $id);
        }
        $data = $this->db->get($this->penjualan . ' as a');
        return $data;
    }
}
