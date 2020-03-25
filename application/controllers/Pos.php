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
        $this->load->model('m_pengadaan');
        $this->load->model('m_penjualan');
        $this->load->model('m_material');
        $this->load->model('m_accounting');
        $this->load->model('m_pos');
        $this->load->library('datatables');
    }

    function index()
    {
        $data['active'] = 'Home';
        $data['material'] = $this->m_material->get_material()->result();
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
        $data = [
            'nama' => $this->input->post('nama'),
            'satuan' => $this->input->post('satuan'),
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
        $data['active'] = 'Penjualan';
        $data['penjualan'] = $this->m_penjualan->get_data()->result();
        $data['subview'] = 'pos/penjualan/penjualan';
        $this->load->view('pos/template/main', $data);
    }

    function get_data_stock()
    {
        $this->datatables->select('A.id, A.upah_darat, A.upah_laut, A.nama, A.satuan, A.harga_jual, B.stock');
        $this->datatables->from('material A');
        $this->datatables->join('stock B', 'A.id = B.material_id');
        echo $this->datatables->generate();
    }

    public function get_item_list()
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

    function save_payment()
    {
        $this->db->trans_begin();

        $date = date('Y-m-d H:i:s');
        $nota = 'TR' . time();
        $tanggal = date('Y-m-d');
        $ket = $this->input->post('keterangan');
        // $lebih_uang = $this->input->post('lebih-uang');
        // $tunai = $this->input->post('tunai');


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
                'upah' => $material->upah_darat,
                // 'upah' => str_replace(",", "", $upah[$i]),
                'ket_detail' => 'Penjualan nomor ' . $nota,
                'stock_updated' => $material->stock - $quantity,
                'created_at' => $date,
                'created_user' => $user = $this->session->userdata('id')
            ];
        }

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

    function tambah_pengadaan()
    {
        $data['material'] = $this->m_material->get_material()->result();
        $data['active'] = 'pengadaan';
        $data['subview'] = 'pos/pengadaan/form_pengadaan';
        $this->load->view('pos/template/main', $data);
    }

    function simpan_pengadaan()
    {
        $this->db->trans_begin();

        // data pengadaan
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
                'qty' => str_replace(",", "", $quantity),
                'harga_beli' => ($material->harga_beli) ? $material->harga_beli : 0,
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
}
