<?php
namespace AdminNeo;

use AdminNeo\Plugin;
/**
 * AI‑assisted SQL generation using an OpenWebUI backend.
 *
 * This version mirrors the original Gemini plugin but talks to an
 * OpenWebUI instance (any OpenAI‑compatible chat endpoint) instead of
 * Google Gemini.
 *
 * @link https://github.com/open-webui/open-webui
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @author Peter Knut
 * @author Bram Daams
 *
 * @license Apache‑2.0 OR GPL‑2.0
 */
class OpenWebUIPlugin extends Plugin
{
    /** @var string URL of the chat endpoint, e.g. http://127.0.0.1:8080/v1/chat/completions */
    private $apiUrl;

    /** @var string Model name that exists in OpenWebUI */
    private $model;

    /** @var string|null Bearer token – leave null/empty if the endpoint is public */
    private $apiKey;

    /**
     * @param string      $apiUrl  Full URL to the `/v1/chat/completions` endpoint
     * @param string      $model   Model name as shown in the OpenWebUI UI
     * @param string|null $apiKey  Optional Bearer token (can be empty string)
     */
    public function __construct(
        string $apiUrl,
        string $model = "gpt-oss:120b",
        ?string $apiKey = null
    ) {
        $this->apiUrl = rtrim($apiUrl, "/");
        $this->model = $model;
        $this->apiKey = $apiKey;
    }

    /* ----------------------------------------------------------------------
     *  Send the request to OpenWebUI and echo the generated SQL
     * ---------------------------------------------------------------------- */
    public function sendHeaders()
    {
        /* ------------------------------------------------------------------
         *  If the request does NOT come from the "Ask OpenWebUI" textarea we
         *  just let the normal AdminNeo flow continue.
         * ------------------------------------------------------------------ */
        if (!isset($_POST["openwebui"]) || isset($_POST["query"])) {
            return null;
        }

        /* ------------------------------------------------------------------
         *  Build the prompt – identical to the Gemini version, only the
         *  variable name changed.
         * ------------------------------------------------------------------ */
        $prompt = "I have a " . get_driver_name(DRIVER) . " database";

        if (DB) {
            $prompt .= " with this structure:\n\n";
            foreach (tables_list() as $table => $type) {
                $prompt .= create_sql($table, false, "CREATE") . ";\n\n";
            }
        } else {
            $prompt .= ".\n\n";
        }

        $prompt .=
            "Prefer returning relevant columns including the primary key.\n\n";
        $prompt .= "Give me this SQL query and nothing else:\n\n{$_POST["openwebui"]}";
        /* ------------------------------------------------------------------
         *  Payload for OpenAI‑compatible chat endpoint
         * ------------------------------------------------------------------ */
        $payload = [
            "model" => $this->model,
            "messages" => [["role" => "user", "content" => $prompt]],
            // Optional: you can request a higher temperature or max_tokens here
            // 'temperature' => 0.2,
            // 'max_tokens'  => 1024,
        ];

        $jsonPayload = json_encode(
            $payload,
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );

        /* ------------------------------------------------------------------
         *  HTTP context (fallback to file_get_contents).  If you have curl
         *  enabled you can replace the whole block with a curl call – both
         *  work the same.
         * ------------------------------------------------------------------ */
        $httpHeaders = [
            "User-Agent: AdminNeo/" . VERSION,
            "Content-Type: application/json",
            "Content-Length: " . strlen($jsonPayload),
        ];

        if (!empty($this->apiKey)) {
            $httpHeaders[] = "Authorization: Bearer {$this->apiKey}";
        }

        $context = stream_context_create([
            "http" => [
                "method" => "POST",
                "header" => implode("\r\n", $httpHeaders),
                "content" => $jsonPayload,
                "ignore_errors" => true, // we want the body even on 4xx/5xx
                "timeout" => 60,
            ],
        ]);

        $url = rtrim($this->apiUrl, "/") . "/api/v1/chat/completions";
        $result = @file_get_contents($url, false, $context);

        /* ------------------------------------------------------------------
         *  Error handling – same behaviour as the original plugin
         * ------------------------------------------------------------------ */
        if ($result === false || !($response = json_decode($result))) {
            echo "-- Error loading URL: $url\n\n";
            exit();
        }

        if (isset($response->error)) {
            echo "-- " . $response->error->message;
            exit();
        }
        /* ------------------------------------------------------------------
         *  Extract the assistant message – OpenWebUI returns it in
         *  `choices[0].message.content`.
         * ------------------------------------------------------------------ */
        $text = $response->choices[0]->message->content ?? "xx";

        /* ------------------------------------------------------------------
         *  The original Gemini plugin wrapped the answer in a comment block
         *  and tried to strip Markdown fences.  We keep the same behaviour
         *  so the UI does not change.
         * ------------------------------------------------------------------ */
        $text2 = preg_replace(
            '~(\n|^)```sql\n(.+)\n```(\n|$)~sU',
            "*/\n\n\\2\n\n/*",
            "/*\n$text\n*/",
            -1,
            $count
        );

        // Remove an empty comment block if the model did not use fences
        echo $count ? preg_replace('~/\*\s*\*/\n*~', "", $text2) : $text;

        exit(); // <-- stop normal AdminNeo processing – we already echoed the answer
    }

    /* ----------------------------------------------------------------------
     *  UI – textarea + button (renamed from “Gemini” to “OpenWebUI”)
     * ---------------------------------------------------------------------- */
    public function printAfterSqlCommand()
    {
        // Text shown while we wait for the answer
        $waitingText = lang("Just a sec...");

        // ------------------------------------------------------------------
        // JavaScript that drives the tiny UI.  Only the names of the HTML
        // elements change – the logic stays identical.
        // ------------------------------------------------------------------
        $script = <<<JS
const openwebuiText   = qsl('textarea[name="openwebui"]');
const openwebuiButton = qsl('input[name="openwebuiBtn"]');

openwebuiText.onfocus = event => {
    toggleDefaultButton(this.form);
    event.stopImmediatePropagation();
};
openwebuiText.onblur  = () => toggleDefaultButton(this.form);
openwebuiText.onkeydown = event => {
    // Ctrl+Enter → submit
    if (isCtrl(event) && (event.keyCode === 13 || event.keyCode === 10)) {
        openwebuiButton.onclick(null);
        event.stopPropagation();
    }
};

openwebuiButton.onclick = () => {
    setSqlAreaValue('-- $waitingText');
    ajax(
        '',
        req => setSqlAreaValue(req.responseText),
        'openwebui=' + encodeURIComponent(openwebuiText.value) +
        '&token=' + encodeURIComponent(this.form['token'].value)
    );
};

function setSqlAreaValue(value) {
    const sqlArea = qs('textarea.sqlarea');
    sqlArea.value = value;
    sqlArea.onchange && sqlArea.onchange(null);
}
function toggleDefaultButton(form) {
    qs('input[type="submit"]', form).classList.toggle('default');
    openwebuiButton.classList.toggle('default');
}
JS;

        // ------------------------------------------------------------------
        // Render the textarea + button (same layout as the original)
        // ------------------------------------------------------------------
        echo "<p style='margin-top: 19px;'>
                <textarea name='openwebui' rows='5' cols='50' placeholder='" .
            lang("Ask OpenWebUI") .
            "'>" .
            h($_POST["openwebui"] ?? "") .
            "</textarea>
              </p>\n";

        echo "<p><input type='button' name='openwebuiBtn' class='button' value='OpenWebUI'></p>\n";
        // Finally inject the JS
        echo script($script);

        return null; // keep the plugin chain alive
    }
}
