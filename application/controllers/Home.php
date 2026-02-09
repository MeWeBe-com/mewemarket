<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends CI_Controller {

	public function index()
	{
		
		$SendData['categories'] =  $this->general->SelectQueryWithClause('categories','visibility','1');
		$SendData['testimonials'] = $this->general->SelectQuery('testimonial');
		$SendData['Products'] = $this->product->GetProductsForHome();

		if(!empty($this->session->userdata('user_id'))){
			$SendData['userproducts'] =  $this->product->UserProducts($this->session->userdata('user_id'));
		}else{
			$SendData['userproducts'] =  array();
		}

		if(!empty($this->session->userdata('user_id'))){
			$SendData['userfavourite'] =  $this->product->UserFavourites($this->session->userdata('user_id'));
		}else{
			$SendData['userfavourite'] =  array();
		}


		$this->load->view('index',$SendData);
	}


}
