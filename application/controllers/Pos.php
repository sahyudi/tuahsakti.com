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
    }

    function index()
    {
        $data['material'] = $this->m_material->get_material()->result();
        $this->load->view('pos/index', $data);
    }

    function get_data_stock()
    {
        $this->load->library('datatables');

        $this->datatables->select('A.nama, A.satuan, A.harga_jual, B.stock');
        $this->datatables->join('stock B', 'A.id = B.material_id');
        $this->datatables->from('material A');
        echo $this->datatables->generate();
    }
}
