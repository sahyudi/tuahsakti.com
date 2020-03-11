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

    function get_item($id)
    {
        if ($id) {
            $this->db->where('id', $id);
            $data = $this->db->get('material')->row();
            echo json_encode($data);
        }
    }
}
