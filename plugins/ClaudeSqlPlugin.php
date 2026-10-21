<?php

namespace AdminNeo;

/**
 * AI prompt in SQL command generating the queries with Anthropic Claude.
 *
 * Beware that this sends your whole database structure (not data) to Anthropic Claude.
 *
 * Last changed in release: !compile: version
 *
 * @link https://claude.ai/
 * @link https://www.adminneo.org/plugins/#usage
 *
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class ClaudeSqlPlugin extends Plugin
{
	/** @var string */
	private $apiKey;

	/** @var string */
	private $model;

	/**
	 * @param string $apiKey API key (get your own at https://platform.claude.com/settings/keys)
	 * @param string $model Model (https://platform.claude.com/docs/en/about-claude/models/overview)
	 */
	public function __construct(string $apiKey, string $model = "claude-opus-5-5")
	{
		$this->apiKey = $apiKey;
		$this->model = $model;
	}

	public function sendHeaders(): ?bool
	{
		// If the request does NOT come from the Claude textarea, just let the normal AdminNeo flow continue.
		if (!isset($_POST["claude"]) || isset($_POST["query"])) {
			return null;
		}

		// Build the system prompt. The database structure stays the same between questions, so it is cached.
		$system = "I have a " . get_driver_name(DRIVER) . " database";
		if (DB) {
			$system .= " with this structure:\n\n";

			foreach (tables_list() as $table => $type) {
				$system .= create_sql($table, false, "CREATE") . ";\n\n";
			}
		} else {
			$system .= ".\n\n";
		}

		$system .= "Prefer returning relevant columns including the primary key.\n\n";
		$system .= "Give me the requested SQL query and nothing else.";

		// Prepare payload.
		$content = json_encode([
			"model" => $this->model,
			"max_tokens" => 16000,
			"system" => [
				["type" => "text", "text" => $system, "cache_control" => ["type" => "ephemeral"]],
			],
			"messages" => [
				["role" => "user", "content" => $_POST["claude"]],
			],
		]);

		// Send request.
		$headers = [
			"Content-Type: application/json",
			"Content-Length: " . strlen($content),
			"x-api-key: $this->apiKey",
			"anthropic-version: 2023-06-01",
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

		$url = "https://api.anthropic.com/v1/messages";

		[$result] = get_url($url, $context);
		if ($result === false || !($response = json_decode($result))) {
			echo "-- Error loading URL: $url\n\n";
			exit();
		}

		if (isset($response->error)) {
			echo "-- " . $response->error->message;
			exit();
		}

		if ($response->stop_reason == "refusal") {
			echo "-- " . ($response->stop_details->explanation ?? "Claude declined to answer.");
			exit();
		}

		// Extract the response message. Thinking blocks may precede the text.
		$text = "";
		foreach ($response->content as $block) {
			if ($block->type == "text") {
				$text .= $block->text;
			}
		}

		echo $this->stripMarkdown($text);

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
		$waitingText = lang('Loading…');

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
		if (isCtrl(event) && event.key === 'Enter') {
			button.onclick(null);
			event.stopPropagation();
		}
	};

	button.onclick = () => {
		setSqlAreaValue('-- $waitingText');

		ajax(
			'',
			req => setSqlAreaValue(req.responseText),
			'claude=' + encodeURIComponent(textarea.value) + '&token=' + encodeURIComponent(this.form['token'].value)
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
			"<textarea name='claude' rows='5' cols='50' placeholder='", lang('Ask %s', "Claude"), "'>",
			h($_POST["claude"] ?? ""),
			"</textarea>",
			"</p>\n";

		echo "<p><input type='button' class='button' value='Claude'></p>\n";
		echo script($script);

		return null;
	}
}
