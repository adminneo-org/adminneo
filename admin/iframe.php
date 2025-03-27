<?php
	$queryString = parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY);
?>
<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>

	<title>IFRAME test</title>

	<style>
		body {
			margin: 0;
			padding: 0;
			background: #444;
			color: #eee;
			text-align: center;
			font-family: Helvetica, sans-serif;
		}

		iframe {
			padding: 0;
			border: 0;
			background: #fff;
			width: 100%;
			height: 600px;
		}

		p {
			margin: 30px;
			overflow-wrap: anywhere;
		}
	</style>
</head>
<body>
<h1>IFRAME test</h1>

<iframe id="adminneo-frame" src="plugins.php<?= $queryString != "" ? "?$queryString" : ""; ?>"></iframe>
<p id="message"></p>

<script>
	const baseUrl = window.location.href.split("?")[0];
	const allowedOrigin = new URL(window.location.href).origin;
	const serviceTitle = document.title;
	const adminneoFrame = document.getElementById("adminneo-frame");
	const messageBox = document.getElementById("message");

	window.addEventListener("message", function (event) {
		if (!event.isTrusted || event.origin !== allowedOrigin || event.source !== adminneoFrame.contentWindow) {
			return;
		}

		const data = event.data;

		messageBox.innerText = JSON.stringify(data);

		if (typeof data === "object" && data.event === "adminneo-loading") {
			const search = new URL(data.url).search;

			document.title = `${data.title} - ${serviceTitle}`;
			history.replaceState(null, null, baseUrl + search);
		}
	});
</script>

</body>
