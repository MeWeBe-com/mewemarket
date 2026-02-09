<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class archive extends CI_Controller {

	public function index()
	{
		$SendData['jobDetails'] = $this->admin_model->getAllArchiveJobs();

		$SendData['hospitals'] = $this->admin_model->getAllHospitals();

		$SendData['dateFormat'] = $this->admin_model->GetConfigOption('','1','__date__type__')[0]->value;

		$this->load->view('archive',$SendData);
	}

	public function AddtoArchive()
	{
		$Post_id =  $this->input->get('Post_id');
		
		$test_id = $this->admin_model->AddtoArchive($Post_id);

		if($test_id != 'Fail'){
			echo "--Done--";
		}
	}

	public function RemoveFromArchive()
	{
		$Post_id =  $this->input->get('Post_id');
		
		$test_id = $this->admin_model->RemoveFromArchive($Post_id);

		if($test_id != 'Fail'){
			echo "--Done--";
		}
			
	}

}
/* End of file admin.php */
/* Location: ./application/controllers/archive.php */