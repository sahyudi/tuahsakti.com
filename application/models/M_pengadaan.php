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
        $this->db->select('a.*, d.*, d.id as detail_id, m.satuan, m.nama as nama, v.nama as vendor');
        $this->db->join($this->pengadaan_detail . ' as d', 'a.id = d.pengadaan_id', 'left');
        $this->db->join($this->material . ' as m', 'm.id = d.material_id', 'left');
        $this->db->join($this->vendor . ' as v', 'v.id = a.vendor_id', 'left');
        $this->db->order_by('a.tanggal', 'asc');
        $data = $this->db->get($this->pengadaan . ' as a');
        return $data;
    }

    function get_report_pengadaan($start_date = null, $end_date = null, $material = null)
    {
        $this->db->select('a.no_nota, a.surat_jalan, a.tanggal, a.keterangan, a.created_user, m.satuan, m.nama as item, d.upah, d.qty, d.harga_beli, d.satuan, d.id as detail_id');
        $this->db->join($this->pengadaan_detail . ' as d', 'a.id = d.pengadaan_id', 'left');
        $this->db->join($this->material . ' as m', 'm.id = d.material_id', 'left');
        if ($start_date) {
            $this->db->where("a.tanggal BETWEEN '{$start_date}' AND '{$end_date}'");
        }
        if ($material) {
            $this->db->where("d.material_id", $material);
        }
        $this->db->order_by('a.tanggal', 'asc');
        $data = $this->db->get($this->pengadaan . ' as a');
        return $data;
    }
}
