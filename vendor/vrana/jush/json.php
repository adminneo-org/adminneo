<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<title>JSON</title>
<link rel="stylesheet" media="(prefers-color-scheme: dark)" href="demo-dark.css">
<body>

<form action="" method="post">
<p><textarea name="json" rows="10" cols="50"><?php
if (isset($_POST["json"])) {
	echo htmlspecialchars($_POST["json"]);
}
?></textarea>
<p><input type="submit" value="JSON">
</form>

<pre><code class="language-js"><?php
if (isset($_POST["json"])) {
	echo htmlspecialchars(json_encode(json_decode($_POST["json"]), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
}
?></code></pre>

<script src="jush.js"></script>
<script>
jush.style('jush.css');
jush.style('jush-dark.css', '(prefers-color-scheme: dark)');
jush.highlight_tag('code');
</script>
