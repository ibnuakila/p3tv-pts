<?php
require_once ('evaluasiproses.php');
require_once ('basemodel.php');
require_once ('prosesRegistrasi.php');
require_once ('statusproses.php');





/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:41:36
 */
class Proses extends CI_Model implements BaseModel
{

	private $idEvaluator;
	private $idProses;
	private $idStatusProses;
	private $keterangan;
	private $revisi;
	private $tglExpire;
	private $tglKirim;
	private $tglTerima;
	private $typeEvaluator;
	private $objEvaluasiProses;
	private $objProsesRegistrasi;
	private $objStatusProses;
        

	function __construct($id=NULL)
	{
            parent::__construct();
            if($id != NULL){
                $this->db->select('*');         
                $this->db->from('proses');
                $this->db->where('id_proses',$id);
                $result = $this->db->get();
                if($result->num_rows()>0){
                    foreach ($result->result() as $value){                        
                        $this->setIdProses($value->id_proses);
                        $this->setIdEvaluator($value->id_evaluator);
                        $this->setTypeEvaluator($value->type_evaluator);
                        $this->setIdStatusProses($value->id_status_proses);
                        $this->setTglKirim($value->tgl_kirim);
                        $this->setTglExpire($value->tgl_expire);
                        $this->setTglTerima($value->tgl_terima);
                        $this->setKeterangan($value->keterangan);
                        $this->setRevisi($value->revisi);
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
            $this->db->join('evaluasi_proses', 'evaluasi.id_evaluasi = evaluasi_proses.id_evaluasi');
            $this->db->join('proses', 'evaluasi_proses.id_proses = proses.id_proses');
            $this->db->where('proses.id_proses',  $this->idProses);
            $result = $this->db->get();
            $this->objEvaluasiProses = new ArrayObject($array);
            if($result->num_rows()>0){                
                foreach ($result->result() as $obj){
                    $this->objEvaluasiProses = new Evaluasi($obj->id_evaluasi);                    
                }
                    
            }
            return $this->objEvaluasiProses;
	}

	public function getIdEvaluator()
	{
		return $this->idEvaluator;
	}

	public function getIdProses()
	{
		return $this->idProses;
	}

	public function getIdStatusProses()
	{
		return $this->idStatusProses;
	}

	public function getKeterangan()
	{
		return $this->keterangan;
	}

	public function getRegistrasi()
	{
		$this->db->select('registrasi.*');
		$this->db->from('registrasi');
		$this->db->join('proses_registrasi','registrasi.id_registrasi = proses_registrasi.id_registrasi');
		//$this->db->join('proses','proses_registrasi.id_proses = proses.id_proses');
		$this->db->where('proses_registrasi.id_proses',  $this->idProses);
		$result = $this->db->get();
		//$this->objProsesRegistrasi = null;
		if($result->num_rows()>0){
			foreach ($result->result() as $obj){
				$this->objProsesRegistrasi = new Registrasi($obj->id_registrasi);
				
			}		
		}
		return $this->objProsesRegistrasi;
	}

	public function getRevisi()
	{
		return $this->revisi;
	}

	public function getStatusProses()
	{
		$this->db->select('status_proses.*');
		$this->db->from('status_proses');
		$this->db->where('id_status_proses',  $this->idStatusProses);
		$result = $this->db->get();
		$this->objStatusProses = NULL;
		if($result->num_rows()>0){
			foreach ($result->result() as $obj){
				$this->objStatusProses = new StatusProses($obj->id_status_proses);
			}
		
		}
		return $this->objStatusProses;
	}

	public function getTglExpire()
	{
		return $this->tglExpire;
	}

	public function getTglKirim()
	{
		return $this->tglKirim;
	}

	public function getTglTerima()
	{
		return $this->tglTerima;
	}

	public function getTypeEvaluator()
	{
		return $this->typeEvaluator;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdEvaluator($newVal)
	{
		$this->idEvaluator = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdProses($newVal)
	{
		$this->idProses = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdStatusProses($newVal)
	{
		$this->idStatusProses = $newVal;
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
	public function setRevisi($newVal)
	{
		$this->revisi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTglExpire($newVal)
	{
		$this->tglExpire = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTglKirim($newVal)
	{
		$this->tglKirim = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTglTerima($newVal)
	{
		$this->tglTerima = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTypeEvaluator($newVal)
	{
		$this->typeEvaluator = $newVal;
	}

	public function delete()
	{
            $this->db->delete('proses', array('id_proses'=>  $this->idProses));
	}

	/**
	 * 
	 * @param row
	 * @param segment
	 */
	public function get($row = Null, $segment = Null)
	{
            $this->db->select('*');
            $this->db->from('proses');
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
                    $this->setIdProses($value->id_proses);
                    $this->setIdEvaluator($value->id_evaluator);
                    $this->setTypeEvaluator($value->type_evaluator);
                    $this->setIdStatusProses($value->id_status_proses);
                    $this->setTglKirim($value->tgl_kirim);
                    $this->setTglExpire($value->tgl_expire);
                    $this->setTglTerima($value->tgl_terima);
                    $this->setKeterangan($value->keterangan);
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
            $this->db->select('proses.*');
            $this->db->from('proses');
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
            $data = array('id_evaluator'=>  $this->idEvaluator,
                    'type_evaluator'=>  $this->typeEvaluator,
                    'tgl_kirim'=>  $this->tglKirim,
                    'tgl_terima'=> $this->tglTerima,
                    'tgl_expire'=> $this->tglExpire,
                    'id_status_proses'=>  $this->idStatusProses,
                    'keterangan'=>  $this->keterangan,
                    'revisi'=> $this->revisi);
                $this->db->insert('proses',$data);
	}

	public function update()
	{
            $data = array('id_evaluator'=>  $this->idEvaluator,
                    'type_evaluator'=>  $this->typeEvaluator,
                    'tgl_kirim'=>  $this->tglKirim,
                    'tgl_terima'=> $this->tglTerima,
                    'tgl_expire'=> $this->tglExpire,
                    'id_status_proses'=>  $this->idStatusProses,
                    'keterangan'=>  $this->keterangan,
                    'revisi'=> $this->revisi);
                $this->db->where('id_proses', $this->idProses);
                $this->db->update('proses',$data);
	}

}
?>