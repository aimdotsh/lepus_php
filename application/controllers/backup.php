<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Backup extends Front_Controller {
    function __construct(){
		parent::__construct();
	    $this->load->model("backup_model","backup");
	}
    
    public function index(){ 
        
        if(!empty($_GET["stime"])){
            $current_url= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        }
        else{
            $current_url= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?noparam=1';
        }
        
        //分页
		$this->load->library('pagination');
		$config['base_url'] = $current_url;
		$config['total_rows'] = $this->backup->get_total_rows();
        $config['per_page'] = 30;
		$config['num_links'] = 5;
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		$offset = !empty($_GET['per_page']) ? $_GET['per_page'] : 1;
        $stime = !empty($_GET["stime"])? $_GET["stime"]: date('Y-m-d H:i',time()-3600*24*7);
        $etime = !empty($_GET["etime"])? $_GET["etime"]: date('Y-m-d H:i',time());
        $this->db->where("create_time >=", $stime);
        $this->db->where("create_time <=", $etime);
        !empty($_GET["host_name"]) && $this->db->where("host_name", $_GET["host_name"]);     //where语句，控制条件
        $this->db->order_by("create_time", "desc");
        $setval["host_name"]=isset($_GET["host_name"]) ? $_GET["host_name"] : "";
        $data['datalist'] = $this->backup->get_total_record_paging($config['per_page'],($offset-1)*$config['per_page']);
        $setval["stime"]=$stime;
        $setval["etime"]=$etime;
        $data["setval"]=$setval;    
        
        $this->layout->view("backup/index",$data);
    }
    
}

/* End of file backup.php */
/* Location: ./application/controllers/backup.php */
