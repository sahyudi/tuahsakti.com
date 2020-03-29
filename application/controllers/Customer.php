<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
    public $customer = 'customer';
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
    }

    public function index()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'customer');
        $data['active'] = 'customer';
        $data['title'] = 'Customer';
        $data['customer'] = $this->db->get($this->customer)->result();
        $data['subview'] = 'customer/list';
        $this->load->view('template/main', $data);;
    }

    function add()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'customer');
        $this->db->trans_begin();

        $data = [
            'nama' => $this->input->post('nama'),
            'no_telp' => $this->input->post('no_telp'),
            'alamat' => $this->input->post('alamat'),
            'is_active' => ($this->input->post('is_active')) ? $this->input->post('is_active') : 0,
        ];
        if ($this->input->post('id')) {
            $this->db->update($this->customer, $data, ['id' => $this->input->post('id')]);
        } else {
            $this->db->insert($this->customer, $data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        redirect('customer');
    }


    function delete($id)
    {
        check_persmission_pages($this->session->userdata('group_id'), 'customer');
        if ($id) {
            $this->db->trans_begin();
            $this->db->delete($this->customer, ['id' => $id]);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
            redirect('customer');
        }
    }

    function get_data($id)
    {
        if ($id) {
            $data = $this->db->get_where($this->customer, ['id' => $id])->row();
            echo json_encode($data);
        }
    }
}
