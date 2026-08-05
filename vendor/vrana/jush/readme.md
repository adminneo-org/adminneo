# JUSH - JavaScript Syntax Highlighter

Highlights the full stack of PHP application starting with HTML, PHP, SQL and JavaScript code and ending with HTTP headers, `php.ini` settings or database variables.

- [Demo](demo.html)
- [SQL highlighter for various databases](sql.html)
- [Tests](tests.html)
- [Homepage](https://jush.sourceforge.io/)

## Features

- Highlights and links documentation in spaghetti code like nothing else: `<?php mysql_query("SELECT 1"); ?>`
- Supported languages: everything related to PHP: HTML5, JS, JSON, CSS 3, SQL including variables (multiple dialects), `php.ini` directives, HTTP and e-mail headers, Apache config. Anything could be embedded into each other, e.g. `header("Content-Type: text/html")` or `color: expression(parentNode.style.color)`.
- Allows using HTML tags in source code (could be used for pointing out important parts): `echo "This part is <b>important</b>."`. Produces overlapping HTML tags in this case though.
- Performance is a priority.
- `<textarea>` [syntax highlight](textarea.html).

## Installation instructions

1. Copy [jush.css](jush.css) and [jush.js](jush.js) into your directory.

2. Add following snippet before the `</body>` tag in HTML file:

   ```javascript
   <script src="jush.js"></script>
   <script>
   jush.style('jush.css');
   jush.highlight_tag('code');
   </script>
   ```

   All `<code class="jush">` tags will be highlighted. Language is determined by the class name beginning with "jush-" (e.g. `<code class="jush-js">`). Default language is `htm`. It is also possible to use `<code class="language-*">`.

3. If you want to enable dark mode, call `jush.style('jush-dark.css')`. To enable it only based on user preferences, call `jush.style('jush-dark.css', '(prefers-color-scheme: dark)')`.

Alternatively call `jush.highlight(language, text)` to syntax highlight single text.

## Command-line help reference

It is also possible to use JUSH for opening the appropriate documentation in a browser:

```
Syntax: node jush-help.js filename line column [tabsize] [word]
Example: node jush-help.js demo.html 2 2
```

The example should open a browser with documentation of the `<html>` tag which is at position 2:2 of [demo.html](demo.html).

## Updating language references

The `update/` directory holds scripts which sync a language module's list of keywords, functions and classes from an upstream reference file. For example, [update/php.php](update/php.php) rebuilds the class and function lists in `modules/jush-php.js` from a `php.api` file (from [scite-files](https://github.com/moltenform/scite-files/blob/main/files/files/api_files/php.api)):

```
php update/php.php path/to/php.api
```

[update/sql.php](update/sql.php) rebuilds the MySQL/MariaDB lists in `modules/jush-sql.js` from the MySQL online manual (the index pages are cached in the given directory) and a checkout of [mariadb-docs](https://github.com/mariadb-corporation/mariadb-docs):

```
php update/sql.php path/to/mysql-cache path/to/mariadb-docs
```
