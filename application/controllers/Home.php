<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
        $this->load->model('m_home');
    }

    public function index()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'home');

        $data['jml_customer'] = $this->m_home->get_member()->num_rows();
        $data['jml_penjualan'] = $this->m_home->get_penjualan()->num_rows();
        $data['jml_project'] = $this->m_home->get_projec()->num_rows();
        $data['active'] = 'home';
        $data['title'] = 'Home';
        $data['subview'] = 'home/index';
        $this->load->view('template/main', $data);
    }
}
