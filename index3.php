<?php 
include './logic/php/index3.php';
include './logic/php/count.php'; 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="300;url=index.php"><!-- 定时跳转页面，单位‘秒’,5分钟跳转页面 -->
    <link rel="shortcut icon" href="./logic/icon/favicon.ico">
    <link rel="stylesheet" href="./logic/css/time.css" type="text/css" />
    <script src="http://cdn.staticfile.org/echarts/3.5.0/echarts.min.js"></script>
    <script src="http://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <script src="./logic/js/time.js"></script>
    <title>图书馆人流监测</title>
    <style>
        /* 去除滚动条 */
        body::-webkit-scrollbar {
            display: none;
        }
        /* 设置页面不可滚动 */
        html,body {
            overflow:hidden; 
        }
        body{
            background:url(./logic/images/night.jpg)no-repeat;
            width:100%;
            height:100%;
            background-size:100% 100%;
            /* position:absolute; */
            filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='./logic/images/night.jpg',sizingMethod='scale');
        }
    </style>
</head>
<body onload="getTime();setInterval('refresh()',5000)"><!-- 异步获取数据，单位‘毫秒’,30秒请求一次数据 -->
<div style="width:100%;height:30px;z-index:1;position:absolute;">
<div id="date1" style="color:#F8F1F0;font-size:20px;margin-top:30px;padding-right:40px"></div>
</div>
<div id="no1" style="width:100%;height:30px;line-height:30px;font-weight: 600;padding-left:10px;margin:30px 30px 0 30px;font-size:20px;color:#F8F1F0;background-color: rgba(150, 150, 150, 0.5)">
<div id="count"> 本学期入馆人数 : <?php echo $countAll['count'];?>人，今日实时入馆人数 : <?php echo $countToday['count'];?>人</div>
</div>
        <div id="perPercentPie" style="float:left;margin-left:30px"></div>
        <div id="typePercentPie" style="float:left"></div>
    <script type="text/javascript">
        height = $(window).height();         //可视窗口的高度
        width = $(window).width();
        $('#perPercentPie').css({'height': height,'width': width - 80});//设置高度属性
        $('#no1').css('width',width - 90);
        
        var deptPercentChart = echarts.init(document.getElementById('perPercentPie'));

		var hour = <?php echo json_encode($hour);?>;
		var data = <?php echo json_encode($data);?>;

        typeoption = option = {
            title: {
                text: '分时段入馆人数',
                x:'center',
                textStyle: {
                    fontSize: 26, //设置字体大小
                    color: '#F8F1F0'
                }
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'cross'
                }
            },
            xAxis:  {
                type: 'category',
                boundaryGap: false,
                data: hour,
                axisLabel: {
                    textStyle: {
                        color: '#F8F1F0',
                        fontSize: 18,  //设置y轴字体
                        fontWeight: 600
                    }
                },
                axisLine: {
                    lineStyle: {
                        color: '#F8F1F0' 
                    }
                }
            },
            yAxis: {
                type: 'value',
                axisLabel: {
                    textStyle: {
                        color: '#F8F1F0',
                        fontSize: 18,  //设置y轴字体
                        fontWeight: 600
                    }
                },
                axisPointer: {
                    snap: true
                },
                axisLine: {
                    lineStyle: {
                        color: '#F8F1F0' 
                    }
                }
            },
            grid: {
                left: '4%',
                right: '4%',
                bottom: '95',
                containLabel: true
            },
            backgroundColor: 'rgba(150, 150, 150, 0.5)',
            series: [
                {
                    name:'入馆人数',
                    type:'line',
                    smooth: true,
                    label: {
                        normal: {
                            show:true,
                            position: 'insideTop',
                            offset: [0,-30],
                            textStyle:{
                                color:'#F8F1F0',
                                fontSize: 17,
                                fontWeight: 600
                            }, 
                        }
                    },
                    // data: [50, 80,95,100,70,60,65,95,120,130,140,100,110,93,50,32],
                    data: data,
                    // areaStyle : {
					// 	normal : {
					// 		color : '#7ed3da',
					// 		opacity : 0.5
					// 	}
					// },
                    symbolSize: 10,
                    // symbol: 'circle',
                    itemStyle: {
                        normal: {
                            lineStyle: {
                                color: '#ff7f0e',
                                width: 6
                            }
                        }
                    }
                }
            ]
        };
        deptPercentChart.setOption(typeoption);

        function refresh(){
            $.ajax({ 
                type: "post", 
                async: false, //同步执行 
                url: './logic/php/period.php', 
                dataType: "json", //返回数据形式为json 
                success: function(result) { 
                    $("#count").html("本学期入馆人数 : " + result.countAll['count'] + "人，今日实时入馆人数 : " + result.countToday['count'] + "人");//要刷新的div
                    // alert(urlList[i]);
                    // myChart.hideLoading(); //隐藏加载动画 
                    deptPercentChart.setOption({
                        xAxis: [{
                            data: result.hour,
                        }],
                        series: [{
                            data: result.data,
                            // data: [50, 80,95,100,70,60,65,95,120,130,140,100,110,93,50,32],                            
                        }] //渲染数据
                    });
                }, 
                error: function() { 
                    alert("error" + i); 
                } 
            });
        }
    </script>
</body>
</html>