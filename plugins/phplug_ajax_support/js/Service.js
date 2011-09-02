var __phplugServiceData = Array(), 
PHPlugService = function(serviceName) {
	this.serviceName = serviceName;
	this.method = "POST";
	this.server = "index.php";
	this.async = true;
}, 
$p, currentPhplugServiceObj;

PHPlugService.prototype.call = function() {
	var method = arguments[0], params = Array(), i, xmlhttp, server, paramstr;
	currentPhplugServiceObj = this;
	paramstr = "phplugAjaxMode=1&phplugServerName=servicesServer&serviceName="+this.serviceName+"&method="+method;
	for(i = 1; i < arguments.length; i++) {
		paramstr += "&p[]="+arguments[i]; 
		params["p"+String(i-1)] = arguments[i];
	}
	xmlhttp = this.getXmlHttpRequest();
	server = this.server;
	if(this.method == "GET") {
		server += "?"+paramstr
	}
	xmlhttp.open(this.method, server, this.async);
	if(this.async && this.callback !== false) {
		xmlhttp.onreadystatechange = function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				__phplugServiceCallback(xmlhttp.responseText);
			}
		}
	}
	if(this.method == "POST") {
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(paramstr);
	} else {
		xmlhttp.send();
		__phplugServiceCallback(xmlhttp.responseText);
	}
};

PHPlugService.prototype.getXmlHttpRequest = function() {
	var xmlhttp;
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	} else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	return xmlhttp;
}

PHPlugService.prototype.setMethod = function(method) {
	this.method = method;
}

PHPlugService.prototype.setServer = function(server) {
	this.server = server;
}

PHPlugService.prototype.setCallback = function(callback) {
	this.callback = callback;
}

$p = function(serviceName) {
	var service = __phplugServiceData[serviceName];
	if(!service) {
		service = new PHPlugService(serviceName);
		__phplugServiceData[serviceName] = service;
	}
	return service
};

function __phplugServiceCallback(responseText) {
	var responseObj;
//	alert(responseText);
	eval(responseText);
	if(responseObj) {
		currentPhplugServiceObj.callback(responseObj);
	}
}