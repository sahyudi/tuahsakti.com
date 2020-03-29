<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
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
        $data['penjualan'] = $this->m_penjualan->get_data()->result();
        $data['active'] = 'penjualan';
        $data['title'] = 'Penjualan';
        $data['subview'] = 'penjualan/list';
        $this->load->view('template/main', $data);
    }

    function form()
    {
        $data['material'] = $this->m_material->get_material_penjualan()->result();

        $data['active'] = 'Penjualan';
        $data['title'] = 'Form';
        $data['subview'] = 'penjualan/form';
        $this->load->view('template/main', $data);
    }

    function save()
    {
        $this->db->trans_begin();

        $date = date('Y-m-d H:i:s');
        $nota = 'TR' . time();
        $tanggal = $this->input->post('tanggal');
        $ket = $this->input->post('keterangan');
        $kredit = $this->input->post('kredit');


        $upah = $this->input->post('upah');
        $item = $this->input->post('item');
        $qty = $this->input->post('qty');
        $harga_jual = $this->input->post('harga_jual');

        $data_pengadaan = [
            'transaksi_id' => $nota,
            'tanggal' => $tanggal,
            'keterangan' => $ket,
            'created_at' => $date,
            'created_user' => $user = $this->session->userdata('id')
        ];

        $this->db->insert($this->penjualan, $data_pengadaan);
        $penjualan_id = $this->db->insert_id();

        $detail = [];

        for ($i = 0; $i < count($item); $i++) {
            $quantity =  str_replace(",", "", $qty[$i]);
            $material = $this->m_material->get_material($item[$i])->row();

            $detail[] = [
                'penjualan_id' => $penjualan_id,
                'material_id' => $item[$i],
                'qty' => $quantity,
                'harga_jual' => str_replace(",", "", $harga_jual[$i]),
                'satuan' => $material->satuan,
                'upah' => ($material->upah),
                'ket_detail' => 'Penjualan nomor ' . $nota,
                'stock_updated' => $material->stock - $quantity,
                'created_at' => $date,
                'created_user' => $user = $this->session->userdata('id')
            ];
        }


        // if ($kredit != 0) {
        //     $saldo_hutang = [
        //         'no_nota' => $nota,
        //         'vendor_id' => $vendor,
        //         'saldo' => $saldo = str_replace(",", "", $kredit),
        //         'updated_at' => $date,
        //         'created_user' => $user
        //     ];
        //     $this->db->insert('hutang', $saldo_hutang);
        // }

        $this->db->insert_batch('penjualan_detail', $detail);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        redirect('penjualan');
    }

    function get_item($id)
    {
        if ($id) {
            $data = $this->m_material->get_material_penjualan($id)->row();
            echo json_encode($data);
        }
    }

    function delete_detail($id)
    {
        if ($id) {
            $this->db->delete($this->penjualan_detail, ['id' => $id]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil delete penjualan!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal delete penjualan!</div>');
        }
        redirect('penjualan');
    }

    function report()
    {
        $this->form_validation->set_rules('start_date', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('end_date', 'Tanggal Akhir', 'trim|required');
        $this->form_validation->set_rules('material', 'Material', 'trim|required');


        if ($this->form_validation->run() == false) {
            $start_date = null;
            $end_date = null;
            $material = null;
            $data['penjualan'] = $this->m_penjualan->get_report_penjualan()->result();
        } else {
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $material = $this->input->post('material');
            $data['penjualan'] = $this->m_penjualan->get_report_penjualan($start_date, $end_date, $material)->result();
        }
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['material_id'] = $material;
        $data['material'] = $this->m_material->get_material()->result();
        $data['active'] = 'penjualan/report';
        $data['title'] = 'Report Penjualan';
        $data['subview'] = 'penjualan/report';
        $this->load->view('template/main', $data);
    }

    function print_report($start_date, $end_date, $material)
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $material = $this->input->post('material');

        $data['penjualan'] = $this->m_penjualan->get_report_penjualan($start_date, $end_date, $material)->result();
        $data['subview'] = 'penjualan/print_report';
        $this->load->view('penjualan/print_report', $data);
    }
}
