<?php 
header("Content-type: text/html; charset=utf-8");
include './logic/php/index.php';
include './logic/php/count.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="300;url=index2.php"><!-- 定时跳转页面，单位‘秒’,5分钟跳转页面 -->
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
            background:url(./logic/images/222.jpg)no-repeat;
            width:100%;
            height:100%;
            background-size:100% 100%;
            /* position:absolute; */
            filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='./logic/images/222.jpg',sizingMethod='scale');
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
    <div id="perCountBar" style="float:left;margin-left:30px"></div>
    <script type="text/javascript">
        height = $(window).height();         //可视窗口的高度
        width = $(window).width();
        $('#perCountBar').css('height',height - 38);//设置高度属性
        $('#perCountBar').css('width',width - 80);
        $('#no1').css('width',width - 90);
        
        var deptCountChart = echarts.init(document.getElementById('perCountBar'));

        var deptArr = <?php echo json_encode($deptArr); ?>;
        var deptCountArr = <?php echo json_encode($deptCountArr); ?>;
 
        // deptCountChart.showLoading(); //预加载动画
        var deptoption = {
            title : {
                text: '实时入馆人数',
                x:'center',
                textStyle: {
                    fontSize: 26, //设置字体大小
                    color: '#F8F1F0'
                }
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: { // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow' // 默认为直线，可选为：'line' | 'shadow'
                },
                // formatter: '{c} 人'
            },
            // legend: {
            //     data: ['访问人数']
            // },
            grid: {
                left: '4%',
                right: '4%',
                bottom: '55',
                containLabel: true
            },
            yAxis: [{
                // name: '学院',
                type: 'category',
                data: deptArr,
                axisLabel: {
                    textStyle: {
                        color: '#F8F1F0',
                        fontSize: 18,  //设置y轴字体
                        fontWeight: 600
                    }
                },
                axisTick: {
                    alignWithLabel: true
                },
                axisLine: {
                    lineStyle: {
                        color: '#F8F1F0' 
                    }
                }
            }],
            xAxis: [{
                // name: '访问人数',
                type: 'value',
                axisLabel: {
                    show: true,
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
            }],
            backgroundColor: 'rgba(150, 150, 150, 0.5)',
            series: [{
                name: '访问人数',
                type: 'bar',
                animationDuration: 1500,
                animationEasing: 'exponentialInOut',
                data: deptCountArr,
                label: {
                    normal: {
                        show: true,
                        position: 'insideRight',
                        textStyle: {
                            color: 'white',
                            fontSize: 16
                        }
                    }
                },
                itemStyle: {
                    normal: {
                        color: function (params) {
                            // 每列设置不同的颜色
                            var colorList = [
                                '#18569d', '#1a5d9d', '#1d649d', '#1f6b9d', '#22729e', '#24799e', '#27809e', '#29879f', '#2c8e9f',
                                '#2e959f', '#319c9f', '#33a3a0', '#36aaa0', '#38b1a0', '#3bb8a1', '#3dbfa1', '#40c6a1', '#43cea2'
                            ];
                            return colorList[params.dataIndex];
                        }
                    }
                }
            }]
        }
        deptCountChart.setOption(deptoption);
                 
        function refresh(){
            $.ajax({ 
                type: "post", 
                async: true, //同步执行 
                url: './logic/php/deptCount.php', 
                dataType: "json", //返回数据形式为json 
                success: function(result) { 
                    // console.log(result);
                    //  alert('success!!');
                    // myChart.hideLoading(); //隐藏加载动画 
                    $("#count").html("本学期入馆人数 : " + result.countAll['count'] + "人，今日实时入馆人数 : " + result.countToday['count'] + "人");//要刷新的div
                    deptCountChart.setOption({
                        yAxis: [{
                            data: result.deptArr,
                        }],
                        series: [{
                            data: result.deptPercentArr,
                        }] //渲染数据
                    });
                }, 
                error: function() { 
                    // alert("Unsuccess!!"); 
                } 
            });
        }
    </script>
</body>
</html>