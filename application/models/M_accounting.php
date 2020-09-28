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
        $this->db->select('A.*, B.total, B.item, B.keterangan as ket_detail');
        $this->db->join('pendanaan_detail B', 'A.id = B.pendanaan_id', 'left');
        $this->db->where('A.id', $id);
        $data = $this->db->get('pendanaan A');
        return $data;
    }

    function get_nomor_pengajuan()
    {
        $this->db->select('*');
        $data = $this->db->get('pendanaan');
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
        $this->db->select('A.*, B.nama AS nama_vendor, A.updated_at as tanggal');
        $this->db->join('vendor B', 'A.vendor_id = B.id');
        if ($id) {
            $this->db->where('A.id', $id);
        }
        $data = $this->db->get('hutang A');
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
        $data = $this->db->get('hutang A');
        return $data;
    }

    function get_piutang($id = null)
    {
        $this->db->select('A.*, B.nama');
        $this->db->join('customer B', 'A.customer_id = B.id');
        if ($id) {
            $this->db->where('A.id', $id);
        }
        $data = $this->db->get('piutang A');
        return $data;
    }

    function get_detail_piutang($id)
    {
        $this->db->select('A.no_nota, B.nama, C.*');
        $this->db->join('customer B', 'A.customer_id = B.id');
        $this->db->join('piutang_detail C', 'A.id = C.saldo_id');
        if ($id) {
            $this->db->where('A.id', $id);
        }
        $data = $this->db->get('piutang A');
        return $data;
    }
}
