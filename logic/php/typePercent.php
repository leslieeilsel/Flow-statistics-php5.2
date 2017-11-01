<?php
    /*设置时区*/
date_default_timezone_set('PRC');
    /*连接数据库*/
require 'database.php';

$typeCountSql="SELECT type,count(type) as typecnt FROM dbo.RTPass WHERE datediff(day,VisitTime,getdate()) = 0 and dept !=N'未知部门' GROUP BY type ORDER BY typecnt ASC"; 
$typeCountSql = iconv("utf-8", "gbk", $typeCountSql);
$b = mssql_query($typeCountSql);
while($bb = mssql_fetch_assoc($b))
{   $bbstr['type'] = iconv('GBK','UTF-8',$bb['type']);
    $bbstr['typecnt'] = $bb['typecnt'];
    $typeCount[] = $bbstr;
} 
$typeArr = array();
$typeCountArr = array();
$typePercent = array();
$typePercentArr = array();
if (!empty($typeCount)) {
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

    // sqlsrv_free_stmt($typeCountSql);
    // sqlsrv_close($db);

echo json_encode($typePercentArr);
