<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pos extends CI_Controller
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
        $this->load->model('m_pos');
        $this->load->library('datatables');
    }

    function index()
    {
        $data['material'] = $this->m_material->get_material()->result();
        $this->load->view('pos/index', $data);
    }

    function get_data_stock()
    {
        $this->datatables->select('A.upah_darat, A.upah_laut, A.nama, A.satuan, A.harga_jual, B.stock');
        $this->datatables->from('material A');
        $this->datatables->join('stock B', 'A.id = B.material_id');
        // echo $this->db->last_query();
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
        $lebih_uang = $this->input->post('lebih-uang');
        $tunai = $this->input->post('tunai');


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

        log_r($data_pengadaan);
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
                'upah' => $upah[$i],
                'ket_detail' => 'Penjualan nomor ' . $nota,
                'stock_updated' => $material->stock - $quantity,
                'created_at' => $date,
                'created_user' => $user = $this->session->userdata('id')
            ];
        }

        // log_r($data_pengadaan);

        // if ($kredit != 0) {
        //     $saldo_hutang = [
        //         'no_nota' => $nota,
        //         'vendor_id' => $vendor,
        //         'saldo' => $saldo = str_replace(",", "", $kredit),
        //         'updated_at' => $date,
        //         'created_user' => $user
        //     ];
        //     $this->db->insert('saldo_hutang', $saldo_hutang);
        // }

        $this->db->insert_batch('penjualan_detail', $detail);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            redirect('pos');
        } else {
            $this->db->trans_commit();
            $data['tunai'] = $tunai;
            $data['kembali'] = $lebih_uang;
            $data['detail'] = $this->m_pos->get_pos_penjualan($penjualan_id)->result();
            $this->load->view('pos/invoice', $data);
        }
    }

    function print_invoice($id = null)
    {
        $data['tunai'] = null;
        $data['kembali'] = null;
        $data['detail'] = $this->m_pos->get_pos_penjualan(10)->result();
        // log_r($data['detail']);
        $this->load->view('pos/invoice', $data);
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
