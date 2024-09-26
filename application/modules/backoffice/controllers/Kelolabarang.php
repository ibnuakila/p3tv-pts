<?php

require_once ('Icontroll.php');

//namespace controllers;
//use controllers;
/**
 * @author LENOVO
 * @version 1.0
 * @created 27-May-2020 10:55:06 AM
 */
class KelolaBarang extends MX_Controller implements IControll {

    function __construct() {
        parent::__construct();
        $this->load->library('sessionutility');
        if (!$this->sessionutility->validateSession()) {
            redirect(base_url() . 'backoffice/');
        }
        $this->load->model('Itembarang');
        $this->load->model('Itemkategori');
        $this->load->model('Itemsubkategori');
        $this->load->model('Itemhibah');
        $this->load->model('Itemgedung');
        $this->load->model('Itemongkir');
        $this->load->model('Registrasi');
        $this->load->model('Pti');
        $this->load->model('Rekapitulasi');
        $this->load->model('Proses');
        $this->load->model('Periode');
    }

    function __destruct() {
        
    }

    public function add() {
        
    }

    public function edit() {
        
    }

    public function find() {
        
    }

    public function index() {
        $view = 'list_barang';
        $segment = $this->uri->segment(5, 0);
        $id_registrasi = $this->uri->segment(4, 0);
        $per_page = 20;

        $item_barang = new ItemBarang();
        $result = $item_barang->get($per_page, $segment);
        $total_row = $item_barang->get();
        $base_url = base_url() . 'backoffice/kelolabarang/index/' . $id_registrasi;
        setPagingTemplate($base_url, 5, $total_row, $per_page);
        
        $item_kategori = new ItemKategori();
        $res_kategori = $item_kategori->get('0','0');
        $arr_kategori = array('-' => '~Pilih~');
        foreach ($res_kategori->result() as $kategori){
            $arr_kategori[$kategori->kd_kategori] = $kategori->nm_kategori;
        }
        $item_hibah = new ItemHibah();
        $grand_total = 0; $i=0;
        $params = array(            
                    'paging' => array('row'=>'0','segment'=>'0')
                );
        $params['field']['tbl_item_hibah.id_registrasi'] = $id_registrasi;
        $res_item_hibah = $item_hibah->search($params);
        $registrasi = new Registrasi($id_registrasi);

            if($res_item_hibah->num_rows()>0){
                foreach ($res_item_hibah->result() as $value) {
                    
                    if($registrasi->getJnsUsulan()=='01'){
                        $params = array('id_item' => $value->id_item, 'periode' => $registrasi->getPeriode());
                        $item_barang = new ItemBarang($params);
                        $nama = $item_barang->getBarang();
                        $spesifikasi = $item_barang->getSpesifikasi();
                        //$ppn = ($value->subtotal*10)/100;
                    }elseif ($registrasi->getJnsUsulan()=='02') {                            
                        $item_barang = new ItemGedung($value->id_item);
                        $nama = $item_barang->getNmGedung();
                        $spesifikasi = $item_barang->getNmGedung();
                        //$ppn = 0;
                    }else{
                        if(strlen($value->id_item)==9 ){
                            $item_barang = new ItemBarang($value->id_item);
                            $nama = $item_barang->getBarang();
                            $spesifikasi = $item_barang->getSpesifikasi();
                            //$ppn = ($value->subtotal*10)/100;
                        }else{
                            $item_barang = new ItemGedung($value->id_item);
                            $nama = $item_barang->getNmGedung();
                            $spesifikasi = $item_barang->getNmGedung();
                            //$ppn = 0;
                        }
                    }
                    
                    //$ppn = ($value->subtotal*10)/100;
                    $sub_total = $value->subtotal; //+ $ppn;
                    $grand_total = $grand_total + $sub_total;
                    $i++;
                }
            }
        $data['grand_total'] = $grand_total;
        $data['count'] = $i;
        $data['opt_kategori'] = $arr_kategori;
        $data['item_barang'] = $result;
        $data['total_row'] = $total_row;
        $data['id_registrasi'] = $id_registrasi;
        $data['paging'] = 'true';
        $rekapitulasi = new Rekapitulasi();
        $rekapitulasi->getBy('id_registrasi', $id_registrasi);
        if($rekapitulasi->getIdStatusRegistrasi()=='7'){
            redirect(base_url().'backoffice/kelolabarang/cart/'.$id_registrasi);
        }else{
            add_footer_js('js/app/list_barang.js');
            showNewBackEnd($view, $data, 'index-1');
        }
    }

