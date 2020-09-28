<?php

class M_material extends CI_Model
{

    public $material_stock = 'material_stock';
    function __construct()
    {
        parent::__construct();
    }

    public function get_material($id = null)
    {
        $this->db->select('*');
        if ($id != 0) {
            $this->db->where('id', $id);
        }
        $data = $this->db->get($this->material_stock);
        return $data;
    }


    function get_material_penjualan($id = null)
    {
        $this->db->select('*');
        $this->db->where('stock >=', 1);
        if ($id) {
            $this->db->where('id', $id);
        }
        $data = $this->db->get($this->material_stock);
        return $data;
    }

    function get_kartu_stock($start_date, $end_date, $material_id = null)
    {
        $this->db->select(" ('in')AS tipe,
                                B1.tanggal AS tanggal,
                                A1.ket_detail AS ket,
                                C1.nama AS material,
                                A1.qty AS quantity,
                                A1.satuan AS satuan,
                                A1.harga_beli AS harga,
                                A1.stock_updated AS stockUpdate
                            ");
        $this->db->from("pengadaan_detail A1");
        $this->db->join("pengadaan B1", "A1.pengadaan_id = B1.id");
        $this->db->join("material C1", "A1.material_id = C1.id");
        $this->db->where("B1.tanggal >= ", $start_date);
        $this->db->where("B1.tanggal <= ", $end_date);
        $this->db->where("A1.material_id", $material_id);
        $query_1 = $this->db->get_compiled_select();


        $this->db->select(" ('out')AS tipe,
                                B2.tanggal AS tanggal,
                                A2.ket_detail AS ket,
                                C2.nama AS material,
                                A2.qty AS quantity,
                                A2.satuan AS satuan,
                                A2.harga_jual AS harga,
                                A2.stock_updated AS stockUpdate
                            ");
        $this->db->from("penjualan_detail A2");
        $this->db->join("penjualan B2", "A2.penjualan_id = B2.id");
        $this->db->join("material C2", "A2.material_id = C2.id");
        $this->db->where("B2.tanggal >= ", $start_date);
        $this->db->where("B2.tanggal <= ", $end_date);
        $this->db->where("A2.material_id", $material_id);
        $query_2 = $this->db->get_compiled_select();

        $final_query = $this->db->query($query_1 . ' UNION ' . $query_2);
        // $result = $final_query->result();
        return $final_query;
    }

    function get_report_stock($start_date = null, $end_date = null, $material_id = null)
    {
        $this->db->select(" ('in')AS tipe,
                                B1.tanggal AS tanggal,
                                ('Pengadaan') AS nama,
                                A1.ket_detail AS ket,
                                C1.nama AS material,
                                A1.qty AS quantity,
                                A1.satuan AS satuan,
                                A1.harga_beli AS harga,
                                A1.upah as upah,
                                A1.stock_updated AS stockUpdate
                            ");
        $this->db->from("pengadaan_detail A1");
        $this->db->join("pengadaan B1", "A1.pengadaan_id = B1.id");
        $this->db->join("material C1", "A1.material_id = C1.id");
        if ($start_date) {
            $this->db->where("B1.tanggal >= ", $start_date);
        }
        if ($end_date) {
            $this->db->where("B1.tanggal <= ", $end_date);
        }

        if ($material_id) {
            $this->db->where("A1.material_id", $material_id);
        }
        $query_1 = $this->db->get_compiled_select();


        $this->db->select(" ('out')AS tipe,
                                B2.tanggal AS tanggal,
                                B2.customer_name AS nama,
                                A2.ket_detail AS ket,
                                C2.nama AS material,
                                A2.qty AS quantity,
                                A2.satuan AS satuan,
                                A2.harga_jual AS harga,
                                A2.upah AS upah,
                                A2.stock_updated AS stockUpdate
                            ");
        $this->db->from("penjualan_detail A2");
        $this->db->join("penjualan B2", "A2.penjualan_id = B2.id");
        $this->db->join("material C2", "A2.material_id = C2.id");
        if ($start_date) {
            $this->db->where("B2.tanggal >= ", $start_date);
        }
        if ($end_date) {
            $this->db->where("B2.tanggal <= ", $end_date);
        }

        if ($material_id) {
            $this->db->where("A2.material_id", $material_id);
        }
        $this->db->order_by('tanggal', 'asc');
        $query_2 = $this->db->get_compiled_select();

        $final_query = $this->db->query($query_1 . ' UNION ' . $query_2);
        // $result = $final_query->result();
        return $final_query;
    }
}
