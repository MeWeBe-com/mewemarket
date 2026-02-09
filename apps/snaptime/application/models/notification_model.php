<?php


class notification_model extends CI_Model
{
    /**
     * project_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

    }

    public function index(){
        $output='';
        if($this->input->post('view')!=null) {

            $data = array(
                'status' => 1
            );

            $this->db->where('status', 0);
            $this->db->update('notification', $data);

            $this->db->select('*');
            $this->db->from('notification');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {


                    $output .= '
   <li>
   <a href="'.$row->url.'">
   <strong>' . $row->subject . '</strong><br/>
   <small><em>' . $row->description . '</em></small>
   <small>' . $row->ceated_at . '</small><br/>
   </a>
   </li>
   ';
                }

            } else {

                $output .= '
     <li><a href="#" class="text-bold text-italic">No Noti Found</a></li>';
            }
        }
            $this->db->select('*');
            $this->db->from('notification');
            $this->db->where('status',0);
            $query = $this->db->get();
            $count = $query->num_rows();

            $data = array(
                'notification' => $output,
                'unseen_notification'  => $count
            );

            return ($data);

    }


}