    public function remove() {
        $id = $this->input->post('id');
        $item_hibah = new ItemHibah($id);
        $ret = $item_hibah->delete();
        if($ret){
            $data[] = array('message'=>'Data '.$id.' Terhapus!');
        }else{
            $data[] = array('message'=>'Proses Hapus Gagal!');
        }
        echo json_encode($data);
    }

    public function save() {
        $id_registrasi = $this->input->post('id_registrasi');
        $id_item = $this->input->post('id_item');
        $qty = $this->input->post('qty');
        $flag = $this->input->post('flag');
        $id_item_hibah = $this->input->post('id');
        $this->load->library('form_validation');        
        $this->form_validation->set_rules('id_registrasi', 'Id Registrasi', 'trim|required');
        $this->form_validation->set_rules('qty', 'Qty', 'trim|required');
        $this->form_validation->set_rules('id_item', 'Id Item', 'trim|required');
        
        if ($this->form_validation->run() === TRUE){
            $registrasi = new Registrasi($id_registrasi);
            $params = array('id_item' => $id_item, 'periode' => $registrasi->getPeriode());
            $item_barang = new ItemBarang($params);
            $item_ongkir = new ItemOngkir($id_registrasi);
            $item_hibah = new ItemHibah($id_item_hibah);
            
            //hitung ongkir -------------------
            $ongkir = $item_barang->getBerat() * $item_ongkir->getOngkirKg();
            
            //hitung harga barang ----------------            
            $harga_barang = ($item_barang->getHarga() + $ongkir);
            
            //hitung jumlah harga barang -----------
            $sub_total = $harga_barang * $qty;
            
            $item_hibah->setIdRegistrasi($id_registrasi);
            $item_hibah->setIdItem($id_item);
            $item_hibah->setJmlItem($qty);
            $item_hibah->setHargaSatuan($item_barang->getHarga());
            $item_hibah->setSubTotal($sub_total);
            $item_hibah->setOngkirSatuan($ongkir);
            if($flag=='true'){
                if(!$item_hibah->isExist()){
                    $item_hibah->insert();
                }else{
                    $item_hibah->update();
                }
            }else{                
                $item_hibah->update();
            }
            //hitung total --------------------
            $grand_total = 0; $i=0;
            $params = array('paging' => array('row' => '0', 'segment' => '0'));
            //$params['join']['tbl_item_barang'] = 'tbl_item_hibah.id_item = tbl_item_barang.id_item';
            $params['field']['id_registrasi'] = $id_registrasi;
            //$params['field']['periode'] = $registrasi->getPeriode();
            $result = $item_hibah->search($params);
            if($result->num_rows()>0){
                foreach ($result->result() as $value) {
                    //$ppn = ($value->subtotal*10)/100;
                    $sub_total = $value->subtotal; //+ $ppn;
                    $grand_total = $grand_total + $sub_total;
                    $i++;
                }
            }
            $data[] = array(
                'message'=>'Data Tersimpan!', 
                'grand_total' => number_format($grand_total,2), 
                'count' => $i,
                'sub_total' => number_format($sub_total,2));
            echo json_encode($data);
        }else{
            $data[] = array('message'=>'Qty/IdRegistrasi/IdItem tidak boleh kosong!', 'grand_total' => 0, 'count' => 0);
            echo json_encode($data);
        }
    }
    
