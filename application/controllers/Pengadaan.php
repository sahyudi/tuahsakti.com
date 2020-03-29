<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengadaan extends CI_Controller
{
    public $pengadaan = 'pengadaan';
    public $pengadaan_detail = 'pengadaan_detail';
    public $vendor = 'vendor';
    public $material = 'material';

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
        $this->load->model('m_pengadaan');
        $this->load->model('m_material');
        $this->load->model('m_accounting');
    }

    function index()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'pengadaan');
        $data['pengadaan'] = $this->m_pengadaan->get_data()->result();
        $data['active'] = 'pengadaan';
        $data['title'] = 'Pengadaan';
        $data['subview'] = 'pengadaan/list';
        $this->load->view('template/main', $data);
    }

    function form()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'pengadaan');
        $data['material'] = $this->m_material->get_material()->result();
        $data['vendor'] = $this->db->get('vendor')->result();
        $data['momor_pengjuan'] = $this->m_accounting->get_nomor_pengajuan()->result();
        $data['active'] = 'pengadaan';
        $data['title'] = 'Form';
        $data['subview'] = 'pengadaan/form';
        $this->load->view('template/main', $data);
    }

    function save()
    {
        $this->db->trans_begin();

        // data pengadaan
        $date = date('Y-m-d H:i:s');
        $tanggal = $this->input->post('tanggal');
        $nota = 'PE' . time();
        $vendor = $this->input->post('vendor');
        $ket = $this->input->post('keterangan');
        $surat_jalan = $this->input->post('surat_jalan');
        $kredit = $this->input->post('kredit');

        // detail item
        $item = $this->input->post('item');
        $qty = $this->input->post('qty');
        $harga_beli = $this->input->post('harga_beli');
        $upah = $this->input->post('upah');

        $data_pengadaan = [
            'surat_jalan' => $surat_jalan,
            'no_nota' => $nota,
            'vendor_id' => $vendor,
            'tanggal' => $tanggal,
            'keterangan' => $ket,
            'created_at' => $date,
            'created_user' => $user = $this->session->userdata('id')
        ];

        $this->db->insert($this->pengadaan, $data_pengadaan);
        $pengadaan_id = $this->db->insert_id();

        $detail = [];
        for ($i = 0; $i < count($item); $i++) {
            $quantity =  str_replace(",", "", $qty[$i]);
            $material = $this->m_material->get_material($item[$i])->row();

            $detail[] = [
                'pengadaan_id' => $pengadaan_id,
                'material_id' => $item[$i],
                'qty' => $quantity,
                'harga_beli' => $material->harga_beli,
                'satuan' => $material->satuan,
                'upah' => ($upah[$i]) ? $upah[$i] : 0,
                'ket_detail' => 'Pengadaan nomor ' . $nota,
                'stock_updated' => $quantity + $material->stock,
                'created_at' => $date
            ];
        }


        if ($kredit != 0) {
            $saldo_hutang = [
                'no_nota' => $nota,
                'vendor_id' => $vendor,
                'saldo' => $saldo = str_replace(",", "", $kredit),
                'updated_at' => $date,
                'created_user' => $user
            ];
            $this->db->insert('hutang', $saldo_hutang);
        }

        $this->db->insert_batch('pengadaan_detail', $detail);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        redirect('pengadaan');
    }

    function get_item($id)
    {
        if ($id) {
            $this->db->where('id', $id);
            $data = $this->db->get($this->material)->row();
            echo json_encode($data);
        }
    }

    function delete_detail($id)
    {
        if ($id) {
            $this->db->delete($this->pengadaan_detail, ['id' => $id]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil delete pengadaan!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal delete pengadaan!</div>');
        }
        redirect('pengadaan');
    }


    function report()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'pengadaan/report');

        $this->form_validation->set_rules('start_date', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('end_date', 'Tanggal Akhir', 'trim|required');
        $this->form_validation->set_rules('material', 'Material', 'trim|required');


        if ($this->form_validation->run() == false) {
            $start_date = null;
            $end_date = null;
            $material = null;
            $data['pengadaan'] = $this->m_pengadaan->get_report_pengadaan()->result();
        } else {
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $material = $this->input->post('material');
            $data['pengadaan'] = $this->m_pengadaan->get_report_pengadaan($start_date, $end_date, $material)->result();
        }
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['material_id'] = $material;
        $data['material'] = $this->m_material->get_material()->result();
        $data['active'] = 'pengadaan/report';
        $data['title'] = 'Report Pengadaan';
        $data['subview'] = 'pengadaan/report';
        $this->load->view('template/main', $data);
    }

    function print_report($start_date, $end_date, $material)
    {
        check_persmission_pages($this->session->userdata('group_id'), 'pengadaan/report');
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['material_id'] = $material;
        $data['pengadaan'] = $this->m_pengadaan->get_report_pengadaan($start_date, $end_date, $material)->result();
        $this->load->view('pengadaan/print_report', $data);
    }
}
