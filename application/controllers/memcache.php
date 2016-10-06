<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class memcache extends Front_Controller {

    function __construct(){
		parent::__construct();
        $this->load->model('servers_memcache_model','server');
        $this->load->model("option_model","option");
		$this->load->model("memcache_model","memcache");
        $this->load->model("os_model","os");  
	}

        public function index2(){

        $memcache_statistics = array();
        $memcache_statistics["memcache_servers_up"] = $this->db->query("select count(*) as num from memcache_status where connect=1")->row()->num;
        $memcache_statistics["memcache_servers_down"] = $this->db->query("select count(*) as num from memcache_status  where connect!=1")->row()->num;
        $data["memcache_statistics"] = $memcache_statistics;
        //print_r($mysql_statistics);
        $data["memcache_versions"] = $this->db->query("select memcache_version as versions, count(*) as num from memcache_status where memcache_version !='0' GROUP BY versions")->result_array();
        
        $data['memcache_connected_clients_ranking'] = $this->db->query("select server.host,server.port,status.curr_connections value from memcache_status status left join db_servers_memcache server on `status`.server_id=`server`.id order by curr_connections desc limit 10;")->result_array();
        $data['memcache_used_memory_ranking'] = $this->db->query("select server.host,server.port,ROUND((status.bytes/1024/1024))   value from memcache_status status left join db_servers_memcache server on `status`.server_id=`server`.id order by value  desc limit 10;")->result_array();
       
        $this->layout->view("memcache/index",$data);
    }

    
    public function index()
	{
        parent::check_privilege();
        $data["datalist"]=$this->memcache->get_status_total_record();

        $setval["host"]=isset($_GET["host"]) ? $_GET["host"] : "";
        $setval["tags"]=isset($_GET["tags"]) ? $_GET["tags"] : "";
        
        $setval["order"]=isset($_GET["order"]) ? $_GET["order"] : "";
        $setval["order_type"]=isset($_GET["order_type"]) ? $_GET["order_type"] : "";
        $data["setval"]=$setval;
  
        $this->layout->view("memcache/index",$data);
    }

     public function memory()
        {
        parent::check_privilege();
        $data["datalist"]=$this->memcache->get_status_total_record(1);

        $setval["host"]=isset($_GET["host"]) ? $_GET["host"] : "";
        $setval["tags"]=isset($_GET["tags"]) ? $_GET["tags"] : "";
        
        $setval["order"]=isset($_GET["order"]) ? $_GET["order"] : "";
        $setval["order_type"]=isset($_GET["order_type"]) ? $_GET["order_type"] : "";
        $data["setval"]=$setval;
        
        
        $this->layout->view("memcache/memory",$data);
    }

    
    
    
    public function chart()
    {
        parent::check_privilege('');
        $server_id = $this->uri->segment(3);
        $server_id=!empty($server_id) ? $server_id : "0";
        $begin_time = $this->uri->segment(4);
        $begin_time=!empty($begin_time) ? $begin_time : "30";
        $time_span = $this->uri->segment(5);
        $time_span=!empty($time_span) ? $time_span : "min";
        
        //图表
        $chart_reslut=array();              
        for($i=$begin_time;$i>=0;$i--){
            $timestamp=time()-60*$i;
            $time= date('YmdHi',$timestamp);
            $has_record = $this->memcache->check_has_record($server_id,$time);
            if($has_record){
                $chart_reslut[$i]['time']=date('Y-m-d H:i',$timestamp);
                $dbdata=$this->memcache->get_status_chart_record($server_id,$time);
                $chart_reslut[$i]['curr_connections'] = $dbdata['curr_connections'];
                $chart_reslut[$i]['get_hits'] = $dbdata['get_hits'];
                $chart_reslut[$i]['get_misses'] = $dbdata['get_misses'];                
                $chart_reslut[$i]['network_bytesIn_persecond'] = $dbdata['network_bytesIn_persecond'];
                $chart_reslut[$i]['network_bytesOut_persecond'] = $dbdata['network_bytesOut_persecond'];               
                $chart_reslut[$i]['opcounters_get_persecond'] = $dbdata['opcounters_get_persecond'];
                $chart_reslut[$i]['opcounters_set_persecond'] = $dbdata['opcounters_set_persecond'];               
                $chart_reslut[$i]['opcounters_get_rate'] = number_format($dbdata['opcounters_get_rate']/100,2);
                $chart_reslut[$i]['bytes'] = $dbdata['bytes'];
                $chart_reslut[$i]['limit_maxbytes'] = $dbdata['limit_maxbytes'];
                $chart_reslut[$i]['evictions'] = $dbdata['evictions'];
            }  
        }
        $data['chart_reslut']=$chart_reslut;   
        $chart_option=array();
        if($time_span=='min'){
            $chart_option['formatString']='%H:%M';
        }
        else if($time_span=='hour'){
            $chart_option['formatString']='%H:%M';
        }
        else if($time_span=='day'){
            $chart_option['formatString']='%m/%d %H:%M';
        }
        
        $data['chart_option']=$chart_option;
        $data['begin_time']=$begin_time;
        $data['cur_server_id']=$server_id;
        $data["cur_server"] = $this->server->get_servers($server_id);
        $this->layout->view('memcache/chart',$data);
    }

    
}

/* End of file memcache.php */
/* Location: ./application/controllers/memcache.php */