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
        $data['material'] = $this->m_material->get_material()->result();
        $data['active'] = 'accounting/';
        $data['title'] = 'Material';
        $data['subview'] = 'material/list';
        $this->load->view('template/main', $data);
    }

    function item()
    {
        $data['item'] = $this->db->get('item_pengajuan')->result();
        $data['active'] = 'accounting/item';
        $data['title'] = 'Item';
        $data['subview'] = 'accounting/item';
        $this->load->view('template/main', $data);
    }

    function addItem()
    {
        $data['nama'] = $this->input->post('nama');

        if ($this->input->post('id')) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->db->update('item_pengajuan', $data, ['id' => $this->input->post('id')]);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('item_pengajuan', $data);
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
}
