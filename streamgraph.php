<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Streamgraph</title>
<style>

body {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  margin: auto;
  position: relative;
 
}

#stream{
	float:left;
	width:80%;
	
}

#verticalline{
	float:left;
	width: 0.1%; 
	height: 600px; 
	background-color: #222222
}
#legend{
	float:left;
	width:19.9%;
	margin:5px,5px,5px,5px;
}
#repreimg{
	max-width:200px;
	margin:auto;
	display: block;
	padding: 10px;
	background: #c0dfff;
	border: 1px solid #99b3cc;	
	border-radius: 10px;
}
#descrip{
	margin-left: 40px;
}　 
#curve{
	position:fixed;
}
.yui3-overlay {
	background: #000000;
	padding: 3px;
	border: 1px #a92 solid;
	border-radius: 5px;

}
.yui3-overlay-content{
			color:#ffffff;
		}
</style>

<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="http://yui.yahooapis.com/3.10.1/build/yui/yui-min.js"></script>
</head>
<body>
<div id="stream">
	<div>
		<table style="width:100%">
		<tr>
			<td>Jan</td>
			<td >Feb</td>
			<td >Mar</td>
			<td >Apr</td>
			<td >May</td>
			<td >Jun</td>
			<td >Jul</td>
			<td >Aug</td>
			<td >Sep</td>
			<td >Oct</td>
			<td >Nov</td>
			<td >Dec</td>
		</tr>
		</table>
	</div>
	<div id="graph">
		<script>
		YUI().use('node','io-base','json-parse','graphics', 'event-mouseenter',function(Y){
		Y.io('geteventheat.php',{
		data:{'topicid':30},
		on:{
			complete:function(id,response){
				if(response.status>=200&&response.status<300){
					datas=Y.JSON.parse(response.responseText);
					if(datas.code==0)
					{
						alert('error');
					}
					else
					{
						
						var n = datas.num, // number of layers
    						m = 365, // number of samples per layer
    						stack = d3.layout.stack().offset("wiggle")
    								  .values(function(d) { return d.values; });
						//var	basic=d3.range(n).map(function(){return d3.range(m).map(function(){return parseInt(Math.random()*10);});});
						var basic=datas.events.sort(sortEvent);
						var layers0 = stack(d3.range(n).map(function(d,i) { return {"eventid":basic[i].event_id,"heat":basic[i].heat,"name":basic[i].title,"values":bumpLayer(m,basic[i])}; }));
						//alert(basic[0]);
   
						var bodyw=document.body.clientWidth;
						var width = 0.8*bodyw,
    						height = 500;

						var x = d3.scale.linear()
    							  .domain([0, m - 1])
    							  .range([0, width]);

						var y = d3.scale.linear()
   								  .domain([0, d3.max(layers0, function(layer) { return d3.max(layer.values, function(d) { return d.y0 + d.y; }); })])
   								  .range([height, 0]);

						var color = d3.scale.linear()
  									  .range([ "#CD5C5C","#FF9900"]);
						/*alert(color(Math.sin(0)));
						alert(color(Math.sin(20)));
						alert(color(Math.sin(40)));
						alert(color(Math.sin(60)));
						alert(color(Math.sin(80)));
						alert(color(Math.sin(100)));*/
						var area = d3.svg.area()
   									 .x(function(d) { return x(d.x); })
   									 .y0(function(d) { return y(d.y0); })
 									 .y1(function(d) { return y(d.y0 + d.y); });

						var svg = d3.select("div#graph").append("svg")
  								    .attr("width", width)
  								    .attr("height", height);

						var node= svg.selectAll("path")
 						   			 .data(layers0)
 						  		     .enter().append("path")
 									 .attr("d", function(d) { return area(d.values); })
 									 .attr("packing",function(d){return d.name})
 									 .attr('data-tooltip',function(d){return d.name})
 									 .attr('event-id',function(d){return d.eventid})
 						   			 .style("fill", function(d) { return color(Math.sin(d.heat)); });
 						node.append("title")     					   
      					    .text(function(d) { return d.name; });
      					node.append("text")
      					    //.attr("dy", ".3em")
      					    .attr("width","50px")
      					    .attr("height","50px")
     					    .style("text-anchor", "middle")
    					    .text(function(d) { return d.name; });
    					
    					
    					
						mygraphic = new Y.Graphic({render: "#curve"});
						Y.all('path').on('mouseover', function (ev) {			
							var connector = mygraphic.addShape({
                			type: "path",
							stroke: {
								weight: 2,
								color: "#B0B0B0",
								opacity: 1,
								dashstyle: "none"
							},
							
            				});
							var node=ev.currentTarget;
							connector.moveTo(ev.pageX,ev.pageY);
							Y.io('geteventurl.php',{
								data:{'eventid':node.getAttribute('event-id')},
								on:{
									complete:function(id,response){
									if(response.status>=200&&response.status<300){
										url=Y.JSON.parse(response.responseText);
										if(url.url!=null)
											Y.one('#repreimg').set('src',url.url);
										else
											Y.one('#repreimg').set('src','./img/default.png');
				
						
									}
									}
								}
							});
							var pic=Y.one('#repreimg');
							connector.curveTo((ev.pageX+pic.getX())/2,ev.pageY,(ev.pageX+pic.getX())/2,pic.getY(),pic.getX(),pic.getY());
							connector.end();
						});
						Y.all('path').on('mouseout', function (ev) {
							if(mygraphic!=null)
								mygraphic.removeAllShapes();
						});
		


						// Inspired by Lee Byron's test data generator.
						
							}//else
						}//if
					}//complete
				}//on
			});//io
		});//use

		function sortEvent(a,b)
		{
			return a.heat - b.heat;
		}
		function bumpLayer(n,basicv) {

			function bump(a) {
  				var x = 1 / (.1 + Math.random()),
       			y = 2 * Math.random() - .5,
      			z = 10 / (.1 + Math.random());
   				for (var i = 0; i < n; i++) {
     				var w = (i / n - y) * z;
     				a[i] += x * Math.exp(-w * w);
   				}
  			}

  			var a = [], i;
 			var cushion=10,delta;
  			for (i = 0; i < n; ++i) 
  			{
  				if(basicv.started_at-cushion<=i&&i<=basicv.ended_at+cushion)
  				{
  					if(basicv.started_at<=i&&i<=basicv.ended_at)
  						delta=0;
  					else if(basicv.started_at>i)
  						delta=basicv.started_at-i;
  					else
  						delta=i-basicv.ended_at;
  					a[i] = basicv.heat*Math.exp(-0.01*delta*delta);
  				}
  				else 
  					a[i]=0;
  			}
  			for (i = 0; i < 5; ++i) bump(a);
			return a.map(function(d, i) { return {x: i, y: Math.max(0, d)}; });
		}
		</script>
	</div>

