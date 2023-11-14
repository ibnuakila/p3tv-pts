<?php

require_once ('Basemodel.php');

//use ;
/**
 * @author siti
 * @version 1.0
 * @created 18-Jun-2017 11:52:08
 */
class DetailKirim extends CI_Model implements BaseModel{
	private $id;
	private $idDetailPaketHibah;
	private $idKirim;
	private $jumlah;


    function __construct($id='') {
        parent::__construct($id);
        if($id != NULL){
                $this->db->select('*');         
                $this->db->from('tbl_detail_kirim');
                $this->db->where('id',$id);
                $result = $this->db->get();
                if($result->num_rows()>0){
                    foreach ($result->result() as $value){
                        $this->id = $value->id;
                        $this->idDetailPaketHibah = $value->id_detail_paket_hibah;
                        $this->idKirim = $value->id_kirim;
                        $this->jumlah = $value->jumlah;
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
        $this->db->select('*');         
        $this->db->from('tbl_detail_kirim');
        $this->db->where($field, $value);
        $result = $this->db->get();
        if($result->num_rows()>0){
            foreach ($result->result() as $row){
                $this->id = $row->id;
                $this->idDetailPaketHibah = $row->id_detail_paket_hibah;
                $this->idKirim = $row->id_kirim;
                $this->jumlah = $row->jumlah;
            }
        }
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
        $this->db->select('*');
        $this->db->from('tbl_detail_kirim');
        
        $this->db->where($related . '.' . $field, $value);
        if ($row == NULL && $segment == NULL) {
            return $this->db->count_all_results();
        } elseif ($row == 0 && $segment == 0) {
            return $this->db->get();
        } else {
            return $this->db->get('', $row, $segment);
        }
    }

    public function insert() {
        
    }

    public function update() {
        
    }

	public function getId()
	{
		return $this->id;
	}

	public function getIdDetailPaketHibah()
	{
		return $this->idDetailPaketHibah;
	}

	public function getIdKirim()
	{
		return $this->idKirim;
	}

	public function getJumlah()
	{
		return $this->jumlah;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setId($newVal)
	{
		$this->id = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdDetailPaketHibah($newVal)
	{
		$this->idDetailPaketHibah = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdKirim($newVal)
	{
		$this->idKirim = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setJumlah($newVal)
	{
		$this->jumlah = $newVal;
	}

}

?>