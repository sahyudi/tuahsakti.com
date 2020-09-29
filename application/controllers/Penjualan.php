<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{
    public $material = 'material';
    public $penjualan = 'penjualan';
    public $penjualan_detail = 'penjualan_detail';

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
        $this->load->model('m_pengadaan');
        $this->load->model('m_penjualan');
        $this->load->model('m_material');
        $this->load->model('m_accounting');
    }

    function index()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'penjualan');
        $data['penjualan'] = $this->m_penjualan->get_data()->result();
        $data['active'] = 'penjualan';
        $data['title'] = 'Penjualan';
        $data['subview'] = 'penjualan/list';
        $this->load->view('template/main', $data);
    }

    function form()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'penjualan');

        $data['material'] = $this->m_material->get_material_penjualan()->result();
        $data['active'] = 'Penjualan';
        $data['title'] = 'Form';
        $data['subview'] = 'penjualan/form';
        $this->load->view('template/main', $data);
    }

    function save()
    {
        $this->db->trans_begin();

        $date = date('Y-m-d H:i:s');
        $nota = 'TR' . time();
        $tanggal = $this->input->post('tanggal');
        $ket = $this->input->post('keterangan');
        $kredit = $this->input->post('kredit');


        $upah = $this->input->post('upah');
        $item = $this->input->post('item');
        $qty = $this->input->post('qty');
        $harga_jual = $this->input->post('harga_jual');

        $data_pengadaan = [
            'transaksi_id' => $nota,
            'tanggal' => $tanggal,
            'keterangan' => $ket,
            'created_at' => $date,
            'created_user' => $user = $this->session->userdata('id')
        ];

        $this->db->insert($this->penjualan, $data_pengadaan);
        $penjualan_id = $this->db->insert_id();

        $detail = [];

        for ($i = 0; $i < count($item); $i++) {
            $quantity =  str_replace(",", "", $qty[$i]);
            $material = $this->m_material->get_material($item[$i])->row();

            $detail[] = [
                'penjualan_id' => $penjualan_id,
                'material_id' => $item[$i],
                'qty' => $quantity,
                'harga_jual' => str_replace(",", "", $harga_jual[$i]),
                'satuan' => $material->satuan,
                'upah' => ($material->upah),
                'ket_detail' => 'Penjualan nomor ' . $nota,
                'stock_updated' => $material->stock - $quantity,
                'created_at' => $date,
                'created_user' => $user = $this->session->userdata('id')
            ];
        }


        // if ($kredit != 0) {
        //     $saldo_hutang = [
        //         'no_nota' => $nota,
        //         'vendor_id' => $vendor,
        //         'saldo' => $saldo = str_replace(",", "", $kredit),
        //         'updated_at' => $date,
        //         'created_user' => $user
        //     ];
        //     $this->db->insert('hutang', $saldo_hutang);
        // }

        $this->db->insert_batch('penjualan_detail', $detail);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        redirect('penjualan');
    }

    function save_payment()
    {
        $this->db->trans_begin();

        $date = date('Y-m-d H:i:s');
        $nota = 'TR' . time();
        $tanggal = date('Y-m-d');
        $ket = $this->input->post('keterangan');
        $lebih_uang = $this->input->post('lebih-uang');
        $tunai = $this->input->post('tunai');
        $total = $this->input->post('total');
        $diskon_global = $this->input->post('diskon_global');

        // status pemeblian
        $tipe_customer = $this->input->post('status');

        // status pemabayaran
        $status_pembayaran = $this->input->post('status_pembayaran');

        //
        $project = $this->input->post('project');

        // detail item

        $item = $this->input->post('item');
        $qty = $this->input->post('qty');
        $dsikon_item = $this->input->post('dsikon');
        $harga_jual = $this->input->post('harga_jual');

        // log_r($status_pembayaran);
        $ket_project = null;
        if ($tipe_customer == 'default') {

            $project = $this->input->post('project');
            if ($status_pembayaran == 'kredit') {
                $customer = $this->input->post('customer_kredit');
                $data_kredit = [
                    'no_nota' => $nota,
                    'customer_id' => $customer,
                    'saldo' => abs(replace_angka($lebih_uang)),
                    'updated_at' => $date,
                    'created_user' => $this->session->userdata('id')
                ];

                $this->db->insert('piutang', $data_kredit);
            } else {
                $customer = $this->input->post('customer_cash');
            }

            $ket_detail = 'Penjualan nomor ' . $nota;
            $data_pengadaan = [
                'customer_name' => ($status_pembayaran == 'kredit') ? get_customer_name($customer) : $customer,
                'tipe_pembayaran' => $status_pembayaran,
                'tipe_customer' => $tipe_customer,
                'transaksi_id' => $nota,
                'tanggal' => $tanggal,
                'total' => $total,
                'diskon' => $diskon_global,
                'keterangan' => $ket,
                'created_at' => $date,
                'created_user' => $user = $this->session->userdata('id')
            ];


            $this->db->insert($this->penjualan, $data_pengadaan);
            $penjualan_id = $this->db->insert_id();

            $detail = [];

            for ($i = 0; $i < count($item); $i++) {
                $quantity =  str_replace(",", "", $qty[$i]);
                $material = $this->m_material->get_material($item[$i])->row();

                $detail[] = [
                    'penjualan_id' => $penjualan_id,
                    'material_id' => $item[$i],
                    'qty' => $quantity,
                    'harga_jual' => replace_angka($harga_jual[$i]),
                    'diskon_item' => replace_angka($dsikon_item[$i]),
                    'satuan' => $material->satuan,
                    'upah' => $material->upah_darat,
                    'ket_detail' => $ket_detail,
                    'stock_updated' => $material->stock - $quantity,
                    'created_at' => $date,
                    'created_user' => $user = $this->session->userdata('id')
                ];
            }
            // log_r($detail);

            $this->db->insert_batch('penjualan_detail', $detail);
        } else {
            $data_pengadaan['project_no'] = $project;
            $ket_detail = "Penjualan nomor " . $nota . " untuk project no " . get_proyek_no($project);


            // log_r($data_pengadaan);
            $this->db->insert($this->proyek, $data_pengadaan);
            $proyek_id = $this->db->insert_id();

            $detail = [];
            for ($i = 0; $i < count($item); $i++) {
                $quantity =  str_replace(",", "", $qty[$i]);
                $material = $this->m_material->get_material($item[$i])->row();

                $detail[] = [
                    'tanggal' => $tanggal,
                    'proyek_id' => $project,
                    'material_id' => $item[$i],
                    'qty' => $quantity,
                    'harga_beli' => str_replace(",", "", $material->harga_beli),
                    'harga' => str_replace(",", "", $harga_jual[$i]),
                    'satuan' => $material->satuan,
                    'ket_detail' => $ket_detail,
                    'created_at' => $date,
                    'created_user' => $user
                ];
            }
            // log_r($detail);

            if ($status_pembayaran  == 'kredit') {
                $saldo_hutang = [
                    'proyek_id' => $proyek_id,
                    'saldo' => abs(str_replace(",", "", $lebih_uang)),
                    'keterangan' => $this->input->post('ket_hutang'),
                    'updated_at' => $date,
                    'created_user' => $user
                ];
                $this->db->insert('hutang_project', $saldo_hutang);
                // $hutang_id = $this->db->insert_id();
            }

            $this->db->insert_batch($this->proyek_detail, $detail);
        }



        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Penjualan nomor ' . $nota . ' gagal disimpan !</div>');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Penjualan nomor ' . $nota . ' berhasil disimpan !</div>');

            // $data['tunai'] = $tunai;
            // $data['kembali'] = $lebih_uang;
            // $data['detail'] = $this->m_pos->get_pos_penjualan($penjualan_id)->result();
            // $this->load->view('pos/invoice', $data);
        }
        redirect('penjualan');
    }
    function get_item($id)
    {
        if ($id) {
            $data = $this->m_material->get_material_penjualan($id)->row();
            echo json_encode($data);
        }
    }

    function delete_detail($id)
    {
        if ($id) {
            $this->db->delete($this->penjualan_detail, ['id' => $id]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil delete penjualan!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal delete penjualan!</div>');
        }
        redirect('penjualan');
    }

    function report()
    {
        check_persmission_pages($this->session->userdata('group_id'), 'penjualan/report');

        $this->form_validation->set_rules('start_date', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('end_date', 'Tanggal Akhir', 'trim|required');
        $this->form_validation->set_rules('material', 'Material', 'trim|required');


        if ($this->form_validation->run() == false) {
            $start_date = null;
            $end_date = null;
            $material = null;
            $data['penjualan'] = $this->m_penjualan->get_report_penjualan()->result();
        } else {
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $material = $this->input->post('material');
            $data['penjualan'] = $this->m_penjualan->get_report_penjualan($start_date, $end_date, $material)->result();
        }
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['material_id'] = $material;
        $data['material'] = $this->m_material->get_material()->result();
        $data['active'] = 'penjualan/report';
        $data['title'] = 'Report Penjualan';
        $data['subview'] = 'penjualan/report';
        $this->load->view('template/main', $data);
    }

    function print_report($start_date, $end_date, $material)
    {
        check_persmission_pages($this->session->userdata('group_id'), 'penjualan/report');
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['material_id'] = $material;
        $data['penjualan'] = $this->m_penjualan->get_report_penjualan($start_date, $end_date, $material)->result();
        $data['subview'] = 'penjualan/print_report';
        $this->load->view('penjualan/print_report', $data);
    }
}
