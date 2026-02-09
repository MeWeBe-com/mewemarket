<?php


class log_model extends CI_Model
{
    protected $log = 'log';

    function __construct(){
        parent::__construct();

    }

    function get_log($id){
        $result = $this->db->get_where('log',array('id'=>$id))->row_array();

        return $result;
    }

    /** Get all log
     *
     */
    function get_all_log($supplier_id){

        if($this->session->userdata('role') == 'Supplier') {
            $this->db->select('log.*');
            $this->db->select('supplier.name');
            $this->db->join('supplier','log.supplier_id  = supplier.id');
            $this->db->where('log.model', 'supplier');
            $this->db->where('log.supplier_id', $this->session->userdata('id'));
            $this->db->where('log.supplier_id', $this->session->userdata('id'));
            $this->db->order_by('log.id', 'desc');

        }elseif($this->session->userdata('role') == '0')
        {
            $this->db->select('log.*');
            $this->db->select('supplier.name');
            $this->db->join('supplier','log.supplier_id  = supplier.id','left');
            $this->db->where('log.model', 'supplier');
            $this->db->where('log.supplier_id', $supplier_id);
             $this->db->order_by('log.id', 'desc');
        }else
        {
            $this->db->select('log.*');
            $this->db->select('supplier.name');
            $this->db->join('supplier','log.supplier_id  = supplier.id');
            $this->db->where('log.model', 'supplier');
            $this->db->where('log.supplier_id',$supplier_id);
            $this->db->order_by('log.id', 'desc');
        }

        $result = $this->db->get('log')->result();
        
   
        return $result;
    }

    /** Get limit log
     *@param $limit - limit of query , $start - start of db table index to get query
     *
     */
    function get_limit_log($limit, $start){
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('log')->result_array();
        return $result;
    }

    /** Count log rows
     *
     */
    function get_count_log(){
        $result = $this->db->from("log")->count_all_results();
        return $result;
    }

    /** function to add new log
     *@param $params - data set to add record
     *
     */
    function add_log($action,$model,$url=null){
        $params = array(
            'supplier_id'=>$this->session->userdata('id'),
            'action' =>$action,
            'model'=>$model,
            'url'=>$url,
            'ip'=>$_SERVER['REMOTE_ADDR'],
            'created_at' =>date('Y-m-d h:i:s'),
            'updated_at'=>date('Y-m-d h:i:s')
        );
        $this->db->insert('log',$params);

        return true;
    }

    /*
     * function to update log
     *@param $id - primary key to update record,$params - data set to add record
     *
     */
    function update_log($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('log',$params);

        return $status;
    }

    /*
     * function to delete log
     *@param $id - primary key to delete record
     *
     */

    function delete_log($id){
        $status = $this->db->delete('log',array('id'=>$id));
        return $status;
    }

}