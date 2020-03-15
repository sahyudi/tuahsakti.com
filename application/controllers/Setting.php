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
        $data['menu'] = $this->m_setting->get_menu()->result();
        $data['parent'] = $this->m_setting->get_parent_menu()->result();

        $data['active'] = 'setting/menu';
        $data['title'] = 'Menu';
        $data['subview'] = 'setting/menu';
        $this->load->view('template/main', $data);
    }

    function get_menu($id)
    {
        if ($id) {
            $data = $this->m_setting->get_menu($id)->row();
            echo json_encode($data);
        }
    }

    function add_menu()
    {
        $id = $this->input->post('id');
        $data = [
            'parent_id' => $this->input->post('parent'),
            'title' => $this->input->post('title'),
            'link' => $this->input->post('link'),
            'icon' => $this->input->post('icon')
        ];

        if ($id) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success update menu!</div>');
            $this->db->update('menus', $data, ['id' => $id]);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success add menu!</div>');
            $this->db->insert('menus', $data);
        }
        redirect('setting/menu');
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
