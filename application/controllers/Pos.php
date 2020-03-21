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
        // $idgudang   = $this->input->post('id_gudang');
        // $searchTerm = $this->input->post('cari');
        // $sel_plu   = array_unique(json_decode(html_entity_decode($this->input->post('sel'))));

        $id = $this->input->post('id');
        $this->db->select('A.*, B.stock');
        $this->db->join('stock B', 'A.id = B.material_id');
        $this->db->where('B.stock >=', 1);
        if ($id) {
            $this->db->where_not_in('A.id', $id);
        }
        $data = $this->db->get('material A')->result();
        echo json_encode($data);
    }
}
