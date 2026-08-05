/** JUSH help - open URL with help on specified position in file
* @link https://jush.sourceforge.io/
* @author Jakub Vrana, https://www.vrana.cz
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
*/

/* SciTE:
file.patterns.jush=*.htm;*.html;*.php;*.sql;*.js;*.css;php.ini;*.conf;.htaccess;my.ini
command.1.$(file.patterns.jush)=node jush-help.js "$(FilePath)" $(SelectionStartLine) $(SelectionStartColumn) $(tabsize) "$(CurrentWord)"
command.name.1.$(file.patterns.jush)=JUSH help
command.quiet.1.$(file.patterns.jush)=1
command.save.before.1.$(file.patterns.jush)=1
*/

const fs = require('fs');
const path = require('path');
const { spawn } = require('child_process');

function loadJush() {
	const dir = path.join(__dirname, 'modules');
	const files = fs.readdirSync(dir).sort().filter(file => (/^jush-(?!textarea|autocomplete-.+).+\.js$/.test(file)));
	const code = ['jush.js'].concat(files)
		.map(file => fs.readFileSync(path.join(dir, file), 'utf8'))
		.join('\n');
	return new Function(code + '\nreturn jush;')();
}

function openUrl(url) {
	const options = { detached: true, stdio: 'ignore', windowsHide: true };
	let child;
	if (process.platform == 'win32') {
		child = spawn('cmd', ['/c', 'start', '""', '"' + url + '"'], Object.assign({ windowsVerbatimArguments: true }, options));
	} else if (process.platform == 'darwin') {
		child = spawn('open', [url], options);
	} else {
		child = spawn('xdg-open', [url], options);
	}
	child.unref();
}

const args = process.argv.slice(2);
if (args.length < 3) {
	console.error('Usage: node jush-help.js filename line column [tabsize] [word]\nPurpose: Open URL with help on specified position in file');
	process.exit(1);
}
const filename = args[0];
const line = +args[1];
const column = +args[2];
const basename = path.basename(filename);
let lang = 'htm';
const extension = /\.(js|sql|xml|css)$/.exec(basename);
if (extension) {
	lang = extension[1];
} else if (basename == 'php.ini') {
	lang = 'phpini';
} else if (basename == 'my.ini') {
	lang = 'sqlset';
} else if (/\.conf$/.test(basename) || basename == '.htaccess') {
	lang = 'cnf';
}
const file = fs.readFileSync(filename, 'utf8').replace(/\r/g, '').split('\n').slice(0, line).join('\n'); // highlight only first lines of file (performance)
let s = loadJush().highlight(lang, file).split('\n').pop(); // get last line of output
if (args.length > 3) {
	s = s.replace(/\t/g, ' '.repeat(+args[3]));
}
s = s.replace(/&[^;]+;/g, '&');
let href = '';
let pos = 1;
let match;
const re = /<a href="([^"]+)" class="jush-help">|(<\/a>)|<[^>]+>|([^<]+)/g;
while ((match = re.exec(s))) {
	if (match[1]) {
		href = match[1];
	} else if (match[2]) {
		if (pos == column) { // last character of link
			break;
		}
		href = '';
	} else if (match[3]) {
		pos += match[3].length;
		if (pos > column) {
			break;
		}
	}
}
openUrl(href ? href : 'https://www.google.com/search?q=' + encodeURIComponent(args.length > 4 ? args[4] : (match ? match[3] : '')));
