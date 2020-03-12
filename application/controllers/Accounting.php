<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Accounting extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
        $this->load->model('m_material');
        $this->load->model('m_accounting');
    }

    public function index()
    {
        $data['material'] = $this->m_material->get_material()->result();
        $data['active'] = 'material';
        $data['title'] = 'Material';
        $data['subview'] = 'material/list';
        $this->load->view('template/main', $data);
    }

    public function pengajuan()
    {
        $data['pengajuan'] = $this->m_accounting->get_pengajuan()->result();
        $data['active'] = 'accounting/pengajuan';
        $data['title'] = 'Pengajuan';
        $data['subview'] = 'accounting/pengajuan';
        $this->load->view('template/main', $data);
    }

    public function form_pengajuan()
    {
        $data['item'] = $this->m_accounting->get_item()->result();
        $data['active'] = 'accounting/form_pengajuan';
        $data['title'] = 'Form Pengajuan';
        $data['subview'] = 'accounting/form_pengajuan';
        $this->load->view('template/main', $data);
    }

    function simpan_pengajuan()
    {
        $nomor = $this->input->post('nomor');
        $tanggal = $this->input->post('tanggal');
        $keterangan = $this->input->post('keterangan');
        $item = $this->input->post('item');
        $sub_total = $this->input->post('sub_total');

        $data = [];
        for ($i = 0; $i < count($item); $i++) {
            $data[] = [
                'datetime' => $nomor,
                'keterangan' => $keterangan,
                'gudang_id' => 1,
                'item_id' => $item[$i],
                'total' => $sub_total[$i]
            ];
        }

        $this->db->trans_begin();

        $this->db->insert_batch('pengajuan_dana', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        redirect('accounting/pengajuan');
    }

    function item()
    {
        $data['item'] = $this->m_accounting->get_item()->result();
        $data['active'] = 'accounting/item';
        $data['title'] = 'Item';
        $data['subview'] = 'accounting/item';
        $this->load->view('template/main', $data);
    }

    function addItem()
    {
        $data['nama'] = $this->input->post('nama');
        $this->db->trans_begin();

        if ($this->input->post('id')) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->db->update('item_pengajuan', $data, ['id' => $this->input->post('id')]);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('item_pengajuan', $data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        redirect('accounting/item');
    }

    function get_item($id)
    {
        if ($id) {
            $data = $this->db->get_where('item_pengajuan', ['id' => $id])->row();
            echo json_encode($data);
        }
    }
    function deleteItem($id)
    {
        if ($id) {
            $this->db->delete('item_pengajuan', ['id' => $id]);
            redirect('accounting/item');
        }
    }


    function saldo_hutang()
    {
        $data['saldo_hutang'] = $this->m_accounting->get_saldo_hutang()->result();
        $data['active'] = 'accounting/saldo_hutang';
        $data['title'] = 'Hutang';
        $data['subview'] = 'hutang/saldo_hutang';
        $this->load->view('template/main', $data);
    }
}
