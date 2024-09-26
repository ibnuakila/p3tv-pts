<?php

//namespace models;

/**
 * @author LENOVO
 * @version 1.0
 * @created 30-Jun-2020 7:24:42 PM
 */
class JenisEvaluasi extends CI_Model {

    private $idJnsEvaluasi;    
    private $namaEvaluasi;

    function __construct($id = NULL) {
        parent::__construct();
        if ($id != NULL) {
            $this->db->select('*');
            $this->db->from('jenis_evaluasi');
            $this->db->where('id_jns_evaluasi', $id);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                $row = $result->row();
                $this->idJnsEvaluasi = $row->id_jns_evaluasi;
                $this->namaEvaluasi = $row->nama_evaluasi;
                
            }
        }
    }

    function __destruct() {
        
    }

    
    public function getIdJnsEvaluasi() {
        return $this->idJnsEvaluasi;
    }

    public function getNamaEvaluasi() {
        return $this->namaEvaluasi;
    }

    
    /**
     * 
     * @param newVal
     */
    public function setIdJnsEvaluasi($newVal) {
        $this->idJnsEvaluasi = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setNamaEvaluasi($newVal) {
        $this->namaEvaluasi = $newVal;
    }

}

?>