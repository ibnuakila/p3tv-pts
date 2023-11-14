<?php
require_once ('Basemodel.php');




//use ;
/**
 * @author LENOVO
 * @version 1.0
 * @created 18-Sep-2018 10:27:41 AM
 */
class TerimaBarang extends CI_Model implements BaseModel
{

	private $cekGaransi;
	private $cekKondisi;
	private $cekSesuai;
	private $fileTerima;
	private $fotoBarang;
	private $idDetailKirim;
	private $idDetailPaket;
	private $idTerima;
	private $ketKondisi;
	private $postingDate;
	private $receiveDate;
	private $terima;

	function __construct($id='')
	{
            parent::__construct();
		if($id != ''){
			$sql = "SELECT * FROM tbl_terima_barang WHERE id_terima ='".$id."'";
			$result = $this->db->query($sql);
			if($result->num_rows()>0){
				foreach ($result->result('array') as $value) {
					$this->setIdTerima($value['id_terima']);
					$this->setTerima($value['terima']);
					$this->setFileTerima($value['fileterima']);
					$this->setCekSesuai($value['ceksesuai']);
					$this->setCekKondisi($value['cekkondisi']);
					$this->setKetKondisi($value['ketkondisi']);
                                        $this->setCekGaransi($value['cekgaransi']);
                                        $this->setFotoBarang($value['fotobarang']);
                                        $this->setReceiveDate($value['receive_date']);
                                        $this->setPostingDate($value['posting_date']);
                                        $this->setIdDetailPaket($value['id_detail_paket']);
                                        $this->setIdDetailKirim($value['id_detail_kirim']);
				}
			}
		}
	}

	function __destruct()
	{
	}



	public function getCekGaransi()
	{
		return $this->cekGaransi;
	}

	public function getCekKondisi()
	{
		return $this->cekKondisi;
	}

	public function getCekSesuai()
	{
		return $this->cekSesuai;
	}

	public function getFileTerima()
	{
		return $this->fileTerima;
	}

	public function getFotoBarang()
	{
		return $this->fotoBarang;
	}

	public function getIdDetailKirim()
	{
		return $this->idDetailKirim;
	}

	public function getIdDetailPaket()
	{
		return $this->idDetailPaket;
	}

	public function getIdTerima()
	{
		return $this->idTerima;
	}

	public function getKetKondisi()
	{
		return $this->ketKondisi;
	}

	public function getPostingDate()
	{
		return $this->postingDate;
	}

	public function getReceiveDate()
	{
		return $this->receiveDate;
	}

	public function getTerima()
	{
		return $this->terima;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setCekGaransi($newVal)
	{
		$this->cekGaransi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setCekKondisi($newVal)
	{
		$this->cekKondisi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setCekSesuai($newVal)
	{
		$this->cekSesuai = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setFileTerima($newVal)
	{
		$this->fileTerima = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setFotoBarang($newVal)
	{
		$this->fotoBarang = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdDetailKirim($newVal)
	{
		$this->idDetailKirim = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdDetailPaket($newVal)
	{
		$this->idDetailPaket = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdTerima($newVal)
	{
		$this->idTerima = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setKetKondisi($newVal)
	{
		$this->ketKondisi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setPostingDate($newVal)
	{
		$this->postingDate = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setReceiveDate($newVal)
	{
		$this->receiveDate = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTerima($newVal)
	{
		$this->terima = $newVal;
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
            //$sql = "SELECT * FROM tbl_terima_barang WHERE id_terima ='".$id."'";
            $this->db->select("*");
            $this->db->from("tbl_terima_barang");
            $this->db->where($field, $value);
            $result = $this->db->get();
            if($result->num_rows()>0){
                foreach ($result->result('array') as $value) {
                    $this->setIdTerima($value['id_terima']);
                    $this->setTerima($value['terima']);
                    $this->setFileTerima($value['fileterima']);
                    $this->setCekSesuai($value['ceksesuai']);
                    $this->setCekKondisi($value['cekkondisi']);
                    $this->setKetKondisi($value['ketkondisi']);
                    $this->setCekGaransi($value['cekgaransi']);
                    $this->setFotoBarang($value['fotobarang']);
                    $this->setReceiveDate($value['receive_date']);
                    $this->setPostingDate($value['posting_date']);
                    $this->setIdDetailPaket($value['id_detail_paket']);
                    $this->setIdDetailKirim($value['id_detail_kirim']);
                }
            }
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