# Flow-statistics 系统搭建
## 一、搭建运行环境 ##
1. 安装 [PHPstudy](http://www.phpstudy.net/download.html "前往下载") (Apache + PHP + MySQL)<br />
![](/logic/images/PHPstudy.jpg)

2. 安装 [vc14运行库](http://www.xdowns.com/soft/184/dll/2016/Soft_164980.html "前往下载")<br />
![](/logic/images/vc14.jpg)
3. 安装 [ODBC Driver 11 For SQL （msodbcsql.msi）](https://www.microsoft.com/en-us/download/details.aspx?id=36434 "前往下载")<br />
![](/logic/images/ODBC.jpg)
4. 将php-7.0.12-NTS添加到系统环境变量，并在php.ini中插入如下两行：

	`extension=php_pdo_sqlsrv_7_ts_x86.dll` <br />
	`extension=php_sqlsrv_7_ts_x86.dll`
![](/logic/images/phpini.jpg)
5. 保存修改，重启PHPstudy，运行phpinfo(),查看sqlsrv是否开启<br/>
![](/logic/images/phpinfo.jpg)

## 二、连接数据库 ##
1. 安装代码编辑器 [Visual Studio Code](https://code.visualstudio.com/ "前往下载")，用以编辑代码<br/>
![](/logic/images/vscode.jpg)

2. 从github上获取项目 [Flow-statistics](https://github.com/leslieeilsel/Flow-statistics)，将项目文件夹放置在**D:\phpStudy\WWW**目录下<br/>
![](/logic/images/github.jpg)

3. 使用Visual Studio Code打开项目文件夹，**Flow-statistics\logic\php\database.php**，配置数据库连接，完成后保存<br/>
![](/logic/images/database.jpg)

4. 打开浏览器（建议使用Chrome或者Firefox），运行127.0.0.1，点击项目目录即可运行