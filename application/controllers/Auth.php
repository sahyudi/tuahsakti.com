<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->load->view('auth/login');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('users', ['email' => $email])->row_array();

        if ($user) {
            if ($user['is_active'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'id' => $user['id'],
                        'email' => $user['email'],
                        'group_id' => $user['group_id']
                    ];

                    $this->session->set_userdata($data);
                    if ($user['group_id'] == 1) {
                        redirect('home');
                    } else {
                        redirect('book');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password!</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">This email is has been not activated!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Email anda tidak terdaftar!</div>');
            redirect('auth');
        }
    }

    public function registration()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont matches!',
            'min_length' => 'Password to short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[3]|matches[password]');

        if ($this->form_validation->run() == false) {
            $this->load->view('auth/register');
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'group_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('users', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Congratulations your acount has been created. Please Login</div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('group_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logout!</div>');
        redirect('auth');
    }

    public function forgot()
    {
        $data['title'] = 'Forgot Password';
        $this->load->view('auth/header-auth', $data);
        $this->load->view('auth/forgot-password');
        $this->load->view('auth/footer-auth');
    }

    public function reset()
    {
        $data['title'] = 'Reset Password';
        $this->load->view('auth/header-auth', $data);
        $this->load->view('auth/reset-password');
        $this->load->view('auth/footer-auth');
    }

    public function blocked()
    {
        $data['title'] = 'Page Not Found';
        $this->load->view('auth/blocked');
    }
}
