<?php 
// 连接数据库 
$conn=@mysql_connect("localhost","sql211_159_146_","tRYc5PQRh3")  or die(mysql_error()); 
//mysql_connect() 函数打开非持久的 MySQL 连接。如果成功，则返回一个 MySQL 连接标识，失败则返回 FALSE。
//注释：脚本一结束，到服务器的连接就被关闭，除非之前已经明确调用 mysql_close() 关闭了。若要创建一个持久连接，请使用 mysql_pconnect() 函数。
@mysql_select_db('sql211_159_146_',$conn) or die(mysql_error()); 
//mysql_select_db() 函数设置活动的 MySQL 数据库。如果成功，则该函数返回 true。如果失败，则返回 false
//当数据库操作出错时，可以用$result = mysql_query($sql)or die(mysql_error());查看出错原因
 
// 判断action 
$action = isset($_REQUEST['action'])? $_REQUEST['action'] : ''; 
/*isset()用於检测变量是否设置，并且不是 NULL。如果已经使用 unset() 释放了一个变量之后，它将不再是 isset()
。若使用 isset() 测试一个被设置成 NULL 的变量，将返回 FALSE。*/
/*$_REQUEST用於获取所有用户输入的变量数组,包含$_GET、$_POST、$COOKIE所包含的输入内容*/

// 上传图片 
if($action=='add'){   
    $image = mysql_escape_string(file_get_contents($_FILES['photo']['tmp_name'])); 
    /*mysql_real_escape_string() 函数转义 SQL 语句中使用的字符串中的特殊字符。
    因为考虑到连接的当前字符集，因此可以安全用于 mysql_query()。*/
   /*file_get_contents() 函数把整个文件读入一个字符串中。
   保存在$_FILES['photo']['tmp_name']中的值式该文件临时保存在WEB服务器上的临时名称和位置*/
    $type = $_FILES['photo']['type']; 
  	//保存在$_FILES['photo']['type']中的值是文件的MME类型,例如text/plain或image/png
    $sqlstr = "insert into photo(type,binarydata) values('".$type."','".$image."')"; 
    //INSERT INTO 语句用于向表格中插入新的行
    @mysql_query($sqlstr) or die(mysql_error()); 
    header('location:index.php');
    //header() 函数向客户端发送原始的HTTP报头,作用在於使得上传图片之后仍然能显示当前页面
    exit(); 
// 显示图片 
}elseif($action=='show'){ 
    $id = isset($_GET['id'])? intval($_GET['id']) : 0; 
    /*预定义的 $_GET 变量用于收集来自method="get" 的表单中的值。$_GET 变量是一个数组，
    内容是由HTTP GET方法发送的变量名称和值。当获取到之后调用intval()函数获取变量的整数值,
    并将其赋值给变量$id,否则将0赋给$id*/
    $sqlstr = "select * from photo where id=$id"; 
    //先在photo表当中查找id列,接著查找名称与$id变量相等的栏位,取当中的值存入变量$sqlstr中
    $query = mysql_query($sqlstr) or die(mysql_error()); 
    $thread = mysql_fetch_assoc($query); 
     //mysql_fetch_assoc() 函数从结果集中取得一行作为关联数组

    if($thread){ 
        header('content-type:'.$thread['type']); 
        //使用.拼接header,根据图片的类型输出图片    
        /*例如:header('Content-type:application/pdf')将会输出一个pdf文件       
        header('Content-Disposition:attachment;filename="downloaded.pdf"');
        这样做就会提示下载PDF文件downloaded.pdf*/
        echo $thread['binarydata']; 
        //输出$thread数组变量中的图片
        exit(); 
    } 
}
?>
