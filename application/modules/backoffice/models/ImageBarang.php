<?php

/**
 * @author ibnua
 * @version 1.0
 * @created 23-Jun-2022 20:29:34
 */
class ImageBarang extends CI_Model implements BaseModel {

    private $idItem;
    private $imagePath;
    private $imageThumbPath;

    function __construct($id = null) {
        parent::__construct();
        if ($id != NULL) {
            $this->db->select('*');
            $this->db->from('tbl_image_barang');
            $this->db->where('id_item', $id);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $value) {
                    $this->idItem($value->id_item);
                    $this->imagePath($value->image_path);
                    $this->imageThumbPath($value->image_thumb_path);
                    
                }
            }
        }
    }

    function __destruct() {
        
    }

    public function getIdItem() {
        return $this->idItem;
    }

    public function getImagePath() {
        return $this->imagePath;
    }

    public function getImageThumbPath() {
        return $this->imageThumbPath;
    }

    /**
     * 
     * @param newVal
     */
    public function setIdItem($newVal) {
        $this->idItem = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setImagePath($newVal) {
        $this->imagePath = $newVal;
    }

    /**
     * 
     * @param newVal
     */
    public function setImageThumbPath($newVal) {
        $this->imageThumbPath = $newVal;
    }

    public function delete() {
        $this->db->delete('tbl_image_barang', ['id_item' => $this->idItem]);
    }

    public function get($row = Null, $segment = Null) {
        
    }

    public function getBy($field, $value) {
        
    }

    public function getByRelated($related, $field, $value, $row = Null, $segment = Null) {
        
    }

    public function insert() {
        $data = [
            'id_item' => $this->idItem,
            'image_path' => $this->imagePath,
            'image_thumb_path' => $this->imageThumbPath
        ];
        $this->db->insert('tbl_image_barang', $data);
    }

    public function update() {
        $data = [
            'id_item' => $this->idItem,
            'image_path' => $this->imagePath,
            'image_thumb_path' => $this->imageThumbPath
        ];
        $this->db->where('id_item', $this->idItem);
        $this->db->update('tbl_image_barang', $data);
    }

}

?>