    public function saveGedung() {
        $id_registrasi = $this->input->post('id_registrasi');
        $id_item = $this->input->post('id_item');
        $qty = $this->input->post('qty');
        $biaya = $this->input->post('biaya');
        $flag = $this->input->post('flag');
        $id_item_hibah = $this->input->post('id');
        $this->load->library('form_validation');        
        $this->form_validation->set_rules('id_registrasi', 'Id Registrasi', 'trim|required');
        $this->form_validation->set_rules('qty', 'Qty', 'trim|required');
        $this->form_validation->set_rules('id_item', 'Id Item', 'trim|required');
        
        if ($this->form_validation->run() == TRUE){
            //$item_gedung = new ItemGedung($id_item);
            //$item_ongkir = new ItemOngkir($id_registrasi);
            $item_hibah = new ItemHibah($id_item_hibah);
            //hitung ongkir -------------------
            //$ongkir = $item_barang->getBerat() * $item_ongkir->getOngkirKg();
            //hitung sub total ----------------
            
            
            $item_hibah->setIdRegistrasi($id_registrasi);
            $item_hibah->setIdItem($id_item);
            $item_hibah->setJmlItem($qty);
            $item_hibah->setHargaSatuan($biaya);
            $item_hibah->setSubTotal($biaya);
            $item_hibah->setOngkirSatuan(0);
            if($flag=='true'){
                if(!$item_hibah->isExist()){
                    $item_hibah->insert();
                }else{
                    $item_hibah->update();
                }
            }else{                
                $item_hibah->update();
            }
            //hitung total --------------------
            $grand_total = 0; $i=0; $sub_total = 0;
            //$result = $item_hibah->getByRelated('', 'id_registrasi', $id_registrasi, '0', '0');
            $params = array(
                'paging' => array('row' => '0', 'segment' => '0')
            );
            $params['join']['tbl_item_gedung'] = 'tbl_item_hibah.id_item = tbl_item_gedung.kd_gedung';
            $result = $item_hibah->search($params);
            if($result->num_rows()>0){
                foreach ($result->result() as $value) {
                    //$ppn = ($value->subtotal*10)/100;
                    $sub_total = $value->subtotal ;
                    $grand_total = $grand_total + $sub_total;
                    $i++;
                }
            }
            $data[] = array(
                'message'=>'Data Tersimpan!', 
                'grand_total' => number_format($grand_total,2), 
                'count' => $i,
                'sub_total' => number_format($sub_total,2));
            echo json_encode($data);
        }else{
            $data[] = array('message'=>'Qty/IdRegistrasi/IdItem tidak boleh kosong!', 'grand_total' => 0, 'count' => 0);
            echo json_encode($data);
        }
    }
    
    public function getSubKategori(){
        $kd_kategori = $this->input->post('kd_kategori');
        $sub_kategori = new ItemSubKategori();
        $tbl_periode = new Periode();
        $open_periode = $tbl_periode->getOpenPeriode();
        $periode = $open_periode->periode;
        $params['paging'] = ['row' => 0, 'segment' => 0];
        $params['field']['LEFT('.ItemSubKategori::table.'.kd_sub_kategori,2)'] = ['=' => $kd_kategori];
        $params['field'][ItemSubKategori::table.'.periode'] = ['=' => $periode];
        $result = $sub_kategori->getResult($params);
        if($result->num_rows()>0){
            foreach ($result->result() as $value) {
                $data[] = array(
                    'value' => $value->kd_sub2_kategori, 
                    'label' => $value->nm_sub2_kategori);
            }
            echo json_encode($data);
        }else{
            echo null;
        }
    }
    
