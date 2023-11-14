<?php

//require_once ('imodel.php');

/**
 * @author user
 * @version 1.0
 * @created 26-Aug-2014 11:58:49 AM
 */
class BobotNilai extends CI_Model implements BaseModel {

    private $aspek;
    private $bobot;
    private $idAspek;
    private $keteranganAspek;
    private $noAspek;
    //private $typeBobot;
    private $idBobot;
    private $jnsUsulan;
    private $uraian;
    private $periode;

    function __construct($id = '') {
        parent::__construct();
        $sql = "SELECT * FROM bobot_nilai WHERE id_bobot='" . $id . "'";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            foreach ($result->result('array') as $value) {
                $this->setIdBobot($value['id_bobot']);
                $this->setIdAspek($value['id_aspek']);
                $this->setNoAspek($value['no_aspek']);
                $this->setBobot($value['bobot']);
                $this->setAspek($value['aspek']);
                $this->setKeteranganAspek($value['ket_aspek']);
                $this->setJnsUsulan($value['jns_usulan']);
                $this->setUraian($value['uraian']);
                $this->setPeriode($value['periode']);
            }
        }
    }

    function __destruct() {
        
    }

    public function getAspek() {
        return $this->aspek;
    }

    public function getBobot() {
        return $this->bobot;
    }

    public function getIdAspek() {
        return $this->idAspek;
    }

    public function getKeteranganAspek() {
        return $this->keteranganAspek;
    }

    public function getNoAspek() {
        return $this->noAspek;
    }

    public function getPeriode() {
        return $this->periode;
    }

    /**
     * 
     * @param newVal
     */
    public function setAspek($newVal) {
        $this->aspek = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setBobot($newVal) {
        $this->bobot = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setIdAspek($newVal) {
        $this->idAspek = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setKeteranganAspek($newVal) {
        $this->keteranganAspek = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setNoAspek($newVal) {
        $this->noAspek = $newVal;
    }

    public function setPeriode($newVal) {
        $this->periode = $newVal;
    }

    public function insert() {
        $data = array('id_bobot' => $this->getIdBobot(),
            'id_aspek' => $this->getIdAspek(),
            'no_aspek' => $this->getNoAspek(),
            'bobot' => $this->getBobot(),
            'aspek' => $this->getAspek(),
            'ket_aspek' => $this->getKeteranganAspek(),
            'jns_usulan' => $this->getJnsUsulan(),
            'uraian' => $this->getUraian(),
            'periode' => $this->getPeriode()
        );
        $this->db->insert('bobot_nilai', $data);
    }

    public function update() {
        
    }

    public function delete() {
        
    }

    /**
     * 
     * @param row
     * @param segment
     */
    public function get($row = Null, $segment = Null) {
        $list = new ArrayObject();
        $this->db->select('*');
        $this->db->from('bobot_nilai');
        if ($this->periode != '') {
            if($this->periode >= '20221'){
                $periode = '20221';
            $this->db->where('periode', $periode);            
            }elseif($this->periode >= '20211'){
                $periode = '20211';
                $this->db->where('periode', $periode);
            }elseif($this->periode >= '20201'){
                $periode = '20201';
                $this->db->where('periode', $periode);
            }else{
                $this->db->where('periode', $this->periode);
            }
            
        }
        if($this->aspek != ''){
            if($this->periode >= '20201'){
                $skema = 'A';
                $this->db->where('aspek', $skema);
            }else{
                $this->db->where('aspek', $this->aspek);
            }
            
        }
        $result = '';
        if ($row == '' && $segment == '') {
            $this->db->order_by('no_aspek', 'asc');
            $result = $this->db->get('');
        } else {
            $result = $this->db->get('', $row, $segment);
        }
        foreach ($result->result('array') as $row) {
            $obj = new BobotNilai($row['id_bobot']);
            $list->append($obj);
        }
        return $list;
    }

    public function getBy($field, $value) {
        $this->db->select('*');
        $this->db->from('bobot_nilai');
        $this->db->where($field, $value);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            foreach ($result->result('array') as $value) {
                $this->setIdBobot($value['id_bobot']);
                $this->setIdAspek($value['id_aspek']);
                $this->setNoAspek($value['no_aspek']);
                $this->setBobot($value['bobot']);
                $this->setAspek($value['aspek']);
                $this->setKeteranganAspek($value['ket_aspek']);
                $this->setJnsUsulan($value['jns_usulan']);
                $this->setUraian($value['uraian']);
                $this->setPeriode($value['periode']);
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getByRelated($related, $field, $value, $row = Null, $segment = Null) {
        $this->db->select('*');
        $this->db->from('bobot_nilai');
        $this->db->like($related . '.' . $field, $value);
        if ($row == NULL && $segment == NULL) {
            return $this->db->count_all_results();
        } elseif ($row == 0 && $segment == 0) {
            return $this->db->get();
        } else {
            return $this->db->get('', $row, $segment);
        }
    }

    public function getIdBobot() {
        return $this->idBobot;
    }

    /**
     * 
     * @param newVal
     */
    public function setIdBobot($newVal) {
        $this->idBobot = $newVal;
    }

    public function getJnsUsulan() {
        return $this->jnsUsulan;
    }

    /**
     * 
     * @param newVal
     */
    public function setJnsUsulan($newVal) {
        $this->jnsUsulan = $newVal;
    }

    public function getUraian() {
        return $this->uraian;
    }

    /**
     * 
     * @param newVal
     */
    public function setUraian($newVal) {
        $this->uraian = $newVal;
    }

}

?>