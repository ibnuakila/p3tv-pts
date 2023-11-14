<?php
require_once ('Registrasi.php');
require_once ('Basemodel.php');





/**
 * @author akil
 * @version 1.0
 * @created 02-Apr-2016 20:24:14
 */
class Verifikasi extends CI_Model implements BaseModel
{

	private $idRegistrasi;
	private $idStatusRegistrasi;
	private $keterangan;
	private $publish;
	private $tglVerifikasi;
	public $m_Registrasi;

	function __construct($id=NULL)
	{
		parent::__construct();
		if($id != NULL){
			$this->db->select('*');
			$this->db->from('verifikasi');
			$this->db->where('id_registrasi',$id);
			$result = $this->db->get();
			if($result->num_rows()>0){
				foreach ($result->result() as $value){
					$this->setIdRegistrasi($value->id_registrasi);					
					$this->setIdStatusRegistrasi($value->id_status_registrasi);
					$this->setKeterangan($value->keterangan);
					$this->setTglVerifikasi($value->tgl_verifikasi);
					$this->setPublish($value->publish);
					
				}
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

	public function getIdStatusRegistrasi()
	{
		return $this->idStatusRegistrasi;
	}

	public function getKeterangan()
	{
		return $this->keterangan;
	}

	public function getPublish()
	{
		return $this->publish;
	}

	public function getTglVerifikasi()
	{
		return $this->tglVerifikasi;
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
	public function setKeterangan($newVal)
	{
		$this->keterangan = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setPublish($newVal)
	{
		$this->publish = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTglVerifikasi($newVal)
	{
		$this->tglVerifikasi = $newVal;
	}

	public function delete()
	{
		$this->db->delete('verifikasi', array('id_registrasi'=>  $this->idRegistrasi));
	}

	/**
	 * 
	 * @param row
	 * @param segment    segment
	 */
	public function get($row = Null, $segment = Null)
	{
		$this->db->select('verifikasi.*');
		$this->db->from('verifikasi');
		$this->db->join('registrasi','verifikasi.id_registrasi = registrasi.id_registrasi');
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
		$this->db->select('*');
		$this->db->from('verifikasi');
		$this->db->where($field, $value);
		$result = $this->db->get();
		if($result->num_rows()>0){
			foreach ($result->result() as $value){
				$this->setIdRegistrasi($value->id_registrasi);					
				$this->setIdStatusRegistrasi($value->id_status_registrasi);
				$this->setKeterangan($value->keterangan);
				$this->setTglVerifikasi($value->tgl_verifikasi);
				$this->setPublish($value->publish);
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
	 * @param value    value
	 * @param row
	 * @param segment
	 */
	public function getByRelated($related, $field, $value, $row = Null, $segment = Null)
	{
		$this->db->select('verifikasi.*');
		$this->db->from('verifikasi');
		$this->db->join('registrasi','verifikasi.id_registrasi = registrasi.id_registrasi');
		$this->db->join('account','registrasi.id_account = account.id_account');
		$this->db->join('yayasan','account.id_yayasan = yayasan.id_yayasan');
		$this->db->join('pti','registrasi.kdpti = pti.kdpti');
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
		$data = array('id_registrasi'=>$this->idRegistrasi,
				'id_status_registrasi'=>$this->idStatusRegistrasi,
				'keterangan'=>$this->keterangan,
				'tgl_verifikasi'=>$this->tglVerifikasi,
				'publish'=>$this->publish
		);
		return $this->db->insert('verifikasi',$data);
	}

	public function update()
	{
		$data = array('id_registrasi'=>$this->idRegistrasi,
				'id_status_registrasi'=>$this->idStatusRegistrasi,
				'keterangan'=>$this->keterangan,
				'tgl_verifikasi'=>$this->tglVerifikasi,
				'publish'=>$this->publish
		);
		$this->db->where('id_registrasi',$this->idRegistrasi);
		return $this->db->update('verifikasi',$data);
	}

}
?>