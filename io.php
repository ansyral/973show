<?php
	header('Content-type: application/json');
	$response = array();
	if (isset($_GET['month_id'])) {
		
		$conn=@mysql_connect("localhost:3306","root","a19890624");
		if (!$conn)
  		{	$response['code']=0;echo"hi";}
		else {
			mysql_query("set character set 'utf8'");//读库 
			mysql_query("set names 'utf8'");//写库 
			$db=@mysql_select_db("summaryshow",$conn);              //使用mysql_select_db函数打开test数据库      
   			if(!$db)
      		{	$response['code']=0;echo"what";}
			else {
				$sql="SELECT summary ,repimg,repword,repword_weight FROM topic_evolution WHERE month_id=".$_GET['month_id']." AND topic_id=1"; 
				$query=mysql_query($sql,$conn); 
				if(!$query)
        		{	$response['code']=0;echo $sql;}
				else if(mysql_num_rows($query)==0)
					$response['code']=2;
      			else 
      			{
        			$row=mysql_fetch_row($query);           //显示test表中的数据
          			$response['code']=1;
            		$response['summary']=$row[0];
					$response['repimg']=$row[1];
          			$response['repword']=$row[2];
					$response['repword_weight']=$row[3];
					
      			}
  		
				mysql_close($conn);
			}
		
			
		}
		
  		
	}
	else {
		$response['code'] = 0;
		
	}
	echo json_encode($response);
?>