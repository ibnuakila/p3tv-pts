<?php
require_once ('basemodel.php');





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
            if($row==NULL && $segment==NULL){
                return $this->db->count_all_results();
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

}
?>