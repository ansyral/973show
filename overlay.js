  $_overlay =  {
	self: '',

	create: function() {
		if(this.self && this.self.parent().length){return;}
		$(window).bind('resize.overlay', $_overlay.resize);
		return (this.self = (this.self || $('<div></div>').css({
			height:'100%',left:0,position:'absolute',top:0,width:'100%',background:'#000','opacity':0.8,'z-index':777
		})).appendTo('body').css({
			width:this.width(),
			height:this.height()
		}));
	},

	destroy: function() {
		if(this.self &&!this.self.parent().length){return;}
		$([document, window]).unbind('resize.overlay');
		$_overlay.self.animate({
			opacity:'hide'
		},function(){
			$(this).remove().show();
		}); 
	},
	resize: function() {
		$_overlay.self.css({
			width: 0,height: 0
		}).css({
			width: $_overlay.width(),height: $_overlay.height()
		});
	},
	height: function() {
		var scrollHeight,offsetHeight;
		if (this.isIE6) {
			scrollHeight = Math.max(
				document.documentElement.scrollHeight,document.body.scrollHeight
			);
			offsetHeight = Math.max(
				document.documentElement.offsetHeight,document.body.offsetHeight
			);
			if (scrollHeight < offsetHeight) {
				return $(window).height() + 'px';
			} else {
				return scrollHeight + 'px';
			}
		} else {
			return $(document).height() + 'px';
		}
	},
	width: function() {
		var scrollWidth,
			offsetWidth;
		if (this.isIE6) {
			scrollWidth = Math.max(
				document.documentElement.scrollWidth,document.body.scrollWidth
			);
			offsetWidth = Math.max(
				document.documentElement.offsetWidth,document.body.offsetWidth
			);
			if (scrollWidth < offsetWidth) {
				return $(window).width() + 'px';
			} else {
				return scrollWidth + 'px';
			}
		} else {
			return $(document).width() + 'px';
		}
	}
};
monthchara=new Array('','January','February','March','April','May','June','July','August','September','October','November','December');
function updateinner(){
	var repreimg=datas.repimg.split(",");
	for(var i=0;i<3;i++)
	{
		$("#img"+i).attr("src",repreimg[i]);
	}
	$("#summcontent").text(datas.summary);
	$('#monthtip h1').text(monthchara[month]);
										
	var fill = d3.scale.category20();
  	var hfterms=datas.repword;
  	var hfterm_weight=datas.repword_weight;
  	var hfterm_weights=hfterm_weight.split(",");

  	d3.layout.cloud().size([300, 300])
    .words((hfterms.split(",")).map(function(d,i) {
        return {text: d, size: parseInt(hfterm_weights[i]*3000)};
    }))
    .rotate(function() { return ~~(Math.random() * 2) * 90; })
    .font("Impact")
    .fontSize(function(d) { return d.size; })
    .on("end", redraw)
    .start();
}