<?php
if (!defined('APPPATH'))
    exit('No direct script access allowed');

class PagingTemplate
{
    private $ci;
    
    function __construct() {
        $this->ci =& get_instance();
        
    }
    
    public function setPagingTemplate($base_url,$uri_segment,$total_row){
        //$this->ci->load->library('pagination');
        $config['base_url'] = $base_url;
        $config['per_page'] = '5';
        $config['num_links'] = '5';
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['next_link'] = 'NEXT';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = 'PREV';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['uri_segment'] = $uri_segment;
        $config['total_rows'] = $total_row;
        //$this->ci->pagination->initialize($config);
        return $config;
    }
}