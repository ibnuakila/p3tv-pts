<?php

require_once ('Basemodel.php');

//use ;
/**
 * @author akil
 * @version 1.0
 * @created 15-Jul-2016 11:21:29
 */
class ItemHibah extends CI_Model implements BaseModel {

    private $fileDesign;
    private $fileRab;
    private $idItem;
    private $id;
    private $idRegistrasi;
    private $hargaSatuan;
    private $subTotal;
    private $jmlItem;
    private $ongkirSatuan;
    private $periode;

    function __construct($id = '') {
        parent::__construct();
        if ($id != '') {
            $sql = "SELECT * FROM tbl_item_hibah WHERE id='" . $id . "'";
            $result = $this->db->query($sql);
            if ($result->num_rows() > 0) {
                foreach ($result->result('array') as $value) {
                    $this->setId($value['id']);
                    $this->setIdItem($value['id_item']);
                    $this->setJmlItem($value['jml_item']);
                    $this->setFileRab($value['file_rab']);
                    $this->setFileDesign($value['file_design']);
                    $this->setIdRegistrasi($value['id_registrasi']);
                    $this->setHargaSatuan($value['hrg_satuan']);
                    $this->setOngkirSatuan($value['ongkir_satuan']);
                    $this->setSubTotal($value['subtotal']);
                }
            }
        }
    }

    function __destruct() {
        
    }

    public function getFileDesign() {
        return $this->fileDesign;
    }

    public function getFileRab() {
        return $this->fileRab;
    }

    public function getIdItem() {
        return $this->idItem;
    }
    
    public function getPeriode() {
        return $this->periode;
    }

