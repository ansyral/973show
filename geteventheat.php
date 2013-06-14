<?php
	header('Content-type: application/json');
	$response = array();
	if (isset($_GET['topicid'])) {	
		$conn=@mysql_connect("mysql.973.udms.org:3306","project973","008059c20c2ec4bca8e18ce5c9e2bea0");
		if (!$conn)
  			{exit("Connection Failed: " . $conn);}
		mysql_query("set character set 'utf8'");
		mysql_query("set names 'utf8'");
		$db=@mysql_select_db("project973_20130529",$conn);              
   		if(!$db)
      		exit( "打开数据库失败");
		$sql="SELECT event_id,datediff(started_at,'2012-1-1'),datediff(ended_at,'2012-1-1'),title,heat FROM events_topics ,events where events.id=event_id and topic_id= ".$_GET["topicid"]; 
		$query=mysql_query($sql,$conn); 
		if(!$query)
        	exit( "执行sql语句失败");                  	          			      			  			
		
  		$response['code'] = 1;
		$response['events']=array();
		$i=0;
  		while($row=mysql_fetch_row($query)) 
		{
			$response['events'][$i]=array('event_id'=>$row[0],'started_at'=>$row[1],'ended_at'=>$row[2],'title'=>$row[3],'heat'=>$row[4]);
			$i++;
		}
		$response['num']=$i;
		mysql_close($conn);
		
	}
	else {
		$response['code'] = 0;
		
	}
	echo json_encode($response);
?>