(function( $ ){
	$.fn.updateComponent = function() {
		var xmlhttp = getXmlHttpRequest(), paramstr, objToUpdate = this[0];
		paramstr = "phplugAjaxMode=1&phplugServerName=uiUpdater&updateComponent="+this.attr("id");
		xmlhttp.open("POST", "index.php", this.async);
		xmlhttp.onreadystatechange = function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				objToUpdate.innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(paramstr);
	};
})( jQuery );

function getXmlHttpRequest() {
	var xmlhttp;
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	} else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	return xmlhttp;
}

function testUpdate() {
	$("#testId").updateComponent();
}

//setInterval("testUpdate()",1000)