<?php

namespace AdminNeo;

/**
 * AI prompt in SQL command generating the queries with Google Gemini.
 *
 * Beware that this sends your whole database structure (not data) to Google Gemini.
 *
 * @link https://gemini.google.com/
 * @link https://www.adminneo.org/plugins/#usage
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class SqlGeminiPlugin extends Plugin
{
	/** @var string */
	private $apiKey;

	/** @var string */
	private $model;

	/**
	 * @param string $apiKey API key (https://aistudio.google.com/apikey)
	 * @param string $model Model (https://ai.google.dev/gemini-api/docs/models#available-models)
	 */
	public function __construct(string $apiKey, string $model = "gemini-2.0-flash")
	{
		$this->apiKey = $apiKey;
		$this->model = $model;
	}

	public function sendHeaders(): ?bool
	{
		if (!$_POST["gemini"] || isset($_POST["query"])) {
			return null;
		}

		$prompt = "I have a database with this structure:\n\n";
		foreach (tables_list() as $table => $type) {
			$prompt .= create_sql($table, false, "CREATE") . ";\n\n";
		}

		$prompt .= "Give me this SQL query and nothing else:\n\n$_POST[gemini]";

		$context = stream_context_create([
			"http" => [
				"method" => "POST",
				"header" => ["User-Agent: AdminNeo", "Content-Type: application/json"],
				"content" => '{"contents": [{"parts":[{"text": ' . json_encode($prompt) . '}]}]}',
			]
		]);
		$result = file_get_contents("https://generativelanguage.googleapis.com/v1beta/models/$this->model:generateContent?key=$this->apiKey", false, $context);
		if (!$result) {
			exit;
		}

		$response = json_decode($result);
		$text = $response->candidates[0]->content->parts[0]->text;

		echo rtrim(preg_replace('~```sql\n(.*\n)```~sU', "$1", $text)) . "\n\n";
		exit;
	}

	public function printAfterSqlCommand(): ?bool
	{
		$script = <<<JS
qsl('input').onclick = event => {
	ajax(
		'',
		req => {
			qs('textarea.sqlarea').value = req.responseText;

			const sqlArea = qs('pre.sqlarea');
			sqlArea.textContent = req.responseText;
			sqlArea.oninput(event); // syntax highlighting

			gid('ajaxstatus').classList.add("hidden");
		},
		'gemini=' + encodeURIComponent(this.form['gemini'].value) + '&token=' + encodeURIComponent(this.form['token'].value),
		'Just a sec…' // This is the phrase used by Google Gemini.
	);
};
JS;

		echo "<p><textarea name='gemini' rows='5' cols='50' title='AI prompt'>", h($_POST["gemini"]), "</textarea></p>\n";
		echo "<p><input type='button' class='button' value='Gemini'>", script($script), "</p>";

		return null;
	}
}
