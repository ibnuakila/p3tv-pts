<?php
require_once ('registrasi.php');
require_once ('basemodel.php');





/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:41:20
 */
class ProsesRegistrasi extends CI_Model implements BaseModel
{

	private $id;
	private $idProses;
	private $idRegistrasi;
	private $objRegistrasi;

	function __construct($id=NULL)
	{
            parent::__construct();
            if($id != NULL){
                $this->db->select('*');         
                $this->db->from('proses_registrasi');
                $this->db->where('id',$id);
                $result = $this->db->get();
                if($result->num_rows()>0){
                    foreach ($result->result() as $value){
                        $this->setId($value->id);
                        $this->setIdProses($value->id_proses);
                        $this->setIdRegistrasi($value->id_registrasi);
                        
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

	public function getIdProses()
	{
		return $this->idProses;
	}

	public function getIdRegistrasi()
	{
		return $this->idRegistrasi;
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
	public function setIdProses($newVal)
	{
		$this->idProses = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdRegistrasi($newVal)
	{
		$this->idRegistrasi = $newVal;
	}

	public function delete()
	{
            $this->db->delete('proses_registrasi', array('id'=>  $this->id));
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
            $data = array('id_registrasi'=>  $this->idRegistrasi, 'id_proses'=>  $this->idProses);
            $this->db->insert('proses_registrasi',$data);
	}

	public function update()
	{
            $data = array('id_registrasi'=>  $this->idRegistrasi, 'id_proses'=>  $this->idProses);
            $this->db->where('id',  $this->id);
            $this->db->update('proses_registrasi',$data);
	}

}
?>