<?php
require_once ('basemodel.php');





/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:41:50
 */
class StatusProses extends CI_Model implements BaseModel
{

	private $idStatusProses;
	private $namaStatus;

	function __construct()
	{
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