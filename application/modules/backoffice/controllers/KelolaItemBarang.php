<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of KelolaItemBarang
 *
 * @author ibnua
 */
class KelolaItemBarang extends MX_Controller implements IControll{
    //put your code here
    function __construct(){
        parent::__construct();
        $this->load->library('sessionutility');
        if (!$this->sessionutility->validateSession()) {
            redirect(base_url() . 'backoffice/');
        }
        $this->load->model('ImageBarang');
        $this->load->model('Itembarang');
    }
    public function add() {
        
    }

    public function edit() {
        
    }

    public function find() {
        
    }

    public function index() {
        $view = 'list_item_barang';

        $barang = new ItemBarang();
        $segment = $this->uri->segment(4, 0);
        $per_page = 10;
        
        $params = array(
            'paging' => array('row' => 10, 'segment' => $segment)
        );
        //$params['field']['registrasi.periode'] = $current_periode[0];
        $result = $barang->search($params);
        $params['count'] = array('1');
        $total_row = $barang->search($params);
        $base_url = base_url() . 'backoffice/kelolaitembarang/index';
        setPagingTemplate($base_url, 4, $total_row, $per_page);
        
        //data sub_kategori
        $this->db->select('*');
        $this->db->from('tbl_item_sub2kategori');
        $res_sub_kategori = $this->db->get();
        $option_kategori = array('' => '~Pilih~');
        foreach ($res_sub_kategori->result() as $value) {
            $option_kategori[$value->nm_sub2_kategori] = $value->nm_sub2_kategori;
        }
        
        //$data['jns_usulan'] = $option_jns_usulan;
        $data['kategori'] = $option_kategori;
        $data['item_barang'] = $result;
        $data['total_row'] = $total_row;
        showBackEnd($view, $data, 'index_new');
    }

    public function remove() {
        
    }

    public function save() {
        
    }

}
