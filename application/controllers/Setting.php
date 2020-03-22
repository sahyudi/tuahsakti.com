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

    function deleteMenu($id)
    {
        if ($id) {
            $data = $this->db->delete('menus', ['id' => $id]);
            if ($data) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success delete menu!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">failed delete menu!</div>');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data is not found!</div>');
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


    public function group()
    {
        $data['groups'] = $this->m_setting->get_group()->result();

        $data['active'] = 'setting/group';
        $data['title'] = 'User Groups';
        $data['subview'] = 'setting/group';
        $this->load->view('template/main', $data);
    }

    function get_group($id)
    {
        $data =  $this->m_setting->get_group($id)->row();
        echo json_encode($data);
    }

    function add_group()
    {
        $id = $this->input->post('id');
        $data['group_name'] = $this->input->post('group');
        if ($id) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->db->update('groups', $data, ['id' => $id]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success update groups!</div>');
            log_r($data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('groups', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success add groups!</div>');
        }

        redirect('setting/group');
    }

    public function privelage()
    {
        $data['menu'] = $this->m_setting->get_menu()->result();

        $data['active'] = 'setting/privelage';
        $data['title'] = 'Menu';
        $data['subview'] = 'setting/privelage';
        $this->load->view('template/main', $data);
    }
}
