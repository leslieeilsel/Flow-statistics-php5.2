<?php 
include './logic/php/index2.php';
include './logic/php/count.php'; 

// echo json_encode(array('deptPercentArrTen'=>$deptPercentArrTen));
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="300;url=index3.php"><!-- 定时跳转页面，单位‘秒’,5分钟跳转页面 -->
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
    <!-- <div style="width:100%;height:30px;z-index:1;position:fix;">
		<div id="date1"></div>
	</div> -->
        <div id="perPercentPie" style="float:left;margin-left:30px"></div>
        <div id="typePercentPie" style="float:left"></div>
    <script type="text/javascript">
        height = $(window).height();         //可视窗口的高度
        width = $(window).width();
        $('#perPercentPie').css({'height': height,'width': width * 0.59});//设置高度属性
        $('#typePercentPie').css({'height': height,'width': width * 0.39 - 42});//设置高度属性
        $('#no1').css('width',width - 90);
        
        var deptPercentChart = echarts.init(document.getElementById('perPercentPie'));
        var deptPercentArrCurrent = <?php echo json_encode($deptPercentArrTen); ?>;
        typeoption = {
            title : {
                text: '实时学院入馆人数占比',
                // subtext: '纯属虚构',
                x: 'center',
                textStyle: {
                    fontSize: 26, //设置字体大小
                    color: '#F8F1F0'
                },
                top: '40'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} 人 ({d} %)"
            },
            // legend: {
            //     orient: 'vertical',
            //     left: 'left',
            //     data: deptArr
            // },
            backgroundColor: 'rgba(150, 150, 150, 0.5)',
            series : [
                {
                    name: '访问人数',
                    type: 'pie',
                    // minAngle: 10,// 最小角度
                    radius : '53%',
                    animationType: 'scale',
                    /* 
                    * roseType:是否展示成南丁格尔图，通过半径区分数据大小。可选择两种模式：
                    * 'radius' 扇区圆心角展现数据的百分比，半径展现数据的大小。
                    * 'area' 所有扇区圆心角相同，仅通过半径展现数据大小。
                    */
                    // roseType: 'radius',
                    animationEasing: 'exponentialInOut',
                    animationDuration: 1500,
                    center: ['50%', '50%'],
                    data: deptPercentArrCurrent,
                    itemStyle: {
                        normal: {
                            color: function (params) {
                                // 每列设置不同的颜色
                                var colorList = [
                                        '#228fbd', '#BA55D3', '#20B2AA', '#e08031', '#c7ceb2', '#7c8489', '#ee827c', '#c8c8a9', '#83af9b',
                                        '#c97586', '#495a80', '#5ca7ba', '#199475', '#e36868', '#376956', '#b57795', '#6e8631', '#94b38f'
                                    ];
                                return colorList[params.dataIndex];
                            }
                        }
                    },
                    label: {
                        normal: {
                            textStyle: {
                                fontSize: 17, //设置字体大小
                                color: '#F8F1F0',
                                fontWeight: 600
                            },
                            formatter: "{b} {d}%"
                        }
                    },
                    labelLine: {
                        normal: {
                            // smooth: true, //平滑视觉引导线
                            lineStyle: {
                                color: '#F8F1F0'
                            }
                        }
                    }
                }
            ]
        };
        deptPercentChart.setOption(typeoption);

        var typePercentCurrentChart = echarts.init(document.getElementById('typePercentPie'));
        var typeArr = <?php echo json_encode($typeArr); ?>;
        var typePercentArr = <?php echo json_encode($typePercentArr); ?>;
        typepercentoption = {
            title : {
                text: '实时学生入馆人数占比',
                // subtext: '纯属虚构',
                x: 'center',
                textStyle: {
                    fontSize: 26, //设置字体大小
                    color: '#F8F1F0'
                },
                top: '40'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} 人"
            },
            // legend: {
            //     orient: 'vertical',
            //     left: 'left',
            //     data: typeArr
            // },
            color: ['#e36868', '#f5be33','#20b2aa', '#c97586', '#f5be33', '#e36868', '#a3bac2', '#7c8489'],
            backgroundColor: 'rgba(150, 150, 150, 0.5)',
            series : [
                {
                    name: '访问人数',
                    type: 'pie',
                    // minAngle: 10,// 最小角度
                    // radius : '70%',
                    radius: ['53%', '80%'],
                    animationType: 'scale',
                    /* 
                    * roseType:是否展示成南丁格尔图，通过半径区分数据大小。可选择两种模式：
                    * 'radius' 扇区圆心角展现数据的百分比，半径展现数据的大小。
                    * 'area' 所有扇区圆心角相同，仅通过半径展现数据大小。
                    */
                    // roseType: 'radius',
                    animationEasing: 'exponentialInOut',
                    animationDuration: 1500,
                    // center: ['50%', '50%'],
                    data: typePercentArr,
                    itemStyle: {
                        normal: {
                            color: function (params) {
                                // 每列设置不同的颜色
                                var colorList = [
                                    '#bfad86', '#94b38f', '#f5be33', '#e36868', '#a3bac2', '#7c8489',
                                ];
                                return colorList[params.dataIndex];
                            }
                        }
                    },
                    label: {
                        normal: {
                            textStyle: {
                                fontSize: 17, //设置字体大小
                                color: '#F8F1F0',
                                fontWeight: 600
                            },
                            formatter: "{b} {d}%"
                        }
                    },
                    labelLine: {
                        normal: {
                            // smooth: true,//平滑视觉引导线
                            lineStyle: {
                                color: '#F8F1F0'
                            }
                        }
                    }
                }
            ]
        };
        typePercentCurrentChart.setOption(typepercentoption);
        
        function refresh(){
                $.ajax({ 
                    type: "post", 
                    async: false, //同步执行 
                    url: './logic/php/percent.php', 
                    dataType: "json", //返回数据形式为json 
                    success: function(result) { 
                        // console.log(result);
                        // alert('bbb');
                        // myChart.hideLoading(); //隐藏加载动画 
                    $("#count").html("本学期入馆人数 : " + result.countAll['count'] + "人，今日实时入馆人数 : " + result.countToday['count'] + "人");//要刷新的div
                        deptPercentChart.setOption({
                            series: [{
                                data: result.deptPercentArrTen,
                            }] //渲染数据
                        });
                        typePercentCurrentChart.setOption({
                            series: [{
                                data: result.typePercentArr,
                            }] //渲染数据
                        });
                    }, 
                    error: function() { 
                        // alert("error" + i); 
                    } 
                });
        }
    </script>
</body>
</html>