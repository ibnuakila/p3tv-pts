<?php
require_once ('ptiprodi.php');
require_once ('yayasan.php');
require_once ('basemodel.php');





/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:39:22
 */
class Pti extends CI_Model implements BaseModel
{

	private $cluster;
	private $idYayasan;
	private $kdPti;
	private $kota;
	private $nmPti;
	private $peringkat;
	private $objPtiProdi;
	private $objYayasan;

	function __construct($id=NULL)
	{
            parent::__construct();
            if($id != NULL){
                $this->db->select('*');         
                $this->db->from('pti');
                $this->db->where('kdpti',$id);
                $result = $this->db->get();
                if($result->num_rows()>0){
                    foreach ($result->result() as $value){
                        $this->setKdPti($value->kdpti);
                        $this->setNmPti($value->nmpti);
                        $this->setKota($value->kota);
                        $this->setIdYayasan($value->id_yayasan);
                        $this->setCluster($value->cluster);
                        $this->setPeringkat($value->peringkat);
                    }
                }
            }
	}

	function __destruct()
	{
	}



	public function getCluster()
	{
		return $this->cluster;
	}

	public function getIdYayasan()
	{
		return $this->idYayasan;
	}

	public function getKdPti()
	{
		return $this->kdPti;
	}

	public function getKota()
	{
		return $this->kota;
	}

	public function getNmPti()
	{
		return $this->nmPti;
	}

	public function getPeringkat()
	{
		return $this->peringkat;
	}

	public function getProdi()
	{
            $this->db->select('prodi.*');
            $this->db->from('prodi');
            $this->db->join('pti_prodi','prodi.id_prodi = pti_prodi.id_prodi');
            $this->db->join('pti','pti_prodi.kdpti = pti.kdpti');
            $this->db->where('pti.kdpti',  $this->kdPti);
            $result = $this->db->get();
            $this->objPtiProdi = new ArrayObject();
            if($result->num_rows()>0){                
                foreach ($result->result() as $obj){
                    $pti = new Prodi($obj->id_prodi);
                    $this->objPtiProdi->append($pti);
                }                    
            }
            return $this->objPtiProdi;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setCluster($newVal)
	{
		$this->cluster = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdYayasan($newVal)
	{
		$this->idYayasan = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setKdPti($newVal)
	{
		$this->kdPti = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setKota($newVal)
	{
		$this->kota = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setNmPti($newVal)
	{
		$this->nmPti = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setPeringkat($newVal)
	{
		$this->peringkat = $newVal;
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
            $this->db->from('pti');
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
            $this->db->from('pti');
            $this->db->where($field, $value);
            $result = $this->db->get();
            if($result->num_rows()>0){
                foreach ($result->result() as $value){
                    $this->setKdPti($value->kdpti);
                    $this->setNmPti($value->nmpti);
                    $this->setKota($value->kota);
                    $this->setIdYayasan($value->id_yayasan);
                    $this->setCluster($value->cluster);
                    $this->setPeringkat($value->peringkat);
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
            $this->db->select('pti.*');
            $this->db->from('pti');
            $this->db->join('yayasan','pti.id_yayasan = yayasan.id_yayasan');
            $this->db->join('account','yayasan.id_yayasan = account.id_yayasan');
            $this->db->join('registrasi','account.id_account = registrasi.id_account');
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
	}

	public function update()
	{
	}

}
?>