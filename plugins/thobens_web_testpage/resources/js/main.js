function alertHelloWorld(responseObj) {
	$("#test")[0].value = responseObj.helloWorld;
}

$p("helloWorldService").setCallback(alertHelloWorld);
$p("helloWorldService").call("alertHelloWorldString");
