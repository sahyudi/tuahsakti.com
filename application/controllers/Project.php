<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Project extends CI_Controller
{
    public $proyek = 'proyek';
    public $proyek_detail = 'proyek_detail';
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }

        $this->load->model('m_proyek');
        $this->load->model('m_material');
        $this->load->model('m_vendor');
    }

    public function index()
    {
        $data['proyek'] = $this->m_proyek->get_proyek()->result();

        // log_r($data['proyek']);
        $data['active'] = 'project';
        $data['title'] = 'Project';
        $data['subview'] = 'project/list';
        $this->load->view('template/main', $data);
    }

    function pendanaan()
    {
        $data['pendanaan'] = $this->m_proyek->get_proyek_dana()->result();;
        $data['active'] = 'project/pendanaan';
        $data['title'] = 'Pendanaan';
        $data['subview'] = 'project/dana';
        $this->load->view('template/main', $data);
    }

    function form_pendanaan()
    {
        $data['proyek'] = $this->m_proyek->get_proyek()->result();
        // log_r($data['proyek']);
        $data['active'] = 'project/pendanaan';
        $data['title'] = 'Form Pendanaan';
        $data['subview'] = 'project/form_dana';
        $this->load->view('template/main', $data);
    }

    function simpan_pendanaan()
    {
        $proyek = $this->input->post('proyek_id');
        $tanggal = $this->input->post('tanggal');
        $date = date('Y-m-d H:i:s');
        $keterangan = $this->input->post('keterangan');
        $sub_total = $this->input->post('sub_total');
        for ($i = 0; $i < count($keterangan); $i++) {
            $data[] = [
                'proyek_id' => $proyek,
                'tanggal' => $tanggal,
                'total' => $sub_total[$i],
                'keterangan' => $keterangan[$i],
                'created_at' => $date,
                'created_user' => $this->session->userdata('id')
            ];
        }

        $this->db->insert_batch('proyek_dana', $data);
        redirect('project/pendanaan');
    }

    function create_project()
    {
        $data['vendor'] = $this->m_vendor->get_vendor()->result();
        $data['active'] = 'project';
        $data['title'] = 'Project';
        $data['subview'] = 'project/form';
        $this->load->view('template/main', $data);
    }

    function info_detail($id)
    {
        $data['master'] = $this->m_proyek->get_proyek($id)->row();
        $data['detail'] = $this->m_proyek->get_proyek_detail($id)->result();
        $data['pendanaan'] = null;
        $data['active'] = 'project';
        $data['title'] = 'Project';
        $data['subview'] = 'project/info';
        $this->load->view('template/main', $data);
    }

    function save_project()
    {
        $this->db->trans_begin();

        // data proyek
        $date = date('Y-m-d H:i:s');
        $tanggal = $this->input->post('tanggal');
        $no_proyek = 'PRO' . time();
        $nama = $this->input->post('nama');
        $deksripsi = $this->input->post('deksripsi');
        $anggaran = $this->input->post('anggaran');
        $vendor = $this->input->post('vendor');
        $kredit = $this->input->post('kredit');

        // log_r();


        // detail item
            $item = $this->input->post('item');
        $qty = $this->input->post('qty');
        $harga = $this->input->post('harga');
        $ket_item = $this->input->post('ket_item');

        $data_pengadaan = [
            'nama_proyek' => $nama,
            'anggaran' => str_replace(",", "", $anggaran),
            'deskripsi' => $deksripsi,
            'proyek_no' => $no_proyek,
            'status' => 0,
            'tanggal' => $tanggal,
            'created_at' => $date,
            'created_user' => $user = $this->session->userdata('id')
        ];

        // log_r($data_pengadaan);
        $this->db->insert($this->proyek, $data_pengadaan);
        $proyek_id = $this->db->insert_id();

        $detail = [];
        for ($i = 0; $i < count($item); $i++) {
            $quantity =  str_replace(",", "", $qty[$i]);
            $material = $this->m_material->get_material($item[$i])->row();

            $detail[] = [
                'tanggal' => $tanggal,
                'proyek_id' => $proyek_id,
                'material_id' => $item[$i],
                'qty' => $quantity,
                'harga' => str_replace(",", "", $harga[$i]),
                'satuan' => $material->satuan,
                'ket_detail' => $ket_item[$i],
                'created_at' => $date,
                'created_user' => $user
            ];
        }
        // log_r($detail);

        if ($kredit != 0) {
            $saldo_hutang = [
                'no_nota' => $no_proyek,
                'proyek_id'=>$proyek_id,
                'vendor_id' => $vendor,
                'saldo' => abs(str_replace(",", "", $kredit)),
                'updated_at' => $date,
                'created_user' => $user
            ];
            // log_r($saldo_hutang);
            $this->db->insert('saldo_hutang', $saldo_hutang);
        }

        $this->db->insert_batch($this->proyek_detail, $detail);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Project dengan nomor ' . $no_proyek . ' gagal disimpan !</div>');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Project dengan nomor ' . $no_proyek . ' berhasil disimpan !</div>');
        }
        redirect('project');
    }
}
