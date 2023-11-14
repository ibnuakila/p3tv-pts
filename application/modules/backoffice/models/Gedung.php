<?php
require_once ('Basemodel.php');




//use ;
/**
 * @author akil
 * @version 1.0
 * @created 15-Jul-2016 11:21:39
 */
class Gedung extends CI_Model implements BaseModel
{

	private $kdGedung;
	private $nmGedung;

	function __construct($id='')
	{
		parent::__construct();
		if($id != ''){
			$sql = "SELECT * FROM tbl_item_gedung WHERE kd_gedung='".$id."'";
			$result = $this->db->query($sql);
			if($result->num_rows()>0){
				foreach ($result->result('array') as $value) {
					$this->setKdGedung($value['kd_gedung']);
					$this->setNmGedung($value['nm_gedung']);
					
						
				}
			}
		}
	}

	function __destruct()
	{
	}



	public function getKdGedung()
	{
		return $this->kdGedung;
	}

	public function getNmGedung()
	{
		return $this->nmGedung;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setKdGedung($newVal)
	{
		$this->kdGedung = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setNmGedung($newVal)
	{
		$this->nmGedung = $newVal;
	}

	public function delete()
	{
	}

	/**
	 * 
	 * @param row
	 * @param segment    segment
	 */
	public function get($row = Null, $segment = Null)
	{
	}

	/**
	 * 
	 * @param field
	 * @param value    value
	 */
	public function getBy($field, $value)
	{
	}

	/**
	 * 
	 * @param related
	 * @param field
	 * @param value    value
	 * @param row
	 * @param segment
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