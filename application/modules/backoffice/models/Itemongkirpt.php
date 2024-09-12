<?php

//namespace Silemkerma\evapro\models;

/**
 * Description of ModItemOngkirPt
 *
 * @author ibnua
 */
class ItemOngkirPt extends CI_Model{
    
    public $idItem;
    public $idRegistrasi;
    public $ongkir;
    
    function __construct($params=null)
    {
        parent::__construct();
        if (is_array($params)) {
            $this->db->select('*');
            $this->db->from('tbl_item_ongkir_pt');
            $this->db->where('id_registrasi', $params['id_registrasi']);
            $this->db->where('id_item', $params['id_item']);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                $row = $result->row();
                $this->idItem = $row->id_item;
                $this->idRegistrasi = $row->id_registrasi;
                $this->ongkir = $row->ongkir;

            }
        }
    }
    
    public function insert(){
        
    }
    
    public function update(){
        
    }
    
    public function delete(){
        
    }
}
