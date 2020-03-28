<?php

class M_proyek extends CI_Model
{

    public $proyek = 'proyek';
    public $proyek_detail = 'proyek_detail';
    public $proyek_dana = 'proyek_dana';
    public $material = 'material';

    function __construct()
    {
        parent::__construct();
    }

    public function get_proyek($id = null)
    {
        $this->db->select('a.*');
        if ($id) {
            $this->db->where('a.id', $id);
        }
        $data = $this->db->get($this->proyek . ' as a');
        return $data;
    }

    public function get_proyek_detail($id = null)
    {
        $this->db->select('d1.tanggal as tanggal_detail, d1.harga_beli, m1.nama as nama_item, m1.satuan, d1.qty, d1.harga, d1.ket_detail');
        $this->db->from($this->proyek . ' as a1');
        $this->db->join($this->proyek_detail . ' as d1', 'a1.id = d1.proyek_id', 'left');
        $this->db->join($this->material . ' as m1', 'm1.id = d1.material_id', 'left');
        $this->db->where('a1.id', $id);
        $query_1 = $this->db->get_compiled_select();


        $this->db->select('d2.tanggal as tanggal_detail, (0) as harga_beli, d2.keterangan AS nama_item, ("-") as satuan, (1) as qty, d2.total AS harga,("-") as ket_detail');
        $this->db->from($this->proyek . ' as a2');
        $this->db->join($this->proyek_dana . ' as d2', 'a2.id = d2.proyek_id', 'right');
        $this->db->where('a2.id', $id);
        $query_2 = $this->db->get_compiled_select();
        $final_query = $this->db->query($query_1 . ' UNION ' . $query_2);

        return $final_query;
    }

    public function get_proyek_dana($id = null)
    {
        $this->db->select('a.*, d.keterangan as ket_detail, SUM(d.total) as total, d.tanggal as tanggal_detail');
        $this->db->join($this->proyek_dana . ' as d', 'a.id = d.proyek_id', 'right');
        if ($id) {
            $this->db->where('a.id', $id);
        }
        $this->db->group_by('a.id');
        $data = $this->db->get($this->proyek . ' as a');
        return $data;
    }

    function get_detail_dana($id)
    {
        $this->db->select('d2.tanggal, d2.item AS nama_item, d2.keterangan,d2.total, d2.created_user');
        $this->db->from($this->proyek . ' as a2');
        $this->db->join($this->proyek_dana . ' as d2', 'a2.id = d2.proyek_id', 'right');
        $this->db->where('a2.id', $id);
        $data = $this->db->get();
        return $data;
    }
}
