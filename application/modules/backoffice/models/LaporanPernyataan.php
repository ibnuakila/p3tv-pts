<?php




/**
 * @author ibnua
 * @version 1.0
 * @created 20-Dec-2022 2:38:03 PM
 */
class LaporanPernyataan extends CI_Model implements BaseModel
{

	private $filePath;
	private $id;
	private $idRegistrasi;
	private $uploadDate;

	function __construct($id=null)
	{
            parent::__construct();
            if($id!=null){
                $qry = "SELECT * FROM laporan_pernyataan WHERE id='".$id."' ".
                        "OR id_registrasi='".$id."'";
                $result = $this->db->query($qry);
                if($result->num_rows()>0){
                    $row = $result->row();
                    $this->id = $row->id;
                    $this->filePath = $row->filepath;
                    $this->uploadDate = $row->upload_date;
                    $this->idRegistrasi = $row->id_registrasi;
                }
            }
	}

	function __destruct()
	{
	}



	public function getFilePath()
	{
		return $this->filePath;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getIdRegistrasi()
	{
		return $this->idRegistrasi;
	}

	public function getUploadDate()
	{
		return $this->uploadDate;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setFilePath($newVal)
	{
		$this->filePath = $newVal;
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
	public function setIdRegistrasi($newVal)
	{
		$this->idRegistrasi = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setUploadDate($newVal)
	{
		$this->uploadDate = $newVal;
	}

    public function delete() {
        
    }

    public function get($row = Null, $segment = Null) {
        
    }

    public function getBy($field, $value) {
        
    }

    public function getByRelated($related, $field, $value, $row = Null, $segment = Null) {
        
    }

    public function insert() {
        
    }

    public function update() {
        
    }

}
?>