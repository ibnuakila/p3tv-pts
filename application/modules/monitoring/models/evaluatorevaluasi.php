<?php
require_once ('evaluator.php');
require_once ('basemodel.php');





/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:46:41
 */
class EvaluatorEvaluasi extends CI_Model implements BaseModel
{

	private $id;
	private $idEvaluasi;
	private $idEvaluator;
	private $objEvaluator;

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

	public function getIdEvaluator()
	{
		return $this->idEvaluator;
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
	public function setIdEvaluator($newVal)
	{
		$this->idEvaluator = $newVal;
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