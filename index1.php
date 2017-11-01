<?php include './logic/php/index1.php';?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!--定时跳转页面，单位‘秒’-->
    <meta http-equiv="refresh" content="300;url=index.php">
    <link rel="shortcut icon" href="./logic/icon/favicon.ico">
    <link rel="stylesheet" href="./logic/css/time.css" type="text/css" />
    <script src="http://cdn.staticfile.org/echarts/3.5.0/echarts.min.js"></script>
    <script src="http://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <script src="./logic/js/time.js"></script>
    <title>图书馆人流监测</title>
</head>

<body onload="getTime()">
	<div style="width:100%;height:134px;z-index:1;position:absolute;">
		<div id="date1"></div>
	</div>
	
    <div style="width:100%;height:30px;line-height:30px;font-weight: 600;font-size:18px;">
		<div> 本学期入馆人数 : 89468人，今日实时入馆人数 : 2870人</div>
	</div>
	<div id="chartDiv2">
		<div id="timeScroll" style="width: 100%;height:100%;float:left;"></div>
	</div>
	<script type="text/javascript">
		height = $(window).height(); //可视窗口的高度
		width = $(window).width();
		$('#chartDiv2').css('height', height); //设置高度属性
		$('#chartDiv2').css('width', width);

		var timeScrollChart = echarts.init(document.getElementById('timeScroll'));
		var hahaha = <?php echo json_encode($hahaha);?>;
		var years = <?php echo json_encode($years);?>;
		/*var enenen = <?php echo json_encode($enenen);?>;*/

		var all = {
			"data": hahaha,
			"provinces": ['材料学院', '电子信息学院', '动力与能源学院', '管理学院', '航海学院', '航空学院', '航天学院', '机电学院', '计算机学院', '教育实验学院','理学院', '力学与土木建筑学院', '人文与经法学院', '软件与微电子学院', '生命学院', '外国语学院', '自动化学院'],
			"years": years
		};

		option = {
			timeline: {
				axisType: 'category',
				autoPlay: true,
				playInterval: 5000,//跳动间隔,单位'毫秒'
				data: all.years,
				bottom: 10,
				checkpointStyle: {
					color: 'red'
				}
			},
			options: [{
					title: {
						text: all.years[0],
						left: 'center',
						textStyle: {
							fontSize: 25 //设置字体大小
						}
					},
					tooltip: {
						trigger: 'axis',
						axisPointer: { // 坐标轴指示器，坐标轴触发有效
							type: 'shadow' // 默认为直线，可选为：'line' | 'shadow'
						}
					},
					grid: {
						left: '3%',
						right: '3%',
						bottom: '7%',
						containLabel: true
					},
					calculable: true,
					yAxis: [{
						// name: '学院',
						type: 'category',
						data: all.provinces,
						axisLabel: {
							textStyle: {
								color: '#000',
								fontSize: 14 //设置y轴字体
							}
						},
						axisTick: {
							alignWithLabel: true
						}
					}],
					xAxis: [{
						// name: '访问人数',
						type: 'value',
						axisLabel: {
							show: true,
							textStyle: {
								color: '#000',
								fontSize: 14 //设置x轴字体
							}
						}
					}],
					series: [{
						name: '人数',
						type: 'bar',
						markLine: {
							symbol: ['arrow', 'none'],
							symbolSize: [4, 2],
							itemStyle: {
								normal: {
									lineStyle: {
										color: '#de3163'
									},
									barBorderColor: '#de3163',
									label: {
										position: 'left',
										formatter: function (params) {
											return Math.round(params.value) + '（平均人数）';
										},
										textStyle: {
											color: '#de3163'
										}
									}
								}
							},
							animationDuration: 1500,
							animationEasing: 'exponentialInOut',
							data: [{
								type: 'average',
								name: '平均值'
							}]
						},
						data: all.data[0],
						label: {
							normal: {
								show: true,
								position: 'insideRight',
								textStyle: {
									color: 'white'
								}
							}
						},
						itemStyle: {
							normal: {
								color: function (params) {
									// 每列设置不同的颜色
									var colorList = [
										'#228fbd', '#BA55D3', '#20B2AA', '#e08031', '#c7ceb2',
										'#7c8489', '#f9cdad', '#c8c8a9', '#83af9b',
										'#55aaad', '#495a80', '#5ca7ba', '#199475', '#f5b977',
										'#376956', '#b57795', '#6e8631'
									];
									return colorList[params.dataIndex];
								}
							}
						}
					}]
				},
				{
					title: {
						text: all.years[1] + ' 访问人数'
					},
					series: [{
						data: all.data[1]
					}]
				},
				{
					title: {
						text: all.years[2] + ' 访问人数'
					},
					series: [{
						data: all.data[2]
					}]
				},
				{
					title: {
						text: all.years[3] + ' 访问人数'
					},
					series: [{
						data: all.data[3]
					}]
				},
				{
					title: {
						text: all.years[4] + ' 访问人数'
					},
					series: [{
						data: all.data[4]
					}]
				},
				{
					title: {
						text: all.years[5] + ' 访问人数'
					},
					series: [{
						data: all.data[5]
					}]
				},
				{
					title: {
						text: all.years[6] + ' 访问人数'
					},
					series: [{
						data: all.data[6]
					}]
				},
				{
					title: {
						text: all.years[7] + ' 访问人数'
					},
					series: [{
						data: all.data[7]
					}]
				},
				{
					title: {
						text: all.years[8] + ' 访问人数'
					},
					series: [{
						data: all.data[8]
					}]
				}
			]
		};
		timeScrollChart.setOption(option);
	</script>
</body>

</html>