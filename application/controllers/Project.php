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
    }

    public function index()
    {
        $data['proyek'] = $this->m_proyek->get_proyek()->result();
        $data['active'] = 'project';
        $data['title'] = 'Project';
        $data['subview'] = 'project/list';
        $this->load->view('template/main', $data);
    }

    function create_project()
    {
        $data['proyek'] = $this->m_proyek->get_proyek()->result();
        $data['active'] = 'project';
        $data['title'] = 'Project';
        $data['subview'] = 'project/form';
        $this->load->view('template/main', $data);
    }

    function info_detail($id)
    {
        $data['master'] = $this->m_proyek->get_proyek($id)->row();
        $data['detail'] = $this->m_proyek->get_proyek_detail($id)->result();
        // log_r($data['detail']);
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

        // detail item
        $item = $this->input->post('item');
        $qty = $this->input->post('qty');
        $harga_beli = $this->input->post('harga_beli');
        $harga_jual = $this->input->post('harga_jual');
        $upah = $this->input->post('upah');

        $data_pengadaan = [
            'nama_proyek' => $nama,
            'anggaran' => $anggaran,
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
                'harga_beli' => str_replace(",", "", $harga_beli[$i]),
                'harga_jual' => str_replace(",", "", $harga_jual[$i]),
                'satuan' => $material->satuan,
                'upah' => ($upah[$i]) ? $upah[$i] : 0,
                'ket_detail' => 'Proyek nomor ' . $no_proyek,
                'created_at' => $date,
                'created_user' => $user
            ];
        }
        // log_r($detail);



        // if ($kredit != 0) {
        //     $saldo_hutang = [
        //         'no_nota' => $nota,
        //         'vendor_id' => $vendor,
        //         'saldo' => $saldo = str_replace(",", "", $kredit),
        //         'updated_at' => $date,
        //         'created_user' => $user
        //     ];
        //     $this->db->insert('saldo_hutang', $saldo_hutang);
        // }

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
