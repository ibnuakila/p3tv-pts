<?php
require_once ('Basemodel.php');





/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:41:07
 */
class Dokumen extends CI_Model implements BaseModel
{

	private $formGroup;
	private $formName;
	private $idForm;
	private $keterangan;
        private $skema;
        private $periode;
	private $jnsUsulan;

	function __construct($id=NULL)
	{
            parent::__construct();
            if($id != NULL){
                $this->db->select('*');         
                $this->db->from('dokumen');
                $this->db->where('id_form',$id);
                
                $result = $this->db->get();
                if($result->num_rows()>0){
                    foreach ($result->result() as $value){
                        $this->setIdForm($value->id_form);
                        $this->setFormName($value->form_name);
                        $this->setFormGroup($value->form_group);
                        $this->setKeterangan($value->keterangan); 
                        $this->setSkema($value->skema);
                        $this->setPeriode($value->periode);
                    }
                }
            }
	}

	function __destruct()
	{
	}



	public function getFormGroup()
	{
		return $this->formGroup;
	}

	public function getFormName()
	{
		return $this->formName;
	}

	public function getIdForm()
	{
		return $this->idForm;
	}

	public function getKeterangan()
	{
		return $this->keterangan;
	}

        public function getSkema() {
            return $this->skema;
        }
	/**
	 * 
	 * @param newVal
	 */
	public function setFormGroup($newVal)
	{
		$this->formGroup = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setFormName($newVal)
	{
		$this->formName = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdForm($newVal)
	{
		$this->idForm = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setKeterangan($newVal)
	{
		$this->keterangan = $newVal;
	}
        
        public function setSkema($newVal)
        {
            $this->skema = $newVal;
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
            $this->db->from('dokumen');
            $this->db->where('skema', $this->skema);
            //$this->db->where('jns_usulan', $this->jnsUsulan);
            //if($this->periode >= '20191'){
            	//$this->db->where('periode', '20191');
            //}else{
            	$this->db->where('periode', $this->periode);
            //}
            
            if($row==NULL && $segment==NULL){
                return $this->db->count_all_results();
            }elseif($row=='0' && $segment=='0'){
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
            $this->db->from('dokumen');
            $this->db->where($field, $value);
            $result = $this->db->get();
            if($result->num_rows()>0){
                foreach ($result->result() as $value){
                    $this->setIdForm($value->id_form);
                    $this->setFormName($value->form_name);
                    $this->setFormGroup($value->form_group);
                    $this->setKeterangan($value->keterangan); 
                }
                return TRUE;
            }else{
                return FALSE;
            }
	}
	
	public function getByArray(array $params)
	{
            $this->db->select('*');
            $this->db->from('dokumen');
			if(count($params)>0){
	                foreach ($params as $key => $value) {
	                    $this->db->where($key, $value);
	                }                
            }
            //$this->db->where($field, $value);
            $result = $this->db->get();
            if($result->num_rows()>0){
                foreach ($result->result() as $value){
                    $this->setIdForm($value->id_form);
                    $this->setFormName($value->form_name);
                    $this->setFormGroup($value->form_group);
                    $this->setKeterangan($value->keterangan); 
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
            $this->db->select('dokumen.*');
            $this->db->from('dokumen');
            $this->db->join('dokumen_registrasi','dokumen.id_form = dokumen_registrasi.id_form');
            $this->db->join('registrasi','dokumen_registrasi.id_registrasi = registrasi.id_registrasi');
            $this->db->like($related.'.'.$field, $value);
            if($row==NULL && $segment==NULL){
                return $this->db->count_all_results();
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
	
	public function setPeriode($newVal)
	{
		$this->periode = $newVal;
	}
	
	public function getPeriode()
	{
		return $this->periode;
	}

	public function getJnsUsulan()
	{
		return $this->jnsUsulan;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setJnsUsulan($newVal)
	{
		$this->jnsUsulan = $newVal;
	}

}
?>