<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WebServiceAgent
 *
 * @author ibnua
 */
class WebServiceAgent {
    //put your code here
    
    //private $websiteLink;
    
    public function getByKodePt($kode){
        //$nama_pt = '114096';
        $url = 'https://api-frontend.kemdikbud.go.id/hit/'.$kode;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLINFO_HEADER_OUT => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 100,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POST => false, 
        //CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
        CURLOPT_HTTPHEADER => array(
                //'Authorization: Bearer '.$access_token,
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $data = json_decode($response, true);
        $temp_weblink = $data['pt'][0]['website-link'];
        $arr_weblink = explode('/', $temp_weblink);
        //print_r($arr_weblink);
        
        $website_link = $arr_weblink[2];
        return $website_link;
    }
    
    public function getDetailPtProdi($website_link){
        $url = 'https://api-frontend.kemdikbud.go.id/v2/detail_pt_prodi/'.$website_link;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLINFO_HEADER_OUT => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POST => false, 
        //CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
        CURLOPT_HTTPHEADER => array(
                //'Authorization: Bearer '.$access_token,
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $data = json_decode($response, true);
        return $data;
    }
    
    public function getDetailPt($website_link){
        $url = 'https://api-frontend.kemdikbud.go.id/v2/detail_pt/'.$website_link;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLINFO_HEADER_OUT => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POST => false, 
        //CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
        CURLOPT_HTTPHEADER => array(
                //'Authorization: Bearer '.$access_token,
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $data = json_decode($response, true);
        return $data;
    }
    
    public function getDetailProdi($id_sms){
        $url = 'https://api-frontend.kemdikbud.go.id/v2/detail_prodi/'.$id_sms;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLINFO_HEADER_OUT => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POST => false, 
        //CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
        CURLOPT_HTTPHEADER => array(
                //'Authorization: Bearer '.$access_token,
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $data = json_decode($response, true);
        return $data;
    }
}
