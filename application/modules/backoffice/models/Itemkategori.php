<?php
require_once ('Basemodel.php');

//namespace models;



//use models;
/**
 * @author LENOVO
 * @version 1.0
 * @created 27-May-2020 11:20:08 AM
 */
class ItemKategori extends CI_Model implements BaseModel
{
		private $kdKategori;
		private $nmkategori;


	

	function __construct($id=null)
	{
            parent::__construct();
            if($id!=null){
                $this->db->select('*');
                $this->db->from('tbl_item_kategori');
                $this->db->where('kd_kategori',$id);
                $result = $this->db->get();
                if($result->num_rows()>0){
                    $row = $result->row();
                    $this->kdKategori = $row->kd_kategori;
                    $this->nmkategori = $row->nm_kategori;
                }
            }
    	}

	function __destruct()
	{
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
            $this->db->from('tbl_item_kategori');
            
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

		public function getKdKategori()
		{
			return $this->kdKategori;
		}

		public function getNmkategori()
		{
			return $this->nmkategori;
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
		public function setNmkategori($newVal)
		{
			$this->nmkategori = $newVal;
		}

}
?>