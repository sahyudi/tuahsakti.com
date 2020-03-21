<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pos extends CI_Controller
{
    public $material = 'material';
    public $penjualan = 'penjualan';
    public $penjualan_detail = 'penjualan_detail';

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
        $this->load->model('m_pengadaan');
        $this->load->model('m_penjualan');
        $this->load->model('m_material');
        $this->load->model('m_accounting');
        $this->load->library('datatables');
    }

    function index()
    {
        $data['material'] = $this->m_material->get_material()->result();
        $this->load->view('pos/index', $data);
    }

    function get_data_stock()
    {
        $this->datatables->select('A.nama, A.satuan, A.harga_jual, B.stock');
        $this->datatables->from('material A');
        $this->datatables->join('stock B', 'A.id = B.material_id');
        echo $this->db->last_query();
        echo $this->datatables->generate();
    }

    public function get_item_list()
    {
        $idgudang   = $this->input->post('id_gudang');
        $searchTerm = $this->input->post('cari');
        $sel_plu   = array_unique(json_decode(html_entity_decode($this->input->post('sel'))));
        // $cabangnya = CABANG;
        // $gudangnya = $this->db->query("SELECT id_cabang FROM d_gudang WHERE id='$idgudang'")->row_array();
        // if ($cabangnya == '1' || $cabangnya == '0') {
        //     $query = $this->db->query("SELECT d_item_recipi_produksi.plu, d_item_recipi_produksi.duplicate, d_item.nama_item FROM d_item_recipi_produksi LEFT JOIN d_item ON d_item_recipi_produksi.plu=d_item.plu WHERE d_item.nama_item  LIKE '%" . $searchTerm . "%' AND d_item_recipi_produksi.id_kota='$gudangnya[id_cabang]' UNION ALL SELECT d_item_recipi_produksi.duplicate, d_item_recipi_produksi.duplicate, d_item.nama_item FROM d_item_recipi_produksi LEFT JOIN d_item ON d_item_recipi_produksi.duplicate=d_item.plu WHERE d_item.nama_item LIKE '%" . $searchTerm . "%' AND d_item_recipi_produksi.id_kota='$gudangnya[id_cabang]' ORDER BY plu ASC");
        // } else {
        //     $query = $this->db->query("SELECT d_item_recipi_produksi.plu, d_item_recipi_produksi.duplicate, d_item.nama_item FROM d_item_recipi_produksi LEFT JOIN d_item ON d_item_recipi_produksi.plu=d_item.plu WHERE d_item.nama_item  LIKE '%" . $searchTerm . "%' AND d_item_recipi_produksi.id_kota='$cabangnya' UNION ALL SELECT d_item_recipi_produksi.duplicate, d_item_recipi_produksi.duplicate, d_item.nama_item FROM d_item_recipi_produksi LEFT JOIN d_item ON d_item_recipi_produksi.duplicate=d_item.plu WHERE d_item.nama_item LIKE '%" . $searchTerm . "%' AND d_item_recipi_produksi.id_kota='$cabangnya' ORDER BY plu ASC");
        // }
        // $json = array();
        // if (empty($cari)) {
        //     $cari = " ";
        // }
        $id = $this->input->post('id');
        $this->db->select('A.*, B.stock');
        $this->db->join('stock B', 'A.id = B.material_id');
        $this->db->where('B.stock >=', 1);
        if ($id) {
            $this->db->where_not_in('A.id', $id);
        }
        $data = $this->db->get('material A');
        // foreach ($data as $key => $value) {
        //     $json[] = array("id" => $value->id, "text" => "$value->nama");
        // }
        echo json_encode($data);
    }
}
