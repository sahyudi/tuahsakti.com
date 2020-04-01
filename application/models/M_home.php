<?php

class M_home extends CI_Model
{
    public $customer = 'customer';
    public $penjualan = 'penjualan';
    public $project = 'proyek';

    function __construct()
    {
        parent::__construct();
    }

    public function get_member($id = null)
    {
        if ($id) {
            $this->db->where('id', $id);
        }
        $data = $this->db->get($this->customer);
        return $data;
    }

    function get_penjualan()
    {
        return $this->db->get($this->penjualan);
    }

    function get_projec()
    {
        return $this->db->get($this->project);
    }
}
