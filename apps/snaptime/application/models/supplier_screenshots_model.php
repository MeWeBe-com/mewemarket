<?php


class supplier_screenshots_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('upload');
    }
    public function store()
    {
        $supplier_id = $this->input->post('supplier_id');
        $relation_id = $this->input->post('relation_id');
        $UPLOAD_DIR = "./assets/supplier/".$supplier_id."/".$relation_id;
		
        $base_64_data = base64_encode(file_get_contents($this->input->post('image')));

        if (!is_dir($UPLOAD_DIR)) {
            if (!mkdir($UPLOAD_DIR,0777,TRUE) && !is_dir($UPLOAD_DIR)) {
                echo new \RuntimeException(sprintf('Directory "%s" was not created', $UPLOAD_DIR));
            }
        }
        if(isset($supplier_id) && isset($relation_id)) {

            $image_name = $supplier_id . "-" . $relation_id . "-" . date('Y-m-dHis');
            if (!file_put_contents($UPLOAD_DIR . "/" . $image_name . '.jpg', base64_decode($base_64_data))) {
                $error = array('error' => $this->upload->display_errors());
                echo json_encode($error);
            } else {
                $store_data = array(
                    'file' => $image_name . '.jpg',
                    'status' => '1',
                    'relation_id' => $this->input->post('relation_id'),
                    'supplier_id' => $this->input->post('supplier_id')
                );
                $this->db->insert('supplier_screenshots', $store_data);

                $responseArray =  array('file' => $image_name . '.jpg','relation_id' => $this->input->post('relation_id'),
                    'supplier_id' => $this->input->post('supplier_id'), 'created_at' => date("H:i d/m/Y") );
                
                return $responseArray;
            }
        }
    }

    public function get_work_gallery($supplier_id = NULL,$table,$relation_id)
    {
        $this->db->select('supplier_screenshots.*');
        $this->db->select('supplier.name as supplier_name');
        $this->db->select($table.'.name as '.$table.'_name,'.$table.'.id as '.$table.'_id');
        $this->db->from('supplier_screenshots');
        $this->db->join($table,'supplier_screenshots.relation_id = '.$table.'.id','left');
        $this->db->join('supplier','supplier_screenshots.supplier_id = supplier.id');
        $this->db->join('supplier_relations','supplier_screenshots.relation_id = supplier_relations.id');

        if(!empty($supplier_id)){
            $this->db->where('supplier_screenshots.supplier_id',$supplier_id);
        }
        $this->db->where('supplier_relations.table_name',$table);
        $this->db->where('supplier_relations.relation_id',$relation_id);
        $this->db->order_by('supplier_screenshots.id','desc');
        $this->db->limit('6');

        $query= $this->db->get();
        return $query->result();
    }
    public function get_3_work_gallery($supplier_id = NULL,$table,$relation_id)
    {
        $this->db->select('supplier_screenshots.*');
        $this->db->select('supplier.name as supplier_name');
        $this->db->select($table.'.name as '.$table.'_name,'.$table.'.id as '.$table.'_id');
        $this->db->from('supplier_screenshots');
        $this->db->join($table,'supplier_screenshots.relation_id = '.$table.'.id','left');
        $this->db->join('supplier','supplier_screenshots.supplier_id = supplier.id');
        $this->db->join('supplier_relations','supplier_screenshots.relation_id = supplier_relations.id');

        if(!empty($supplier_id)){
            $this->db->where('supplier_screenshots.supplier_id',$supplier_id);
        }
        $this->db->where('supplier_relations.table_name',$table);
        $this->db->where('supplier_relations.relation_id',$relation_id);
        $this->db->order_by('supplier_screenshots.id','desc');
        $this->db->limit('3');

        $query= $this->db->get();
        return $query->result();
    }
    public function get_3_work_gallery_by_supplier($supplier_id)
    {
        $this->db->select('supplier_screenshots.*');
        $this->db->from('supplier_screenshots');
        $this->db->where('supplier_screenshots.supplier_id',$supplier_id);
        $this->db->order_by('supplier_screenshots.id','desc');
        $this->db->limit('3');

        $query= $this->db->get();
        return $query->result();

    }

    public function get_work_gallery_For_All($relation_id,$supplier_id = NULL,$table,$start_date = NULL,$end_date = NULL,$limit = Null,$start = Null)
    {
        $this->db->select('supplier_screenshots.*');
        $this->db->select('supplier.name as supplier_name');
        $this->db->select($table.'.name as '.$table.'_name,'.$table.'.id as '.$table.'_id');
        $this->db->from('supplier_screenshots');

        $this->db->join('supplier','supplier_screenshots.supplier_id = supplier.id');
        $this->db->join('supplier_relations','supplier_screenshots.relation_id = supplier_relations.id');
        $this->db->join($table,'supplier_relations.relation_id = '.$table.'.id','left');

        $this->db->where('supplier_relations.table_name',$table);
        $this->db->where('supplier_relations.relation_id',$relation_id);
        if(!empty($supplier_id)){
            $this->db->where('supplier_screenshots.supplier_id',$supplier_id);
        }

        if(!empty($start_date) && !empty($end_date)){
            $this->db->where('supplier_screenshots.created_at BETWEEN "'.$start_date.'"  AND "'.$end_date.'" ');
        }

        $this->db->order_by('supplier_screenshots.id','desc');

         $this->db->limit($limit, $start);
        $query= $this->db->get();
        return $query->result();
    }

    public function get_count_work_gallery_For_All($relation_id,$supplier_id = NULL,$table,$start_date = NULL,$end_date = NULL)
    {
        $this->db->select('count(*) as totals');
        
        $this->db->select($table.'.name as '.$table.'_name,'.$table.'.id as '.$table.'_id');
        $this->db->from('supplier_screenshots');

        $this->db->join('supplier','supplier_screenshots.supplier_id = supplier.id');
        $this->db->join('supplier_relations','supplier_screenshots.relation_id = supplier_relations.id');
        $this->db->join($table,'supplier_relations.relation_id = '.$table.'.id','left');

        $this->db->where('supplier_relations.table_name',$table);
        $this->db->where('supplier_relations.relation_id',$relation_id);
        if(!empty($supplier_id)){
            $this->db->where('supplier_screenshots.supplier_id',$supplier_id);
        }

        if(!empty($start_date) && !empty($end_date)){
            $this->db->where('supplier_screenshots.created_at BETWEEN "'.$start_date.'"  AND "'.$end_date.'" ');
        }

        $this->db->order_by('supplier_screenshots.id','desc');

        $query= $this->db->get();
        return $query->result();
    }

    public function get_all_screenshots_by_supplier_id($id,$company_id)
    {
        $this->session->set_userdata('previous_url', current_url());
        $this->db->select('*');
        $this->db->from('supplier_screenshots');
        $this->db->join("supplier","supplier_screenshots.supplier_id = supplier.id");
        $this->db->where('supplier.company_id', $company_id);
        $this->db->where('supplier_id', $id);
        $query = $this->db->get();
        return $query->result();
    }
   /* public function get_all_screenshots_by_supplier_id_and_relation_id($supplier_id,$relation_id)
    {
        $this->session->set_userdata('previous_url', current_url());
        $query = $this->db->get_where('supplier_screenshots', array('supplier_id' => $supplier_id,'relation_id'=>$relation_id),6,'desc');
        return $query->result();
    }
*/

 	public function get_all_screenshots_by_supplier_id_and_relation_id($start_date,$last_date,$supplier_id,$relation_id)
    {
       // $this->db->select_sum('total');
        $this->db->select('*');
		$this->db->limit('6');
        $this->db->from('supplier_screenshots');
		$this->db->where('supplier_id', $supplier_id);
        $this->db->where('relation_id', $relation_id);
		$this->db->where("Date(created_at) BETWEEN '". $start_date . "' AND '" . $last_date . "'");
        $query = $this->db->get();
        return $result = $query->result();

    }
	
    public function get_screenshot_by_id($id)
    {
        $query = $this->db->get_where('supplier_screenshots', array('id' => $id));
        return $query->row();
    }

    public function get_latest_record($id,$company_id)
    {
        $this->db->select("*");
        $this->db->from("supplier_screenshots");
        $this->db->join("supplier","supplier_screenshots.supplier_id = supplier.id");
        $this->db->where('supplier.company_id', $company_id);
        $this->db->where('supplier_screenshots.supplier_id', $id);
        $this->db->limit(1);
        $this->db->order_by('supplier_screenshots.id',"DESC");
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function delete($id)
    {
        $previous_url = $this->session->userdata('previous_url');
        $this->db->where('id', $id);
        $this->db->delete('supplier_screenshots');
        return redirect($previous_url);
    }

      public function get_all_screenshots_by_supplier_id_with_Projects($id)
    {
        $this->db->select("*,projects.id as project_id,supplier_screenshots.relation_id as screenshot_relation_id");
        $this->db->from("supplier_screenshots");
        $this->db->join('supplier_relations','supplier_screenshots.relation_id = supplier_relations.id','right');
        $this->db->join('projects','supplier_relations.relation_id = projects.id','left');
        $this->db->where('supplier_screenshots.supplier_id', $id);
        $this->db->where('supplier_relations.table_name', 'projects');

        $this->db->group_by('supplier_relations.relation_id');
        $this->db->order_by('supplier_screenshots.id',"DESC");
        $query = $this->db->get();
        $result = $query->result();
       
        return $result;
    }

}