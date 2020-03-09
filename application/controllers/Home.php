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
    }

    public function index()
    {
        $data['active'] = 'home';
        $data['title'] = 'Home';
        $data['subview'] = 'home/index';
        $this->load->view('template/main', $data);
    }
}
