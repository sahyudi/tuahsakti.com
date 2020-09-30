<?php

class M_penjualan extends CI_Model
{

    public $material = 'material';
    public $penjualan = 'penjualan';
    public $penjualan_detail = 'penjualan_detail';
    public $proyek = 'proyek';
    public $proyek_detail = 'proyek_detail';


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
        $this->db->select('a.transaksi_id, a.customer_name as nama, a.tanggal as tanggal, a.keterangan as keterangan, a.created_user, m.nama as item, d.upah, d.qty, d.harga_jual as harga_jual, d.satuan, d.id as detail_id, d.ket_detail');
        $this->db->from($this->penjualan . ' as a');
        $this->db->join($this->penjualan_detail . ' as d', 'a.id = d.penjualan_id', 'left');
        $this->db->join($this->material . ' as m', 'm.id = d.material_id', 'left');
        if ($start_date) {
            $this->db->where("a.tanggal BETWEEN '{$start_date}' AND '{$end_date}'");
        }
        if ($material) {
            $this->db->where("d.material_id", $material);
        }

        $query_1 = $this->db->get_compiled_select();


        $this->db->select('0 as transaksi_id, a1.nama_proyek as nama, d1.tanggal as tanggal, d1.ket_detail as keterangan, a1.created_user, m1.nama as item, 0 as upah, d1.qty, d1.harga as harga_jual, m1.satuan, d1.id as id_detail, d1.ket_detail');
        $this->db->from($this->proyek . ' as a1');
        $this->db->join($this->proyek_detail . ' as d1', 'a1.id = d1.proyek_id', 'left');
        $this->db->join($this->material . ' as m1', 'm1.id = d1.material_id', 'left');
        if ($start_date) {
            $this->db->where("a1.tanggal BETWEEN '{$start_date}' AND '{$end_date}'");
        }
        if ($material) {
            $this->db->where("d1.material_id", $material);
        }

        $this->db->order_by('tanggal', 'asc');
        $query_2 = $this->db->get_compiled_select();

        $data = $this->db->query($query_1 . ' UNION ' . $query_2);
        return $data;
    }
}