    public function getBarang(){
        $id_item = $this->input->post('id_item');
        $tbl_periode = new Periode();
        $open_periode = $tbl_periode->getOpenPeriode();
        $periode = $open_periode->periode;
        $params = array('id_item' => $id_item, 'periode' => $periode);
        $item_barang = new ItemBarang($params);
        $data[] = array(
            'kd_barang' => $item_barang->getKdBarang(),
            'barang' => $item_barang->getBarang(),
            'spesifikasi' => $item_barang->getSpesifikasi(),
            'no_barang' => $item_barang->getNoBarang(),
            'id_item' => $item_barang->getIdItem(),
            'harga' => number_format($item_barang->getHarga(), 2),
            'image' => base_url().'assets/images/no-image-2.png'
        );
        echo json_encode($data);
    }
    
    public function getGedung(){
        $id_item = $this->input->post('id_item');
        $item_barang = new ItemGedung($id_item);
        $data[] = array(
            'kd_gedung' => $item_barang->getKdGedung(),
            'nm_gedung' => $item_barang->getNmGedung(),            
            'image' => base_url().'assets/images/no-image.jpg'
        );
        echo json_encode($data);
    }
    
    public function getBarangHibah(){
        $id = $this->input->post('id');
        $item_hibah = new ItemHibah($id);
        $tbl_periode = new Periode();
        $open_periode = $tbl_periode->getOpenPeriode();
        $periode = $open_periode->periode;
        $params = array('id_item' => $item_hibah->getIdItem(), 'periode' => $periode);
        $item_barang = new ItemBarang($params);
        $data[] = array(
            'barang' => $item_barang->getBarang(),
            'spesifikasi' => $item_barang->getSpesifikasi(),
            'no_barang' => $item_barang->getNoBarang(),
            'id' => $item_hibah->getId(),
            'qty' => $item_hibah->getJmlItem(),
            'id_registrasi' => $item_hibah->getIdRegistrasi(),
            'sub_total' => number_format($item_hibah->getSubTotal(),2),
            'id_item' => $item_hibah->getIdItem(),
            'harga_satuan' => number_format($item_hibah->getHargaSatuan(), 2),
            'ongkir' => number_format($item_hibah->getOngkirSatuan(),2),
            'image' => base_url().'assets/images/no-image-2.png'
        );
        echo json_encode($data);
    }
    
    public function getItemBarang(){
        $kd_kategori = $this->input->get('kd_kategori');
        $sub_kategori = $this->input->get('sub_kategori');
        $keyword = $this->input->get('keyword');
        $view = '';
        
        $params['paging'] = ['row' => 0, 'segment' => 0];
        if($kd_kategori=='01'){
            $item_barang = new ItemBarang();
            $tbl_periode = new Periode();
            $open_periode = $tbl_periode->getOpenPeriode();
            $periode = $open_periode->periode;
            if($keyword!=''){
                $params['field']['tbl_item_barang.barang'] = ['LIKE'=>$keyword];
                $params['field']['LEFT(kd_barang,6)'] = ['='=>$sub_kategori];
                $params['field']['tbl_item_barang.periode'] = ['='=>$periode];
                $result = $item_barang->getResult($params);
            }else{
                $params['field']['LEFT(kd_barang,6)'] = ['='=>$sub_kategori];
                $params['field']['tbl_item_barang.periode'] = ['='=>$periode];
                $result = $item_barang->getResult($params);
                //$result = $item_barang->getByRelated('','LEFT(kd_barang,6)=', $sub_kategori,'0','0');
            }
            $view = 'item_barang_rows';
            $data['item_barang'] = $result;
        }else{
            $item_gedung = new ItemGedung();
            if($keyword!=''){
                $params['field']['tbl_item_gedung.nm_gedung'] = $keyword;
                $params['field']['LEFT(kd_gedung,4)='] = $sub_kategori;
                $result = $item_gedung->search($params);
            }else{
                $result = $item_gedung->getByRelated('','LEFT(kd_gedung,4)=', substr($sub_kategori, 0, 4),'0','0');
            }
            $view = 'item_gedung_tabled';
            $data['item_gedung'] = $result;
        }      
        //echo '<h3>'.$view.'</h3>';
        //print_r($data);
        //print_r($result->result());
        $data['paging'] = false;
        $this->load->view($view, $data);
    }
    
