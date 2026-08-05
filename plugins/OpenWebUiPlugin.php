<?php

namespace AdminNeo;

/**
 * AI‑assisted SQL generation using an Open WebUI backend.
 *
 * This version mirrors the original Gemini plugin but talks to an OpenWebUI instance
 * (any OpenAI‑compatible chat endpoint).
 *
 * @link https://github.com/open-webui/open-webui
 * @link https://docs.openwebui.com/
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @author Peter Knut
 * @author Bram Daams
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class OpenWebUiPlugin extends Plugin
{
	/** @var string */
	private $apiUrl;

	/** @var string */
	private $model;

	/** @var ?string */
	private $apiKey;

	/**
	 * @param string $apiUrl FURL of the chat endpoint, e.g. http://127.0.0.1:8080.
	 * @param string $model Model name as shown in the Open WebUIUI.
	 * @param ?string $apiKey Bearer token – leave null if the endpoint is public.
	 */
	public function __construct(string $apiUrl, string $model = "gpt-oss:120b", ?string $apiKey = null)
	{
		$this->apiUrl = rtrim($apiUrl, "/");
		$this->model = $model;
		$this->apiKey = $apiKey;
	}

	/**
	 * Processes the request to Open WebUI and prints the generated SQL.
	 */
	public function sendHeaders(): ?bool
	{
		// If the request does NOT come from the Open WebUI textarea, just let the normal AdminNeo flow continue.
		if (!isset($_POST["openwebui"]) || isset($_POST["query"])) {
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
		$prompt .= "Give me this SQL query and nothing else:\n\n{$_POST["openwebui"]}";

		// Prepare payload for OpenAI‑compatible chat endpoint.
		$payload = [
			"model" => $this->model,
			"messages" => [["role" => "user", "content" => $prompt]],
			// Optional: you can request a higher temperature or max_tokens here
			// 'temperature' => 0.2,
			// 'max_tokens'  => 1024,
		];

		$content = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

		// Send request.
		$headers = [
			"Content-Type: application/json",
			"Content-Length: " . strlen($content),
		];

		if ($this->apiKey) {
			$headers[] = "Authorization: Bearer $this->apiKey";
		}

		$context = stream_context_create([
			"http" => [
				"method" => "POST",
				"header" => $headers,
				"user_agent" => "AdminNeo/" . VERSION,
				"content" => $content,
				"ignore_errors" => true, // we want the body even on 4xx/5xx
				"timeout" => 60,
			],
		]);

		$url = $this->apiUrl . "/api/v1/chat/completions";

		$result = @file_get_contents($url, false, $context);
		if ($result === false || !($response = json_decode($result))) {
			echo "-- Error loading URL: $url\n\n";
			exit();
		}

		if (isset($response->detail)) {
			echo "-- " . $response->detail;
			exit();
		}

		// Extract the response message.
		echo $this->stripMarkdown($response->choices[0]->message->content);

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

	/**
	 * Prints query form.
	 */
	public function printAfterSqlCommand(): ?bool
	{
		$waitingText = lang('Loading') . "…";

		$script = <<<JS
(function() {
	const textarea   = qsl('textarea');
	const button = qsl('input');

	textarea.onfocus = event => {
	    toggleDefaultButton(this.form);
	    event.stopImmediatePropagation();
	};
	textarea.onblur  = () => toggleDefaultButton(this.form);
	textarea.onkeydown = event => {
	    // Ctrl+Enter → submit.
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
	        'openwebui=' + encodeURIComponent(textarea.value) + '&token=' + encodeURIComponent(this.form['token'].value)
	    );
	};

	function setSqlAreaValue(value) {
	    const sqlArea = qs('textarea.sqlarea');

	    sqlArea.value = value;
	    sqlArea.onchange && sqlArea.onchange(null);
	}

	function toggleDefaultButton(form) {
	    qs('input[type="submit"]', form).classList.toggle('default');
	    button.classList.toggle('default');
	}
})();
JS;

		// Render the textarea and button.
		echo "<p style='margin-top: 19px;'>",
			"<textarea name='openwebui' rows='5' cols='50' placeholder='", lang('Ask %s', "Open WebUI"), "'>",
			h($_POST["openwebui"] ?? ""),
			"</textarea>",
			"</p>\n";

		echo "<p><input type='button' name='openwebuiBtn' class='button' value='Open WebUI'></p>\n";
		echo script($script);

		return null;
	}
}
