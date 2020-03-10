<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
        $this->load->model('m_setting');
    }

    public function menu()
    {
        $data['active'] = 'setting/menu';
        $data['title'] = 'Menu';
        $data['subview'] = 'setting/menu';
        $data['menu'] = $this->m_setting->get_menu()->result();
        $this->load->view('template/main', $data);
    }

    function users()
    {
        $data['active'] = 'setting/users';
        $data['title'] = 'Users';
        $data['subview'] = 'setting/users';
        $data['users'] = $this->m_setting->get_users()->result();
        $this->load->view('template/main', $data);
    }
}
