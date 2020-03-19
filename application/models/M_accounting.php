<?php

class M_accounting extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_pengajuan($id = null)
    {
        $this->db->select('A.*, sum(B.total) AS total');
        $this->db->join('pendanaan_detail B', 'A.id = B.pendanaan_id', 'left');
        if ($id) {
            $this->db->where('A.id', $id);
        }
        $this->db->group_by('A.id');
        $data = $this->db->get('pendanaan A');
        return $data;
    }

    function get_detail_pendanaan($id)
    {
        $this->db->select('A.*, B.total, C.nama as nama_item');
        $this->db->join('pendanaan_detail B', 'A.id = B.pendanaan_id', 'left');
        $this->db->join('pendanaan_item C', 'B.item_id = C.id', 'left');
        $this->db->where('A.id', $id);
        $data = $this->db->get('pendanaan A');
        return $data;
    }

    function get_nomor_pengajuan()
    {
        $this->db->select('*');
        $this->db->group_by('datetime');
        $data = $this->db->get('pengajuan_dana');
        return $data;
    }

    function get_item($id = null)
    {
        if ($id != 0) {
            $this->db->where('id', $id);
        }
        $data = $this->db->get('pendanaan_item');
        return $data;
    }

    function get_saldo_hutang($id = null)
    {
        $this->db->select('A.*, B.nama AS nama_vendor');
        $this->db->join('vendor B', 'A.vendor_id = B.id');
        if ($id) {
            $this->db->where('A.id', $id);
        }
        $data = $this->db->get('saldo_hutang A');
        return $data;
    }


    function get_detail_hutang($id = null)
    {
        $this->db->select('A.no_nota, B.nama AS nama_vendor, C.*');
        $this->db->join('vendor B', 'A.vendor_id = B.id');
        $this->db->join('hutang_detail C', 'A.id = C.saldo_id');
        if ($id) {
            $this->db->where('A.id', $id);
        }
        $data = $this->db->get('saldo_hutang A');
        return $data;
    }
}