    public function cart($id_registrasi){
        $registrasi = new Registrasi($id_registrasi);
        $item_hibah = new ItemHibah();
        $grand_total = 0; $i=0;
        $params = array(            
                    'paging' => array('row'=>'0','segment'=>'0')
                );
        $tbl_periode = new Periode();
        $open_periode = $tbl_periode->getOpenPeriode();
        $periode = $open_periode->periode;
        /*if($registrasi->getJnsUsulan()=='01'){//barang
            //$params['join']['tbl_item_barang'] = "tbl_item_hibah.id_item = tbl_item_barang.id_item";
            //$params['field']['periode'] = $registrasi->getPeriode();
        }elseif($registrasi->getJnsUsulan()=='02'){//gedung
            //$params['join']['tbl_item_gedung'] = "tbl_item_hibah.id_item = tbl_item_gedung.kd_gedung";
        }else{//barang & gedung
            
        }*/
        
        $params['field']['tbl_item_hibah.id_registrasi'] = $id_registrasi;
        $res_item_hibah = $item_hibah->search($params);
            /*if($res_item_hibah->num_rows()>0){
                foreach ($res_item_hibah->result() as $value) {
                    $grand_total = $grand_total + $value->subtotal;
                    $i++;
                }
            }*/
        //$data['grand_total'] = $grand_total;
        //$data['count'] = $i;
        $data['item_hibah'] = $res_item_hibah;
        $data['id_registrasi'] = $id_registrasi;
        $data['periode'] = $periode;
        $view = 'cart_detail';
        add_footer_js('js/app/cart_detail.js');
        showNewBackEnd($view, $data, 'index-1');
    }
    
    public function printDataBarang($id_registrasi){
        $item_hibah = new ItemHibah();
        $grand_total = 0; $i=0;
        $params = array(            
                    'paging' => array('row'=>'0','segment'=>'0')
                );
        $params['field']['tbl_item_hibah.id_registrasi'] = $id_registrasi;
            $res_item_hibah = $item_hibah->search($params);
            if($res_item_hibah->num_rows()>0){
                foreach ($res_item_hibah->result() as $value) {
                    $grand_total = $grand_total + $value->subtotal;
                    $i++;
                }
            }
            $tbl_periode = new Periode();
        $open_periode = $tbl_periode->getOpenPeriode();
        $periode = $open_periode->periode;
        //$data['grand_total'] = $grand_total;
        $data['periode'] = $periode;
        $data['item_hibah'] = $res_item_hibah;
        $data['id_registrasi'] = $id_registrasi;
        $view = 'print_cart';
        $this->load->view($view, $data);
    }
    
    public function finish(){
        $id_registrasi = $this->input->post('id_registrasi');
        //$registrasi = new Registrasi($id_registrasi);
        //$registrasi->setIdStatusRegistrasi(7);
        //$registrasi->update();
        $rekapitulasi = new Rekapitulasi();
        $rekapitulasi->getBy('id_registrasi', $id_registrasi);
        $rekapitulasi->setIdStatusRegistrasi(7);
        $update = $rekapitulasi->update();
        //redirect(base_url().'backoffice/kelolabarang/cart/'.$id_registrasi);
        
        if($update){
            /*$data[] = [
                'message' => 'Input barang selesai!',
                'response' =>
            ]*/
            $data['message'] = 'Input barang selesai!';
            $data['response'] = 1;
        }else{
            $data['message'] = 'Gagal mengupdate!';
            $data['response'] = 0;
        }
        echo json_encode($data);
    }

}

?>