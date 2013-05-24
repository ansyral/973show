<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<script src="jquery-2.0.0.min.js" type="text/javascript"></script>
		<script src="jcarousellite_1.0.1.min.js" type="text/javascript"></script>
		<script src="lib/d3/d3.js"></script>
		<script src="d3.layout.cloud.js"></script>
		<script type="text/javascript">
   			$(document).ready(function(){
    		$(".carousel").jCarouselLite({
        		auto:800,
        		speed:1000,
        		visible: 1,/*one pic visible*/
    		});  
   		});
   
		</script>
		<style type="text/css">

			ul{
    			margin:0;
    			padding:0;
    			list-style-type:none;
			}
			.clear{
    			clear:both;
			}
			.carousel{
    			margin:0pt 0pt 20px 40px;
    			padding:10px 0pt 0pt;
    			position:relative;
			}
			.jCarouselLite{
    			background-color:#DFDFDF;
    			border:1px solid black;
    			float:left;
    		/* 官方有这段不知道有何用处,如果放进去就会显示不了图片了,js动态产生的值为何没有替换掉 */
			/*  left:-5000px;
    		position:relative;
    		visibility:hidden;*/
			}
			.jCarouselLite li img{
    			background-color: #fff;
    			width: 200px;
    			height:200px;
    			margin: 10px;
			}

		</style>
	</head>
	<body style="height:100%">
		<div style="text-align:center">
		<?php
				$conn=@mysql_connect("localhost:3306","root","a19890624");
				if (!$conn)
  					{exit("Connection Failed: " . $conn);}
				mysql_query("set character set 'utf8'");//读库 
				mysql_query("set names 'utf8'");//写库 
				$db=@mysql_select_db("summaryshow",$conn);              //使用mysql_select_db函数打开test数据库      
   				if(!$db)
      				exit( "打开数据库失败");
				$sql="SELECT * FROM topic_summary where topic_id=".$_GET["topicid"]; 
				$query=mysql_query($sql,$conn); 
				if(!$query)
        			exit( "执行sql语句失败");
      			$row=mysql_fetch_row($query);          //显示test表中的数据	           	          			      			
  		
				mysql_close($conn);
  		
  				
				echo "<h1 style=\"color: red; \">".$row[5]."</h1>";
		?>
		</div>
		<div style="height:40%">
			<div style="position:absolute;  width:600px; ">
				<h2>Summarization:</h2>
				
				<?php
				
				echo "<span>人名：".$row[6]." </span><br>";
				echo "<span>地名：".$row[7]." </span><br>";
				echo "<span>机构名：".$row[8]." </span><br>";
            	echo "<p>".$row[1]." </p><br>";
          			
  				?>
				
			</div>
			<div style="text-align:center">
				<div id="tagcloud" style="margin-left:400px; ">
				
					<script>
  					var fill = d3.scale.category20();
  					var hfterms=String("<?php echo $row[3];?>");
  					var hfterm_weight=String("<?php echo $row[4];?>");
  					var hfterm_weights=hfterm_weight.split(",");

  					d3.layout.cloud().size([300, 300])
      				.words((hfterms.split(",")).map(function(d,i) {
        			return {text: d, size: parseInt(hfterm_weights[i])};
      				}))
      				.rotate(function() { return ~~(Math.random() * 2) * 90; })
      				.font("Impact")
      				.fontSize(function(d) { return d.size; })
      				.on("end", draw)
      				.start();

  					function draw(words) {
    				d3.select("div#tagcloud").append("svg")
        			.attr("width", 300)
       			    .attr("height", 300)
      				.append("g")
       				 .attr("transform", "translate(150,150)")
      				.selectAll("text")
       				 .data(words)
     				 .enter().append("text")
       				 .style("font-size", function(d) { return d.size + "px"; })
       				 .style("font-family", "Impact")
       				 .style("fill", function(d, i) { return fill(i); })
       				 .attr("text-anchor", "middle")
       				 .attr("transform", function(d) {
         			 return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
        			})
       				 .text(function(d) { return d.text; });
  					}
					</script>
				</div> 
			</div>
		</div>
		<div>
			<h2>Representative Images:</h2>
			<div class="carousel">
    			
    			<div class="jCarouselLite">
        			<ul>
        				<?php
        				$repreimg=explode("\t",$row[2]);
						for($i=0;$i<count(repreimg);$i++)
            			{
            				echo "<li><img src=\"".$repreimg[$i]."\" alt=\"\" width=\"200\" height=\"200\" /></li>";
						}
            			?>

			 
        			</ul>
    			</div>
   
    			<div class="clear"></div>   
			</div>
		</div>
	</body>
</html>