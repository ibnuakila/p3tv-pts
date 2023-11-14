<?php


/**
 * Description of Laporankemajuan
 *
 * @author ibnua
 */
class Laporankemajuan extends CI_Model{
    
    public $id;
    public $filePath;
    public $uploadDate;
    public $idRegistrasi;
            
    function __construct($id=null) {
        parent::__construct();
        if ($id != NULL) {
            $this->db->select('*');
            $this->db->from('laporan_kemajuan');
            $this->db->where('id_registrasi', $id);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $value) {
                    $this->id = $value->id;
                    $this->idRegistrasi = $value->id_registrasi;                   
                    $this->filePath = $value->filepath;
                    $this->uploadDate = $value->upload_date;                   
                    
                }
            }
        }
    }
}
