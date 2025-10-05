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
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class GeminiSqlPlugin extends Plugin
{
	/** @var string */
	private $apiKey;

	/** @var string */
	private $model;

	/**
	 * @note: The default key is shared with all users and may run out of quota.
	 *
	 * @param string $apiKey API key (get your own at https://aistudio.google.com/apikey)$prompt .= "Prefer returning relevant columns including primary key.\n\n";
	 * @param string $model Model (https://ai.google.dev/gemini-api/docs/models#available-models)
	 */
	public function __construct(string $apiKey = "AIzaSyA6Mnq1zSBhRvdgFJgPztn6tw5KorlMtG8", string $model = "gemini-2.0-flash")
	{
		$this->apiKey = $apiKey;
		$this->model = $model;
	}

	public function sendHeaders(): ?bool
	{
		if (!isset($_POST["gemini"]) || isset($_POST["query"])) {
			return null;
		}

		$prompt = "I have a " . get_driver_name(DRIVER) . " database with this structure:\n\n";
		foreach (tables_list() as $table => $type) {
			$prompt .= create_sql($table, false, "CREATE") . ";\n\n";
		}

		$prompt .= "Prefer returning relevant columns including the primary key.\n\n";
		$prompt .= "Give me this SQL query and nothing else:\n\n$_POST[gemini]";

		$context = stream_context_create([
			"http" => [
				"method" => "POST",
				"header" => ["User-Agent: AdminNeo/" . VERSION, "Content-Type: application/json"],
				"content" => '{"contents": [{"parts":[{"text": ' . json_encode($prompt) . '}]}]}',
				"ignore_errors" => true,
			]
		]);

		$url = "https://generativelanguage.googleapis.com/v1beta/models/$this->model:generateContent";

		$result = @file_get_contents("$url?key=$this->apiKey", false, $context);
		if ($result === false || !($response = json_decode($result))) {
			echo "-- Error loading URL: $url\n\n";
			exit;
		}

		if (isset($response->error)) {
			echo "-- " . $response->error->message;
		} else {
			$text = $response->candidates[0]->content->parts[0]->text;
			$text2 = preg_replace('~(\n|^)```sql\n(.+)\n```(\n|$)~sU', "*/\n\n\\2\n\n/*", "/*\n$text\n*/", -1, $count);

			echo $count ? preg_replace('~/\*\s*\*/\n*~', '', $text2) : $text;
		}

		exit;
	}

	public function printAfterSqlCommand(): ?bool
	{
		// The phrases from https://gemini.google.com/
		$waitingText = lang("Just a sec...");

		$script = <<<JS
const geminiText = qsl('textarea');
const geminiButton = qsl('input');

geminiText.onfocus = event => {
	toggleDefaultButton(this.form);

	event.stopImmediatePropagation();
};

geminiText.onblur = () => toggleDefaultButton(this.form);

geminiText.onkeydown = event => {
	// Handle Ctrl+Enter.
	if (isCtrl(event) && (event.keyCode === 13 || event.keyCode === 10)) {
		geminiButton.onclick(null);
		event.stopPropagation();
	}
};

geminiButton.onclick = () => {
	setSqlAreaValue('-- $waitingText');

	ajax(
		'',
		req => setSqlAreaValue(req.responseText),
		'gemini=' + encodeURIComponent(geminiText.value) + '&token=' + encodeURIComponent(this.form['token'].value),
	);
};

function setSqlAreaValue(value) {
	const sqlArea = qs('textarea.sqlarea');

	sqlArea.value = value;
	sqlArea.onchange && sqlArea.onchange(null);
}

function toggleDefaultButton(form) {
	qs('input[type="submit"]', form).classList.toggle('default');
	geminiButton.classList.toggle("default");
}
JS;

		echo "<p style='margin-top: 19px;'><textarea name='gemini' rows='5' cols='50' placeholder='", lang('Ask Gemini') , "'>", h($_POST["gemini"]), "</textarea></p>\n";
		echo "<p><input type='button' class='button' value='Gemini'></p>\n";
		echo script($script);

		return null;
	}
}
