<?php
//require_once ('modbobotnilai.php');
//require_once ('imodel.php');



/**
 * @author user
 * @version 1.0
 * @created 26-Aug-2014 11:58:58 AM
 */
class NilaiDetail extends CI_Model implements BaseModel
{

	
	private $komentar;
	private $nilai;	
	public $m_ModBobotNilai;
	private $idEvaluasi;
	private $idBobot;

	function __construct($id='', $idbobot='')
	{
            parent::__construct();
            if($id != ''){
                $sql = "SELECT * FROM nilai_detail WHERE id_evaluasi='".$id."' AND id_bobot='".$idbobot."'";
                $result = $this->db->query($sql);
                if($result->num_rows()>0){
                    foreach ($result->result('array') as $value) {
                        $this->setIdEvaluasi($value['id_evaluasi']);
                        $this->setNilai($value['nilai']);
                        $this->setKomentar($value['komentar']);
                        $this->setIdBobot($value['id_bobot']);
                    }
                }
            }
	}

	function __destruct()
	{
	}



	

	public function getKomentar()
	{
		return $this->komentar;
	}

	public function getNilai()
	{
		return $this->nilai;
	}

	

	

	/**
	 * 
	 * @param newVal
	 */
	public function setKomentar($newVal)
	{
		$this->komentar = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setNilai($newVal)
	{
		$this->nilai = $newVal;
	}

	

	public function insert()
	{
            $data = array('id_evaluasi'=>  $this->getIdEvaluasi(),
                    'id_bobot'=>  $this->getIdBobot(),
                    'nilai'=>  $this->getNilai(),
                    'komentar'=>  $this->getKomentar());
            return $this->db->insert('nilai_detail', $data);
                
	}

	public function update()
	{
            $data = array(
                    'nilai'=>  $this->getNilai(),
                    'komentar'=>  $this->getKomentar());
                $this->db->where('id_evaluasi',$this->getIdEvaluasi());
                $this->db->where('id_bobot', $this->getIdBobot());
                $this->db->update('nilai_detail', $data);
	}

	public function delete()
	{
            return $this->db->delete('nilai_detail', array('id_evaluasi'=>  $this->getIdEvaluasi()));
	}

	/**
	 * 
	 * @param row
	 * @param segment
	 */
	public function get($row = Null, $segment = Null)
	{
		$this->db->select('*');
		$this->db->from('nilai_detail');
		if ($this->idEvaluasi !=''){
			$this->db->where('id_evaluasi',$this->idEvaluasi);
		}
		$list = new ArrayObject();
		$result = '';
		if($row==NULL && $segment==NULL){
			//return $this->db->count_all_results();
		}elseif($row==0 && $segment==0){
			$result = $this->db->get();
		}else{
			$result = $this->db->get('', $row, $segment);
		}
		foreach($result->result('array') as $row){
			$obj = new NilaiDetail($row['id_evaluasi'],$row['id_bobot']);
			$list->append($obj);
		}
		return $list;
	}
	
	public function getBy($field, $value)
	{
		$this->db->select('*');
		$this->db->from('nilai_detail');
		$this->db->where($field, $value);
		$result = $this->db->get();
		if($result->num_rows()>0){
			foreach ($result->result() as $value){
				$this->setNoEvaluasi($value['id_evaluasi']);
                $this->setNilai($value['nilai']);
                $this->setKomentar($value['komentar']);
                $this->setIdBobot($value['id_bobot']);
			}
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	 * 
	 * @param criteria
	 * @param value
	 * @param row
	 * @param segment
	 */
	public function getByRelated($related, $field, $value, $row = Null, $segment = Null)
	{
		$this->db->select('evaluasi.*');
		$this->db->from('evaluasi');
		$this->db->join('evaluasi_proses','evaluasi.id_evaluasi = evaluasi_proses.id_evaluasi');
		$this->db->join('proses','evaluasi_proses.id_proses = proses.id_proses');
		$this->db->join('proses_registrasi','proses.id_proses = proses_registrasi.id_proses');
        $this->db->join('registrasi','proses_registrasi.id_registrasi = registrasi.id_registrasi');            
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

	
	public function getIdEvaluasi()
	{
		return $this->idEvaluasi;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdEvaluasi($newVal)
	{
		$this->idEvaluasi = $newVal;
	}

	public function getIdBobot()
	{
		return $this->idBobot;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setIdBobot($newVal)
	{
		$this->idBobot = $newVal;
	}

	

}
?>