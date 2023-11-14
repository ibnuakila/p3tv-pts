<?php

require_once ('Evaluasiproses.php');
require_once ('Evaluatorevaluasi.php');
require_once ('Basemodel.php');

/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:46:26
 */
class Evaluasi extends CI_Model implements BaseModel {

    private $filePath;
    private $idEvaluasi;
    private $idStatusRegistrasi;
    private $keterangan;
    private $lastUpdate;
    private $revisi;
    private $skor;
    private $tglEvaluasi;
    private $objEvaluasiProses;
    private $objEvaluatorEvaluasi;
    private $objStatusRegistrasi;
    private $range;
    private $periode;
    private $idJnsEvaluasi;

    const table = 'evaluasi';

    function __construct($id = NULL) {
        parent::__construct();
        if ($id != NULL) {
            $this->db->select('*');
            $this->db->from('evaluasi');
            $this->db->where('id_evaluasi', $id);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $value) {
                    $this->setIdEvaluasi($value->id_evaluasi);
                    $this->setTglEvaluasi($value->tgl_evaluasi);
                    $this->setSkor($value->skor);
                    $this->setRange($value->range);
                    $this->setFilePath($value->file_path);
                    $this->setIdStatusRegistrasi($value->id_status_registrasi);
                    $this->setKeterangan($value->keterangan);
                    $this->setRevisi($value->revisi);
                    $this->setLastUpdate($value->last_update);
                    $this->setIdJnsEvaluasi($value->id_jns_evaluasi);
                }
            }
        }
    }

    function __destruct() {
        
    }

    public function getEvaluator() {
        $this->db->select('evaluator.*');
        $this->db->from('evaluator');
        $this->db->join('evaluator_evaluasi', 'evaluator.id_evaluator = evaluator_evaluasi.id_evaluator');
        //$this->db->join('evaluasi','evaluator_evaluasi.id_evaluasi = evaluator_evaluasi.id_evaluasi');
        $this->db->where('evaluator_evaluasi.id_evaluasi', $this->idEvaluasi);
        $result = $this->db->get();
        $this->objEvaluatorEvaluasi = null;
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $value) {
                $this->objEvaluatorEvaluasi = new Evaluator($value->id_evaluator);
            }
        }
        return $this->objEvaluatorEvaluasi;
    }

    public function getFilePath() {
        return $this->filePath;
    }

    public function getIdEvaluasi() {
        return $this->idEvaluasi;
    }

    public function getIdStatusRegistrasi() {
        return $this->idStatusRegistrasi;
    }

    public function getKeterangan() {
        return $this->keterangan;
    }

    public function getLastUpdate() {
        return $this->lastUpdate;
    }

    public function getProses() {
        $this->db->select('evaluasi_proses.*');
        $this->db->from('evaluasi');
        $this->db->join('evaluasi_proses', 'evaluasi.id_evaluasi = evaluasi_proses.id_evaluasi');
        //$this->db->join('evaluasi','evaluator_evaluasi.id_evaluasi = evaluator_evaluasi.id_evaluasi');
        $this->db->where('evaluasi_proses.id_evaluasi', $this->idEvaluasi);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            foreach ($result->result() as $value) {
                $this->objEvaluasiProses = new Proses($value->id_proses);
            }
        }
        return $this->objEvaluasiProses;
    }

    public function getRevisi() {
        return $this->revisi;
    }

    public function getSkor() {
        return $this->skor;
    }

    public function getTglEvaluasi() {
        return $this->tglEvaluasi;
    }

    /**
     * 
     * @param newVal
     */
    public function setFilePath($newVal) {
        $this->filePath = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setIdEvaluasi($newVal) {
        $this->idEvaluasi = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setIdStatusRegistrasi($newVal) {
        $this->idStatusRegistrasi = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setKeterangan($newVal) {
        $this->keterangan = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setLastUpdate($newVal) {
        $this->lastUpdate = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setRevisi($newVal) {
        $this->revisi = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setSkor($newVal) {
        $this->skor = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setTglEvaluasi($newVal) {
        $this->tglEvaluasi = $newVal;
    }

    public function delete() {
        $this->db->delete('evaluasi', array('id_evaluasi' => $this->idEvaluasi));
    }

    /**
     * 
     * @param row
     * @param segment
     */
    public function get($row = Null, $segment = Null) {
        $this->db->select('*');
        $this->db->from('evaluasi');
        if ($row == NULL && $segment == NULL) {
            return $this->db->count_all_results();
        } elseif ($row == 0 && $segment == 0) {
            return $this->db->get();
        } else {
            return $this->db->get('', $row, $segment);
        }
    }

    public function getStatusRegistrasi() {
        $this->db->select('*');
        $this->db->from('status_registrasi');
        $this->db->where('id_status_registrasi', $this->idStatusRegistrasi);
        $result = $this->db->get();
        $this->objStatusRegistrasi = NULL;
        if ($result->num_rows() > 0) {
            $this->objStatusRegistrasi = new StatusRegistrasi();
            foreach ($result->result() as $value) {
                $this->objStatusRegistrasi->setIdStatusRegistrasi($value->id_status_registrasi);
                $this->objStatusRegistrasi->setNamaStatus($value->nama_status);
            }
        }
        return $this->objStatusRegistrasi;
    }

    /**
     * 
     * @param field
     * @param value
     */
    public function getBy($field, $value) {
        $this->db->select('*');
        $this->db->from('evaluasi');
        $this->db->where($field, $value);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $value) {
                $this->setIdEvaluasi($value->id_evaluasi);
                $this->setTglEvaluasi($value->tgl_evaluasi);
                $this->setSkor($value->skor);
                $this->setFilePath($value->file_path);
                $this->setIdStatusRegistrasi($value->id_status_registrasi);
                $this->setKeterangan($value->keterangan);
                $this->setRevisi($value->revisi);
                $this->setLastUpdate($value->last_update);
                $this->setIdJnsEvaluasi($value->id_jns_evaluasi);
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param related
     * @param field
     * @param value
     */
    public function getByRelated($related, $field, $value, $row = Null, $segment = Null) {
        $this->db->select('evaluasi.*');
        $this->db->from('evaluasi');

        if ($related == 'evaluator_evaluasi') {
            $this->db->join('evaluator_evaluasi', 'evaluasi.id_evaluasi = evaluator_evaluasi.id_evaluasi');
            $this->db->where($related . '.' . $field, $value);
        } elseif ($related == 'proses') {
            $this->db->join('evaluasi_proses', 'evaluasi.id_evaluasi = evaluasi_proses.id_evaluasi');
            $this->db->join('proses', 'evaluasi_proses.id_proses = proses.id_proses');
            $this->db->join('proses_registrasi', 'proses.id_proses = proses_registrasi.id_proses');
            $this->db->like($related . '.' . $field, $value);
        } elseif ($related == 'registrasi') {
            $this->db->join('evaluasi_proses', 'evaluasi.id_evaluasi = evaluasi_proses.id_evaluasi');
            $this->db->join('proses', 'evaluasi_proses.id_proses = proses.id_proses');
            $this->db->join('proses_registrasi', 'proses.id_proses = proses_registrasi.id_proses');
            $this->db->join('registrasi', 'proses_registrasi.id_registrasi = registrasi.id_registrasi');
            $this->db->like($related . '.' . $field, $value);
        } elseif ($related == 'pti') {
            $this->db->join('evaluasi_proses', 'evaluasi.id_evaluasi = evaluasi_proses.id_evaluasi');
            $this->db->join('proses', 'evaluasi_proses.id_proses = proses.id_proses');
            $this->db->join('proses_registrasi', 'proses.id_proses = proses_registrasi.id_proses');
            $this->db->join('registrasi', 'proses_registrasi.id_registrasi = registrasi.id_registrasi');
            $this->db->join('tbl_pti', 'registrasi.kdpti = tbl_pti.kdpti');
            $this->db->like($related . '.' . $field, $value);
        } elseif ($related == 'status_registrasi') {
            $this->db->join('evaluasi_proses', 'evaluasi.id_evaluasi = evaluasi_proses.id_evaluasi');
            $this->db->join('proses', 'evaluasi_proses.id_proses = proses.id_proses');
            $this->db->join('proses_registrasi', 'proses.id_proses = proses_registrasi.id_proses');
            $this->db->join('registrasi', 'proses_registrasi.id_registrasi = registrasi.id_registrasi');
            $this->db->join('status_registrasi', 'registrasi.id_status_registrasi=status_registrasi.id_status_registrasi');
            $this->db->like($related . '.' . $field, $value);
        } elseif ($related == 'nama_penyelenggara') {
            $this->db->join('evaluasi_proses', 'evaluasi.id_evaluasi = evaluasi_proses.id_evaluasi');
            $this->db->join('proses', 'evaluasi_proses.id_proses = proses.id_proses');
            $this->db->join('proses_registrasi', 'proses.id_proses = proses_registrasi.id_proses');
            $this->db->join('registrasi', 'proses_registrasi.id_registrasi = registrasi.id_registrasi');
            $this->db->join('tbl_badan_penyelenggara', 'registrasi.kdpti = tbl_badan_penyelenggara.kdpti');
        }
        if ($this->periode != '') {
            $this->db->join('evaluasi_proses', 'evaluasi.id_evaluasi = evaluasi_proses.id_evaluasi');
            $this->db->join('proses', 'evaluasi_proses.id_proses = proses.id_proses');
            $this->db->join('proses_registrasi', 'proses.id_proses = proses_registrasi.id_proses');
            $this->db->join('registrasi', 'proses_registrasi.id_registrasi = registrasi.id_registrasi');
            $this->db->where_in('registrasi.periode', $this->periode);
        }
        if (is_object($this->objEvaluatorEvaluasi)) {
            $this->db->join('evaluator_evaluasi', 'evaluasi.id_evaluasi = evaluator_evaluasi.id_evaluasi');
            $this->db->where('evaluator_evaluasi.id_evaluator', $this->objEvaluatorEvaluasi->getIdEvaluator());
        }
        if ($row == NULL && $segment == NULL) {
            return $this->db->count_all_results();
        } elseif ($row == 0 && $segment == 0) {
            return $this->db->get();
        } else {
            return $this->db->get('', $row, $segment);
        }
    }

    public function insert() {
        $data = array('id_evaluasi' => $this->idEvaluasi,
            'tgl_evaluasi' => $this->tglEvaluasi,
            'skor' => $this->skor,
            'range' => $this->range,
            'keterangan' => $this->keterangan,
            'last_update' => $this->lastUpdate,
            'id_status_registrasi' => $this->idStatusRegistrasi,
            'file_path' => $this->filePath,
            'revisi' => $this->revisi,
            'id_jns_evaluasi' => $this->idJnsEvaluasi);
        $insert = $this->db->insert('evaluasi', $data);
        $this->db->select_max('id_evaluasi');
        $this->db->from('evaluasi');
        $result = $this->db->get();
        foreach ($result->result() as $row) {
            //$this->idEvaluasi = $row->id_evaluasi;
        }
        return $insert;
    }

    public function update() {
        $data = array('id_evaluasi' => $this->idEvaluasi,
            'tgl_evaluasi' => $this->tglEvaluasi,
            'skor' => $this->skor,
            'range' => $this->range,
            'keterangan' => $this->keterangan,
            'last_update' => $this->lastUpdate,
            'id_status_registrasi' => $this->idStatusRegistrasi,
            'file_path' => $this->filePath,
            'revisi' => $this->revisi,
            'id_jns_evaluasi' => $this->idJnsEvaluasi);
        $this->db->where('id_evaluasi', $this->idEvaluasi);
        $update = $this->db->update('evaluasi', $data);
        return $update;
    }

    public function isExist($idproses) {
        $this->db->select('e.*');
        $this->db->from('evaluasi e');
        $this->db->join('evaluasi_proses ep', 'e.id_evaluasi = ep.id_evaluasi');
        //$this->db->where('e.id_evaluasi',$this->idEvaluasi);
        $this->db->where('ep.id_proses', $idproses);
        $result = $this->db->get();
        //echo 'numrows: '.$result->num_rows();
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $this->setIdEvaluasi($row->id_evaluasi);
            }
            return true;
        } else {
            return false;
        }
    }

    public function generateId($idevaluator) {
        //nomor otomatis
        $thn = date('y');
        $bln = date('m');
        $tgl = date('d');
        $tempno = $tgl . $bln . $thn;
        //$kdevaluator = $this->session->userdata('username');
        $qry = "SELECT * FROM evaluasi e
				INNER JOIN evaluator_evaluasi ee ON e.id_evaluasi=ee.id_evaluasi 
				WHERE e.id_evaluasi LIKE'" . $tempno . "%' AND id_evaluator='"
                . $idevaluator . "' order by e.id_evaluasi";

        $result = $this->db->query($qry);
        $tempno = '';
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $tempno = $row->id_evaluasi;
            }
            $tempno = substr($tempno, 6, 2);
            $tempno = $tempno + 1;
            if (strlen($tempno) == 1) {
                $tempno = '0' . $tempno;
            }
            $tempno = $tgl . $bln . $thn . $tempno . $idevaluator;
        } else {
            $tempno = $tgl . $bln . $thn . '01' . $idevaluator;
        }

        return $tempno;
    }

    public function getRange() {
        return $this->range;
    }

    /**
     * 
     * @param newVal
     */
    public function setRange($newVal) {
        $this->range = $newVal;
    }

    public function getPeriode() {
        return $this->periode;
    }

    /**
     * 
     * @param newVal
     */
    public function setPeriode($newVal) {
        $this->periode = $newVal;
    }

    public function setEvaluator($objEvaluator) {
        $this->objEvaluatorEvaluasi = $objEvaluator;
    }

    public function getIdJnsEvaluasi() {
        return $this->idJnsEvaluasi;
    }

    /**
     * 
     * @param newVal
     */
    public function setIdJnsEvaluasi($newVal) {
        $this->idJnsEvaluasi = $newVal;
    }

    public function getResult($params) {
        $this->db->select(self::table . '.*');
        $this->db->from(self::table);

        $count = false;
        foreach ($params as $key => $value) {
            if ($key == 'join') {
                foreach ($value as $key => $sub_value) {
                    foreach ($sub_value as $operator => $value) {
                        $this->db->join($key, $value, $operator);
                    }
                }
            }
            if ($key == 'field') {
                foreach ($value as $key => $sub_value) {
                    foreach ($sub_value as $operator => $item) {
                        if ($operator == 'IN') {
                            $this->db->where_in($key, $item);
                        } elseif ($operator == 'NOT IN') {
                            $this->db->where_not_in($key, $item);
                        } elseif ($operator == 'LIKE') {
                            $this->db->like('lower(' . $key . ')', strtolower($item));
                        } elseif ($operator == 'BETWEEN') {
                            $where = $key . " " . $operator . " '" . $item[0] . "' AND '" . $item[1] . "'";
                            $this->db->where($where);
                        } else {
                            $this->db->where($key . $operator, $item);
                        }
                    }
                }
            }

            if ($key == 'paging') {
                foreach ($value as $key => $value) {
                    if ($key == 'row') {
                        $row = $value;
                    } else {
                        $segment = $value;
                    }
                }
            }
            if ($key == 'count') {
                $count = $value;
            }
            if ($key == 'order') {
                foreach ($value as $key => $value) {
                    $this->db->order_by($key, $value);
                }
            }
        }
        if ($count) {
            return $this->db->count_all_results();
        } elseif ($row == 0 && $segment == 0) {
            return $this->db->get();
        } else {
            return $this->db->get('', $row, $segment);
        }
    }

}

?>