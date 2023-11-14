<?php
require_once ('dokumen.php');
require_once ('basemodel.php');





/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:40:54
 */
class DokumenRegistrasi extends CI_Model implements BaseModel
{

	private $download;
	private $fileName;
	private $fileType;
	private $fullPath;
	private $idForm;
	private $idRegistrasi;
	private $idUpload;
	private $revisi;
	private $uploadDate;
	private $verifikasi;
	private $objDokumen;

	function __construct()
	{
	}

	function __destruct()
	{
	}



	public function getDokumen()
	{
            $this->db->select('*');
            $this->db->from('dokumen');
            $this->db->where('id_form',  $this->idForm);
            $result = $this->db->get();
            $this->objDokumen = NULL;
            if($result->num_rows()>0){
                $this->objDokumen = new Dokumen();
                foreach ($result->result() as $obj){
                    $this->objDokumen->setIdForm($obj->id_form);
                    $this->objDokumen->setFormName($obj->form_name);
                    $this->objDokumen->setFormGroup($obj->form_group);
                    $this->objDokumen->setKeterangan($obj->keterangan);                    
                }                    
            }
            return $this->objDokumen;
	}

	public function getDownload()
	{
		return $this->download;
	}

	public function getFileName()
	{
		return $this->fileName;
	}

	public function getFileType()
	{
		return $this->fileType;
	}

	public function getFullPath()
	{
		return $this->fullPath;
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

	public function getRevisi()
	{
		return $this->revisi;
	}

	public function getUploadDate()
	{
		return $this->uploadDate;
	}

	public function getVerifikasi()
	{
		return $this->verifikasi;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setDownload($newVal)
	{
		$this->download = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setFileName($newVal)
	{
		$this->fileName = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setFileType($newVal)
	{
		$this->fileType = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setFullPath($newVal)
	{
		$this->fullPath = $newVal;
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
	public function setRevisi($newVal)
	{
		$this->revisi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setUploadDate($newVal)
	{
		$this->uploadDate = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setVerifikasi($newVal)
	{
		$this->verifikasi = $newVal;
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