<?php
require_once ('basemodel.php');





/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:40:01
 */
class Prodi extends CI_Model implements BaseModel
{

	private $idProdi;
	private $jenjang;
	private $kdProdi;
	private $nmProdi;
	private $pohonIlmu;
	private $rumpun;

	function __construct()
	{
	}

	function __destruct()
	{
	}



	public function getIdProdi()
	{
		return $this->idProdi;
	}

	public function getJenjang()
	{
		return $this->jenjang;
	}

	public function getKdProdi()
	{
		return $this->kdProdi;
	}

	public function getNmProdi()
	{
		return $this->nmProdi;
	}

	public function getPohonIlmu()
	{
		return $this->pohonIlmu;
	}

	public function getRumpun()
	{
		return $this->rumpun;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdProdi($newVal)
	{
		$this->idProdi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setJenjang($newVal)
	{
		$this->jenjang = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setKdProdi($newVal)
	{
		$this->kdProdi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setNmProdi($newVal)
	{
		$this->nmProdi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setPohonIlmu($newVal)
	{
		$this->pohonIlmu = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setRumpun($newVal)
	{
		$this->rumpun = $newVal;
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