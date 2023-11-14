<?php
require_once ('Basemodel.php');




//use ;
/**
 * @author akil
 * @version 1.0
 * @created 15-Jul-2016 11:21:34
 */
class Barang extends CI_Model implements BaseModel
{

	private $idItem;
	private $kdBarang;
	private $nmBarang;
	private $noBarang;
	private $spesifikasi;
	private $berat;
	private $harga;

	function __construct($id='')
	{
		parent::__construct();
		if($id != ''){
			$sql = "SELECT * FROM tbl_item_barang WHERE id_item='".$id."'";
			$result = $this->db->query($sql);
			if($result->num_rows()>0){
				foreach ($result->result('array') as $value) {
					$this->setKdBarang($value['kd_barang']);
					$this->setNmBarang($value['barang']);
					$this->setSpesifikasi($value['spesifikasi']);
					$this->setNoBarang($value['no_barang']);
					$this->setIdItem($value['id_item']);
					$this->setHarga($value['harga']);
                                        $this->setBerat($value['berat']);
				}
			}
		}
	}

	function __destruct()
	{
	}



	public function getIdItem()
	{
		return $this->idItem;
	}

	public function getKdBarang()
	{
		return $this->kdBarang;
	}

	public function getNmBarang()
	{
		return $this->nmBarang;
	}

	public function getNoBarang()
	{
		return $this->noBarang;
	}

	public function getSpesifikasi()
	{
		return $this->spesifikasi;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdItem($newVal)
	{
		$this->idItem = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setKdBarang($newVal)
	{
		$this->kdBarang = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setNmBarang($newVal)
	{
		$this->nmBarang = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setNoBarang($newVal)
	{
		$this->noBarang = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setSpesifikasi($newVal)
	{
		$this->spesifikasi = $newVal;
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

	public function getBerat()
	{
		return $this->berat;
	}

	public function getHarga()
	{
		return $this->harga;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setBerat($newVal)
	{
		$this->berat = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setHarga($newVal)
	{
		$this->harga = $newVal;
	}

}
?>