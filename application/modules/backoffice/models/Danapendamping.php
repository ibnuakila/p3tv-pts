<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of DanaPendamping
 *
 * @author ibnua
 */
class DanaPendamping extends CI_Model implements BaseModel{
    //put your code here
    const table = 'dana_pendamping';
    public $id;
    public $id_registrasi;
    public $kode_pt;
    public $nama_pt;
    public $nama_kegiatan;
    public $keuangan;
    public $vol_output;
    public $output_kegiatan;
    public $real_keuangan;
    public $real_vol_output;
    public $bukti_luaran;
    
    function __construct($id = NULL) {
        parent::__construct();
        if ($id != NULL) {
            $this->db->select('*');
            $this->db->from(DanaPendamping::table);
            $this->db->where('id', $id);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $value) {
                    $this->id = $value->id;
                    $this->id_registrasi = $value->id_registrasi;
                    $this->kode_pt = $value->kode_pt;
                    $this->nama_pt = $value->nama_pt;
                    $this->nama_kegiatan = $value->nama_kegiatan;
                    $this->keuangan = $value->keuangan;
                    $this->vol_output = $value->vol_output;
                    $this->output_kegiatan = $value->output_kegiatan;
                    $this->real_keuangan = $value->real_keuangan;
                    $this->real_vol_output = $value->real_vol_output;
                    $this->bukti_luaran = $value->bukti_luaran;
                }
            }
        }
    }
    public function delete() {
        return $this->db->delete('dana_pendamping',['id' => $this->id]);
    }

    public function get($row = Null, $segment = Null) {
        
    }

    public function getBy($field, $value) {
        
    }

    public function getByRelated($related, $field, $value, $row = Null, $segment = Null) {
        
    }

    public function insert() {
        $data = [
            'id_registrasi' => $this->id_registrasi,
            'kode_pt' => $this->kode_pt,
            'nama_pt' => $this->nama_pt,
            'nama_kegiatan' => $this->nama_kegiatan,
            'keuangan' => $this->keuangan,
            'vol_output' => $this->vol_output,
            'output_kegiatan' => $this->output_kegiatan,
            'real_keuangan' => $this->real_keuangan,
            'real_vol_output' => $this->real_vol_output
        ];
        return $this->db->insert('dana_pendamping', $data);
    }

    public function update() {
        $data = [
            'id_registrasi' => $this->id_registrasi,
            'kode_pt' => $this->kode_pt,
            'nama_pt' => $this->nama_pt,
            'nama_kegiatan' => $this->nama_kegiatan,
            'keuangan' => $this->keuangan,
            'vol_output' => $this->vol_output,
            'output_kegiatan' => $this->output_kegiatan,
            'real_keuangan' => $this->real_keuangan,
            'real_vol_output' => $this->real_vol_output
        ];
        $this->db->where('id', $this->id);
        return $this->db->update('dana_pendamping', $data);
    }
    
    public function getResult($params) {
        $this->db->select(self::table.'.*');
        $this->db->from(self::table);
        
        $count = false;
        foreach ($params as $key => $value) {
            if($key=='join'){
                foreach ($value as $key => $sub_value){
                    foreach ($sub_value as $operator => $value) {                        
                        $this->db->join($key, $value, $operator);
                    }
                    
                }
            }
            if($key=='field'){
                foreach ($value as $key => $sub_value) {
                    foreach ($sub_value as $operator => $item){
                        if($operator=='IN'){
                            $this->db->where_in($key, $item);
                        }elseif($operator=='NOT IN'){
                            $this->db->where_not_in($key, $item);
                        }elseif($operator=='LIKE'){
                            $this->db->like('lower('.$key.')', strtolower($item));
                        } elseif ($operator == 'BETWEEN'){
                            $where = $key . " ".$operator." '".$item[0]."' AND '".$item[1]."'";
                            $this->db->where($where);
                        }else{
                            $this->db->where($key.$operator, $item);
                        }
                    }
                    
                }
            }
            
            if($key=='paging'){
                foreach ($value as $key => $value) {
                    if($key=='row'){
                        $row = $value;
                    }else{
                        $segment = $value;
                    }
                }
            }
            if($key=='count'){
                $count = $value;           
            }
            if($key=='order'){
                foreach ($value as $key => $value) {
                    $this->db->order_by($key, $value);
                }                
            }
        }
        if($count){
            return $this->db->count_all_results();
        }elseif($row==0 && $segment==0){            
            return $this->db->get();
        }else{            
            return $this->db->get('',$row,$segment);
        }
    }
}
