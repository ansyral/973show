<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<h1>SUMMARY REPRESENTATION</h1>
		<ul>
		<?php
		$conn=@mysql_connect("localhost:3306","root","a19890624");
		if (!$conn)
  			{exit("Connection Failed: " . $conn);}
		mysql_query("set character set 'utf8'");//读库 
		mysql_query("set names 'utf8'");//写库 
		$db=@mysql_select_db("summaryshow",$conn);              //使用mysql_select_db函数打开test数据库      
   		if(!$db)
      		exit( "打开数据库失败");
		$sql="SELECT topic_id ,title FROM topic_summary"; 
		$query=mysql_query($sql,$conn); 
		if(!$query)
        	exit( "执行sql语句失败");
      	else 
      	{
        	while($row=mysql_fetch_row($query))           //显示test表中的数据
          	{
            	echo "<li><a href=\"./show.php?topicid=".$row[0]."\">".$row[1]."</a> </li>"."<br><hr>";
          	}
      	}
  		
		mysql_close($conn);
  		
  		?>
		</ul>
	</body>
</html>