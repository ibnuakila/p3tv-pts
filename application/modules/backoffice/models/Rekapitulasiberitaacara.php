<?php
require_once ('Basemodel.php');




//use ;
/**
 * @author LENOVO
 * @version 1.0
 * @created 29-Apr-2020 3:40:57 PM
 */
class RekapitulasiBeritaAcara extends CI_Model implements BaseModel
{

	
	private $idRegistrasi;
	private $idRekapitulasi;
	private $referensi;
	private $revisi;
	private $tglUpload;
	private $filePath;
	private $idJnsFile;
	private $id;
	private $idDp;
	

	function __construct($id=null)
	{
            parent::__construct();
            if($id != NULL){
                $this->db->select("*");
                $this->db->from("rekapitulasi_berita_acara");
                $this->db->where('id',$id);
                //$this->db->where('revisi',$args['revisi']);
                $result = $this->db->get();
                if($result->num_rows()>0){
                    $row = $result->row();
                    
                    $this->idRegistrasi = $row->id_registrasi;
                    $this->id = $row->id;                   
                    $this->referensi = $row->referensi;
                    $this->revisi = $row->revisi;
                    $this->tglUpload = $row->tgl_upload;
                    $this->filePath = $row->file_path;
                    $this->idJnsFile = $row->id_jns_file;
                }
            }
	}

	function __destruct()
	{
	}



	

	public function getIdRegistrasi()
	{
		return $this->idRegistrasi;
	}

	public function getIdRekapitulasi()
	{
		return $this->idRekapitulasi;
	}

	public function getReferensi()
	{
		return $this->referensi;
	}

	public function getRevisi()
	{
		return $this->revisi;
	}

	public function getTglUpload()
	{
		return $this->tglUpload;
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
	public function setIdRekapitulasi($newVal)
	{
		$this->idRekapitulasi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setReferensi($newVal)
	{
		$this->referensi = $newVal;
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
	public function setTglUpload($newVal)
	{
		$this->tglUpload = $newVal;
	}

	public function delete()
	{
            $this->db->delete("rekapitulasi_berita_acara", array('id'=>  $this->id));
	}

	/**
	 * 
	 * @param row
	 * @param segment    segment
	 */
	public function get($row = Null, $segment = Null)
	{
            $this->db->select('rekapitulasi_berita_acara.*');
            $this->db->from('rekapitulasi_berita_acara');
            if($this->idRegistrasi != ''){
                $this->db->join('registrasi','rekapitulasi_berita_acara.id_registrasi = registrasi.id_registrasi');
                $this->db->where('rekapitulasi_berita_acara.id_registrasi', $this->idRegistrasi);
            }
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
            $this->db->select("*");
            $this->db->from("rekapitulasi_berita_acara");
            $this->db->where($field,$value);            
            $result = $this->db->get();
            if($result->num_rows()>0){
                $row = $result->row();
                $this->idRegistrasi = $row->id_registrasi;
                $this->id = $row->id;                   
                $this->referensi = $row->referensi;
                $this->revisi = $row->revisi;
                $this->tglUpload = $row->tgl_upload;
                $this->filePath = $row->file_path;
                $this->idJnsFile = $row->id_jns_file;
            }
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
            $data = array('id_registrasi'=>  $this->idRegistrasi,
                    //'id_rekapitulasi'=> $this->idRekapitulasi,
                    'referensi'=>  $this->referensi,                    
                    'tgl_upload'=> $this->tglUpload,
                    'revisi'=> $this->revisi,
                    'file_path'=> $this->filePath,
                    'id_jns_file'=> $this->idJnsFile,
                    'id_dp'=> $this->idDp);
                $this->db->insert('rekapitulasi_berita_acara',$data);
	}

	public function update()
	{
            $data = array('id_registrasi'=>  $this->idRegistrasi,
                    //'id_rekapitulasi'=> $this->idRekapitulasi,
                    'referensi'=>  $this->referensi,
                    
                    'tgl_upload'=> $this->tglUpload,
                    'revisi'=> $this->revisi,
                    'file_path'=> $this->filePath,
                    'id_jns_file'=> $this->idJnsFile,
                    'id_dp'=> $this->idDp);
                $this->db->where('id',  $this->id);
                //$this->db->where('revisi',  $this->revisi);
                $this->db->update('rekapitulasi_berita_acara',$data);
	}
        
        public function isExist()
        {
            $this->db->select("*");
            $this->db->from("rekapitulasi_berita_acara");
            $this->db->where('id_registrasi',  $this->idRegistrasi);
            $this->db->where('id_jns_file', $this->idJnsFile);
            $this->db->where('referensi', $this->referensi);
            $result = $this->db->get();
            if($result->num_rows()>0){
                $row = $result->row();
                $this->idRegistrasi = $row->id_registrasi;
                $this->id = $row->id;                   
                $this->referensi = $row->referensi;
                $this->revisi = $row->revisi;
                $this->tglUpload = $row->tgl_upload;
                $this->filePath = $row->file_path;
                $this->idJnsFile = $row->id_jns_file;
                return true;
            }else{
                return false;
            }
        }

	public function getFilePath()
	{
		return $this->filePath;
	}

	public function getIdJnsFile()
	{
		return $this->idJnsFile;
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
	public function setIdJnsFile($newVal)
	{
		$this->idJnsFile = $newVal;
	}

	public function getId()
	{
		return $this->id;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setId($newVal)
	{
		$this->id = $newVal;
	}

	public function getIdDp()
	{
		return $this->idDp;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdDp($newVal)
	{
		$this->idDp = $newVal;
	}

	

}
?>