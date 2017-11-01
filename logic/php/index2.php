<?php
/*设置时区*/
date_default_timezone_set('PRC');

/*连接数据库*/
require 'database.php';

//query语句 
$deptCountSqlTen="SELECT dept,count(dept) as deptcnt FROM dbo.RTPass WHERE datediff(day,VisitTime,getdate()) = 0 and dept !=N'未知部门' GROUP BY dept"; 
$deptCountSqlTen = iconv("utf-8", "gbk", $deptCountSqlTen);
$a = mssql_query($deptCountSqlTen);
while($aa = mssql_fetch_assoc($a))
{   $aastr['dept'] = iconv('GBK','UTF-8',$aa['dept']);
    $aastr['deptcnt'] = $aa['deptcnt'];
    $deptTen[] = $aastr;
} 
$typeCountSql="SELECT type,count(type) as typecnt FROM dbo.RTPass WHERE datediff(day,VisitTime,getdate()) = 0 and dept !=N'未知部门' GROUP BY type ORDER BY typecnt ASC"; 
$typeCountSql = iconv("utf-8", "gbk", $typeCountSql);
$b = mssql_query($typeCountSql);
while($bb = mssql_fetch_assoc($b))
{   $bbstr['type'] = iconv('GBK','UTF-8',$bb['type']);
    $bbstr['typecnt'] = $bb['typecnt'];
    $typeCount[] = $bbstr;
} 

/*最近十天 学院人数占比(包括今天)*/
// $deptCountSqlTen = $db->query("SELECT dept,count(dept) as deptcnt FROM dbo.chart WHERE datediff(day,VisitTime,getdate())<= 9 and datediff(day,VisitTime,getdate())>= 0 and dept !=N'未知部门' GROUP BY dept"); //排序 ORDER BY deptcnt ASC
// $deptTen = $deptCountSqlTen->fetchAll(PDO::FETCH_ASSOC);
$deptCountArrTen = array();
$deptPercentTen = array();
$deptPercentArrTen =array();
if ($deptTen !== false) {
    foreach ($deptTen as $v) {
        $xueyuanTen = '';
        $xueyuanTen = substr($v['dept'], -6);
        if ($xueyuanTen == '学院') {
            $deptArrTen[] = $v['dept'];
            $deptCountArrTen[] = $v['deptcnt'];
            $deptPercentTen['name'] = $v['dept'];
            $deptPercentTen['value'] = $v['deptcnt'];
            $deptPercentArrTen[] = $deptPercentTen;
        }
    }
}

/*最近十天 学位人数占比(包括今天)*/
// $typeCountSql = $db->query("SELECT type,count(type) as typecnt FROM dbo.chart WHERE datediff(day,VisitTime,getdate())<= 9 and datediff(day,VisitTime,getdate())>= 0 and dept !=N'未知部门' GROUP BY type ORDER BY typecnt ASC"); //排序 ORDER BY typecnt ASC
// $typeCount = $typeCountSql->fetchAll(PDO::FETCH_ASSOC);
// $typeArr = array();
$typeCountArr = array();
$typePercent = array();
$typePercentArr = array();
if ($typeCount) {
    foreach ($typeCount as $v) {
        $sheng = '';
        $sheng = substr($v['type'], -3);
        if ($sheng == '生') {
            $typeArr[] = $v['type'];
            $typeCountArr[] = $v['typecnt'];
            $typePercent['name'] = $v['type'];
            $typePercent['value'] = $v['typecnt'];
            $typePercentArr[] = $typePercent;
        }
    }
}
