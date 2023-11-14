<?php

require_once ('Statusregistrasi.php');
require_once ('Basemodel.php');

/**
 * @author akil
 * @version 1.0
 * @created 21-Mar-2016 11:47:27
 */
class Rekapitulasi extends CI_Model implements BaseModel {

    private $idRegistrasi;
    private $idRekapitulasi;
    private $idStatusRegistrasi;
    private $keterangan;
    private $nilaiTotal;
    private $publish;
    private $revisi;
    private $tglPublish;
    private $tglRekap;
    private $objStatusRegistrasi;
    private $objEvaluasi;
    private $periode;
    private $fileBeritaAcara;
    private $fileDataBarang;

    const table = 'rekapitulasi';

    function __construct($id = NULL) {
        parent::__construct();
        if ($id != NULL) {
            $this->db->select('*');
            $this->db->from('rekapitulasi');
            $this->db->where('id_rekapitulasi', $id);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $value) {
                    $this->setIdRekapitulasi($value->id_rekapitulasi);
                    $this->setIdStatusRegistrasi($value->id_status_registrasi);
                    $this->setIdRegistrasi($value->id_registrasi);
                    $this->setNilaiTotal($value->nilai_total);
                    $this->setTglRekap($value->tgl_rekap);
                    $this->setPublish($value->publish);
                    $this->setTglPublish($value->tgl_publish);
                    $this->setFileBeritaAcara($value->file_berita_acara);
                    $this->setFileDataBarang($value->file_data_barang);
                    $this->setKeterangan($value->keterangan);
                }
            }
        }
    }

    function __destruct() {
        
    }

    public function getEvaluasi() {
        $this->db->select('evaluasi.*');
        $this->db->from('evaluasi');
        $this->db->join('evaluasi_rekapitulasi', 'evaluasi.id_evaluasi = evaluasi_rekapitulasi.id_evaluasi');
        //$this->db->join('rekapitulasi','evaluasi_rekapitulasi.id_rekapitulasi = rekapitulasi.id_rekapitulasi');
        $this->db->where('evaluasi_rekapitulasi.id_rekapitulasi', $this->idRekapitulasi);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            $this->objEvaluasi = new ArrayObject();
            foreach ($result->result() as $value) {
                $evaluasi = new Evaluasi($value->id_evaluasi);
                $this->objEvaluasi->append($evaluasi);
            }
        }
        return $this->objEvaluasi;
    }

    public function getIdRegistrasi() {
        return $this->idRegistrasi;
    }

    public function getIdRekapitulasi() {
        return $this->idRekapitulasi;
    }

    public function getIdStatusRegistrasi() {
        return $this->idStatusRegistrasi;
    }

    public function getKeterangan() {
        return $this->keterangan;
    }

    public function getNilaiTotal() {
        return $this->nilaiTotal;
    }

    public function getPublish() {
        return $this->publish;
    }

    public function getRevisi() {
        return $this->revisi;
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

    public function getTglPublish() {
        return $this->tglPublish;
    }

    public function getTglRekap() {
        return $this->tglRekap;
    }

    /**
     * 
     * @param newVal
     */
    public function setIdRegistrasi($newVal) {
        $this->idRegistrasi = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setIdRekapitulasi($newVal) {
        $this->idRekapitulasi = $newVal;
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
    public function setNilaiTotal($newVal) {
        $this->nilaiTotal = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setPublish($newVal) {
        $this->publish = $newVal;
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
    public function setTglPublish($newVal) {
        $this->tglPublish = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setTglRekap($newVal) {
        $this->tglRekap = $newVal;
    }

    public function delete() {
        $this->db->delete('rekapitulasi', array('id_rekapitulasi' => $this->idRekapitulasi));
    }

    /**
     * 
     * @param row
     * @param segment
     */
    public function get($row = Null, $segment = Null) {
        $this->db->select('*');
        $this->db->from('rekapitulasi');
        if ($this->periode != '') {
            $this->db->join('registrasi', 'rekapitulasi.id_registrasi = registrasi.id_registrasi');
            $this->db->where_in('registrasi.periode', $this->periode);
        }
        if ($row == NULL && $segment == NULL) {
            return $this->db->count_all_results();
        } elseif ($row == 0 && $segment == 0) {
            return $this->db->get();
        } else {
            return $this->db->get('', $row, $segment);
        }
    }

    /**
     * 
     * @param field
     * @param value
     */
    public function getBy($field, $value) {
        $this->db->select('*');
        $this->db->from('rekapitulasi');
        $this->db->where($field, $value);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $value) {
                $this->setIdRekapitulasi($value->id_rekapitulasi);
                $this->setIdStatusRegistrasi($value->id_status_registrasi);
                $this->setIdRegistrasi($value->id_registrasi);
                $this->setNilaiTotal($value->nilai_total);
                $this->setTglRekap($value->tgl_rekap);
                $this->setPublish($value->publish);
                $this->setTglPublish($value->tgl_publish);
                $this->setFileBeritaAcara($value->file_berita_acara);
                $this->setFileDataBarang($value->file_data_barang);
                $this->setKeterangan($value->keterangan);
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
        $this->db->select('rekapitulasi.*');
        $this->db->from('rekapitulasi');
        $this->db->join('registrasi', 'rekapitulasi.id_registrasi = registrasi.id_registrasi');
        $this->db->join('tbl_badan_penyelenggara', 'registrasi.kdpti = tbl_badan_penyelenggara.kdpti');
        $this->db->join('tbl_pti', 'registrasi.kdpti = tbl_pti.kdpti');
        $this->db->join('status_registrasi', 'registrasi.id_status_registrasi = status_registrasi.id_status_registrasi');
        $this->db->like($related . '.' . $field, $value);
        if ($row == NULL && $segment == NULL) {
            return $this->db->count_all_results();
        } elseif ($row == 0 && $segment == 0) {
            return $this->db->get();
        } else {
            return $this->db->get('', $row, $segment);
        }
    }

    public function insert() {
        $data = array('id_rekapitulasi' => $this->idRekapitulasi,
            'id_registrasi' => $this->idRegistrasi,
            'id_status_registrasi' => $this->idStatusRegistrasi,
            'nilai_total' => $this->nilaiTotal,
            'keterangan' => $this->keterangan,
            'tgl_rekap' => $this->tglRekap,
            'publish' => $this->publish,
            'tgl_publish' => $this->tglPublish,
            'revisi' => $this->revisi,
            'file_berita_acara' => $this->fileBeritaAcara,
            'file_data_barang' => $this->fileDataBarang);
        $insert = $this->db->insert('rekapitulasi', $data);

        $this->db->select_max('id_rekapitulasi');
        $this->db->from('rekapitulasi');
        $result = $this->db->get();
        foreach ($result->result() as $row) {
            $this->idRekapitulasi = $row->id_rekapitulasi;
        }
        return $insert;
    }

    public function update() {
        $data = array('id_rekapitulasi' => $this->idRekapitulasi,
            'id_registrasi' => $this->idRegistrasi,
            'id_status_registrasi' => $this->idStatusRegistrasi,
            'nilai_total' => $this->nilaiTotal,
            'keterangan' => $this->keterangan,
            'tgl_rekap' => $this->tglRekap,
            'publish' => $this->publish,
            'tgl_publish' => $this->tglPublish,
            'revisi' => $this->revisi,
            'file_berita_acara' => $this->fileBeritaAcara,
            'file_data_barang' => $this->fileDataBarang);
        $this->db->where('id_rekapitulasi', $this->idRekapitulasi);
        return $this->db->update('rekapitulasi', $data);
    }

    public function getRegistrasi() {
        $this->db->select('registrasi.*');
        $this->db->from('registrasi');
        //$this->db->join('proses_registrasi','registrasi.id_registrasi = proses_registrasi.id_registrasi');
        //$this->db->join('proses','proses_registrasi.id_proses = proses.id_proses');
        $this->db->where('id_registrasi', $this->idRegistrasi);
        $result = $this->db->get();
        $this->objRegistrasi = null;
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $obj) {
                $this->objRegistrasi = new Registrasi($obj->id_registrasi);
            }
        }
        return $this->objRegistrasi;
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

    public function getFileBeritaAcara() {
        return $this->fileBeritaAcara;
    }

    public function getFileDataBarang() {
        return $this->fileDataBarang;
    }

    /**
     * 
     * @param newVal
     */
    public function setFileBeritaAcara($newVal) {
        $this->fileBeritaAcara = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setFileDataBarang($newVal) {
        $this->fileDataBarang = $newVal;
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