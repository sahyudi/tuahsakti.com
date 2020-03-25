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
        $this->db->select('a.*, m.satuan, m.nama as item, d.*, d.tanggal as tanggal_detail');
        $this->db->join($this->proyek_detail . ' as d', 'a.id = d.proyek_id', 'left');
        $this->db->join($this->material . ' as m', 'm.id = d.material_id', 'left');
        if ($id) {
            $this->db->where('a.id', $id);
        }
        $data = $this->db->get($this->proyek . ' as a');
        return $data;
    }

    public function get_proyek_dana($id = null)
    {
        $this->db->select('a.*, d.*, d.tanggal as tanggal_detail');
        $this->db->join($this->proyek_dana . ' as d', 'a.id = d.proyek_id', 'right');
        if ($id) {
            $this->db->where('a.id', $id);
        }
        $data = $this->db->get($this->proyek . ' as a');
        return $data;
    }
}
