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
        $this->db->select('a.transaksi_id, a.customer_name as nama, a.tanggal, a.keterangan, a.created_user, m.satuan, m.nama as item, d.upah, d.qty, d.harga_jual, d.satuan, d.id as detail_id, , d.ket_detail');
        $this->db->join($this->penjualan_detail . ' as d', 'a.id = d.penjualan_id');
        $this->db->join($this->material . ' as m', 'm.id = d.material_id');
        $data = $this->db->get($this->penjualan . ' as a');
        return $data;
    }

    function get_report_penjualan($start_date = null, $end_date = null, $material = null)
    {
        $this->db->select('a.transaksi_id, a.customer_name as nama, a.tanggal, a.keterangan, a.created_user, m.satuan, m.nama as item, d.upah, d.qty, d.harga_jual, d.satuan, d.id as detail_id, d.ket_detail');
        $this->db->join($this->penjualan_detail . ' as d', 'a.id = d.penjualan_id', 'left');
        $this->db->join($this->material . ' as m', 'm.id = d.material_id', 'left');
        if ($start_date) {
            $this->db->where("a.tanggal BETWEEN '{$start_date}' AND '{$end_date}'");
        }
        if ($material) {
            $this->db->where("d.material_id", $material);
        }
        $this->db->order_by('a.tanggal', 'asc');
        $data = $this->db->get($this->penjualan . ' as a');
        return $data;
    }
}
