<?php

class Coba extends EL_Controller {

     public function kirim() {
        
                $config = array();
                $config['useragent']           = "CodeIgniter";
                $config['mailpath']            = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
                $config['protocol']            = "smtp";
                $config['smtp_host']           = "localhost";
                $config['smtp_port']           = "25";
                $config['mailtype'] = 'html';
                $config['charset']  = 'utf-8';
                $config['newline']  = "\r\n";
                $config['wordwrap'] = TRUE;

                $this->load->library('email');

                $this->email->initialize($config);
                
            
                        
                        $from    = "subdit_ppt@dikti.go.id";
                        $to      = "yunus@ristekdikti.go.id";
                        $subject = "pppts 2016";
                        $isi     = "Ini tes kirim email";

                        
                        $this->email->set_newline("\r\n");
                               
                        $this->email->from($from, ' pp-pts');
                        $this->email->to($to);
                        $this->email->subject($subject);
                        $this->email->message($isi);
                                 
                        if($this->email->send())
                        {
                            echo "terkirim";
                            echo $this->email->print_debugger();
                        }else{
                            echo $this->email->print_debugger();
                        }
    }
    
    public function kirim3() {
        
        $config = array();
                    	
                $config = array();
                $config['useragent']           = "CodeIgniter";
                $config['mailpath']            = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
                $config['protocol']            = "SMTP";
                $config['smtp_host']           =  "ssl://mail.ristekdikti.go.id";//"localhost";
                $config['smtp_port']           = "465";
		$config['smtp_user'] = "no-reply@ristekdikti.go.id"; 
    		$config['smtp_pass'] = "iasi2017"; 
                $config['mailtype'] = 'HTML';
                $config['charset']  = 'utf-8';
                $config['newline']  = "\r\n";
                $config['wordwrap'] = TRUE;

                $this->load->library('email');

                $this->email->initialize($config);
                
            
                        
                        $from    = "subdit_ppt@dikti.go.id";
                        $to      = "subditppt@gmail.com";
                        $subject = "pppts 2016";
                        $isi     = "Ini tes kirim email";

                        
                        $this->email->set_newline("\r\n");
                               
                        $this->email->from($from, ' pp-pts');
                        $this->email->to($to);
                        $this->email->subject($subject);
                        $this->email->message($isi);
                                 
                        if($this->email->send())
                        {
                            echo "terkirim";
                            echo $this->email->print_debugger();
                        }else{
                            echo $this->email->print_debugger();
                        }
    }
    public function kirim1() {
        
                $config = array();
                $config['useragent']           = "CodeIgniter";
                $config['mailpath']            = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
                $config['protocol']            = "smtp";
                $config['smtp_host']           = "localhost";
                $config['smtp_port']           = "25";
                $config['mailtype'] = 'html';
                $config['charset']  = 'utf-8';
                $config['newline']  = "\r\n";
                $config['wordwrap'] = TRUE;

                $this->load->library('email');

                $this->email->initialize($config);
                
            
                        
                        $from    = "subditppt@gmail.com";
                        $to      = "suhandana@dikti.go.id";
                        $subject = "pppts 2016";
                        $isi     = "Ini tes kirim email";

                        
                        $this->email->set_newline("\r\n");
                               
                        $this->email->from($from, ' pp-pts');
                        $this->email->to($to);
                        $this->email->subject($subject);
                        $this->email->message($isi);
                                 
                        if($this->email->send())
                        {
                            echo "terkirim";
                            echo $this->email->print_debugger();
                        }else{
                            echo $this->email->print_debugger();
                        }
    }
    
    public function kirim2() {
        
    
        
        $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => 'subditppt@gmail.com',
        'smtp_pass' => 'nanassubang',
        'mailtype'  => 'html',
        'charset'   => 'iso-8859-1'
    );

    $this->load->library('email',$config);

               
            
                        
                        $from    = "subditppt@gmail.com";
                        $to      = "hamid.adh@bsi.ac.id";
                        $subject = "pppts 2016";
                        $isi     = "Ini tes kirim email";

                        
                        $this->email->set_newline("\r\n");
                               
                        $this->email->from($from, ' pp-pts');
                        $this->email->to($to);
                        $this->email->subject($subject);
                        $this->email->message($isi);
                                 
                        if($this->email->send())
                        {
                            echo "terkirim";
                            echo $this->email->print_debugger();
                        }else{
                            echo $this->email->print_debugger();
                        }
    }
    
    
}
?>
