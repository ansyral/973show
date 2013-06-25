<?php
	header('Content-type: application/json');
	$response = array();
	if (isset($_GET['eventid'])) {
		$conn=@mysql_connect("mysql.973.udms.org:3306","project973","008059c20c2ec4bca8e18ce5c9e2bea0");
		if (!$conn)
  			{exit("Connection Failed: " . $conn);}
		mysql_query("set character set 'utf8'");
		mysql_query("set names 'utf8'");
		$db=@mysql_select_db("project973_20130529",$conn);              
   		if(!$db)
      		exit( "打开数据库失败");
		$sql="SELECT url from images, event_entities where entity_type='Image' and entity_id=images.id and event_id= ".$_GET["eventid"].";"; 
		$query=mysql_query($sql,$conn); 
		if(!$query)
        	exit( "执行sql语句失败"); 
		             	          			      			  			
		$row=mysql_fetch_row($query);  
  		$response['code'] = 1;
		$response['url']=$row[0];
		
	}
	else {
		$response['code'] = 0;
		
	}
	echo json_encode($response);
?>	