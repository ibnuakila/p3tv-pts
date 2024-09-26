<?php

require_once ('Basemodel.php');

//use ;
/**
 * @author siti
 * @version 1.0
 * @created 18-Jun-2017 11:51:34
 */
class Supplier extends CI_Model implements BaseModel {

    private $alamat;
    private $contactPerson;
    private $email;
    private $id;
    private $namaSupplier;
    private $telepon;

    function __construct($id = '') {
        parent::__construct();
        if ($id != '') {
            $sql = "SELECT * FROM tbl_supplier WHERE id='" . $id . "'";
            $result = $this->db->query($sql);
            if ($result->num_rows() > 0) {
                foreach ($result->result('array') as $value) {
                    $this->setId($value['id']);
                    $this->setNamaSupplier($value['nama_supplier']);
                    $this->setAlamat($value['alamat']);
                    $this->setTelepon($value['telepon']);
                    $this->setEmail($value['email']);
                    $this->setContactPerson($value['contact_person']);
                }
            }
        }
    }

    function __destruct() {
        
    }

    public function getAlamat() {
        return $this->alamat;
    }

    public function getContactPerson() {
        return $this->contactPerson;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getId() {
        return $this->id;
    }

    public function getNamaSupplier() {
        return $this->namaSupplier;
    }

    public function getTelepon() {
        return $this->telepon;
    }

    /**
     * 
     * @param newVal
     */
    public function setAlamat($newVal) {
        $this->alamat = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setContactPerson($newVal) {
        $this->contactPerson = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setEmail($newVal) {
        $this->email = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setId($newVal) {
        $this->id = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setNamaSupplier($newVal) {
        $this->namaSupplier = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setTelepon($newVal) {
        $this->telepon = $newVal;
    }

    public function delete() {
        
    }

    /**
     * 
     * @param row
     * @param segment    segment
     */
    public function get($row = Null, $segment = Null) {
        $list = new ArrayObject();
        $this->db->select('*');
        $this->db->from('tbl_supplier');

        $result = '';
        if ($row == '' && $segment == '') {
            $this->db->order_by('id_paket', 'asc');
            $result = $this->db->get('');
        } else {
            $result = $this->db->get('', $row, $segment);
        }
        foreach ($result->result('array') as $row) {
            $obj = new Supplier($row['id']);
            $list->append($obj);
        }
        return $list;
    }

    /**
     * 
     * @param field
     * @param value    value
     */
    public function getBy($field, $value) {
        $this->db->select('*');
        $this->db->from('tbl_detail_paket_hibah');
        $this->db->where($field, $value);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            
                foreach ($result->result('array') as $value) {
                    $this->setId($value['id']);
                    $this->setNamaSupplier($value['nama_supplier']);
                    $this->setAlamat($value['alamat']);
                    $this->setTelepon($value['telepon']);
                    $this->setEmail($value['email']);
                    $this->setContactPerson($value['contact_person']);
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
     * @param value    value
     * @param row
     * @param segment
     */
    public function getByRelated($related, $field, $value, $row = Null, $segment = Null) {
        $this->db->select('*');
        $this->db->from('tbl_supplier');
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
        
    }

    public function update() {
        
    }

}

?>