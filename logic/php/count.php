<?php

/*设置时区*/
date_default_timezone_set('PRC');

/*连接数据库*/
require 'database.php';

//query语句 
$countAllSql="SELECT COUNT(*) as count FROM dbo.RTPass where VisitTime>='2017-09-01 07:00:00.000'";
$a = mssql_query($countAllSql);
$countAll = mssql_fetch_assoc($a);


$countTodaySql="SELECT COUNT(*) as count FROM dbo.RTPass where datediff(day,VisitTime,getdate()) = 0";
$v = mssql_query($countTodaySql);
$countToday = mssql_fetch_assoc($v);