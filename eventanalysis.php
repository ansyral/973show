<html>
	<head>
		<script src="http://yui.yahooapis.com/3.10.1/build/yui/yui-min.js"></script>
		<style type="text/css">
		.yui3-overlay {
			background: #000000;
			padding: 3px;
			border: 1px #a92 solid;
			border-radius: 5px;
			z-index:999 !important;
		}
		.yui3-overlay-content{
			color:#ffffff;
		}
		table
  		{
  			width:100%;
  			height:50%;
  			margin:auto;
  			border:1px;
  			padding:0px;
  			table-layout: automatic
  		}
		.period{
			border-bottom:none;
			text-align:left;
			font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
			font-size:1em;
			
			
		}
		#period1,#period2,#period3,#period4,#period5,#period6,#period7,#period8,#period9,#period10,#period11,#period12{
			width:8%;
		}
		#period13{
			width:4%;
		}
		.period td{
			width:100px;
			vertical-align:top;
			color:#C0C0C0;
			height:10%;
		}
		.circle td{
			height:60%;
			border:solid 1px;
			border-color:#C0C0C0;
		}
		#mygraphiccontainer {
    		position: relative;
    		width: 100%;
    		height:100%;
    		
    		
		}
		</style>
		<script type="text/javascript">
		monthchara=new Array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
		daylimit=new Array(0,31,28,31,30,31,30,31,31,30,31,30,31);
		
		YUI().use('node','io-base','json-parse','graphics','overlay', 'event-mouseenter',function(Y){
			var mygraphic = new Y.Graphic({render: "#mygraphiccontainer"});
			var tooltip = new Y.Overlay({ width: 200, visible: false });
			var anadiv=Y.one('#mygraphiccontainer');
			var width=anadiv.get('offsetWidth');
			var height=anadiv.get('offsetHeight');
			var basicr=10;
			var posy=height-2*basicr;
			//alert(anadiv.getXY());
			//alert(height);
			var basicw=Math.round(2*width/25);
			var periodx=new Array(12) ,periody=new Array(12),periodr=new Array(12);
			var posxbasic=Math.round(basicw)/2-basicr;
			for(var i=0;i<12;i++)
			{
				periodx[i]=posxbasic;
				periody[i]=posy;
				periodr[i]=basicr;
				posxbasic+=basicw;
			}
			Y.one('#submit').on('click',function(){
				if(mygraphic!=null)
					mygraphic.removeAllShapes();
				var sdate=new Date(parseInt(syear.value),parseInt(smonth.value)-1,parseInt(sday.value));
				var edate=new Date(parseInt(eyear.value),parseInt(emonth.value)-1,parseInt(eday.value));
				//var interval=parseInt(eyear.value-syear.value)*365+parseInt(emonth.value-smonth.value)*30+parseInt(eday.value-sday.value);// approximate value of the interval
				var interval=GetInterval(sdate,edate);
				var period=Math.round(interval/12); 
				//alert(Math.round(300/365));
				//alert(interval);
				//alert(period);
				//Y.one('#period1').set('text',"12");
				/*var periodtime=new Array(13);// record the starttime of each period
				periodtime[0]=sdate.getTime();
				for(var i=1;i<=12;i++)
				{
					periodtime[i]=periodtime[i-1]+period.getTime();
				}*/
				if(period>=365)//process according to year .approximate result
				{
					var year=parseInt(syear.value);
					for(var i=1;i<=13;i++)
					{
						var showtext='Jan '+year;
						Y.one('#period'+i).set('text',showtext);
						year+=Math.round(period/365);
										
					}
				}
				else if(period>=30)//process according to month .precise result
				{
					var day=parseInt(sday.value);
					var month=parseInt(smonth.value);
					var year=parseInt(syear.value),preyear=-1;
					for(var i=1;i<=13;i++)
					{
						var showtext;
						if(year!=preyear)
							showtext=monthchara[month]+'<br/>'+year;
						else
							showtext=monthchara[month];
						Y.one('#period'+i).set('innerHTML',showtext);
						//alert(monthchara[month]+' '+day);
						preyear=year;
						day+=period;
						var time=daylimit[month];
						if(month==2&&!Isleap(year))
							time+=1;
						while(day>time)
						{
							month+=1;									
							if(month>12)
							{
								month=1;
								year+=1;
								
							}	
							day-=time;
							time=daylimit[month];
							if(month==2&&!Isleap(year))
								time+=1;
						}						
						
						
					}
				}
				else //process according to day .precise result
				{
					var day=parseInt(sday.value);
					var month=parseInt(smonth.value),premonth=-1;
					var year=parseInt(syear.value);
					if(period==0)
						period=1;// to avoid there is less than 12 days in the time interval that the user chooses
					for(var i=1;i<=13;i++)
					{
						var showtext=day+'<br/>';
						if(premonth!=month)
							showtext+=monthchara[month]+' '+year;
						Y.one('#period'+i).set('innerHTML',showtext);
						premonth=month;
						day=day+period;
						var time=daylimit[month];
						if(month==2&&!Isleap(year))
							time+=1;
						if(day>time)
						{
							
							day-=time;
							month=month+1;
							if(month==13)
							{
								month=1;
								year=year+1;
							}
						}
						
						
					}
				}
				Y.io('getevent.php',{
					data:{'syear':parseInt(syear.value),'smonth':parseInt(smonth.value),'sday':parseInt(sday.value),'eyear':parseInt(eyear.value),'emonth':parseInt(emonth.value),'eday':parseInt(eday.value)},
					on:{
						complete:function(id,response){
							if(response.status>=200&&response.status<300){
								datas=Y.JSON.parse(response.responseText);
								if(datas.code==0)
								{
									alert('something wrong');
								}
								else if(datas.code==1)// code==2 to note there is no data,then no need to draw.
								{
									var events=datas.events;
									for(var j=0;j<2;j++)
									{
									for(var i=0;i<12;i++)
									{
										periody[i]=posy-10-j*100;
										periodr[i]=basicr;
									}							
									
    								//mygraphic = new Y.Graphic({render: "#mygraphiccontainer"});
									for(var i=0;i<events.length;i++)
									{
																															
										var middle=GetMiddle(new Date(events[i].syear,events[i].smonth-1,events[i].sday),
															 new Date(events[i].eyear,events[i].emonth-1,events[i].eday));
										var index=parseInt((GetInterval(sdate,middle)-1)/period);
										var mycircle= mygraphic.addShape({
        									type: "circle",
        									radius:periodr[index],
        									fill: {
            									color: "#7777EE"
        									},
        									stroke: {
            									weight: 2,
            									color: "#444444"
        									},
        									id:"circle"+parseInt(i+j*1000),
        									visible:true,
        									x: periodx[index],
        									y: periody[index]
    									});
    									//if(i==0)alert(Y.one('#circle0').getXY()+" "+periodx[index]+' '+periody[index]);
    									Y.one('#circle'+parseInt(i+j*1000)).setAttribute('data-tooltip',events[i].content);
    									periodr[index]+=2;
    									periody[index]-=80/(periodr[index]-basicr);
    									if(periody[index]<=0)
    										periody[index]=0;
									}
									for(var i=0;i<12;i++)
									{
										if(periody[i]!=posy-10-j*100)
										{											
											periody[i]+=80/(periodr[i]-basicr);
											periodr[i]-=2;
										}
										else
											periody[i]+=2*basicr;
									}
									var connector = mygraphic.addShape({
                						type: "path",
										stroke: {
											weight: 2,
											color: "#B0B0B0",
											opacity: 1,
											dashstyle: "none"
										},
										id: "connector"+j
            						});
            						connector.moveTo(0,height-10-j*100);    	
    								for(var i=0;i<12;i++)
									{
										var contrlpx,contrlpy;
										if(i!=0)
										{
											contrlpx=(periodx[i]+periodx[i-1])/2;
											contrlpy=(periody[i-1]);
										}
										else
										{
											contrlpx=(periodx[i]+0)/2;
											contrlpy=height-10-j*100;
										}
										connector.curveTo(contrlpx,contrlpy,contrlpx,periody[i],periodx[i],periody[i]);
										//alert(periodx[i]+" "+(periody[i]-20-periodr[i]));
									}
    								
    								connector.end();
    							}
    								
									function enter(ev) {
										var node = ev.currentTarget;
										//alert(node);
										//tooltip.align(node, [Y.WidgetPositionAlign.TL, Y.WidgetPositionAlign.TL]);
										tooltip.set('bodyContent', '<div style="text-align:center;padding:5px 5px 5px 5px">'+node.getAttribute('data-tooltip')+'</div>');	
										Y.one('.yui3-overlay').setXY([node.getX()-50,node.getY()-100]);	
										//alert(node.getAttribute('r'));
										//alert(Y.one('.yui3-overlay').getStyle('z-index'));								
										tooltip.show();
										
									}
									function leave(ev) {
										tooltip.hide();
									}
									Y.delegate('mouseenter', enter, 'body', '*[data-tooltip]');
									Y.delegate('mouseleave', leave, 'body', '*[data-tooltip]');
									tooltip.render();
									
								}
							}
							else
							{
								alert("something wrong in getting data ");
							}
						}
					}
				});
			});
		});
		function Isleap(year)
		{
			if(year%400==0)
				return true;
			if(year%4==0&&year%100!=0)
				return true;
			return false;
		}
		function GetInterval(sdate,edate)
		{
			var starttime=sdate.getTime(); 
              
            var endtime=edate.getTime(); 
             
            var intervalTime = endtime-starttime;//the ms between 2 dates--one day86400000ms
            var Inter_Days = ((intervalTime).toFixed(2)/86400000)+1;// plus 1 to make 2 dates with the same date return 1
             
            return Inter_Days; 
		}
		function GetMiddle(sdate,edate)
		{
			var interval=Math.round(GetInterval(sdate,edate)/2);
			var middle=new Date(sdate.getFullYear(),sdate.getMonth(),sdate.getDate());
			middle.setDate(sdate.getDate()+interval-1);
			return middle;
		}
		</script>
	</head>
	<body >
		<form id="timeForm" name="timeForm"  >
			<label>start year:</label>
			<input type="text" name="syear" id="syear" >
			<label>start month:</label>
			<input type="text" name="smonth" id="smonth" >
			<label>start day:</label>
			<input type="text" name="sday" id="sday" >
			<br/><br/>
			<label>end year:</label>
			<input type="text" name="eyear" id="eyear" >
			<label>end month:</label>
			<input type="text" name="emonth" id="emonth" >
			<label>end day:</label>
			<input type="text" name="eday" id="eday" >
			<input id="submit" type="button" value="Submit" />
		</form>
		<div id="analysis">
			<table>
				<tr class="circle">
					<td colspan="13">
						<div id="mygraphiccontainer"></div>
					</td>
				</tr>
				<tr class="period">
					<td id="period1"></td>
					<td id="period2"></td>
					<td id="period3"></td>
					<td id="period4"></td>
					<td id="period5"></td>
					<td id="period6"></td>
					<td id="period7"></td>
					<td id="period8"></td>
					<td id="period9"></td>
					<td id="period10"></td>
					<td id="period11"></td>
					<td id="period12"></td>
					<td id="period13"></td>
				</tr>
			</table>
		</div>
	</body>
</html>