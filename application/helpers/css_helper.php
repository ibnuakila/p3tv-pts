<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//Dynamically add CSS files to header page
if(!function_exists('add_header_css')){
    function add_header_css($file='')
    {
        $str = '';
        $ci = &get_instance();
        $header_css = $ci->config->item('header_css');

        if(empty($file)){
            return;
        }

        if(is_array($file)){
            if(!is_array($file) && count($file) <= 0){
                return;
            }
            foreach($file AS $item){   
                $header_css[] = $item;
            }
            $ci->config->set_item('header_css',$header_css);
        }else{
            $str = $file;
            $header_css[] = $str;
            $ci->config->set_item('header_css',$header_css);
        }
    }
}

//Dynamically add CSS files to header page
if(!function_exists('add_footer_css')){
    function add_footer_css($file='')
    {
        $str = '';
        $ci = &get_instance();
        $footer_css = $ci->config->item('footer_css');

        if(empty($file)){
            return;
        }

        if(is_array($file)){
            if(!is_array($file) && count($file) <= 0){
                return;
            }
            foreach($file AS $item){   
                $footer_css[] = $item;
            }
            $ci->config->set_item('footer_css',$footer_css);
        }else{
            $str = $file;
            $footer_css[] = $str;
            $ci->config->set_item('footer_css',$footer_css);
        }
    }
}

if(!function_exists('put_headers_css')){
    function put_headers_css()
    {
        $str = '';
        $ci = &get_instance();
        $header_css = $ci->config->item('header_css');

        foreach($header_css AS $item){
            $str .= '<link rel="stylesheet" href="'.base_url().'assets/css/'.$item.'" type="text/css" />'."\n";
        }

        return $str;
    }
}

if(!function_exists('put_header_admin_css')){
    function put_header_admin_css()
    {
        $str = '';
        $ci = &get_instance();
        $header_admin_css = $ci->config->item('header_admin_css');

        foreach($header_admin_css AS $item){
            $str .= '<link rel="stylesheet" href="'.base_url().'assets/admin/css/plugins/'.$item.'" type="text/css" />'."\n";
        }

        return $str;
    }
}

if(!function_exists('put_font_awesome_css')){
    function put_font_awesome_css()
    {
        $str = '';
        $ci = &get_instance();
        $font_awesome_css = $ci->config->item('font_awesome_css');

        foreach($font_awesome_css AS $item){
            $str .= '<link rel="stylesheet" href="'.base_url().'assets/font-awesome-4.1.0/css/'.$item.'" type="text/css" />'."\n";
        }

        return $str;
    }
}

if(!function_exists('put_footers_css')){
    function put_footers_css()
    {
        $str = '';
        $ci = &get_instance();
        $footer_css = $ci->config->item('footer_css');

        foreach($footer_css AS $item){
            $str .= '<link rel="stylesheet" href="'.base_url().'assets/'.$item.'" type="text/css" />'."\n";
        }

        return $str;
    }
}

if(!function_exists('put_evapro_css')){
    function put_evapro_css()
    {
        $str = '';
        $ci = &get_instance();
        $evapro_css = $ci->config->item('evapro_css');

        foreach($evapro_css AS $item){
            $str .= '<link rel="stylesheet" href="'.base_url().'assets/css/'.$item.'" type="text/css" />'."\n";
        }

        return $str;
    }
}

if(!function_exists('put_bootstrap_css')){
    function put_bootstrap_css()
    {
        $str = '';
        $ci = &get_instance();
        $bootstrap_css = $ci->config->item('bootstrap_css');

        foreach($bootstrap_css AS $item){
            $str .= '<link rel="stylesheet" href="'.base_url().'assets/css/'.$item.'" type="text/css" />'."\n";
        }

        return $str;
    }
}

if(!function_exists('put_usulan_css')){
    function put_usulan_css()
    {
        $str = '';
        $ci = &get_instance();
        $usulan_css = $ci->config->item('usulan_css');

        foreach($usulan_css AS $item){
            $str .= '<link rel="stylesheet" href="'.base_url().'assets/css/'.$item.'" type="text/css" />'."\n";
        }

        return $str;
    }
}

//Dynamically add CSS files to header page
if(!function_exists('add_plugin_css')){
    function add_plugin_css($file='')
    {
        $str = '';
        $ci = & get_instance();
        $plugin_css = $ci->config->item('plugin_css');

        if(empty($file)){
            return;
        }

        if(is_array($file)){
            if(!is_array($file) && count($file) <= 0){
                return;
            }
            foreach($file AS $item){   
                $plugin_css[] = $item;
            }
            $ci->config->set_item('plugin_css',$plugin_css);
        }else{
            $str = $file;
            $plugin_css[] = $str;
            //echo $str;
            //print_r($header_css);
            $ci->config->set_item('plugin_css',$plugin_css);
        }
    }
}

if(!function_exists('put_plugins_css')){
    function put_plugins_css()
    {
        $str = '';
        $ci = &get_instance();
        $header_css = $ci->config->item('plugin_css');

        foreach($header_css AS $item){
            $str .= '<link rel="stylesheet" href="'.base_url().'assets/'.$item.'" type="text/css" />'."\n";
        }

        return $str;
    }
}
