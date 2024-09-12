<?php
require_once ('Basemodel.php');




//use ;
/**
 * @author LENOVO
 * @version 1.0
 * @created 28-Apr-2020 3:53:13 PM
 */
class DokumenPerbaikanUpload extends CI_Model implements BaseModel
{
    const table = 'dokumen_perbaikan_upload';

    private $filePath;
	private $idForm;
	private $idRegistrasi;
	private $idUpload;
	private $uploadDate;

	function __construct($args=array())
	{
		parent::__construct();
		if(count($args) > 0){
			$this->db->select('*');
			$this->db->from('dokumen_perbaikan_upload');
			$this->db->where('id_upload', $args['id_upload']);
			//$this->db->where('id_registrasi', $args['id_registrasi']);
			$result = $this->db->get();
			if($result->num_rows()>0){
				$row = $result->row();
				$this->idForm = $row->id_form;
				$this->idRegistrasi = $row->id_registrasi;
				$this->idUpload = $row->id_upload;
				$this->filePath = $row->filepath;
				$this->uploadDate = $row->upload_date;
			}
		}
	}

	function __destruct()
	{
	}



	public function getFilePath()
	{
		return $this->filePath;
	}

	public function getIdForm()
	{
		return $this->idForm;
	}

	public function getIdRegistrasi()
	{
		return $this->idRegistrasi;
	}

	public function getIdUpload()
	{
		return $this->idUpload;
	}

	public function getUploadDate()
	{
		return $this->uploadDate;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setFilePath($newVal)
	{
		$this->filePath = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdForm($newVal)
	{
		$this->idForm = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdRegistrasi($newVal)
	{
		$this->idRegistrasi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdUpload($newVal)
	{
		$this->idUpload = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setUploadDate($newVal)
	{
		$this->uploadDate = $newVal;
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
        
        public function getResult($params) {
        $this->db->select(self::table.'.*');
        $this->db->from(self::table);
        
        $count = false;
        foreach ($params as $key => $value) {
            if($key=='join'){
                foreach ($value as $key => $sub_value){
                    foreach ($sub_value as $operator => $value) {                        
                        $this->db->join($key, $value, $operator);
                    }
                    
                }
            }
            if($key=='field'){
                foreach ($value as $key => $sub_value) {
                    foreach ($sub_value as $operator => $item){
                        if($operator=='IN'){
                            $this->db->where_in($key, $item);
                        }elseif($operator=='NOT IN'){
                            $this->db->where_not_in($key, $item);
                        }elseif($operator=='LIKE'){
                            $this->db->like('lower('.$key.')', strtolower($item));
                        } elseif ($operator == 'BETWEEN'){
                            $where = $key . " ".$operator." '".$item[0]."' AND '".$item[1]."'";
                            $this->db->where($where);
                        }else{
                            $this->db->where($key.$operator, $item);
                        }
                    }
                    
                }
            }
            
            if($key=='paging'){
                foreach ($value as $key => $value) {
                    if($key=='row'){
                        $row = $value;
                    }else{
                        $segment = $value;
                    }
                }
            }
            if($key=='count'){
                $count = $value;           
            }
            if($key=='order'){
                foreach ($value as $key => $value) {
                    $this->db->order_by($key, $value);
                }                
            }
        }
        if($count){
            return $this->db->count_all_results();
        }elseif($row==0 && $segment==0){            
            return $this->db->get();
        }else{            
            return $this->db->get('',$row,$segment);
        }
    }

}
?>