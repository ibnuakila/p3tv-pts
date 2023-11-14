<?php
require_once ('Evaluasi.php');
require_once ('Rekapitulasi.php');
require_once ('Basemodel.php');





/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:47:12
 */
class EvaluasiRekapitulasi extends CI_Model implements BaseModel
{

	private $id;
	private $idEvaluasi;
	private $idRekapitulasi;
	private $objEvaluasi;
	private $objRekapitulasi;

	function __construct($id=NULL)
	{
		parent::__construct();
		if($id != NULL){
			$this->db->select('*');
			$this->db->from('evaluasi_rekapitulasi');
			$this->db->where('id',$id);
			$result = $this->db->get();
			if($result->num_rows()>0){
				foreach ($result->result() as $value){
					$this->setId($value->id);
					$this->setIdEvaluasi($value->id_evaluasi);
					$this->setIdRekapitulasi($value->id_rekapitulasi);					
				}
			}
		}
	}

	function __destruct()
	{
	}



	public function getId()
	{
		return $this->id;
	}

	public function getIdEvaluasi()
	{
		return $this->idEvaluasi;
	}

	public function getIdRekapitulasi()
	{
		return $this->idRekapitulasi;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setId($newVal)
	{
		$this->id = $newVal;
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
	public function setIdRekapitulasi($newVal)
	{
		$this->idRekapitulasi = $newVal;
	}

	public function delete()
	{
		$this->db->delete('evaluasi_rekapitulasi', array('id_rekapitulasi'=>  $this->idRekapitulasi));
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
		$data = array('id_evaluasi'=>$this->idEvaluasi,'id_rekapitulasi'=>$this->idRekapitulasi);
		$this->db->insert('evaluasi_rekapitulasi',$data);
	}

	public function update()
	{
	}

}
?>