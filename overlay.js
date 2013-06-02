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