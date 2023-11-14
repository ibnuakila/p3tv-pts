<?php
require_once ('evaluasiproses.php');
require_once ('evaluatorevaluasi.php');
require_once ('basemodel.php');





/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:46:26
 */
class Evaluasi extends CI_Model implements BaseModel
{

	private $filePath;
	private $idEvaluasi;
	private $idStatusRegistrasi;
	private $keterangan;
	private $lastUpdate;
	private $revisi;
	private $skor;
	private $tglEvaluasi;
	private $objEvaluasiProses;
	private $objEvaluatorEvaluasi;

	function __construct($id=NULL)
	{
            parent::__construct();
            if($id != NULL){
                $this->db->select('*');         
                $this->db->from('evaluasi');
                $this->db->where('id_evaluasi',$id);
                $result = $this->db->get();
                if($result->num_rows()>0){
                    foreach ($result->result() as $value){                        
                        $this->setIdEvaluasi($value->id_evaluasi);
                        $this->setTglEvaluasi($value->tgl_evaluasi);
                        $this->setSkor($value->skor);
                        $this->setFilePath($value->file_path);
                        $this->setIdStatusRegistrasi($value->id_status_registrasi);
                        $this->setKeterangan($value->keterangan);
                        $this->setRevisi($value->revisi);
                        $this->setLastUpdate($value->last_update);                        
                    }
                }
            }
	}

	function __destruct()
	{
	}



	public function getEvaluator()
	{
		$this->db->select('evaluator.*');
		$this->db->from('evaluator');
		$this->db->join('evaluator_evaluasi','evaluator.id_evaluator = evaluator_evaluasi.id_evaluator');
		//$this->db->join('evaluasi','evaluator_evaluasi.id_evaluasi = evaluator_evaluasi.id_evaluasi');
		$this->db->where('evaluator_evaluasi.id_evaluasi',$this->idEvaluasi);
		$result = $this->db->get();
		$this->objEvaluatorEvaluasi = null;
		if($result->num_rows()>0){
			foreach ($result->result() as $value){
				$this->objEvaluatorEvaluasi = new Evaluator($value->id_evaluator);
			}
		}
		return $this->objEvaluatorEvaluasi;
	}

	public function getFilePath()
	{
		return $this->filePath;
	}

	public function getIdEvaluasi()
	{
		return $this->idEvaluasi;
	}

	public function getIdStatusRegistrasi()
	{
		return $this->idStatusRegistrasi;
	}

	public function getKeterangan()
	{
		return $this->keterangan;
	}

	public function getLastUpdate()
	{
		return $this->lastUpdate;
	}

	public function getProses()
	{
	}

	public function getRevisi()
	{
		return $this->revisi;
	}

	public function getSkor()
	{
		return $this->skor;
	}

	public function getTglEvaluasi()
	{
		return $this->tglEvaluasi;
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
	public function setIdEvaluasi($newVal)
	{
		$this->idEvaluasi = $newVal;
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
	public function setLastUpdate($newVal)
	{
		$this->lastUpdate = $newVal;
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
	public function setSkor($newVal)
	{
		$this->skor = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTglEvaluasi($newVal)
	{
		$this->tglEvaluasi = $newVal;
	}

	public function delete()
	{
		$this->db->delete('evaluasi', array('id_evaluasi'=>  $this->idEvaluasi));
	}

	/**
	 * 
	 * @param row
	 * @param segment
	 */
	public function get($row = Null, $segment = Null)
	{
		$this->db->select('*');
		$this->db->from('evaluasi');
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
		$this->db->from('proses');
		$this->db->where($field, $value);
		$result = $this->db->get();
		if($result->num_rows()>0){
			foreach ($result->result() as $value){
				$this->setIdEvaluasi($value->id_evaluasi);
                $this->setTglEvaluasi($value->tgl_evaluasi);
                $this->setSkor($value->skor);
                $this->setFilePath($value->file_path);
                $this->setIdStatusRegistrasi($value->id_status_registrasi);
                $this->setKeterangan($value->keterangan);
                $this->setRevisi($value->revisi);
                $this->setLastUpdate($value->last_update);
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
		$this->db->select('evaluasi.*');
		$this->db->from('evaluasi');
		$this->db->join('evaluasi_proses','evaluasi.id_evaluasi = evaluasi_proses.id_evaluasi');
		$this->db->join('proses','evaluasi_proses.id_proses = proses.id_proses');
		$this->db->join('proses_registrasi','proses.id_proses = proses_registrasi.id_proses');
        $this->db->join('registrasi','proses_registrasi.id_registrasi = registrasi.id_registrasi');            
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
		$data = array('id_evaluasi'=>$this->idEvaluasi,
				'tgl_evaluasi'=>$this->tglEvaluasi,
				'skor'=>$this->skor,
				'keterangan'=>$this->keterangan,
				'last_update'=>$this->lastUpdate,
				'id_status_registrasi'=>$this->idStatusRegistrasi,
				'file_path'=>$this->filePath,
				'revisi'=>$this->revisi);
		$this->db->insert('evaluasi',$data);
	}

	public function update()
	{
		$data = array('id_evaluasi'=>$this->idEvaluasi,
				'tgl_evaluasi'=>$this->tglEvaluasi,
				'skor'=>$this->skor,
				'keterangan'=>$this->keterangan,
				'last_update'=>$this->lastUpdate,
				'id_status_registrasi'=>$this->idStatusRegistrasi,
				'file_path'=>$this->filePath,
				'revisi'=>$this->revisi);
		$this->db->where('id_evaluasi',$this->idEvaluasi);
		$this->db->update('evaluasi',$data);
	}

}
?>