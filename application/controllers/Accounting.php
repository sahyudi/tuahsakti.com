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

    // public $this->user = $this->session->userdata('id');

    public function index()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'accounting');
        $data['material'] = $this->m_material->get_material()->result();
        $data['active'] = 'material';
        $data['title'] = 'Material';
        $data['subview'] = 'material/list';
        $this->load->view('template/main', $data);
    }

    public function pengajuan()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'accounting/pengajuan');
        $data['pengajuan'] = $this->m_accounting->get_pengajuan()->result();
        $data['active'] = 'accounting/pengajuan';
        $data['title'] = 'Pengajuan';
        $data['subview'] = 'accounting/pengajuan';
        $this->load->view('template/main', $data);
    }
    public function detail_pendanaan($id)
    {
        $data['detail'] = $this->m_accounting->get_detail_pendanaan($id)->result();
        $data['active'] = 'accounting/pengajuan';
        $data['title'] = 'Pengajuan';
        $data['subview'] = 'accounting/detail_pendanaan';
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
        $this->db->trans_begin();

        $date = date('Y-m-d H:i:s');

        $nomor = $this->input->post('nomor');
        $tanggal = $this->input->post('tanggal');
        $keterangan = $this->input->post('keterangan');

        $ket_detail = $this->input->post('ket_detail');
        $item = $this->input->post('item');
        $sub_total = $this->input->post('sub_total');

        $master = [
            'tanggal' => $tanggal,
            'surat_jalan' => $nomor,
            'keterangan' => $keterangan,
            'status' => 1,
            'created_user' => $user = $this->session->userdata('id'),
            'created_at' => $date
        ];

        $this->db->insert('pendanaan', $master);
        $id = $this->db->insert_id();
        $data = [];
        for ($i = 0; $i < count($item); $i++) {
            $data[] = [
                'pendanaan_id' => $id,
                'keterangan' => $ket_detail[$i],
                'item' => $item[$i],
                'total' => replace_angka($sub_total[$i]),
                'created_user' => $user,
                'created_at' => $date
            ];
        }


        $this->db->insert_batch('pendanaan_detail', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        redirect('accounting/pengajuan');
    }

    function delete_penganjuan($id)
    {
        $this->db->trans_begin();
        $this->db->delete('pendanaan', ['id' => $id]);
        $this->db->delete('pendanaan_detail', ['pendanaan_id' => $id]);
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

    function pembayaran($id)
    {
        $data['active'] = 'accounting/saldo_hutang';
        $data['title'] = 'Hutang';
        $data['master'] = $this->m_accounting->get_saldo_hutang($id)->row();
        $data['detail'] = $this->m_accounting->get_detail_hutang($id)->result();
        $data['subview'] = 'hutang/detail';
        $this->load->view('template/main', $data);
    }

    function piutang()
    {
        $data['piutang'] = $this->m_accounting->get_piutang()->result();
        // log_r($data['piutang']);
        $data['active'] = 'accounting/piutang';
        $data['title'] = 'Piutang';
        $data['subview'] = 'piutang/saldo';
        $this->load->view('template/main', $data);
    }

    function detail_piutang($customer_id)
    {
        $data['active'] = 'accounting/piutang';
        $data['title'] = 'Detail Piutang';
        $data['master'] = $this->m_accounting->get_piutang($customer_id)->row();
        $data['detail'] = $this->m_accounting->get_detail_piutang($customer_id)->result();
        $data['subview'] = 'piutang/detail';
        $this->load->view('template/main', $data);
    }

    function delete_piutang($customer_id)
    {
        if ($this->db->delete('piutang', ['customer_id' => $customer_id])) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Piutang gagal dihapus !</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Piutang berhasil dihapus !</div>');
        }

        redirect('accounting/piutang/' . $customer_id);
    }

    function bayar_piutang()
    {
        $date = date('Y-m-d H:i:s');
        $customer_id = $this->input->post('customer_id');
        $debit = $this->input->post('debit');
        $sisa = $this->input->post('sisa');
        $keterangan = $this->input->post('keterangan');

        $data = [
            'customer_id' => $customer_id,
            'debit' => replace_angka($debit),
            'keterangan' => $keterangan,
            'updated_at' => $date
        ];

        $this->db->trans_begin();

        $this->db->insert('piutang', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Pembayaran gagal disimpan !</div>');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pembayaran berhasil disimpan !</div>');
        }

        redirect('accounting/detail_piutang/' . $id);
    }
}
