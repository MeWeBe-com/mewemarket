<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin extends CI_Controller {


	public function index()
	{
		if(empty($this->session->userdata('user_id')) || $this->session->userdata('role') != 1 ){
			redirect(base_url());
		}

		$GetData['TotalUsers'] =  $this->admin->TotalUsers();
		$GetData['ActivatedTools'] =  $this->admin->ActivatedTools();
		$GetData['TotalPackages'] =  $this->admin->TotalPackages();
		$GetData['Subscription'] =  $this->admin->GetAllUsersSubscription();

		$this->load->view('admin/dashboard',$GetData);
	}

	public function manage_package()
	{
		if(empty($this->session->userdata('user_id')) || $this->session->userdata('role') != 1 ){
			redirect(base_url());
		}

		$GetData['packages'] =  $this->general->SelectQuery('packages');

		$this->load->view('admin/managepackage',$GetData);
	}

	public function manage_category()
	{
		if(empty($this->session->userdata('user_id')) || $this->session->userdata('role') != 1 ){
			redirect(base_url());
		}

		$GetData['categories'] =  $this->general->SelectQuery('categories');

		$this->load->view('admin/managecategory',$GetData);
	}

	public function create_package($id = NULL)
	{
		if(empty($this->session->userdata('user_id')) || $this->session->userdata('role') != 1 ){
			redirect(base_url());
		}

		if(!empty($id)){
			$GetData['package'] =  $this->general->SelectQueryWithClause('packages','package_id',$id);
		}else{
			$GetData['package'] = '';
		}

		$this->load->view('admin/createpackage',$GetData);
	}

	public function create_category($id = NULL)
	{
		if(empty($this->session->userdata('user_id')) || $this->session->userdata('role') != 1 ){
			redirect(base_url());
		}

		if(!empty($id)){
			$GetData['category'] =  $this->general->SelectQueryWithClause('categories','category_id',$id);
		}else{
			$GetData['category'] = '';
		}

		$this->load->view('admin/createcategory',$GetData);
	}

	public function AddPackage()
	{
		if(empty($this->session->userdata('user_id')) || $this->session->userdata('role') != 1 ){
			redirect(base_url());
		}


		$PostedData = $this->input->post();

		$DBData['package_name'] = $PostedData['package_name'];
		$DBData['package_duration'] = $PostedData['package_duration'];
		$DBData['package_amount'] = $PostedData['package_amount'];
		$DBData['visibility'] = $PostedData['visibility'];
		$DBData['user_limit'] = $PostedData['user_limit'];
		$DBData['tools_limit'] = $PostedData['tools_limit'];
		$DBData['reports'] = $PostedData['reports'];
		$DBData['package_description'] = $PostedData['package_description'];

		if(empty($PostedData['package_id'])){
			$this->general->InsertQuery('packages',$DBData);
			redirect('admin/manage_package?Added');
		}else{
			$this->general->UpdateQuery('packages','package_id',$PostedData['package_id'],$DBData);
			redirect('admin/manage_package?Updated');
		}
	}

	public function AddCategory()
	{
		if(empty($this->session->userdata('user_id')) || $this->session->userdata('role') != 1 ){
			redirect(base_url());
		}

		$PostedData = $this->input->post();

		$DBData['category_icon'] = $PostedData['category_icon'];
		$DBData['category_name'] = $PostedData['category_name'];
		$DBData['visibility'] = $PostedData['visibility'];
		$DBData['ordering'] = $PostedData['ordering'];

		if(empty($PostedData['category_id'])){
			$this->general->InsertQuery('categories',$DBData);
			redirect('admin/manage_category?Added');
		}else{
			$this->general->UpdateQuery('categories','category_id',$PostedData['category_id'],$DBData);
			redirect('admin/manage_category?Updated');
		}

	}

	public function manage_product()
	{
		if(empty($this->session->userdata('user_id')) || $this->session->userdata('role') != 1 ){
			redirect(base_url());
		}

		$GetData['products'] =  $this->product->GetProducts();

		$this->load->view('admin/manageproduct',$GetData);
	}

	public function create_product($id = NULL)
	{
		if(empty($this->session->userdata('user_id')) || $this->session->userdata('role') != 1 ){
			redirect(base_url());
		}

		$GetData['categories'] =  $this->general->SelectQuery('categories');

		if(!empty($id)){
			$GetData['product'] =  $this->general->SelectQueryWithClause('products','product_id',$id);
			$GetData['productImages'] =  $this->general->SelectQueryWithClause('product_images','product_id',$id);
		}else{
			$GetData['product'] = '';
		}

		$this->load->view('admin/createproduct',$GetData);
	}

	public function AddProduct()
	{
		if(empty($this->session->userdata('user_id')) || $this->session->userdata('role') != 1 ){
			redirect(base_url());
		}

		$PostedData = $this->input->post();

		$DBData['product_name'] 		= $PostedData['product_name'];
		$DBData['category_id'] 			= $PostedData['category_id'];
		$DBData['product_type'] 		= $PostedData['product_type'];

		if(!empty($_FILES['featured_image']['name'])){

			$file_name   = $_FILES['featured_image']['name'];
			$file_tmp 	 = $_FILES['featured_image']['tmp_name'];

			$ext = pathinfo($file_name, PATHINFO_EXTENSION);
			$allowed = array('jpg','png','gif','jpeg','bmp','svg','JPEG');


			if(!in_array( $ext, $allowed ) ) {
				$data['error'] = "yes";
			}else{
				if(!empty($file_name)){
					move_uploaded_file($file_tmp,"uploads/products/feature_img/".$file_name);
				}else{

				}
			}

			$DBData['featured_image']  = $file_name;
		}

		if(!empty($_FILES['product_video']['name'])){

			$file_name = $_FILES['product_video']['name'];
			$file_tmp 	 = $_FILES['product_video']['tmp_name'];

			$ext = pathinfo($file_name, PATHINFO_EXTENSION);
			$allowed = array('mp4','mov','flv','avi','webm');

			if(!in_array( $ext, $allowed ) ) {
				$data['error'] = "yes";
			}else{
				if(!empty($file_name)){
					move_uploaded_file($file_tmp,"uploads/products/product_video/".$file_name);
				}else{

				}
			}

			$DBData['product_video']  = $file_name;
		}

		$DBData['description'] 			= $PostedData['description'];
		$DBData['key_benefits'] 	 	= $PostedData['key_benefits'];
		$DBData['demo_link'] 	 		= $PostedData['demo_link'];

		$DBData['compatible_browsers'] 	= implode("|",$PostedData['compatible_browsers']);
		$DBData['files_included'] 	 	= implode("|",$PostedData['files_included']);
		$DBData['software_framework'] 	= implode("|",$PostedData['software_framework']);
		$DBData['software_version'] 	= implode("|",$PostedData['software_version']);

		$DBData['api_url'] 	= $PostedData['api_url'];
		$DBData['api_type'] = $PostedData['api_type'];

		$DBData['rating'] 	= $PostedData['rating'];
		$DBData['total_sales'] = $PostedData['total_sales'];

		$DBData['featured_tag'] = $PostedData['featured_tag'];

		if(empty($PostedData['product_id'])){
			$this->general->InsertQuery('products',$DBData);
			redirect('admin/manage_product?Added');
		}else{
			$this->general->UpdateQuery('products','product_id',$PostedData['product_id'],$DBData);
			redirect('admin/manage_product?Updated');
		}
	}

	public function manage_users()
	{
		if(empty($this->session->userdata('user_id')) || $this->session->userdata('role') != 1 ){
			redirect(base_url());
		}

		$GetData['Users'] =  $this->admin->GetAllUsersDetails();

		$this->load->view('admin/manageusers',$GetData);
	}

	public function manage_subscription()
	{
		if(empty($this->session->userdata('user_id')) || $this->session->userdata('role') != 1 ){
			redirect(base_url());
		}

		$GetData['Subscription'] =  $this->admin->GetAllUsersSubscription();
		$GetData['AllTimeEarning'] =  $this->admin->GetAllTimeEarning()[0]->total;
		$GetData['ThisYearEarning'] =  $this->admin->GetThisYearEarning()[0]->total;
		$GetData['ThisMonthEarning'] =  $this->admin->GetThisMonthEarning()[0]->total;

		$this->load->view('admin/managesubscription',$GetData);
	}

	public function UploadGalleryImages($id = NULL)
	{

		if(empty($id)){
			$data = $this->admin->ProductIdNext('products')[0];
			$id =  $data->id + 1;
		}else{
			$id = $id;
		}

		$file_name = $_FILES['file']['name'];
		$file_tmp 	 = $_FILES['file']['tmp_name'];

		if(!empty($file_name)){
			move_uploaded_file($file_tmp,"uploads/products/ss/".$file_name);
		}

		$Posteddata['product_id'] = $id;
		$Posteddata['image'] = $file_name;

		$this->general->InsertQuery('product_images',$Posteddata);

		echo "Done";
	}

	public function DeleteGalleryImageById($id = NULL)
	{

		if(empty($this->session->userdata('user_id'))){
			redirect( base_url());
		};

		$this->general->DeleteQuery('product_images','id',$id);
		echo "Done";

	}
}
