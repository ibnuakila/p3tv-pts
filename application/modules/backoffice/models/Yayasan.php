<?php
require_once ('Pti.php');
require_once ('Basemodel.php');





/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:38:56
 */
class Yayasan extends CI_Model implements BaseModel
{

	private $alamat;
	private $idYayasan;
	private $ketua;
	private $kota;
	private $namaYayasan;
	private $objPti;

	function __construct($id=NULL)
	{
            parent::__construct();
            if($id != NULL){
                $this->db->select('*');         
                $this->db->from('yayasan');
                $this->db->where('id_yayasan',$id);
                $result = $this->db->get();
                if($result->num_rows()>0){
                    foreach ($result->result() as $value){
                        $this->setIdYayasan($value->id_yayasan);
                        $this->setKetua($value->ketua);
                        $this->setNamaYayasan($value->nama_yayasan);
                        $this->setAlamat($value->alamat);
                        $this->setKota($value->kota);
                        
                    }
                }
            }
	}

	function __destruct()
	{
	}



	public function getAlamat()
	{
		return $this->alamat;
	}

	public function getIdYayasan()
	{
		return $this->idYayasan;
	}

	public function getKetua()
	{
		return $this->ketua;
	}

	public function getKota()
	{
		return $this->kota;
	}

	public function getNamaYayasan()
	{
		return $this->namaYayasan;
	}

	public function getPti()
	{
            $this->db->select('*');
            $this->db->from('pti');
            $this->db->where('id_yayasan',  $this->idYayasan);
            $result = $this->db->get();
            $this->objPti = new ArrayObject();
            if($result->num_rows()>0){                
                foreach ($result->result() as $obj){
                    $pti = new Pti($obj->kdpti);
                    $this->objPti->append($pti);
                }                    
            }
            return $this->objPti;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setAlamat($newVal)
	{
		$this->alamat = $newVal;
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
	public function setKetua($newVal)
	{
		$this->ketua = $newVal;
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
	public function setNamaYayasan($newVal)
	{
		$this->namaYayasan = $newVal;
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
            $this->db->from('yayasan');
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
            $this->db->from('yayasan');
            $this->db->where($field, $value);
            $result = $this->db->get();
            if($result->num_rows()>0){
                foreach ($result->result() as $value){
                    $this->setIdYayasan($value->id_yayasan);
                    $this->setKetua($value->ketua);
                    $this->setNamaYayasan($value->nama_yayasan);
                    $this->setAlamat($value->alamat);
                    $this->setKota($value->kota);
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
            $this->db->select('yayasan.*');
            $this->db->from('yayasan');
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