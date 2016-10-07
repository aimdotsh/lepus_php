<div class="container-fluid" style="padding:0px;">
 <div class="row-fluid">
 
 <div id="mysql_connect" style="height:270px; width:49.4%;border:1px solid #ccc;padding:0px;margin-left:3px;margin-top:5px; float:left; background-color:#30536f"></div>
 <div id="mysql_delay" style="height:270px; width:49.4%;border:1px solid #ccc;padding:0px;margin-left:3px;margin-top:5px; float:left; background-color:#30536f"></div>
 <div id="mysql_act_thread" style="height:270px; width:49.4%;border:1px solid #ccc;padding:0px;margin-left:3px;margin-top:5px; float:left; background-color:#30536f"></div>
 <div id="redis_mem" style="height:270px; width:49.4%;border:1px solid #ccc;padding:0px;margin-left:3px;margin-top:5px; float:left; background-color:#30536f"></div>
 <div id="db" style="height:270px; width:32.8%;border:1px solid #ccc;padding:0px;margin-left:3px;margin-top:5px; float:left; background-color:#30536f"></div>
 <div id="alarm" style="height:270px; width:66%;border:1px solid #ccc;padding:0px;margin-left:3px;margin-top:5px; float:left; background-color:#30536f;color:#FFF;"></div>


<script type="text/javascript">

</script>
      

<!--Step:1 Import echarts-plain.js or echarts-plain-map.js-->
<!--Step:1 引入echarts-plain.js或者 echarts-plain-map.js-->
<script src="lib/echarts/echarts-plain-original.js"></script>

<!-- cpu -->
<script type="text/javascript">

