<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Project extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }

        $this->load->model('m_proyek');
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
}
