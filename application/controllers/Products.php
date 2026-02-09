<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class products extends CI_Controller {

	public function index()
	{
		$this->load->view('categories');
	}

	public function ViewProduct($id)
	{

		$GetData['products'] =  $this->product->GetProductsByProductId($id);
		$GetData['product_images'] =  $this->product->GetProductImages($id);

		if(!empty($this->session->userdata('user_id'))){
			$GetData['userproducts'] =  $this->product->UserProductsByProductID($this->session->userdata('user_id'),$id);
		}else{
			$GetData['userproducts'] =  array();
		}

		if(!empty($this->session->userdata('user_id'))){
			$GetData['userfavourite'] =  $this->product->UserFavourites($this->session->userdata('user_id'));
		}else{
			$GetData['userfavourite'] =  array();
		}

		$this->load->view('product_details',$GetData);
	}

	public function ActivateProduct($id)
	{

		if(empty($this->session->userdata('user_id'))){
			redirect(base_url('users/register/'));
		}

		$GetData['productdetails'] =  $this->product->GetProductsByProductId($id);

		$GetData['packages'] = $this->general->SelectQuery('packages');
		$GetData['product_id'] = $id;

		$this->load->view('select_packages',$GetData);
	}


}
