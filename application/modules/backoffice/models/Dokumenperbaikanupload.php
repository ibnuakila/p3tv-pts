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
			$this->db->where('id_form', $args['id_form']);
			$this->db->where('id_registrasi', $args['id_registrasi']);
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

}
?>