<?php

class M_accounting extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function get_pengajuan($id = null)
    {
        $this->db->select('A.*, B.nama');
        $this->db->join('item_pengajuan B', 'A.item_id = B.id', 'left');
        // $this->db->group_by('A.id');
        $data = $this->db->get('pengajuan_dana A');
        return $data;
    }

    function get_item($id = null)
    {
        if ($id != 0) {
            $this->db->where('id', $id);
        }
        $data = $this->db->get('item_pengajuan');
        return $data;
    }
}
