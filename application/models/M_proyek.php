<?php

class M_proyek extends CI_Model
{

    public $proyek = 'proyek';
    public $proyek_detail = 'proyek_detail';
    public $proyek_dana = 'proyek_dana';
    public $material = 'material';
    public $hutang_project = 'hutang_project';
    public $hutang_detail = 'hutang_project_detail';

    public $penjualan = 'penjualan';
    public $penjualan_detail = 'penjualan_detail';

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
        $this->db->select('d1.tanggal as tanggal_detail, d1.id as id_detail, d1.harga_beli, m1.nama as nama_item, m1.satuan, d1.qty, d1.harga, d1.ket_detail');
        $this->db->from($this->proyek . ' as a1');
        $this->db->join($this->proyek_detail . ' as d1', 'a1.id = d1.proyek_id', 'left');
        $this->db->join($this->material . ' as m1', 'm1.id = d1.material_id', 'left');
        $this->db->where('a1.id', $id);
        return $this->db->get();
        // $query_1 = $this->db->get_compiled_select();



        // $this->db->select('a3.tanggal as tanggal_detail, d3.id as id_detail, (0) as harga_beli, m3.nama as nama_item, d3.satuan, d3.qty, d3.harga_jual as harga, d3.ket_detail');
        // $this->db->from($this->penjualan . ' as a3');
        // $this->db->join($this->penjualan_detail . ' as d3', 'a3.id = d3.penjualan_id', 'left');
        // $this->db->join($this->material . ' as m3', 'm3.id = d3.material_id', 'left');
        // $this->db->where('a3.project_no', $id);

        // $query_3 = $this->db->get_compiled_select();

        // $final_query = $this->db->query($query_1 . ' UNION ' . $query_3);
        // return $final_query;

    }

    function get_dana_lainnya($id)
    {
        $this->db->select('d2.tanggal as tanggal_detail, d2.id as id_detail, (0) as harga_beli, d2.item AS nama_item, ("-") as satuan, (1) as qty, d2.total AS harga,d2.keterangan as ket_detail');
        $this->db->from($this->proyek . ' as a2');
        $this->db->join($this->proyek_dana . ' as d2', 'a2.id = d2.proyek_id', 'right');
        $this->db->where('a2.id', $id);
        return  $this->db->get();
    }

    function get_material_project($id)
    {
        $this->db->select('a.nama_proyek, b.nama as material, d.satuan, d.harga_beli, d.harga, d.id as id_detail, d.ket_detail as ket_detail, d.qty, d.tanggal as tanggal_detail');
        $this->db->join($this->proyek_detail . ' as d', 'a.id = d.proyek_id', 'left');
        $this->db->join($this->material . ' as b', 'd.material_id = b.id');
        $this->db->where('d.proyek_id', $id);
        $data = $this->db->get($this->proyek . ' as a');
        return $data;
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
        $this->db->select('d2.id as detail_id, d2.tanggal, d2.item AS nama_item, d2.keterangan,d2.total, d2.created_user');
        $this->db->from($this->proyek . ' as a2');
        $this->db->join($this->proyek_dana . ' as d2', 'a2.id = d2.proyek_id', 'right');
        $this->db->where('a2.id', $id);
        $data = $this->db->get();
        return $data;
    }

    function delete_detail_dana($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->proyek_dana);
    }

    function delete_dana_proyek($id)
    {
        $this->db->where('proyek_id', $id);
        $this->db->delete($this->proyek_dana);
    }

    function delete_detail_proyek($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->proyek_detail);
    }

    function delete_proyek($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->proyek);
    }

    function get_hutang($id = null)
    {
        $this->db->select('B.nama_proyek, B.proyek_no, A.*, A.updated_at as tanggal,B.id as id_project');
        if ($id) {
            $this->db->where('A.id', $id);
        }
        $this->db->join($this->proyek . ' B', 'A.proyek_id = B.id');
        $data = $this->db->get($this->hutang_project . ' A');
        return $data;
    }

    function get_hutang_detail($id)
    {

        $this->db->select('B.*, A.saldo, A.updated_at as tanggal');
        if ($id) {
            $this->db->where('A.id', $id);
        }
        $this->db->join($this->hutang_detail . ' B', 'A.id = B.saldo_id');
        $data = $this->db->get($this->hutang_project . ' A');
        return $data;
    }
}
