function showDialog (dWidth, dHeight, dInnerHTML) {
	var bkMask = document.createElement("div");
	bkMask.id = "bkMask";
	document.body.appendChild(bkMask);
	
	var divWidth = window.innerWidth;
	var divHeight = window.innerHeight;
	var docTop = document.body.scrollTop;
	var docLeft = document.body.scrollLeft;
	var frameWidth = document.body.scrollWidth;
	var frameHeight = document.body.scrollHeight;
	
	//alert("document height:" + frameHeight + "\n" + "document scrollTop" + docTop);
	
	bkMask.style.zIndex = 1000;
	bkMask.style.position = "absolute";
	bkMask.style.width = frameWidth+"px";
	bkMask.style.height = frameHeight+"px";
	bkMask.style.top = 0;
	bkMask.style.left = 0;
	bkMask.style.backgroundColor = "rgba(0,0,0,0.5)";
	
	var inDialog = document.createElement("div");
	inDialog.id = "ntDialog";
	bkMask.appendChild(inDialog);
	inDialog.style.position = "absolute";
	
	var dialogLeft = docLeft + (divWidth - dWidth)/2+"px";
	var dialogTop = docTop + (divHeight - dHeight)/2+"px";
	inDialog.style.left = dialogLeft;
	inDialog.style.top = dialogTop;
	inDialog.style.width = dWidth+"px";
	inDialog.style.height = dHeight+"px";
	//alert(window.eval(dInnerHTML));
	
	inDialog.innerHTML = dInnerHTML;
	
}
