<?php
require_once ('account.php');
require_once ('basemodel.php');
require_once ('dokumenregistrasi.php');
require_once ('statusregistrasi.php');





/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:40:22
 */
class Registrasi extends CI_Model implements BaseModel
{

	private $idAccount;
	private $idRegistrasi;
	private $idStatusRegistrasi;
	private $jnsUsulan;
	private $periode;
	private $revisi;
	private $tglRegistrasi;
	public $objAccount;
	public $objDokumenRegistrasi;
	public $objStatusRegistrasi;
	public $objPti;
	private $kdPti;

	function __construct($id=NULL)
	{
            parent::__construct();
            if($id != NULL){
                $this->db->select('*');         
                $this->db->from('registrasi');
                $this->db->where('id_registrasi',$id);
                $result = $this->db->get();
                if($result->num_rows()>0){
                    foreach ($result->result() as $value){
                        $this->setIdRegistrasi($value->id_registrasi);
                        $this->setIdAccount($value->id_account);
                        $this->setIdStatusRegistrasi($value->id_status_registrasi);
                        $this->setTglRegistrasi($value->tgl_registrasi);
                        $this->setJnsUsulan($value->jns_usulan);
                        $this->setPeriode($value->periode);
                        $this->setRevisi($value->revisi);
                        $this->setKdPti($value->kdpti);
                    }
                }
            }
	}

	function __destruct()
	{
	}



	public function getAccount()
	{
            $this->db->select('*');         
            $this->db->from('account');
            $this->db->where('id_account',  $this->idAccount);
            $result = $this->db->get();
            $this->objAccount = NULL;
            if($result->num_rows()>0){
                
                foreach ($result->result() as $value){
                    $this->objAccount = new Account($value->id_account);
                }
            }
            return $this->objAccount;
	}

	public function getDokumenRegistrasi()
	{
	}

	public function getIdAccount()
	{
		return $this->idAccount;
	}

	public function getIdRegistrasi()
	{
		return $this->idRegistrasi;
	}

	public function getIdStatusRegistrasi()
	{
		return $this->idStatusRegistrasi;
	}

	public function getJnsUsulan()
	{
		return $this->jnsUsulan;
	}

	public function getPeriode()
	{
		return $this->periode;
	}

	public function getRevisi()
	{
		return $this->revisi;
	}

	public function getStatusRegistrasi()
	{
            $this->db->select('*');         
            $this->db->from('status_registrasi');
            $this->db->where('id_status_registrasi',  $this->idStatusRegistrasi);
            $result = $this->db->get();
            $this->objStatusRegistrasi = NULL;
            if($result->num_rows()>0){
                $this->objStatusRegistrasi = new StatusRegistrasi();
                foreach ($result->result() as $value){
                    $this->objStatusRegistrasi->setIdStatusRegistrasi($value->id_status_registrasi);
                    $this->objStatusRegistrasi->setNamaStatus($value->nama_status);                    
                }
            }
            return $this->objStatusRegistrasi;
	}

	public function getTglRegistrasi()
	{
		return $this->tglRegistrasi;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdAccount($newVal)
	{
		$this->idAccount = $newVal;
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
	public function setIdStatusRegistrasi($newVal)
	{
		$this->idStatusRegistrasi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setJnsUsulan($newVal)
	{
		$this->jnsUsulan = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setPeriode($newVal)
	{
		$this->periode = $newVal;
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
	public function setTglRegistrasi($newVal)
	{
		$this->tglRegistrasi = $newVal;
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
            $this->db->select('*');
            $this->db->from('registrasi');
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
	 * @param value
	 */
	public function getBy($field, $value)
	{
            $this->db->select('*');
            $this->db->from('registrasi');
            $this->db->where($field, $value);
            $result = $this->db->get();
            if($result->num_rows()>0){
                foreach ($result->result() as $value){
                    $this->setIdRegistrasi($value->id_registrasi);
                    $this->setIdAccount($value->id_account);
                    $this->setIdStatusRegistrasi($value->id_status_registrasi);
                    $this->setTglRegistrasi($value->tgl_registrasi);
                    $this->setJnsUsulan($value->jns_usulan);
                    $this->setPeriode($value->periode);
                    $this->setRevisi($value->revisi);
                }
                return TRUE;
            }else{
                return FALSE;
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
            $this->db->select('registrasi.*');
            $this->db->from('registrasi');
            $this->db->join('account','registrasi.id_account = account.id_account');
            $this->db->join('yayasan','account.id_yayasan = yayasan.id_yayasan');
            $this->db->join('tbl_pti','registrasi.kdpti = pti.kdpti');
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
	}

	public function getPti()
	{
            $this->db->select('*');         
            $this->db->from('pti');
            $this->db->where('kdpti',  $this->kdPti);
            $result = $this->db->get();
            $this->objPti = NULL;
            if($result->num_rows()>0){                
                foreach ($result->result() as $value){
                    $this->objPti = new Pti($value->kdpti);
                }
            }
            return $this->objPti;
	}

	public function getKdPti()
	{
		return $this->kdPti;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setKdPti($newVal)
	{
		$this->kdPti = $newVal;
	}

	

	

}
?>