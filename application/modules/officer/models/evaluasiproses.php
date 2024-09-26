<?php
require_once ('evaluasi.php');
require_once ('proses.php');
require_once ('basemodel.php');





/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:42:08
 */
class EvaluasiProses extends CI_Model implements BaseModel
{

	private $id;
	private $idEvaluasi;
	private $idProses;
	private $objEvaluasi;
	private $objProses;

	function __construct()
	{
	}

	function __destruct()
	{
	}



	public function getId()
	{
		return $this->id;
	}

	public function getIdEvaluasi()
	{
		return $this->idEvaluasi;
	}

	public function getIdProses()
	{
		return $this->idProses;
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
	public function setIdEvaluasi($newVal)
	{
		$this->idEvaluasi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdProses($newVal)
	{
		$this->idProses = $newVal;
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