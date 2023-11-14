<?php
require_once ('Basemodel.php');




//use ;
/**
 * @author akil
 * @version 1.0
 * @created 15-Jul-2016 11:21:54
 */
class SubKategori extends CI_Model implements BaseModel
{

	private $kdKategori;
	private $kdSubKategori;
	private $nmSubKategori;

	function __construct($id='')
	{
		parent::__construct();
		if($id != ''){
			$sql = "SELECT * FROM tbl_item_sub2kategori WHERE kd_sub_kategori='".$id."'";
			$result = $this->db->query($sql);
			if($result->num_rows()>0){
				foreach ($result->result('array') as $value) {
					$this->setKdSubKategori($value['kd_sub_kategori']);
					$this->setNmSubKategori($value['nm_sub_kategori']);
					$this->setKdKategori($value['kd_kategori']);
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

	public function getKdSubKategori()
	{
		return $this->kdSubKategori;
	}

	public function getNmSubKategori()
	{
		return $this->nmSubKategori;
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
	public function setKdSubKategori($newVal)
	{
		$this->kdSubKategori = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setNmSubKategori($newVal)
	{
		$this->nmSubKategori = $newVal;
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
            $this->db->select('*');
            $this->db->from('tbl_item_sub2kategori');
            
            if($row==NULL && $segment==NULL){
                    return $this->db->count_all_results();
            }elseif($row==0 && $segment==0){
                    return $this->db->get();
            }else{
                    return $this->db->get('', $row, $segment);
            }
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