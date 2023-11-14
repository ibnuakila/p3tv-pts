<?php
require_once ('basemodel.php');





/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:46:56
 */
class Evaluator extends CI_Model implements BaseModel
{

	private $bidang;
	private $email;
	private $foto;
	private $idEvaluator;
	private $institusi;
	private $nmEvaluator;
	private $telepon;

	function __construct($id=NULL)
	{
		parent::__construct();
		if($id != NULL){
			$this->db->select('*');
			$this->db->from('evaluator');
			$this->db->where('id_evaluator',$id);
			$result = $this->db->get();
			if($result->num_rows()>0){
				foreach ($result->result() as $value){
					$this->setIdEvaluator($value->id_evaluator);
					$this->setNmEvaluator($value->nm_evaluator);
					$this->setBidang($value->bidang);
					$this->setEmail($value->email);
					$this->setTelepon($value->telepon);
					$this->setInstitusi($value->institusi);
					$this->setFoto($value->foto);
					
				}
			}
		}
	}

	function __destruct()
	{
	}



	public function getBidang()
	{
		return $this->bidang;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getFoto()
	{
		return $this->foto;
	}

	public function getIdEvaluator()
	{
		return $this->idEvaluator;
	}

	public function getInstitusi()
	{
		return $this->institusi;
	}

	public function getNmEvaluator()
	{
		return $this->nmEvaluator;
	}

	public function getTelepon()
	{
		return $this->telepon;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setBidang($newVal)
	{
		$this->bidang = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setEmail($newVal)
	{
		$this->email = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setFoto($newVal)
	{
		$this->foto = $newVal;
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
	public function setInstitusi($newVal)
	{
		$this->institusi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setNmEvaluator($newVal)
	{
		$this->nmEvaluator = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTelepon($newVal)
	{
		$this->telepon = $newVal;
	}

	public function delete()
	{
		$this->db->delete('evaluasi', array('id_evaluator'=>  $this->idEvaluator));
	}

	/**
	 * 
	 * @param row
	 * @param segment
	 */
	public function get($row = Null, $segment = Null)
	{
		$this->db->select('*');
		$this->db->from('evaluator');
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
		$this->db->from('evaluator');
		$this->db->where($field, $value);
		$result = $this->db->get();
		if($result->num_rows()>0){
			foreach ($result->result() as $value){
				$this->setIdEvaluator($value->id_evaluator);
				$this->setNmEvaluator($value->nm_evaluator);
				$this->setBidang($value->bidang);
				$this->setEmail($value->email);
				$this->setTelepon($value->telepon);
				$this->setInstitusi($value->institusi);
				$this->setFoto($value->foto);
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
		$this->db->select('evaluator.*');
		$this->db->from('evaluator');		
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
		$data = array('id_evaluator'=>$this->idEvaluator,
				'nm_evaluator'=>$this->nmEvaluator,
				'institusi'=>$this->institusi,
				'bidang'=>$this->bidang,
				'telepon'=>$this->telepon,
				'email'=>$this->email,
				'foto'=>$this->foto);
		$this->db->insert('evaluator',$data);
	}

	public function update()
	{
		$data = array('id_evaluator'=>$this->idEvaluator,
				'nm_evaluator'=>$this->nmEvaluator,
				'institusi'=>$this->institusi,
				'bidang'=>$this->bidang,
				'telepon'=>$this->telepon,
				'email'=>$this->email,
				'foto'=>$this->foto);
		$this->db->where('id_evaluator',$this->idEvaluator);
		$this->db->update('evaluator',$data);
	}

}
?>