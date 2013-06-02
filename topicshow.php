<html>
	<head>
		<script src="jquery-2.0.0.min.js" type="text/javascript"></script>
		<script src="http://yui.yahooapis.com/3.10.1/build/yui/yui-min.js"></script>
		<script src="overlay.js" type="text/javascript"></script>
		<script src="lib/d3/d3.js"></script>
   		<script src="d3.layout.cloud.js"></script>
		<style type="text/css">
		table
  		{
  		
  		height:50%;
  		margin:auto;
  		border:1px;
  		padding:0px;
  		}
		.month{
			border-bottom:none;
			text-align:left;
			font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
			font-size:1em;
			
			
		}
		.month td{
			width:100px;
			background-color:LightCyan;
			color:#C0C0C0;
			height:10%;
		}
		.circle td{
			height:90%;
			border:solid 1px;
			border-color:#C0C0C0;
		}
		#mygraphiccontainer {
    		position: relative;
    		width: 100%;
    		height:100%;
    		
    		
		}
		
		#closeicon{
			min-height:73px;
			min-width:71px; 
			position:fixed;
			right:0px;
			top:0px;
			z-index:1000; 
			background: url(http://10.214.28.222:8080/973show/img/chacha.png);
			background-repeat:no-repeat;
			display:none;
		}
		#innershowhtml{
			position:fixed;
			z-index: 999;
			top:10px;
			left:200px;
			width:800px;
   			height:800px;
   			display:none;
   			
		}
		#summary h2,#summary p{
			color:#ffffff
		}
		</style>
		<script>
			<?php
			$posx=array(0,103,203,303,403,503,603,703,803,903,1003,1103);
			$posy=array(70,150,150,150,70,110,150,150,150,150,130,150);//150-2*$radius
			$radius=array(40,0,0,0,40,20,0,0,0,0,10,0);//40*importance
			?>
			YUI().use('graphics', function (Y) {
    			var mygraphic = new Y.Graphic({render: "#mygraphiccontainer"}),
    				connector = mygraphic.addShape({
                	type: "path",
					stroke: {
					weight: 2,
					color: "#B0B0B0",
					opacity: 1,
					dashstyle: "none"
					},
					id: "connector"
            		}),
    			<?php
    			
    			for($i=1;$i<=12;$i++)
				{
    			?>
    				<?php echo"mycircle".$i;?> = mygraphic.addShape({
        			type: "circle",
        			radius:<?php echo $radius[$i-1];?>,
        			fill: {
            		color: "#7777EE"
        			},
        			stroke: {
            		weight: 2,
            		color: "#222222"
        			},
        			id:"<?php echo"circle".$i?>",
        			visible:true,
        			x: <?php echo $posx[$i-1];?>,
        			y: <?php echo $posy[$i-1];?>
    				})<?php if($i!=12)echo",";?>
    			<?php } ?>	;
    			connector.moveTo(0,<?php echo $posy[0];?>);
    			<?php
    			for($i=0;$i<12;$i++)
				{
					echo"connector.curveTo(".$posx[$i].",".$posy[$i].");";
				}
    			?>
    			connector.end();
    			
			});
			YUI().use('io-base','node-base','json-parse', function (Y) {
				<?php 
				for($i=1;$i<=12;$i++)
				{
					if($radius[$i-1]!=0)
				?>
				Y.one('#circle<?php echo $i;?>').on('click', function (ev) {
					Y.io('io.php', {
						data: 'suspect=butler',
						on: {
							complete: function (id, response) {
								if (response.status >= 200 && response.status < 300) {
									var data=Y.JSON.parse(response.responseText);
									
								}
								else {
									//var innerhtml="<div id=\"closeicon\" ></div>";
									//alert(innerhtml);
									//showDialog (600, 600, innerhtml);
									$_overlay.create();
									$("#innershowhtml").fadeIn(1000);
									$("#closeicon").fadeIn(1000);
									$_overlay.self.click(function(){
									$("#innershowhtml").hide();
									$("#closeicon").hide();
									$_overlay.destroy();
									});
									//alert("something has been wrong.");
								}
							}
						}
					});
					
				});
				<?php } ?>
			});
			
			YUI({
    //Last Gallery Build of this module
    		gallery: 'gallery-2011.04.20-13-04'
			}).use('gallery-yui-slideshow', function(Y){
 
				var slideshow = new Y.Slideshow({ 
				srcNode: '#slideshow',
				transition: Y.Slideshow.PRESETS.slideRight,
				duration: 1,
				interval: 3,
				nextButton: '#slideshow'
				});
 
				slideshow.render();
 
			});
	
			YUI().use('node', function (Y) {
				var hideButton = Y.one('#closeicon'),
				demo = Y.one('#innershowhtml');
				hideButton.on('click', function () {
				demo.hide();
				hideButton.hide();
				$_overlay.destroy();
				});
			});
		</script>
		
	</head>
	<body>
		<table>
			<tr class="circle">
				<td colspan="12"><div id="mygraphiccontainer"></div></td>
			</tr>
			<tr class="month">
				<td id="month1">Jan</td>
				<td id="month2">Feb</td>
				<td id="month3">Mar</td>
				<td id="month4">Apr</td>
				<td id="month5">May</td>
				<td id="month6">Jun</td>
				<td id="month7">Jul</td>
				<td id="month8">Aug</td>
				<td id="month9">Sep</td>
				<td id="month10">Oct</td>
				<td id="month11">Nov</td>
				<td id="month12">Dec</td>
			</tr>
		</table>



		<div id="closeicon" ></div>
		<div id="innershowhtml" >
			<table>
				<tr>
					<td id="repimg">
						<div  id="slideshow"style="width: 350px;	height:350px;	margin: 20px;	overflow: hidden;position: relative;">
    			
    						
        							<script>
        							var obj="{'repimg':'http://10.214.28.222:8080/973show/img/JAPAN-1-articleLarge.jpg,http://10.214.28.222:8080/973show/img/contaminated_water.jpg,http://10.214.28.222:8080/973show/img/t1larg.japan.power.plant.afp.gi.jpg'}";
        							var data = eval ("(" + obj + ")");
        							var repimgs=data.repimg.split(",");
        							//alert(repimgs);
        							for(var i=0;i<repimgs.length;i++)
        							{
        								document.write("<img style=\"padding: 10px;	background: #c0dfff;width:310px;height:310px;	border: 1px solid #99b3cc;	border-radius: 10px;position: absolute;\" src=\""+repimgs[i]+"\" alt=\"Cave\" />");
        							}
        							</script>
        						
			 
        						
    						
   
    						
						</div>
					</td>
					<td>
						<div id="summary">
							<h2>Summarization:</h2>
							<script>
        						var obj="{'summary':'That could compromise attempts to bring the crisis under control.2, saw the reading on his dosimeter jump beyond 1,000 millisieverts per hour, the highest reading on the device.The worker left the scene immediately, said Takeo Iwamoto, a spokesman for Tokyo Electric Power.Michiaki Furukawa, a nuclear chemist and a board member of the Citizens&rsquo; Nuclear Information Center, a Tokyo-based watchdog group, said exposure to 1,000 millisieverts of radiation per hour would induce nausea and vomiting, while exposure to triple that amount could be lethal'}";
        						var data = eval ("(" + obj + ")");
        						var summary=data.summary;
        							//alert(repimgs);
        						
        						document.write("<p>"+summary+"</p>");        				
        					</script>
						</div>
						<div id="tagcloud" >
				
							<script>
  								
  								var obj="{'repword':'japan ,nuclear ,plant ,tokyo ,japanese ,water ,reactor ,reactors ,radiation ,power ,fuel ,earthquake ,radioactive ,fukushima ,tsunami ,officials, levels ,daiichi ,workers ,plants ,electric ,company ,safety ,cooling ,crisis,rods,spent,agency ,reported,friday,iodine,energy,damaged,found,days,miles,damage,health,','repword_weight':'0.0323, 0.0278, 0.0215, 0.0194, 0.0173, 0.0165, 0.0154, 0.0154, 0.0143, 0.0138, 0.0118, 0.0115, 0.0104, 0.0104 ,0.0077, 0.0077,0.0075 ,0.0073 ,0.0072 ,0.0071 ,0.0066 ,0.0059 ,0.0058 ,0.0057,0.0056,0.0056,0.0051 ,0.0049,0.0048,0.0044,0.0043,0.0043,0.0039,0.0038,0.0036,0.0036,0.0034,0.0034'}";
        						var data = eval ("(" + obj + ")");
        						
        						var fill = d3.scale.category20();
  								var hfterms=data.repword;
  								var hfterm_weight=data.repword_weight;
  								var hfterm_weights=hfterm_weight.split(",");

  								d3.layout.cloud().size([300, 300])
      							.words((hfterms.split(",")).map(function(d,i) {
        							return {text: d, size: parseInt(hfterm_weights[i]*3000)};
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
					</td>
				</tr>
			</table>

		
   
	</div>
	</body>
</html>

