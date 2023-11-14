<?php
require_once ('statusregistrasi.php');
require_once ('basemodel.php');





/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:47:27
 */
class Rekapitulasi extends CI_Model implements BaseModel
{

	private $idRegistrasi;
	private $idRekapitulasi;
	private $idStatusRegistrasi;
	private $keterangan;
	private $nilaiTotal;
	private $publish;
	private $revisi;
	private $tglPublish;
	private $tglRekap;
	private $objStatusRegistrasi;
	private $objEvaluasi;

	function __construct($id=NULL)
	{
		parent::__construct();
		if($id != NULL){
			$this->db->select('*');
			$this->db->from('rekapitulasi');
			$this->db->where('id_rekapitulasi',$id);
			$result = $this->db->get();
			if($result->num_rows()>0){
				foreach ($result->result() as $value){
					$this->setIdRekapitulasi($value->id_rekapitulasi);
					$this->setIdStatusRegistrasi($value->id_status_registrasi);
					$this->setIdRegistrasi($value->id_registrasi);
					$this->setNilaiTotal($value->nilai_total);
					$this->setTglRekap($value->tgl_rekap);
					$this->setPublish($value->publish);
					$this->setTglPublish($value->tgl_publish);
				}
			}
		}
	}

	function __destruct()
	{
	}



	public function getEvaluasi()
	{
		$this->db->select('evaluasi.*');
		$this->db->from('evaluasi');
		$this->db->join('evaluasi_rekapitulasi','evaluasi.id_evaluasi = evaluasi_rekapitulasi.id_evaluasi');
		//$this->db->join('rekapitulasi','evaluasi_rekapitulasi.id_rekapitulasi = rekapitulasi.id_rekapitulasi');
		$this->db->where('evaluasi_rekapitulasi.id_rekapitulasi',$this->idRekapitulasi);
		$result = $this->db->get();
		
		if($result->num_rows()>0){
			$this->objEvaluasi = new ArrayObject();
			foreach ($result->result() as $value){
				$evaluasi = new Evaluasi($value->id_evaluasi);
				$this->objEvaluasi->append($evaluasi);
			}
		}
		return $this->objEvaluasi;
	}

	public function getIdRegistrasi()
	{
		return $this->idRegistrasi;
	}

	public function getIdRekapitulasi()
	{
		return $this->idRekapitulasi;
	}

	public function getIdStatusRegistrasi()
	{
		return $this->idStatusRegistrasi;
	}

	public function getKeterangan()
	{
		return $this->keterangan;
	}

	public function getNilaiTotal()
	{
		return $this->nilaiTotal;
	}

	public function getPublish()
	{
		return $this->publish;
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

	public function getTglPublish()
	{
		return $this->tglPublish;
	}

	public function getTglRekap()
	{
		return $this->tglRekap;
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
	public function setNilaiTotal($newVal)
	{
		$this->nilaiTotal = $newVal;
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
	public function setRevisi($newVal)
	{
		$this->revisi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTglPublish($newVal)
	{
		$this->tglPublish = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTglRekap($newVal)
	{
		$this->tglRekap = $newVal;
	}

	public function delete()
	{
		$this->db->delete('rekapitulasi', array('id_rekapitulasi'=>  $this->idRekapitulasi));
	}

	/**
	 * 
	 * @param row
	 * @param segment
	 */
	public function get($row = Null, $segment = Null)
	{
		$this->db->select('*');
		$this->db->from('rekapitulasi');
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
		$this->db->from('rekapitulasi');
		$this->db->where($field, $value);
		$result = $this->db->get();
		if($result->num_rows()>0){
			foreach ($result->result() as $value){
				$this->setIdRekapitulasi($value->id_rekapitulasi);
				$this->setIdStatusRegistrasi($value->id_status_registrasi);
				$this->setIdRegistrasi($value->id_registrasi);
				$this->setNilaiTotal($value->nilai_total);
				$this->setTglRekap($value->tgl_rekap);
				$this->setPublish($value->publish);
				$this->setTglPublish($value->tgl_publish);
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
		$this->db->select('rekapitulasi.*');
		$this->db->from('rekapitulasi');		
		$this->db->join('registrasi','rekapitulasi.id_registrasi = registrasi.id_registrasi');
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
		$data =  array('id_rekapitulasi'=>$this->idRekapitulasi,
					'id_registrasi'=>$this->idRegistrasi,
					'id_status_registrasi'=>$this->idStatusRegistrasi,
					'nilai_total'=>$this->nilaiTotal,
					'keterangan'=>$this->keterangan,
					'tgl_rekap'=>$this->tglRekap,
					'publish'=>$this->publish,
					'tgl_publish'=>$this->tglPublish,
					'revisi'=>$this->revisi);
		$this->db->insert('rekapitulasi',$data);
	}

	public function update()
	{
		$data =  array('id_rekapitulasi'=>$this->idRekapitulasi,
				'id_registrasi'=>$this->idRegistrasi,
				'id_status_registrasi'=>$this->idStatusRegistrasi,
				'nilai_total'=>$this->nilaiTotal,
				'keterangan'=>$this->keterangan,
				'tgl_rekap'=>$this->tglRekap,
				'publish'=>$this->publish,
				'tgl_publish'=>$this->tglPublish,
				'revisi'=>$this->revisi);
		$this->db->where('id_rekapitulasi',$this->idRekapitulasi);
		$this->db->update('rekapitulasi',$data);
	}

}
?>