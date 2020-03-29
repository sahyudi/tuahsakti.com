<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendor extends CI_Controller
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
        check_persmission_pages($this->session->userdata('group_id'), 'vendor');
        $data['active'] = 'vendor';
        $data['title'] = 'Vendor';
        $data['vendor'] = $this->db->get('vendor')->result();
        $data['subview'] = 'vendor/list';
        $this->load->view('template/main', $data);;
    }

    function add()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'vendor');
        $this->db->trans_begin();

        $data = [
            'nama' => $this->input->post('nama'),
            'no_telp' => $this->input->post('no_telp'),
            'alamat' => $this->input->post('alamat'),
            'is_active' => ($this->input->post('is_active')) ? $this->input->post('is_active') : 0,
        ];
        if ($this->input->post('id')) {
            $this->db->update('vendor', $data, ['id' => $this->input->post('id')]);
        } else {
            $this->db->insert('vendor', $data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        redirect('vendor');
    }


    function delete($id)
    {
        check_persmission_pages($this->session->userdata('group_id'), 'vendor');
        if ($id) {
            $this->db->trans_begin();
            $this->db->delete('vendor', ['id' => $id]);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
            redirect('vendor');
        }
    }

    function get_data($id)
    {
        if ($id) {
            $data = $this->db->get_where('vendor', ['id' => $id])->row();
            echo json_encode($data);
        }
    }
}
