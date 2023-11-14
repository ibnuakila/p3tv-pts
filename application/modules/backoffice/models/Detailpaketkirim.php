<?php

require_once ('Detailpakethibah.php');

//use ;
/**
 * @author siti
 * @version 1.0
 * @created 18-Jun-2017 11:52:08
 */
class DetailPaketKirim extends DetailPaketHibah {

    function __construct($id='') {
        parent::__construct($id);
        if($id != NULL){
                $this->db->select('*');         
                $this->db->from('tbl_detail_kirim');
                $this->db->where('id',$id);
                $result = $this->db->get();
                if($result->num_rows()>0){
                    foreach ($result->result() as $value){
                        
                    }
                }
            }
    }

    function __destruct() {
        
    }

    public function delete() {
        
    }

    /**
     * 
     * @param row
     * @param segment    segment
     */
    public function get($row = Null, $segment = Null) {
        
    }

    /**
     * 
     * @param field
     * @param value    value
     */
    public function getBy($field, $value) {
        
    }

    /**
     * 
     * @param related
     * @param field
     * @param value    value
     * @param row
     * @param segment
     */
    public function getByRelated($related, $field, $value, $row = Null, $segment = Null) {
        
    }

    public function insert() {
        $data = array( 'id_detail_paket_hibah'=>  $this->getId(),
            'id_paket'=> $this->getIdPaket(),
            'id_item' => $this->getIdItem(),
            'merk' => $this->getMerk(),
            'type' => $this->getType(),
            'volume' => $this->getVolume(),
            'berat' => $this->getBerat(),
            'pajak' => $this->getPajak(),
            'biaya_kirim' => $this->getBiayaKirim(),
            'onkir' => $this->getOnkir(),
            'hps' => $this->getHps(),
            'kdpti' => $this->getKdPti(),
            'kota' => $this->getKota(),
            'kontrak_adendum' =>$this->getKontrakAdendum()
            );
        $result = $this->db->insert('tbl_detail_paket_kirim', $data);
        $this->db->select_max('id');
        $this->db->from('tbl_detail_paket_hibah');
        $rec = $this->db->get()->row();
        $this->setId($rec->id);
        return $result;
    }

    public function update() {
        $data = array( 'id_paket'=> $this->getIdPaket(),
            'id_item' => $this->getIdItem(),
            'merk' => $this->getMerk(),
            'type' => $this->getType(),
            'volume' => $this->getVolume(),
            'berat' => $this->getBerat(),
            'pajak' => $this->getPajak(),
            'biaya_kirim' => $this->getBiayaKirim(),
            'onkir' => $this->getOnkir(),
            'hps' => $this->getHps(),
            'kdpti' => $this->getKdPti(),
            'kota' => $this->getKota(),
            'kontrak_adendum' =>$this->getKontrakAdendum()
            );
        $this->db->where('id_detail_paket_hibah',  $this->getId());
        return $this->db->update('tbl_detail_paket_kirim', $data);
    }

}

?>