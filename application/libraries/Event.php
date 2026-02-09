<?php

class Event {
	public $CI;
	public function __construct(){
		$this->CI = &get_instance();
	}

	public function email($data)
	{
			/*$config = array(
		    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
		    'smtp_host' => 'mail.reviewschef.com', 
		    'smtp_port' => 465,
		    'smtp_user' => 'info@reviewschef.com',
		    'smtp_pass' => 'Idevation786))',
		    'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
		    'mailtype' => 'html', //plaintext 'text' mails or 'html'
		    'smtp_timeout' => '7', //in seconds
		    'charset' => 'iso-8859-1',
		    'wordwrap' => TRUE
		);*/
//$config['smtp_host'] = '';
$config = array(
			'protocol' => 'smtp',
		    'smtp_host' => 'smtp.gmail.com',
		    'smtp_port' => 465,
		    'smtp_user' => 'yaze.live@gmail.com',
		    'smtp_pass' => 'xonmlvoacygaayqg',
		    'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
		    'mail_type' => 'html', //plaintext 'text' mails or 'html'
		    'smtp_timeout' => '7', //in seconds
		    'charset' => 'iso-8859-1',
		    'wordwrap' => TRUE
		);
		
			$this->CI->load->library('email',$config);
			//$this->CI->load->library('email');
			//$this->CI->email->initialize($config);
			$from 		=	'noreply@mewemarket.com';
			$to 		=	$data['to'];
			$subject	=	$data['subject'];
			$message 	=	$data['body'];
					
			$this->CI->email->clear();
			$this->CI->email->set_newline("\r\n");
			$this->CI->email->set_header('Content-Type', 'text/html');
					$this->CI->email->from($from, 'Mewemarket.com NoReply');
					$this->CI->email->to($to); 
					$this->CI->email->subject($subject);
					$this->CI->email->message($message);

					if($this->CI->email->send()){
						 $this->CI->email->print_debugger();

						return true;
						 log_message('info', 'Email has been sent');
					}else{
					    show_error($this->CI->email->print_debugger());
					     $this->CI->email->print_debugger();

						return $this->CI->email->print_debugger();
						  log_message('info', $this->CI->email->print_debugger());
					}
	}
}
