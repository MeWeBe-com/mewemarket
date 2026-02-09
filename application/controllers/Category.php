<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class category extends CI_Controller {

	public function index()
	{

		$GetData['categories'] =  $this->general->SelectQueryWithClause('categories','visibility','1');
		$this->load->view('maincategory',$GetData);
	}

	public function ViewCategory($id)
	{
		$GetData['category'] = $category = $this->general->SelectQueryWithClause('categories','category_id',$id);
		$slug = url_title($category[0]->category_name, 'dash', true);
		$counts = $this->product->GetCountrows('products','category_id',$id);
		$config['base_url'] = base_url('category/ViewCategory/'.$id.'/'.$slug);

		$config['total_rows'] = $counts[0]->total;
		$config['per_page'] = 10;
		$config['uri_segment'] = 5;

		$config['full_tag_open'] = '<div>';
		$config['full_tag_close'] = '</div>';

		$config['first_tag_open'] = '<button class="btn btn-falcon-default btn-sm mr-1 mr-sm-2 px-0 py-0">';
		$config['first_tag_close'] = '</button>';

		$config['prev_tag_open'] = '<li class="btn btn-sm btn-falcon-default text-primary mr-2 px-0 py-0">';
		$config['prev_tag_close'] = '</li>';

		$config['num_tag_open'] = '<li class="btn btn-sm btn-falcon-default text-primary mr-2 px-0 py-0">';
		$config['num_tag_close'] = '</li>';

		$config['next_tag_open'] = '<li class="btn btn-sm btn-falcon-default text-primary mr-2 px-0 py-0">';
		$config['next_tag_close'] = '</li>';

		$config['last_tag_open'] = '<button class="btn btn-falcon-default btn-sm mr-1 mr-sm-2 px-0 py-0">';
		$config['last_tag_close'] = '</button>';

		$config['cur_tag_open'] = '<li class="btn btn-falcon-default btn-sm mr-1 mr-sm-2 active "><a href="javascript:;">';
		$config['cur_tag_close'] = '</li>';

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;

		$GetData['pagination'] = $this->pagination->create_links();

		$GetData['products'] =  $this->product->GetProductsByCategoryId($id,$config['per_page'],$page);
		//$GetData['products'] =  $this->product->GetProductsByCategoryId($id);

		if(!empty($this->session->userdata('user_id'))){
			$GetData['userproducts'] =  $this->product->UserProducts($this->session->userdata('user_id'));
		}else{
			$GetData['userproducts'] =  array();
		}

		if(!empty($this->session->userdata('user_id'))){
			$GetData['userfavourite'] =  $this->product->UserFavourites($this->session->userdata('user_id'));
		}else{
			$GetData['userfavourite'] =  array();
		}

		$this->load->view('categories',$GetData);
	}
}
