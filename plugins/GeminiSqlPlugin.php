<?php

namespace AdminNeo;

/**
 * AI prompt in SQL command generating the queries with Google Gemini.
 *
 * Beware that this sends your whole database structure (not data) to Google Gemini.
 *
 * Last changed in release: !compile: version
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
	 * @param string $apiKey API key (get your own at https://aistudio.google.com/apikey)
	 * @param string $model Model (https://ai.google.dev/gemini-api/docs/models#available-models)
	 */
	public function __construct(string $apiKey, string $model = "gemini-2.5-flash")
	{
		$this->apiKey = $apiKey;
		$this->model = $model;
	}

	public function sendHeaders(): ?bool
	{
		// If the request does NOT come from the Gemini textarea, just let the normal AdminNeo flow continue.
		if (!isset($_POST["gemini"]) || isset($_POST["query"])) {
			return null;
		}

		// Build the prompt.
		$prompt = "I have a " . get_driver_name(DRIVER) . " database";
		if (DB) {
			$prompt .= " with this structure:\n\n";

			foreach (tables_list() as $table => $type) {
				$prompt .= create_sql($table, false, "CREATE") . ";\n\n";
			}
		} else {
			$prompt .= ".\n\n";
		}

		$prompt .= "Prefer returning relevant columns including the primary key.\n\n";
		$prompt .= "Give me this SQL query and nothing else:\n\n$_POST[gemini]";

		// Prepare payload.
		$content = '{"contents": [{"parts":[{"text": ' . json_encode($prompt) . '}]}]}';

		// Send request.
		$headers = [
			"Content-Type: application/json",
			"Content-Length: " . strlen($content),
		];

		$context = stream_context_create([
			"http" => [
				"method" => "POST",
				"header" => $headers,
				"user_agent" => "AdminNeo/" . VERSION,
				"content" => $content,
				"ignore_errors" => true, // we want the body even on 4xx/5xx
			]
		]);

		$url = "https://generativelanguage.googleapis.com/v1beta/models/$this->model:generateContent";

		[$result] = get_url("$url?key=$this->apiKey", $context);
		if ($result === false || !($response = json_decode($result))) {
			echo "-- Error loading URL: $url\n\n";
			exit();
		}

		if (isset($response->error)) {
			echo "-- " . $response->error->message;
			exit();
		}

		// Extract the response message.
		echo $this->stripMarkdown($response->candidates[0]->content->parts[0]->text);

		exit();
	}

	/**
	 * Strips potential Markdown around SQL queries.
	 */
	private function stripMarkdown(string $text): string
	{
		$text2 = preg_replace('~(\n|^)```sql\n(.+)\n```(\n|$)~sU', "*/\n\n$2\n\n/*", "/*\n$text\n*/", -1, $count);

		return $count ? preg_replace('~/\*\s*\*/\n*~', "", $text2) : $text;
	}

	public function printAfterSqlCommand(): ?bool
	{
		// The phrases from https://gemini.google.com/
		$waitingText = lang('Just a sec...');

		$script = <<<JS
(function() {
	const textarea = qsl('textarea');
	const button = qsl('input');

	textarea.onfocus = event => {
		toggleDefaultButton(this.form);

		event.stopImmediatePropagation();
	};

	textarea.onblur = () => toggleDefaultButton(this.form);

	textarea.onkeydown = event => {
		// Handle Ctrl+Enter.
		if (isCtrl(event) && (event.keyCode === 13 || event.keyCode === 10)) {
			button.onclick(null);
			event.stopPropagation();
		}
	};

	button.onclick = () => {
		setSqlAreaValue('-- $waitingText');

		ajax(
			'',
			req => setSqlAreaValue(req.responseText),
			'gemini=' + encodeURIComponent(textarea.value) + '&token=' + encodeURIComponent(this.form['token'].value),
		);
	};

	function setSqlAreaValue(value) {
		const sqlArea = qs('textarea.sqlarea');

		sqlArea.value = value;
		sqlArea.onchange && sqlArea.onchange(null);
	}

	function toggleDefaultButton(form) {
		qs('input[type="submit"]', form).classList.toggle('default');
		button.classList.toggle("default");
	}
})();
JS;

		// Render the textarea and button.
		echo "<p style='margin-top: 19px;'>",
			"<textarea name='gemini' rows='5' cols='50' placeholder='", lang('Ask %s', "Gemini"), "'>",
			h($_POST["gemini"] ?? ""),
			"</textarea>",
			"</p>\n";

		echo "<p><input type='button' class='button' value='Gemini'></p>\n";
		echo script($script);

		return null;
	}
}
