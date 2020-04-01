<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pos extends CI_Controller
{
    public $material = 'material';
    public $penjualan = 'penjualan';
    public $penjualan_detail = 'penjualan_detail';

    public $pengadaan = 'pengadaan';
    public $pengadaan_detail = 'pengadaan_detail';
    public $vendor = 'vendor';

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
        // check_persmission_pages($this->session->userdata('group_id'), 'pos');
        $this->load->model('m_pengadaan');
        $this->load->model('m_penjualan');
        $this->load->model('m_material');
        $this->load->model('m_accounting');
        $this->load->model('m_pos');
        $this->load->library('datatables');
    }

    function index()
    {
        // check_persmission_pages($this->session->userdata('group_id'), 'pos');
        $data['active'] = 'Home';
        $data['subview'] = 'pos/penjualan/index';
        $this->load->view('pos/template/main', $data);
    }

    function item_master()
    {
        $data['active'] = 'Item Master';
        $data['material'] = $this->m_material->get_material()->result();
        $data['subview'] = 'pos/material/stock';
        $this->load->view('pos/template/main', $data);
    }

    function form_item($id = null)
    {
        $data['id'] = $id;
        $data['active'] = 'Item Master';
        $data['subview'] = 'pos/material/form_item';
        $this->load->view('pos/template/main', $data);
    }

    function simpan_item_master()
    {
        $this->db->trans_begin();

        $id = $this->input->post('id');
        $harga_beli = $this->input->post('harga_beli');
        $harga_jual = $this->input->post('harga_jual');
        $keterangan = $this->input->post('keterangan');
        $upah_laut = $this->input->post('upah_laut');
        $upah_darat = $this->input->post('upah_darat');

        $id = $this->input->post('id');
        $data = [
            'nama' => $this->input->post('nama'),
            'satuan' => $this->input->post('satuan'),
            'harga_beli' => replace_angka($harga_beli),
            'harga_jual' => replace_angka($harga_jual),
            'keterangan' => replace_angka($keterangan),
            'upah_laut' => replace_angka($upah_laut),
            'upah_darat' => replace_angka($upah_darat),
            'is_active' => 1
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
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Item gagal disimpan !</div>');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Item berhasil disimpan !</div>');
        }
        redirect('pos/item_master');
    }

    function get_item_master($id)
    {
        $data = $this->db->get_where($this->material, ['id' => $id])->row();
        echo json_encode($data);
    }

    function penjualan()
    {
        $date = date('Y-m-d');
        $start_date = $date;
        $end_date = $date;
        $material = 0;

        $data['active'] = 'Penjualan';
        $data['penjualan'] = $this->m_penjualan->get_report_penjualan($start_date, $end_date, $material)->result();
        // $data['penjualan'] = $this->m_penjualan->get_data()->result();
        $data['subview'] = 'pos/penjualan/penjualan';
        $this->load->view('pos/template/main', $data);
    }

    function report_penjualan()
    {
        // check_persmission_pages($this->session->userdata('group_id'), 'penjualan/report');

        $this->form_validation->set_rules('start_date', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('end_date', 'Tanggal Akhir', 'trim|required');
        $this->form_validation->set_rules('material', 'Material', 'trim|required');

        $date = date('Y-m-d');

        if ($this->form_validation->run() == false) {
            $start_date = $date;
            $end_date = $date;
            $material = 0;
        } else {
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $material = $this->input->post('material');
        }
        $data['penjualan'] = $this->m_penjualan->get_report_penjualan($start_date, $end_date, $material)->result();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['material_id'] = $material;
        $data['material'] = $this->m_material->get_material()->result();
        $data['active'] = 'Penjualan';
        $data['subview'] = 'pos/penjualan/report';
        $this->load->view('pos/template/main', $data);
    }

    function print_penjualan($start_date, $end_date, $material)
    {
        // check_persmission_pages($this->session->userdata('group_id'), 'penjualan/report');
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['material_id'] = $material;
        $data['penjualan'] = $this->m_penjualan->get_report_penjualan($start_date, $end_date, $material)->result();
        // $data['subview'] = 'pos/penjualan/print';
        $this->load->view('pos/penjualan/print', $data);
    }

    function get_data_stock()
    {
        $this->datatables->select('A.id, A.upah_darat, A.upah_laut, A.nama, A.satuan, A.harga_jual, B.stock');
        $this->datatables->from('material A');
        $this->datatables->join('stock B', 'A.id = B.material_id');
        echo $this->datatables->generate();
    }

    public function get_item_list_penjualan()
    {
        $id = $this->input->post('id');
        $this->db->select('A.*, B.stock');
        $this->db->join('stock B', 'A.id = B.material_id');
        $this->db->where('B.stock >=', 1);
        if ($id) {
            $this->db->where_not_in('A.id', $id);
        }
        $data = $this->db->get('material A')->result();
        echo json_encode($data);
    }

    public function get_item_list()
    {
        $id = $this->input->post('id');
        $this->db->select('A.*, B.stock');
        $this->db->join('stock B', 'A.id = B.material_id');
        // $this->db->where('B.stock >=', 1);
        if ($id) {
            $this->db->where_not_in('A.id', $id);
        }
        $data = $this->db->get('material A')->result();
        echo json_encode($data);
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

        // status pemeblian
        $tipe_customer = $this->input->post('status');

        // status pemabayaran
        $status_pembayaran = $this->input->post('status_pembayaran');

        //
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

            // log_r($data_kredit);
            $this->db->insert('piutang', $data_kredit);
        } else {
            $customer = $this->input->post('customer_cash');
        }
        // detail item

        $item = $this->input->post('item');
        $qty = $this->input->post('qty');
        $harga_jual = $this->input->post('harga_jual');

        // log_r($status_pembayaran);
        $ket_project = null;
        if ($tipe_customer == 'default') {
            $data_pengadaan['project_no'] = 0;
            $ket_detail = 'Penjualan nomor ' . $nota;
        } else {
            $data_pengadaan['project_no'] = $project;
            $ket_detail = "Penjualan nomor " . $nota . " untuk project no " . get_proyek_no($project);
        }

        $data_pengadaan = [
            'customer_name' => ($status_pembayaran == 'kredit') ? get_customer_name($customer) : $customer,
            'tipe_pembayaran' => $status_pembayaran,
            'tipe_customer' => $tipe_customer,
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
                'harga_jual' => replace_angka($harga_jual[$i]),
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
        redirect('pos');
    }

    function print_invoice($id = null)
    {
        $data['tunai'] = null;
        $data['kembali'] = null;
        $data['detail'] = $this->m_pos->get_pos_penjualan(10)->result();
        $this->load->view('pos/penjualan/invoice', $data);
    }

    function pengadaan()
    {
        $data['pengadaan'] = $this->m_pengadaan->get_data()->result();
        $data['active'] = 'Pengadaan';
        $data['subview'] = 'pos/pengadaan/list_pengadaan';
        $this->load->view('pos/template/main', $data);
    }

    function report_pengadaan()
    {
        // check_persmission_pages($this->session->userdata('group_id'), 'pengadaan/report');

        $this->form_validation->set_rules('start_date', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('end_date', 'Tanggal Akhir', 'trim|required');
        $this->form_validation->set_rules('material', 'Material', 'trim|required');

        $date = date('Y-m-d');
        if ($this->form_validation->run() == false) {
            $start_date = $date;
            $end_date = $date;
            $material = 0;
        } else {
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $material = $this->input->post('material');
        }
        $data['pengadaan'] = $this->m_pengadaan->get_report_pengadaan($start_date, $end_date, $material)->result();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['material_id'] = $material;
        $data['material'] = $this->m_material->get_material()->result();
        $data['active'] = 'Pengadaan';
        $data['subview'] = 'pos/pengadaan/report';
        $this->load->view('pos/template/main', $data);
    }

    function print_pengadaan($start_date, $end_date, $material)
    {
        // check_persmission_pages($this->session->userdata('group_id'), 'pengadaan/report');
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['material_id'] = $material;
        $data['pengadaan'] = $this->m_pengadaan->get_report_pengadaan($start_date, $end_date, $material)->result();
        $this->load->view('pos/pengadaan/print', $data);
    }

    function tambah_pengadaan()
    {
        $data['surat_jalan'] = $this->db->get_where('pendanaan', ['status' => 1])->result();
        $data['material'] = $this->m_material->get_material()->result();
        $data['active'] = 'pengadaan';
        $data['subview'] = 'pos/pengadaan/form_pengadaan';
        $this->load->view('pos/template/main', $data);
    }

    function get_item_pengadaan($id)
    {
        if ($id) {
            $data = $this->m_material->get_material($id)->row();
            echo json_encode($data);
        }
    }

    function simpan_pengadaan()
    {
        $this->db->trans_begin();

        $date = date('Y-m-d H:i:s');
        $tanggal = $this->input->post('tanggal');
        $nota = 'PE' . time();
        $vendor = 1;
        $ket = $this->input->post('keterangan');
        $surat_jalan = $this->input->post('surat_jalan');
        // $kredit = $this->input->post('kredit');

        // detail item
        $item = $this->input->post('item');
        $qty = $this->input->post('qty');
        $harga_beli = 0;

        $data_pengadaan = [
            'surat_jalan' => $surat_jalan,
            'no_nota' => $nota,
            'vendor_id' => $vendor,
            'tanggal' => $tanggal,
            'keterangan' => $ket,
            'created_at' => $date,
            'created_user' => $user = $this->session->userdata('id')
        ];

        // log_r($data_pengadaan);
        $this->db->insert($this->pengadaan, $data_pengadaan);
        $pengadaan_id = $this->db->insert_id();

        $detail = [];
        for ($i = 0; $i < count($item); $i++) {
            $quantity =  str_replace(",", "", $qty[$i]);
            $material = $this->m_material->get_material($item[$i])->row();

            $detail[] = [
                'pengadaan_id' => $pengadaan_id,
                'material_id' => $item[$i],
                'qty' => replace_angka($quantity),
                'harga_beli' => $material->harga_beli,
                'satuan' => $material->satuan,
                'upah' => $material->upah_laut,
                'ket_detail' => 'Pengadaan nomor ' . $nota,
                'stock_updated' => $quantity + $material->stock,
                'created_at' => $date
            ];
        }

        $this->db->insert_batch('pengadaan_detail', $detail);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Pengadaan dengan surat jalan ' . $surat_jalan . ' gagal disimpan !</div>');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Pengadaan dengan surat jalan ' . $surat_jalan . ' berhasil disimpan !</div>');
        }
        redirect('pos/pengadaan');
    }

    function get_project()
    {
        $data = $this->db->get_where('proyek', ['status' => 0, 'jenis' => 1])->result();
        echo json_encode($data);
    }

    function get_customer()
    {
        $data = $this->db->get('customer')->result();
        echo json_encode($data);
    }

    function simpan_customer()
    {
        $this->db->trans_begin();

        $data = [
            'nama' => $this->input->post('nama'),
            'no_telp' => $this->input->post('no_telp'),
            'alamat' => $this->input->post('alamat'),
            'is_active' => ($this->input->post('is_active')) ? $this->input->post('is_active') : 0,
        ];
        if ($this->input->post('id')) {
            $this->db->update('customer', $data, ['id' => $this->input->post('id')]);
        } else {
            $this->db->insert('customer', $data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        echo json_encode(1);
    }

    function update_character()
    {
        $this->db->trans_begin();


        $data = $this->db->query("SELECT CONCAT('ALTER TABLE `', t.`TABLE_SCHEMA`, '`.`', t.`TABLE_NAME`,
        '` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;') as stmt 
       FROM `information_schema`.`TABLES` t
       WHERE 1
       AND t.`TABLE_SCHEMA` = 'db_tuahsakti'")->result();
        foreach ($data as $key => $value) {
            $this->db->query("{$value->stmt}");
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_r('gagal');
        } else {
            $this->db->trans_commit();
            log_r('berhasil');
        }
    }

    function report_master()
    {
        // check_persmission_pages($this->session->userdata('group_id'), 'material/report_stock');
        $this->form_validation->set_rules('start_date', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('end_date', 'Tanggal Akhir', 'trim|required');
        $this->form_validation->set_rules('material', 'Material', 'trim|required');

        $date = date('Y-m-d');
        if ($this->form_validation->run() == false) {
            $start_date = $date;
            $end_date = $date;
            $material = 0;
        } else {
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $material = $this->input->post('material');
        }
        $data['kartu_stock'] = $this->m_material->get_report_stock($start_date, $end_date, $material)->result();
        // log_r($data['kartu_stock']);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['material_id'] = $material;
        $data['material'] = $this->m_material->get_material()->result();
        $data['active'] = 'Report';
        $data['subview'] = 'pos/material/report';
        $this->load->view('pos/template/main', $data);
    }

    function print_report_master($start_date, $end_date, $material_id)
    {
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['material_id'] = $material_id;
        $data['kartu_stock'] = $this->m_material->get_report_stock($start_date, $end_date, $material_id)->result();
        $this->load->view('pos/material/print', $data);
    }
}