    /**
     * 
     * @param newVal
     */
    public function setFileDesign($newVal) {
        $this->fileDesign = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setFileRab($newVal) {
        $this->fileRab = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setIdItem($newVal) {
        $this->idItem = $newVal;
    }
    
    public function setPeriode($newVal) {
        $this->periode = $newVal;
    }

    public function delete() {
        return $this->db->delete('tbl_item_hibah', array('id' => $this->id));
    }

    /**
     * 
     * @param row
     * @param segment    segment
     */
    public function get($row = Null, $segment = Null) {
        $this->db->select('*');
        $this->db->from('tbl_item_hibah');
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
     * @param value    value
     */
    public function getBy($field, $value) {
        $this->db->select('*');
        $this->db->from('tbl_item_hibah');
        $this->db->where($field, $value);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            foreach ($result->result('array') as $value) {
                $this->setId($value['id']);
                $this->setIdItem($value['id_item']);
                $this->setJumlahItem($value['jml_item']);
                $this->setFileRab($value['file_rab']);
                $this->setFileDesign($value['file_design']);
                $this->setIdRegistrasi($value['id_registrasi']);
                $this->setHargaSatuan($value['hrg_satuan']);
                $this->setOngkirSatuan($value['ongkir_satuan']);
                $this->setSubTotal($value['subtotal']);
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getByArray($param) {
        if (is_array($param)) {
            $this->db->select('*');
            $this->db->from('tbl_item_hibah');

            foreach ($param as $key => $val) {
                $this->db->where($key, $val);
            }
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                foreach ($result->result('array') as $value) {
                    $this->setId($value['id']);
                    $this->setIdItem($value['id_item']);
                    $this->setJmlItem($value['jml_item']);
                    $this->setFileRab($value['file_rab']);
                    $this->setFileDesign($value['file_design']);
                    $this->setIdRegistrasi($value['id_registrasi']);
                    $this->setHargaSatuan($value['hrg_satuan']);
                    $this->setOngkirSatuan($value['ongkir_satuan']);
                    $this->setSubTotal($value['subtotal']);
                }
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return false;
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
    public function getByRelated($related, $field, $value, $row = Null, $segment = Null) {
        $this->db->select('tbl_item_hibah.*,tbl_item_barang.barang, tbl_item_barang.spesifikasi');
        $this->db->from('tbl_item_hibah');
        $this->db->join('tbl_item_barang', 'tbl_item_hibah.id_item = tbl_item_barang.id_item');
        //$this->db->join('tbl_item_gedung','tbl_item_hibah.id_item = tbl_item_gedung.kd_gedung');
        if ($related == 'registrasi') {
            $this->db->join('registrasi', 'tbl_item_hibah.id_registrasi = registrasi.id_registrasi');
        }

        if ($related == 'sub_kategori') {
            $this->db->where('tbl_item_hibah.id_registrasi', $this->idRegistrasi);
        }

        if ($this->idRegistrasi != '') {
            $this->db->where('tbl_item_hibah.id_registrasi', $this->idRegistrasi);
        }
        if ($related == '') {
            $this->db->where($field, $value);
        } else {
            $this->db->like($related . '.' . $field, $value);
        }
        $this->db->where('tbl_item_barang.periode', $this->periode);
        
        if ($row == NULL && $segment == NULL) {
            return $this->db->count_all_results();
        } elseif ($row == 0 && $segment == 0) {
            return $this->db->get();
        } else {
            return $this->db->get('', $row, $segment);
        }
    }

    public function insert() {
        $data = array(
            'id_item' => $this->idItem,
            'jml_item' => $this->jmlItem,
            'hrg_satuan' => $this->hargaSatuan,
            'subtotal' => $this->subTotal,
            'file_rab' => $this->fileRab,
            'file_design' => $this->fileDesign,
            'id_registrasi' => $this->idRegistrasi,
            'ongkir_satuan' => $this->ongkirSatuan
        );
        return $this->db->insert('tbl_item_hibah', $data);
    }

    public function update() {
        $data = array(
            'id_item' => $this->idItem,
            'jml_item' => $this->jmlItem,
            'hrg_satuan' => $this->hargaSatuan,
            'subtotal' => $this->subTotal,
            'file_rab' => $this->fileRab,
            'file_design' => $this->fileDesign,
            'id_registrasi' => $this->idRegistrasi,
            'ongkir_satuan' => $this->ongkirSatuan
        );
        $this->db->where('id', $this->id);
        return $this->db->update('tbl_item_hibah', $data);
    }

    public function getId() {
        return $this->id;
    }

    /**
     * 
     * @param newVal
     */
    public function setId($newVal) {
        $this->id = $newVal;
    }

    public function getIdRegistrasi() {
        return $this->idRegistrasi;
    }

    /**
     * 
     * @param newVal
     */
    public function setIdRegistrasi($newVal) {
        $this->idRegistrasi = $newVal;
    }

    public function getHargaSatuan() {
        return $this->hargaSatuan;
    }

    public function getSubTotal() {
        return $this->subTotal;
    }

    /**
     * 
     * @param newVal
     */
    public function setHargaSatuan($newVal) {
        $this->hargaSatuan = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setSubTotal($newVal) {
        $this->subTotal = $newVal;
    }

    public function getJmlItem() {
        return $this->jmlItem;
    }

    public function getOngkirSatuan() {
        return $this->ongkirSatuan;
    }

    /**
     * 
     * @param newVal
     */
    public function setJmlItem($newVal) {
        $this->jmlItem = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setOngkirSatuan($newVal) {
        $this->ongkirSatuan = $newVal;
    }

    public function isExist() {
        $this->db->select('*');
        $this->db->from('tbl_item_hibah');
        $this->db->where('id_item', $this->idItem);
        $this->db->where('id_registrasi', $this->idRegistrasi);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function search(array $params) {
        $this->db->select("");
        $this->db->from("tbl_item_hibah");
        $row = '';
        $segment = '';
        $count = FALSE;
        foreach ($params as $key => $value) {
            if ($key == 'join') {
                foreach ($value as $key => $value) {
                    $this->db->join($key, $value);
                }
            }
            if ($key == 'field') {
                foreach ($value as $key => $value) {
                    if (is_array($value)) {
                        $this->db->where_in($key, ($value));
                    } else {
                        if (is_numeric($value)) {
                            $this->db->where($key, ($value));
                        } else {
                            $this->db->like('lower(' . $key . ')', strtolower($value));
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
                if (count($value) == 1) {
                    $count = TRUE;
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