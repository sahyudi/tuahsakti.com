<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengadaan extends CI_Controller
{
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
        $data['pengadaan'] = $this->m_pengadaan->get_data()->result();
        $data['active'] = 'pengadaan';
        $data['title'] = 'Pengadaan';
        $data['subview'] = 'pengadaan/list';
        $this->load->view('template/main', $data);
    }

    function form()
    {
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
        $date = date('Y-m-d H:i:s');
        $tanggal = $this->input->post('tanggal');
        $nota = $this->input->post('no_nota');
        $vendor = $this->input->post('vendor');
        $ket = $this->input->post('keterangan');
        $surat_jalan = $this->input->post('surat_jalan');
        $item = $this->input->post('item');
        $qty = $this->input->post('qty');
        $harga_beli = $this->input->post('harga_beli');
        $kredit = $this->input->post('kredit');


        $data_pengadaan = [];
        for ($i = 0; $i < count($item); $i++) {
            $quantity =  str_replace(",", "", $qty[$i]);
            $material = $this->m_material->get_material($item[$i])->row();
            $data_pengadaan[] = [
                'surat_jalan' => $surat_jalan,
                'no_nota' => $nota,
                'vendor_id' => $vendor,
                'tanggal' => $tanggal,
                'material_id' => $item[$i],
                'qty' => $quantity,
                'harga_beli' => str_replace(",", "", $harga_beli[$i]),
                'satuan' => $material->satuan,
                'keterangan' => $ket,
                'stock_updated' => $quantity + $material->stock,
                'created_at' => $date,
                'created_user' => $user = $this->session->userdata('id')
            ];
        }

        $this->db->trans_begin();

        if ($kredit != 0) {
            $saldo_hutang = [
                'no_nota' => $nota,
                'vendor_id' => $vendor,
                'saldo' => $saldo = str_replace(",", "", $kredit),
                'updated_at' => $date,
                'created_user' => $user
            ];
            $this->db->insert('saldo_hutang', $saldo_hutang);
        }

        $this->db->insert_batch('pengadaan', $data_pengadaan);
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
            $data = $this->db->get('material')->row();
            echo json_encode($data);
        }
    }
}
