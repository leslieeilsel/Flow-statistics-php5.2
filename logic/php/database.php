<?php

/*连接数据库*/
    $dbName = "202.117.88.185,1433"; 
    $dbUser = "lib"; 
    $dbPassword = "hmdz"; 

    $conn = mssql_connect($dbName, $dbUser, $dbPassword);
    mssql_select_db('HmNewLib',$conn); 