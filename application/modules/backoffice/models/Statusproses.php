<?php
require_once ('Basemodel.php');





/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:41:50
 */
class StatusProses extends CI_Model implements BaseModel
{

	private $idStatusProses;
	private $namaStatus;

	function __construct($id=NULL)
	{
		parent::__construct();
		if($id != NULL){
			$this->db->select('*');
			$this->db->from('status_proses');
			$this->db->where('id_status_proses',$id);
			$result = $this->db->get();
			if($result->num_rows()>0){
				foreach ($result->result() as $value){
						
					$this->setIdStatusProses($value->id_status_proses);
					$this->setNamaStatus($value->nama_status);
						
				}
			}
		}
	}

	function __destruct()
	{
	}



	public function getIdStatusProses()
	{
		return $this->idStatusProses;
	}

	public function getNamaStatus()
	{
		return $this->namaStatus;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdStatusProses($newVal)
	{
		$this->idStatusProses = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setNamaStatus($newVal)
	{
		$this->namaStatus = $newVal;
	}

	public function delete()
	{
	}

	/**
	 * 
	 * @param row
	 * @param segment
	 */
	public function get($row = Null, $segment = Null)
	{
            $this->db->select('*');
            $this->db->from('status_proses');
            if ($row == NULL && $segment == NULL) {
                return $this->db->count_all_results();
            } elseif ($row == 0 && $segment == 0) {
                return $this->db->get();
            } else {
                return $this->db->get('', $row, $segment);
            }
	}

	/**
	 * 
	 * @param field
	 * @param value
	 */
	public function getBy($field, $value)
	{
	}

	/**
	 * 
	 * @param related
	 * @param field
	 * @param value
	 */
	public function getByRelated($related, $field, $value, $row = Null, $segment = Null)
	{
	}

	public function insert()
	{
	}

	public function update()
	{
	}

}
?>