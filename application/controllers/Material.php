<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Material extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
        $this->load->model('m_material');
    }

    public function index()
    {
        $data['material'] = $this->m_material->get_material()->result();
        $data['active'] = 'material';
        $data['title'] = 'Material';
        $data['subview'] = 'material/stock';
        $this->load->view('template/main', $data);
    }

    function add()
    {
        $this->db->trans_begin();

        $id = $this->input->post('id');
        $data = [
            'nama' => $this->input->post('nama'),
            'satuan' => $this->input->post('satuan'),
            'harga_beli' => $this->input->post('harga_beli'),
            'harga_jual' => $this->input->post('harga_jual'),
            'keterangan' => $this->input->post('keterangan'),
            'upah_laut' => $this->input->post('upah_laut'),
            'upah_darat' => $this->input->post('upah_darat'),
        ];

        if ($id) {
            $data['update_at'] = date('Y-m-d H:i:s');
            $this->db->update('material', $data, ['id' => $id]);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_user'] = $this->session->userdata('id');
            $this->db->insert('material', $data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        redirect('material');
    }


    function delete($id)
    {
        if ($id) {
            $this->db->delete('material', ['id' => $id]);
        }
        redirect('material');
    }


    function get_data($id)
    {
        if ($id) {
            $data = $this->m_material->get_material($id)->row();
            echo json_encode($data);
        }
    }

    function kartu_stock()
    {
        $this->form_validation->set_rules('start_date', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('end_date', 'Tanggal Akhir', 'trim|required');
        $this->form_validation->set_rules('material', 'Material', 'trim|required');


        if ($this->form_validation->run() == false) {
            $data['kartu_stock'] = null;
        } else {
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $material = $this->input->post('material');
            $data['kartu_stock'] = $this->m_material->get_kartu_stock($start_date, $end_date, $material)->result();
        }
        $data['material'] = $this->m_material->get_material()->result();
        $data['active'] = 'material/kartu_stock';
        $data['title'] = 'Material';
        $data['subview'] = 'material/kartu_stock';
        $this->load->view('template/main', $data);
    }

    function report_stock()
    {
        $this->form_validation->set_rules('start_date', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('end_date', 'Tanggal Akhir', 'trim|required');
        $this->form_validation->set_rules('material', 'Material', 'trim|required');


        if ($this->form_validation->run() == false) {
            $data['kartu_stock'] = $this->m_material->get_report_stock()->result();
            $start_date = '';
            $end_date = '';
            $material = '';
        } else {
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $material = $this->input->post('material');
            $data['kartu_stock'] = $this->m_material->get_report_stock($start_date, $end_date, $material)->result();
        }
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['material_id'] = $material;
        $data['material'] = $this->m_material->get_material()->result();
        $data['active'] = 'material/report';
        $data['title'] = 'Report Material';
        $data['subview'] = 'material/report';
        $this->load->view('template/main', $data);
    }

    function print_report($start_date, $end_date, $material_id)
    {

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['material_id'] = $material_id;
        $data['kartu_stock'] = $this->m_material->get_report_stock($start_date, $end_date, $material_id)->result();
        $this->load->view('material/print_report', $data);
    }
}
