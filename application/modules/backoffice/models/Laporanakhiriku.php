<?php

/**
 * Description of LaporanAkhirIku
 *
 * @author ibnua
 */
class LaporanAkhirIku extends CI_Model{
    public $id;
    public $id_registrasi;
    public $no;
    public $indikator_kinerja;
    public $base_line;
    public $target;
    public $capaian;
    public $kendala;
    public $solusi;
    private $exist = false;
    const table = 'laporan_akhir_iku';
    function __construct($id = null) {    
        parent::__construct();
        if($id != null){
            $this->db->select('*');         
            $this->db->from(self::table);
            $this->db->where('id_registrasi',$id);
            $result = $this->db->get();
            if($result->num_rows()>0){
                /*foreach ($result->result() as $value){
                    $this->id = $value->id;
                    $this->id_registrasi = $value->id_registrasi;
                    $this->no = $value->no;
                    $this->indikator_kinerja = $value->indikator_kinerja;
                    $this->base_line = $value->base_line;
                    $this->target = $value->target;
                    $this->capaian = $value->capaian;
                    $this->kendala = $value->kendala;
                    $this->solusi = $value->solusi;
                }*/
                $this->exist = true;
            }
        }
    }
    
    public function insert(){
        $data = [
            'id_registrasi' => $this->id_registrasi,
            'no' => $this->no,
            'indikator_kinerja' => $this->indikator_kinerja,
            'base_line' => $this->base_line,
            'target' => $this->target,
            'capaian' => $this->capaian,
            'kendala' => $this->kendala,
            'solusi' => $this->solusi
        ];
        return $this->db->insert(self::table, $data);
    }
    
    public function update(){
        $data = [
            'id_registrasi' => $this->id_registrasi,
            'no' => $this->no,
            'indikator_kinerja' => $this->indikator_kinerja,
            'base_line' => $this->base_line,
            'target' => $this->target,
            'capaian' => $this->capaian,
            'kendala' => $this->kendala,
            'solusi' => $this->solusi
        ];
        $this->db->where('id', $this->id);
        return $this->db->update(self::table, $data);
    }
    
    public function delete(){
        return $this->db->delete(self::table, ['id' => $this->id]);
    }
    
    public function isExist(){
        return $this->exist;
    }


    public function getResult($params){
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
