<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Files management class created by CodexWorld
 */
class files extends CI_Controller {

    function __construct() {
        parent::__construct();
    }


    public function download($supplier_id,$file){
            //load download helper
            $this->load->helper('download');
            //download file from directory
            $data = file_get_contents(base_url('assets/supplier/'.$supplier_id.'/'.$file));
            force_download($file, $data);
    }
}