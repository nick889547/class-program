<?php
// 连接数据库 
$conn=@mysql_connect("localhost","sql211_159_146_","tRYc5PQRh3")  or die(mysql_error());   
//mysql_connect() 函数打开非持久的 MySQL 连接。如果成功，则返回一个 MySQL 连接标识，失败则返回 FALSE。
//注释：脚本一结束，到服务器的连接就被关闭，除非之前已经明确调用 mysql_close() 关闭了。若要创建一个持久连接，请使用 mysql_pconnect() 函数。
@mysql_select_db('sql211_159_146_',$conn) or die(mysql_error()); 
//mysql_select_db() 函数设置活动的 MySQL 数据库。如果成功，则该函数返回 true。如果失败，则返回 false
//当数据库操作出错时，可以用$result = mysql_query($sql)or die(mysql_error());查看出错原因
?>

<html> 
 <head> 
  <meta http-equiv="content-type" content="text/html; charset=utf-8"> 
  <title> upload image to db sql211_159_146_ </title> 
 </head> 

 <body> 
   <h1>Upload a Picture</h1>
  <form name="form1" method="post" action="upload.php" enctype="multipart/form-data">
  <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />  
    <p>图片：<input type="file" name="photo"></p> 
  <p><input type="hidden" name="action" value="add"><input type="submit" name="b1" value="提交"></p> 
  </form> 
   
   <!--请在这个表单中使用了POST,因为文件上传不能使用GET-->
   <!--在form标记中,必须设置属性enctype="multipart/form-data",告知服务器具有常规信息的文件要上传过来-->
   <!--第20行代码中指定的大小是可以上传文件的最大大小(以字节为单位)。代码中指定的2000000字节约等於2MB,
       可以根据需求做调整,而使用MAX_FILE_SIZ作为隐藏的表单域,它将覆盖服务器端的最大大小设置(如果其值小
       於upload_max_filesize和post_max_size设置-->
   <!--在第21行中创建一个类型为file的输入框,name的内容可以任意选择,这将会用做处理上传文件的PHP脚本中使用该名称访问文件-->
 
<?php 
    $sqlstr = "select * from photo order by id desc";   //查询出所有列之后,从表photo中根据ID倒序的方式拿取数据,并且存入变量@sqlstr中
    $query = mysql_query($sqlstr) or die(mysql_error()); //mysql_query() 函数执行一条 MySQL 查询,如果没有打开的连接时,会尝试无参数调用该函数来建立连接
    $result = array(); 
    while($thread=mysql_fetch_assoc($query)){  //mysql_fetch_assoc() 函数从结果集中取得一行作为关联数组
        $result[] = $thread;   //将数据库当中的数组(图片数据)赋值给$result数组变量
    } 
    foreach($result as $val){   //利用foreach遍歷$result数组变量当中的值
        echo '<p><img src="upload.php?action=show&id='.$val['id'].'&t='.time().'" width="150"></p>';  //将图片输出
    } 
?> 
</body> 
</html> 

