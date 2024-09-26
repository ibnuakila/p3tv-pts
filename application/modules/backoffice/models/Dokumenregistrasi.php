<?php
require_once ('Dokumen.php');
require_once ('Basemodel.php');





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

	function __construct($id=NULL)
	{
		parent::__construct();
		if($id != NULL){
			$this->db->select('*');
			$this->db->from('dokumen_registrasi');
			$this->db->where('id_upload',$id);
			$result = $this->db->get();
			if($result->num_rows()>0){
				foreach ($result->result() as $value){
					$this->setIdRegistrasi($value->id_registrasi);
					$this->setIdUpload($value->id_upload);
					//$this->setFileName($value->file_name);
					//$this->setFileType($value->file_type);
					$this->setFullPath($value->filepath);
					$this->setUploadDate($value->upload_date);
					$this->setDownload($value->download);
					$this->setIdForm($value->id_form);
					$this->setVerifikasi($value->verifikasi);
					$this->setRevisi($value->revisi);
				}
			}
		}
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
            $this->db->select('*');
            $this->db->from('dokumen_registrasi');
            $this->db->where($field,$value);
            $result = $this->db->get();
            if($result->num_rows()>0){
                    foreach ($result->result() as $value){
                            $this->setIdRegistrasi($value->id_registrasi);
                            $this->setIdUpload($value->id_upload);
                            //$this->setFileName($value->file_name);
                            //$this->setFileType($value->file_type);
                            $this->setFullPath($value->filepath);
                            $this->setUploadDate($value->upload_date);
                            $this->setDownload($value->download);
                            $this->setIdForm($value->id_form);
                            $this->setVerifikasi($value->verifikasi);
                            $this->setRevisi($value->revisi);
                    }
            }
	}

	/**
	 * 
	 * @param related
	 * @param field
	 * @param value
	 */
	public function getByRelated($related, $field, $value, $row = Null, $segment = Null)
	{
		$this->db->select('dokumen_registrasi.*');
		$this->db->from('dokumen_registrasi');
		$this->db->join('registrasi','dokumen_registrasi.id_registrasi = registrasi.id_registrasi');
		/*$this->db->join('account','registrasi.id_account = account.id_account');
		$this->db->join('yayasan','account.id_yayasan = yayasan.id_yayasan');
		$this->db->join('pti','registrasi.kdpti = pti.kdpti');*/
		$this->db->like($related.'.'.$field, $value);
		if($row==NULL && $segment==NULL){
			return $this->db->count_all_results();
		}elseif($row==0 && $segment==0){
			return $this->db->get();
		}else{
			return $this->db->get('', $row, $segment);
		}
	}

	public function insert()
	{
	}

	public function update()
	{
            $data = array('verifikasi'=>  $this->verifikasi);
            $this->db->where('id_upload',  $this->idUpload);
            $this->db->update('dokumen_registrasi',$data);
	}
        
        public function getByArray(array $param)
        {
            $this->db->select('*');
            $this->db->from('dokumen_registrasi');
            if(count($param)>0){
                foreach ($param as $key => $value) {
                    $this->db->where($key, $value);
                }                
            }
            $result = $this->db->get();
            if($result->num_rows()>0){
                foreach ($result->result() as $value){
                    $this->setIdRegistrasi($value->id_registrasi);
                    $this->setIdUpload($value->id_upload);
                    //$this->setFileName($value->file_name);
                    //$this->setFileType($value->file_type);
                    $this->setFullPath($value->filepath);
                    $this->setUploadDate($value->upload_date);
                    $this->setDownload($value->download);
                    $this->setIdForm($value->id_form);
                    $this->setVerifikasi($value->verifikasi);
                    $this->setRevisi($value->revisi);
                }
            }
        }

}
?>