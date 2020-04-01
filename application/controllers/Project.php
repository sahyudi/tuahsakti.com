<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Project extends CI_Controller
{
    public $proyek = 'proyek';
    public $proyek_detail = 'proyek_detail';
    public $proyek_dana = 'proyek_dana';
    public $hutang_project = 'hutang_project';
    public $hutang_project_detail = 'hutang_project_detail';


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
        check_persmission_pages($this->session->userdata('group_id'), 'project');

        $data['proyek'] = $this->m_proyek->get_proyek()->result();

        // log_r($data['proyek']);
        $data['active'] = 'project';
        $data['title'] = 'Project';
        $data['subview'] = 'project/list';
        $this->load->view('template/main', $data);
    }

    function pendanaan()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'project/pendanaan');
        $data['pendanaan'] = $this->m_proyek->get_proyek_dana()->result();;
        $data['active'] = 'project/pendanaan';
        $data['title'] = 'Pendanaan';
        $data['subview'] = 'project/dana';
        $this->load->view('template/main', $data);
    }

    function form_pendanaan()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'project/pendanaan');
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
        $item = $this->input->post('item');
        $keterangan = $this->input->post('keterangan');
        $sub_total = $this->input->post('sub_total');
        for ($i = 0; $i < count($keterangan); $i++) {
            $data[] = [
                'proyek_id' => $proyek,
                'tanggal' => $tanggal,
                'total' => str_replace(",", "", $sub_total[$i]),
                'item' => $item[$i],
                'keterangan' => $keterangan[$i],
                'created_at' => $date,
                'created_user' => $this->session->userdata('id')
            ];
        }
        $this->db->trans_begin();
        $this->db->insert_batch('proyek_dana', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Pendanaan proyek gagal disimpan !</div>');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Pendanaan proyek berhasil disimpan !</div>');
        }

        redirect('project/pendanaan');
    }

    function detail_dana($id)
    {
        $data['master'] = $this->m_proyek->get_proyek($id)->row();
        $data['detail'] = $this->m_proyek->get_detail_dana($id)->result();
        // log_r($data['detail']);
        $data['active'] = 'project/pendanaan';
        $data['title'] = 'Detail Dana';
        $data['subview'] = 'project/detail_pendanaan';
        $this->load->view('template/main', $data);
    }

    function delete_detail_dana($id)
    {
        $this->db->trans_begin();
        $this->m_proyek->delete_detail_dana($id);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Pendanaan proyek gagal dihapuskan !</div>');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Pendanaan proyek berhasil dihapuskan !</div>');
        }

        // redirect('project/delete_detail_dana/')
    }

    function delete_dana_proyek($id)
    {
        $this->db->trans_begin();
        $this->m_proyek->delete_dana_proyek($id);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Pendanaan proyek gagal dihapuskan !</div>');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Pendanaan proyek berhasil dihapuskan !</div>');
        }

        redirect('project/pendanaan');
    }

    function delete_proyek($id)
    {
        $this->db->trans_begin();
        $this->m_proyek->delete($this->proyek, ['id' => $id]);
        $this->m_proyek->delete($this->proyek_detail, ['proyek_id' => $id]);
        $this->m_proyek->delete($this->proyek_dana, ['proyek_id' => $id]);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Proyek gagal dihapuskan !</div>');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Proyek berhasil dihapuskan !</div>');
        }
        redirect('project');
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
        // log_r($data['detail']);
        $data['pendanaan'] = null;
        $data['active'] = 'project';
        $data['title'] = 'Project';
        $data['subview'] = 'project/detail_project';
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
        $status_project = $this->input->post('status_project');
        $deksripsi = $this->input->post('deksripsi');
        $anggaran = $this->input->post('anggaran');
        $vendor = $this->input->post('vendor');
        $kredit = $this->input->post('kredit');

        // log_r();


        // detail item
        $item = $this->input->post('item');
        $qty = $this->input->post('qty');
        $harga_beli = $this->input->post('harga_beli');
        $harga = $this->input->post('harga');
        $ket_item = $this->input->post('ket_item');

        $data_pengadaan = [
            'nama_proyek' => $nama,
            'anggaran' => str_replace(",", "", $anggaran),
            'deskripsi' => $deksripsi,
            'proyek_no' => $no_proyek,
            'status' => 0,
            'jenis' => $status_project,
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
                'proyek_id' => $proyek_id,
                'saldo' => abs(str_replace(",", "", $kredit)),
                'keterangan' => $this->input->post('ket_hutang'),
                'updated_at' => $date,
                'created_user' => $user
            ];
            $this->db->insert('hutang_project', $saldo_hutang);
            // $hutang_id = $this->db->insert_id();
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

    function print_project($id)
    {
        check_persmission_pages($this->session->userdata('group_id'), 'project');
        $data['master'] = $this->m_proyek->get_proyek($id)->row();
        $data['detail'] = $this->m_proyek->get_proyek_detail($id)->result();
        $data['pendanaan'] = null;
        $data['active'] = 'project';
        $data['title'] = 'Project';
        $this->load->view('project/print_laporan', $data);
    }

    function hutang()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'project/hutang');
        $data['hutang'] = $this->m_proyek->get_hutang()->result();
        $data['active'] = 'project/hutang';
        $data['title'] = 'Info';
        $data['subview'] = 'project/list_hutang';
        $this->load->view('template/main', $data);
    }

    function info_detail_hutang($id)
    {
        $data['master'] = $this->m_proyek->get_hutang($id)->row();
        $data['detail'] = $this->m_proyek->get_hutang_detail($id)->result();
        $data['active'] = 'project/hutang';
        $data['title'] = 'Info Detail';
        $data['subview'] = 'project/detail_hutang';
        $this->load->view('template/main', $data);
    }

    function pembayaran_hutang()
    {
        $date = date('Y-m-d H:i:s');
        $id = $this->input->post('id');
        $saldo = $this->input->post('saldo');
        $debit = $this->input->post('debit');
        $sisa = $this->input->post('sisa');
        $keterangan = $this->input->post('keterangan');

        $master = [
            'saldo' => str_replace(",", "", $sisa),
            'updated_at' => $date,
        ];

        $data = [
            'saldo_id' => $id,
            'kredit' => 0,
            'debit' => str_replace(",", "", $debit),
            'saldo_updated' => str_replace(",", "", $sisa),
            'ket_detail' => $keterangan,
            'update_at' => $date
        ];

        $this->db->trans_begin();

        $this->db->update($this->hutang_project, $master, ['id' => $id]);
        $this->db->insert($this->hutang_project_detail, $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Pembayaran gagal disimpan !</div>');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pembayaran berhasil disimpan !</div>');
        }

        redirect('project/info_detail_hutang/' . $id);
    }
}
