<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

	//Dynamically add Javascript files to header page
	if (!function_exists('add_js')) {
	
		function add_js($file = '') {
			$str = '';
			$ci = &get_instance();
			$header_js = $ci->config->item('header_js');
	
			if (empty($file)) {
				return;
			}
	
			if (is_array($file)) {
				if (!is_array($file) && count($file) <= 0) {
					return;
				}
				foreach ($file AS $item) {
					$header_js[] = $item;
				}
				$ci->config->set_item('header_js', $header_js);
			} else {
				$str = $file;
				$header_js[] = $str;
				$ci->config->set_item('header_js', $header_js);
			}
		}
	
	}
	
	//Dynamically add CSS files to header page
	if (!function_exists('add_css')) {
	
		function add_css($file = '') {
			$str = '';
			$ci = &get_instance();
			$header_css = $ci->config->item('header_css');
	
			if (empty($file)) {
				return;
			}
	
			if (is_array($file)) {
				if (!is_array($file) && count($file) <= 0) {
					return;
				}
				foreach ($file AS $item) {
					$header_css[] = $item;
				}
				$ci->config->set_item('header_css', $header_css);
			} else {
				$str = $file;
				$header_css[] = $str;
				$ci->config->set_item('header_css', $header_css);
			}
		}
	
	}
	
	if (!function_exists('put_headers')) {
	
		function put_headers() {
			$str = '';
			$ci = &get_instance();
			$header_css = $ci->config->item('header_css');
			$header_js = $ci->config->item('header_js');
	
			foreach ($header_css AS $item) {
				$str .= '<link rel="stylesheet" href="' . base_url() . 'assets/css/' . $item . '" type="text/css" />' . "\n";
			}
	
			foreach ($header_js AS $item) {
				$str .= '<script type="text/javascript" src="' . base_url() . 'assets/js/' . $item . '"></script>' . "\n";
			}
	
			return $str;
		}
	
	}
	
	function showFrontpage($view, $data = array(), $template = 'index') {
		$ci = &get_instance();
		$data['view'] = $view;
		$data = $ci->load->view('frontpage/' . $template, $data);
	}
	
        function showBackEnd1($view, $data = array(), $template = 'index') {
		$ci = &get_instance();
		$data['view'] = $view;
		$data = $ci->load->view('officer/' . $template, $data);
	}
        
	function showBackEnd($view, $data = array(), $template = 'index') {
		$ci = &get_instance();
		$data['view'] = $view;
		$data = $ci->load->view('backoffice/' . $template, $data);
	}
        
        function showNewBackEnd($view, $data = array(), $template = 'index') {
		$ci = &get_instance();
		$data['view'] = $view;
		$data = $ci->load->view($template, $data);
	}

	function showBackEndadh($view, $data = array(), $template = 'index') {
		$ci = &get_instance();
		$data['view'] = $view;
		$data = $ci->load->view('vendor/' . $template, $data);
	}
	
	function setPagingTemplate($base_url, $uri_segment, $total_row, $per_page)
	{
		$ci = &get_instance();
		$ci->load->library('pagination');
		$config['base_url'] = $base_url;
		$config['per_page'] = $per_page;
		$config['num_links'] = '3';
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = '&gt;';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active" aria-current="page"><a href="#" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['attributes'] = array('class' => 'page-link');
		$config['uri_segment'] = $uri_segment;
		$config['total_rows'] = $total_row;
		$ci->pagination->initialize($config);
	
	}
	