<?php
require_once ('Basemodel.php');

//namespace models;



//use models;
/**
 * @author LENOVO
 * @version 1.0
 * @created 29-May-2020 10:02:35 AM
 */
class ItemOngkir extends CI_Model implements BaseModel
{

	private $idRegistrasi;
	private $kdPti;
	private $ongkirKg;

	function __construct($id=null)
	{
            parent::__construct();
            if ($id != null) {
                $this->db->select('*');
                $this->db->from('tbl_item_ongkir');
                $this->db->where('id_registrasi', $id);
                $result = $this->db->get();
                if ($result->num_rows() > 0) {
                    $row = $result->row();
                    $this->idRegistrasi = $row->id_registrasi;
                    $this->kdPti = $row->kdpti;
                    $this->ongkirKg = $row->ongkir_kg;

                }
            }
	}

	function __destruct()
	{
	}



	public function getIdRegistrasi()
	{
		return $this->idRegistrasi;
	}

	public function getKdPti()
	{
		return $this->kdPti;
	}

	public function getOngkirKg()
	{
		return $this->ongkirKg;
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
	public function setKdPti($newVal)
	{
		$this->kdPti = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setOngkirKg($newVal)
	{
		$this->ongkirKg = $newVal;
	}

	public function delete()
	{
	}

	/**
	 * 
	 * @param row
	 * @param segment    segment
	 */
	public function get($row = Null, $segment = Null)
	{
	}

	/**
	 * 
	 * @param field
	 * @param value    value
	 */
	public function getBy($field, $value)
	{
	}

	/**
	 * 
	 * @param related
	 * @param field
	 * @param value    value
	 * @param row
	 * @param segment
	 */
	public function getByRelated($related, $field, $value, $row = Null, $segment = Null)
	{
	}

	public function insert()
	{
	}

	public function update()
	{
	}

}
?>