function echarts_mysql_connect(){

    var myChart_cpu = echarts.init(document.getElementById('mysql_connect'));
    
    var options_cpu = {
        
            backgroundColor: '#30536f',
        
        title : {
            text: 'MySQL connections Top10',
            subtext: '',
            x: 'center',
            textStyle: {
                fontSize: 14, 
                fontWeight: 'bolder',
                color: '#FFFFFF'
            }
        },
        tooltip : {
            trigger: 'axis',
            color : ['#FFFFFF','#22bb22','#4b0082','#d2691e'],
        
        },
        legend: {
            data:['THREAD_CONNECTED'],
            x: 'left',
            textStyle: {
                fontSize: 8, 
                color: '#FFFFFF'
            }
        },
        grid: {
            x: '45px',
            x2: '20px',
            y: '40px',
            y2: '90px',
        },
        toolbox: {
            show : true,
            color : ['#FFFFFF','#FFFFFF','#FFFFFF','#FFFFFF'],
            feature : {
               
                magicType : {show: true, type: ['line', 'bar']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                data : [],
                name : '',
                axisLabel : {
                    rotate: '45',
                    textStyle: { 
                        color:'#FFFFFF',
                    }
                }
            }
        ],
        yAxis : [
            {
                type : 'value',
                splitArea : {show : true},
                axisLabel : {
                    textStyle: { 
                        color:'#FFFFFF',
                    }
                }
            }
        ],
        series : [
            {
                name:'THREAD_CONNECTED',
                type:'bar',
                itemStyle: {
                    normal: {
                        color: '#f13a16',
                    },
                    
                },
                data:[]
            },
        ]
    };
 
    
    $.ajax({   
        type:"POST",   
        url:"<?php echo site_url('screen/ajax_mysql_connect')?>",
        dataType: "json", //返回数据形式为json            
        success:function(result){
            if(result){
                options_cpu.xAxis[0].data = result.category;
                options_cpu.series[0].data=result.series.threads_connect;
                myChart_cpu.setOption(options_cpu);
            }
            
        },
        error: function (errorMsg) {
            $('#cpu').html("ajax load data error!");
        }
    });
}
echarts_mysql_connect();
setInterval("echarts_mysql_connect()",30*1000);


</script>


<!-- net -->
<script type="text/javascript">

function echarts_mysql_delay(){

    var myChart_net = echarts.init(document.getElementById('mysql_delay'));
    
    var options_net = {
        
            backgroundColor: '#30536f',
        
        title : {
            text: 'MySQL SLAVE DELAY Top10',
            subtext: '',
            x: 'center',
            textStyle: {
                fontSize: 14, 
                fontWeight: 'bolder',
                color: '#FFFFFF'
            }
        },
        tooltip : {
            trigger: 'axis',
            color : ['#FFFFFF','#22bb22','#4b0082','#d2691e'],
        
        },
        legend: {
            data:['delay'],
            x: 'left',
            textStyle: {
                fontSize: 8, 
                color: '#FFFFFF'
            }
        },
        grid: {
            x: '65px',
            x2: '20px',
            y: '40px',
            y2: '75px',
        },
        toolbox: {
            show : true,
            color : ['#FFFFFF','#FFFFFF','#FFFFFF','#FFFFFF'],
            feature : {
               
                magicType : {show: true, type: ['line', 'bar']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                data : ['a','b'],
                name : '',
                axisLabel : {
                    rotate: '45',
                    textStyle: { 
                        color:'#FFFFFF',
                    }
                }
            }
        ],
        yAxis : [
            {
                type : 'value',
                splitArea : {show : true},
                axisLabel : {
                 formatter: '{value}s',
                 textStyle: {
                        color:'#FFFFFF',
                    }
                }
            }
        ],
        series : [
            {
                name:'delay',
                type:'bar',
                itemStyle: {
                    normal: {
                        color: '#DBFF4C',
                    },
                    
                },
                data:[1,2]
            },
        ]
    };
    $.ajax({   
        type:"POST",   
        url:"<?php echo site_url('screen/ajax_mysql_delay')?>",
        dataType: "json", //返回数据形式为json            
        success:function(result){
            if(result){
                options_net.xAxis[0].data = result.category;
                options_net.series[0].data=result.series.delay;
           
                myChart_net.setOption(options_net);
            }
            
        },
        error: function (errorMsg) {
            $('#net').html("ajax load data error!");
        }
    });

}

echarts_mysql_delay();
setInterval("echarts_mysql_delay()",30*1000);
 

</script>



<!-- io -->
<script type="text/javascript">

function echarts_mysql_thread(){

    var myChart_io = echarts.init(document.getElementById('mysql_act_thread'));
    
    var options_io = {
        
            backgroundColor: '#30536f',
        
        title : {
            text: 'MySQL Thread running Top10',
            subtext: '',
            x: 'center',
            textStyle: {
                fontSize: 14, 
                fontWeight: 'bolder',
                color: '#FFFFFF'
            }
        },
        tooltip : {
            trigger: 'axis',
            color : ['#FFFFFF','#22bb22','#4b0082','#d2691e'],
        
        },
        legend: {
            data:['Thread_running'],
            x: 'left',
            textStyle: {
                fontSize: 8, 
                color: '#FFFFFF'
            }
        },
        grid: {
            x: '45px',
            x2: '20px',
            y: '40px',
            y2: '75px',
        },
        toolbox: {
            show : true,
            color : ['#FFFFFF','#FFFFFF','#FFFFFF','#FFFFFF'],
            feature : {
               
                magicType : {show: true, type: ['line', 'bar']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                data : ['a','b'],
                name : '',
                axisLabel : {
                    rotate: '45',
                    textStyle: {
                     fontSize: 4,
                     color:'#FFFFFF',
                    }
                }
            }
        ],
        yAxis : [
            {
                type : 'value',
                splitArea : {show : true},
                axisLabel : {
                    textStyle: { 
                        color:'#FFFFFF',
                    }
                }
            }
        ],
        series : [
            {
                name:'Thread_running',
                type:'bar',
                itemStyle: {
                    normal: {
                        color: '#FF6633',
                    },
                    
                },
                data:[1,2]
            },
           
        ]
    };
 

    $.ajax({   
        type:"POST",   
        url:"<?php echo site_url('screen/ajax_mysql_thread')?>",
        dataType: "json", //返回数据形式为json            
        success:function(result){
            if(result){
                options_io.xAxis[0].data = result.category;
                options_io.series[0].data=result.series.threads_running;
                myChart_io.setOption(options_io);
            }
            
        },
        error: function (errorMsg) {
            $('#io').html("ajax load data error!");
        }
    });

}

echarts_mysql_thread();
setInterval("echarts_mysql_thread()",30*1000);
 

</script>



<!-- db -->
<script type="text/javascript">

function echarts_load_db(){

    var myChart_db = echarts.init(document.getElementById('db'));
    var options_db = {

    backgroundColor: '#30536f',
        
        title : {
            text: 'DB Active Process',
            subtext: '',
            x: 'left',
            textStyle: {
                fontSize: 14, 
                fontWeight: 'bolder',
                color: '#FFFFFF'
            }
        },
    
    legend: {
        data:['MySQL','Oracle','MongoDB','Redis'],
        x: 'right',
        textStyle: {
                fontSize: 8, 
                color: '#FFFFFF'
        }
    },
    grid: {
            x: '45px',
            x2: '20px',
            y: '40px',
            y2: '40px',
    },
    tooltip : {
            trigger: 'axis',
            color : ['#FFFFFF','#22bb22','#4b0082','#d2691e'],
        
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
            data : ['18:06','18:07','18:08','18:09','18:10','18:11','18:12'],
            axisLabel : {
                    textStyle: { 
                        color:'#FFFFFF',
                    }
            }
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                    textStyle: { 
                        color:'#FFFFFF',
                    }
            }
        }
    ],
    series : [
        {
            name:'MySQL',
            type:'line',
            itemStyle: {
                    normal: {
                        color: '#00FF00',
                    },
                    
            },
            data:[100, 100, 100, 100, 100, 100, 100]
        },
        {
            name:'Oracle',
            type:'line',
            itemStyle: {
                    normal: {
                        color: '#FF3333',
                    },
                    
            },
            data:[30, 30, 30, 30, 30, 30, 30]
        },
        {
            name:'MongoDB',
            type:'line',
            itemStyle: {
                    normal: {
                        color: '#FFFF00',
                    },
                    
            },
            data:[15, 15, 15, 15, 15, 15, 15]
        },
        {
            name:'Redis',
            type:'line',
            itemStyle: {
                    normal: {
                        color: '#CC99FF',
                    },
                    
            },
            data:[5, 5, 5, 5, 5, 5, 5]
        }
    ]
    };


   $.ajax({   
        type:"POST",   
        url:"<?php echo site_url('screen/ajax_get_db_waits')?>",
        dataType: "json", //返回数据形式为json            
        success:function(result){
            if(result){
                options_db.xAxis[0].data = result.category;
                options_db.series[0].data=result.series.mysql_waits;
                options_db.series[1].data=result.series.oracle_waits;
                options_db.series[2].data=result.series.mongodb_waits;
                options_db.series[3].data=result.series.redis_waits;
                myChart_db.setOption(options_db);
            }
            
        },
        error: function (errorMsg) {
            $('#db').html("ajax load data error!");
        }
    });

}

echarts_load_db();
setInterval("echarts_load_db()",30*1000);
</script>


<!-- ajax load alarm-->
<script type="text/javascript">

function load_alarm(){
    $.ajax({   
        type:"POST",   
        url:"<?php echo site_url('screen/ajax_get_alarm')?>",
        //dataType: "json", //返回数据形式为json            
        success:function(result){
            if(result){
               $('#alarm').html(result);
            }
            
        },
        error: function (errorMsg) {
            $('#alarm').html("ajax load alarm data error!");
        }
    });
}

load_alarm();
setInterval("load_alarm()",30*1000);
</script>



  <script type="text/javascript">

   function echarts_redis_mem(){

    var myChart_rmem = echarts.init(document.getElementById('redis_mem'));

    var options_mem = {

     backgroundColor: '#30536f',

     title : {
      text: 'REDIS MEMUSAGE TOP 10',
      subtext: '',
      x: 'center',
      textStyle: {
       fontSize: 14,
       fontWeight: 'bolder',
       color: '#FFFFFF'
      }
     },
     tooltip : {
      trigger: 'axis',
      color : ['#FFFFFF','#22bb22','#4b0082','#d2691e'],

     },
     legend: {
      data:['MEM_USAGE'],
      x: 'left',
      textStyle: {
       fontSize: 8,
       color: '#FFFFFF'
      }
     },
     grid: {
      x: '65px',
      x2: '20px',
      y: '40px',
      y2: '75px',
     },
     toolbox: {
      show : true,
      color : ['#FFFFFF','#FFFFFF','#FFFFFF','#FFFFFF'],
      feature : {

       magicType : {show: true, type: ['line', 'bar']},
       restore : {show: true},
       saveAsImage : {show: true}
      }
     },
     calculable : true,
     xAxis : [
      {
       type : 'category',
       data : ['a','b'],
       name : '',
       axisLabel : {
        rotate: '45',
        textStyle: {
         fontSize: 4,
         color:'#FFFFFF',
        }
       }
      }
     ],
     yAxis : [
      {
       type : 'value',
       splitArea : {show : true},
       axisLabel : {
        formatter: '{value}MB',
        textStyle: {
         color:'#FFFFFF',
        }
       }
      }
     ],
     series : [
      {
       name:'MEM_USAGE',
       type:'bar',
       itemStyle: {
        normal: {
         color: '#660000',
        },

       },
       data:[1,2]
      },

     ]
    };


    $.ajax({
     type:"POST",
     url:"<?php echo site_url('screen/ajax_get_redismem')?>",
     dataType: "json", //返回数据形式为json
     success:function(result){
      if(result){
       options_mem.xAxis[0].data = result.category;
       options_mem.series[0].data=result.series.memory_usage;
       myChart_rmem.setOption(options_mem);
      }

     },
     error: function (errorMsg) {
      $('#io').html("ajax load data error!");
     }
    });

   }

   echarts_redis_mem();
   setInterval("echarts_redis_mem()",30*1000);


  </script>