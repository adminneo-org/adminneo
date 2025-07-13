(function () {
	jush.style('jush.css');
	jush.style('jush-dark.css', '(prefers-color-scheme: dark)');
	jush.create_links = 'target="_blank"';
	var source = document.getElementById('source');
	var value = '';
	if (!source.value && location.hash) {
		source.value = location.hash.substr(1);
	}
	source.oninput = function highlight() {
		if (value == source.value) {
			return;
		}
		value = source.value;
		var result = document.getElementById('result');
		var language = source.form['language'].value;
		result.className = 'jush-' + language;
		result.innerHTML = jush.highlight(language, source.value);
	};
	source.form['language'].onchange = function () {
		value = '';
		source.oninput();
	}
	source.oninput();
})();