</div>
<div id="verticalline">
</div>
<div id="legend">
	<div>
		<img  src="./img/legend_1.jpg"/>
	</div>
	<div>
		<img  id="repreimg" src="./img/default.png"/>
	</div>
	
	
	
</div>
<div id="curve">
</div>

<script >
	/*YUI().use('node','io-base','json-parse','graphics', 'event-mouseenter',function(Y){
		
		
		var tooltip = new Y.Overlay({ width: 200,visible: false });
		function enter(ev) {
			var node = ev.currentTarget;
			//alert(node);
			//tooltip.align(node, [Y.WidgetPositionAlign.TL, Y.WidgetPositionAlign.BC]);
			
			Y.io('geteventurl.php',{
				data:{'eventid':node.getAttribute('event-id')},
				on:{
					complete:function(id,response){
					if(response.status>=200&&response.status<300){
						url=Y.JSON.parse(response.responseText);
					
				
						tooltip.set('bodyContent', '<div style="text-align:center;padding:5px 5px 5px 5px;background-color:#000000">'+node.getAttribute('data-tooltip')+'<img width="160px" height="160px" src="'+url.url+'"/></div>');	
			//Y.one('.yui3-overlay').setXY([node.getX(),node.getY()]);	
						Y.one('.yui3-overlay').setXY([ev.pageX,ev.pageY]);	
			//alert(node.getAttribute('r'));
			//alert(Y.one('.yui3-overlay').getStyle('z-index'));								
						tooltip.show();
					}
					}
				}
			});
										
		}
		function leave(ev) {
			tooltip.hide();
		}
		Y.delegate('mouseenter', enter, 'body', '*[data-tooltip]');
		Y.delegate('mouseleave', leave, 'body', '*[data-tooltip]');
		tooltip.render();
	});*/
</script>
</body>
</html>