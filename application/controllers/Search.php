<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class search extends CI_Controller {

	public function index()
	{
		$data = $this->input->post();

		if(empty($data['keyword'])){
			redirect(base_url());
		}

		$GetData['products'] =  $this->product->SearchProducts(trim($data['keyword']));

		if(!empty($GetData['products'])){
		/*	foreach ($GetData['products'] as $key => $product){
				$FilterCategory[$key]['category_id'] = $product->category_id;
				$FilterCategory[$key]['category_name'] = $product->category_name;
			}


		$compatible_browsers =  $this->general->SelectQuery('compatible_browsers');
		foreach ($compatible_browsers as $key => $browsers){
			if(in_array($browsers->browser_name, array_column($GetData['products'], 'compatible_browsers'))){
				$Filterbrowsers[$key]['browser_name'] = $browsers->browser_name;
			}
		}

		$software_framework =  $this->general->SelectQuery('software_framework');
		foreach ($software_framework as $key => $framework){
			if(in_array($framework->software_name, array_column($GetData['products'], 'software_framework'))){
				$Filtersoftware[$key]['software_name'] = $framework->software_name;
			}

		}

		$software_version =  $this->general->SelectQuery('software_version');
		foreach ($software_version as $key => $version){
			array_filter('','','')

			if(array_filter($version->version_name, array_column($GetData['products'], 'software_version'))){
				$Filterversions[$key]['version_name'] = $version->version_name;
			}
		}



		$files_included =  $this->general->SelectQuery('files_included');
		foreach ($files_included as $key => $files){
			if(in_array($files->files_name, array_column($GetData['products'], 'files_included'))){
				$Filterfiles[$key]['files_name'] = $files->files_name;
			}
		}

		$GetData['FilterCategory'] = $FilterCategory;
		$GetData['Filterbrowsers'] = $Filterbrowsers;
		$GetData['Filtersoftware'] = $Filtersoftware;
		$GetData['Filterversions'] = $Filterversions;
		$GetData['Filterfiles'] 	= $Filterfiles;*/

		}else{
			$GetData['FilterCategory'] = "";
			$GetData['Filterbrowsers'] = "";
			$GetData['Filtersoftware'] = "";
			$GetData['Filterversions'] = "";
			$GetData['Filterfiles'] = "";
		}




		$GetData['keyword'] =  $data['keyword'];

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



		$this->load->view('searchresults',$GetData);
	}

	public function SearchFilter()
	{
		$data = $this->input->post();

		$GetData['keyword'] =  $data['keyword'];
		$GetData['price_min'] =  $data['price_min'];
		$GetData['price_min'] =  $data['price_max'];

		$GetData['products'] =  $this->product->SearchProductsWithFilters($data['keyword'],$data['price_min'],$data['price_max']);

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

		$this->load->view('searchresults',$GetData);
	}


}
