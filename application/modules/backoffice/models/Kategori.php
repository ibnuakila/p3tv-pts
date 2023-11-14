<?php
require_once ('Basemodel.php');




//use ;
/**
 * @author akil
 * @version 1.0
 * @created 15-Jul-2016 11:21:45
 */
class Kategori extends CI_Model implements BaseModel
{

	private $kdKategori;
	private $nmKategori;

	function __construct($id='')
	{
		parent::__construct();
		if($id != ''){
			$sql = "SELECT * FROM tbl_item_kategori WHERE kd_kategori='".$id."'";
			$result = $this->db->query($sql);
			if($result->num_rows()>0){
				foreach ($result->result('array') as $value) {
					$this->setKdKategori($value['kd_kategori']);
					$this->setNmKategori($value['nm_kategori']);						
		
				}
			}
		}
	}

	function __destruct()
	{
	}



	public function getKdKategori()
	{
		return $this->kdKategori;
	}

	public function getNmKategori()
	{
		return $this->nmKategori;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setKdKategori($newVal)
	{
		$this->kdKategori = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setNmKategori($newVal)
	{
		$this->nmKategori = $newVal;
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