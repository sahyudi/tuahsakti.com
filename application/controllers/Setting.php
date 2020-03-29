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
        check_persmission_pages($this->session->userdata('group_id'), 'setting/menu');

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
        check_persmission_pages($this->session->userdata('group_id'), 'setting/menu');
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
        check_persmission_pages($this->session->userdata('group_id'), 'setting/users');
        $data['active'] = 'setting/users';
        $data['title'] = 'Users';
        $data['subview'] = 'setting/users';
        $data['users'] = $this->m_setting->get_users()->result();
        $this->load->view('template/main', $data);
    }

    function create_user()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'setting/users');

        $this->form_validation->set_rules('group', 'Group', 'required|trim');
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[users.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont matches!',
            'min_length' => 'Password to short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[3]|matches[password]');

        if ($this->form_validation->run() == false) {
            $data['groups'] = $this->m_setting->get_group()->result();
            $data['active'] = 'setting/users';
            $data['title'] = 'Form User';
            $data['subview'] = 'setting/user_form';
            $this->load->view('template/main', $data);
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'group_id' => $this->input->post('group'),
                'outlet_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('users', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Congratulations your acount has been created. Please Login</div>');
            redirect('setting/users');
        }
    }

    function delete_user($id)
    {
        check_persmission_pages($this->session->userdata('group_id'), 'setting/users');

        if ($id) {
            $this->db->delete('users', ['id' => $id]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil delete user!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal delete user!</div>');
        }

        redirect('setting/users');
    }

    public function group()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'setting/group');

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
        check_persmission_pages($this->session->userdata('group_id'), 'setting/group');

        $id = $this->input->post('id');
        $data['group_name'] = $this->input->post('group');
        if ($id) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->db->update('groups', $data, ['id' => $id]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success update groups!</div>');
            // log_r($data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('groups', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success add groups!</div>');
        }

        redirect('setting/group');
    }



    public function privelage($id)
    {
        check_persmission_pages($this->session->userdata('group_id'), 'setting/group');

        $data['menu'] = $this->m_setting->get_menu()->result();
        $data['group_id'] = $id;
        $data['active'] = 'setting/privelage';
        $data['title'] = 'Menu';
        $data['subview'] = 'setting/privelage';
        $this->load->view('template/main', $data);
    }
    function update_privelage()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'setting/group');

        $group_id = $this->input->post('group_id');
        $menu = $this->input->post('menu');
        $data_menu = [];
        foreach ($menu as $key => $value) {
            $data_menu[] = [
                'group_id' => $group_id,
                'menu_id' => $value
            ];
        }
        $this->db->trans_begin();

        $this->db->delete('user_access_role', ['group_id' => $group_id]);
        $this->db->insert_batch('user_access_role', $data_menu);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> User role gagal disimpan !</div>');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> User role berhasil disimpan !</div>');
        }
        redirect('setting/group');
    }
}
