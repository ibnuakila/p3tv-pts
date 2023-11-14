<?php

//namespace models;

/**
 * @author LENOVO
 * @version 1.0
 * @created 30-Jun-2020 7:24:42 PM
 */
class JenisUsulan extends CI_Model {

    private $aktif;
    private $jnsUsulan;
    private $nmUsulan;

    function __construct($id = NULL) {
        parent::__construct();
        if ($id != NULL) {
            $this->db->select('*');
            $this->db->from('jenis_usulan');
            $this->db->where('jns_usulan', $id);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                $row = $result->row();
                $this->jnsUsulan = $row->jns_usulan;
                $this->nmUsulan = $row->nm_usulan;
                $this->aktif = $row->aktif;
            }
        }
    }

    function __destruct() {
        
    }

    public function getAktif() {
        return $this->aktif;
    }

    public function getJnsUsulan() {
        return $this->jnsUsulan;
    }

    public function getNmUsulan() {
        return $this->nmUsulan;
    }

    /**
     * 
     * @param newVal
     */
    public function setAktif($newVal) {
        $this->aktif = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setJnsUsulan($newVal) {
        $this->jnsUsulan = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setNmUsulan($newVal) {
        $this->nmUsulan = $newVal;
    }

}

?>