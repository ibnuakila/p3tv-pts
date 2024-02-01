<?php


/**
 * Description of RegistrasiLaporanAkhir
 *
 * @author ibnua
 */
class RegistrasiLaporanAkhir extends CI_Model{
    //put your code here
    public $id_registrasi;
    public $badan_penyelenggara;
    public $perguruan_tinggi;
    public $ketua_pelaksana;
    public $program_studi;
    public $dana_pendamping;
    const table = 'registrasi_laporan_akhir';
    
    function __construct($id_registrasi = null) {
        parent::__construct();
        if($id_registrasi != null){
            $this->db->select('*');         
            $this->db->from('registrasi_laporan_akhir');
            $this->db->where('id_registrasi',$id_registrasi);
            $result = $this->db->get();
            if($result->num_rows()>0){
                foreach ($result->result() as $value){
                    $this->id_registrasi = $value->id_registrasi;
                    $this->badan_penyelenggara = $value->badan_penyelenggara;
                    $this->perguruan_tinggi = $value->perguruan_tinggi;
                    $this->ketua_pelaksana = $value->ketua_pelaksana;
                    $this->program_studi = $value->program_studi;
                    $this->dana_pendamping = $value->dana_pendamping;
                }
            }
        }
    }
    
    public function insert(){
        $data = [
            'id_registrasi' => $this->id_registrasi,
            'badan_penyelenggara' => $this->badan_penyelenggara,
            'perguruan_tinggi' => $this->perguruan_tinggi,
            'ketua_pelaksana' => $this->ketua_pelaksana,
            'program_studi' => $this->program_studi,
            'dana_pendamping' => $this->dana_pendamping
        ];
        return $this->db->insert(self::table, $data);
    }
    
    public function update(){
        $data = [
            'id_registrasi' => $this->id_registrasi,
            'badan_penyelenggara' => $this->badan_penyelenggara,
            'perguruan_tinggi' => $this->perguruan_tinggi,
            'ketua_pelaksana' => $this->ketua_pelaksana,
            'program_studi' => $this->program_studi,
            'dana_pendamping' => $this->dana_pendamping
        ];
        $this->db->where('id_registrasi', $this->id_registrasi);
        return $this->db->update(self::table, $data);
    }
    
    public function delete(){
        return $this->db->delete(self::table, ['id_registrasi' => $this->id_registrasi]);
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
