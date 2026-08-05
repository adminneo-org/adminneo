(function () {
	jush.style('jush.css');
	jush.style('jush-dark.css', '(prefers-color-scheme: dark)');
	jush.create_links = 'target="_blank"';
	const source = document.getElementById('source');
	let value = '';
	if (!source.value && location.hash) {
		source.value = decodeURIComponent(location.hash.slice(1));
	}
	source.oninput = function highlight() {
		if (value == source.value) {
			return;
		}
		value = source.value;
		const result = document.getElementById('result');
		const language = source.form['language'].value;
		result.className = 'jush-' + language;
		result.innerHTML = jush.highlight(language, source.value);
	};
	source.form['language'].onchange = () => {
		value = '';
		source.oninput();
	}
	source.oninput();
})();
