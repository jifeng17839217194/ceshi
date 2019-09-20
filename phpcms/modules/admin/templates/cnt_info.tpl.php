<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="ECharts">
<meta name="author" content="kener.linfeng@gmail.com">
<title><?php echo $title?></title>
</head>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.min.js"></script>
<script src="<?php echo JS_PATH;?>echart/asset/js/echarts.min.js"  charset="utf-8"></script>
<body>
<div id="main" style="text-align:center;width:650px;height:380px;border:0px solid #ccc;"></div>
<script type="text/javascript"> 
var myChart = echarts.init(document.getElementById("main"));
	//为模块加载器配置echarts的路径，这里主要是配置map图表的路径，其他的图表跟map的配置还不太一样，下边也会做另一种类型的图表事例。 
var option = {
    tooltip : {
        trigger: 'axis',
        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
        }
    },
    legend: {
        data:[]
    },
    toolbox: {
        show : true,
        orient: 'vertical',
        x: 'right',
        y: 'center',
        feature : {
            mark : {show: true},
            dataView : {show: true, readOnly: false},
            magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            data : [<?php echo "'" . implode("','", $tempData[name]) . "'";?>],
		    axisLabel:{  
            interval: 0 
			}
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        {
            name:'数量',
            type:'bar',
            data:[<?php echo "'" . implode("','", $tempData[numbers]) . "'";?>]
        }
    ]
};
myChart.setOption(option);
</script> 

<script type="text/javascript" src="<?php echo JS_PATH;?>echart/asset/js/echartsHome.js"></script>

</body>
</html>
