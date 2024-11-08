<?php
require 'vendor/autoload.php';

use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;

class PastScores {
    private $client;

    public function __construct($apiKey) {
        // Initialize the Gemini API client with the provided API key
        $this->client = new Client($apiKey);
    }

    public function getScorePrediction($team1, $team2) {
        // Formulate the prompt for past match scores
        $text = "Give me a table with the last 10 scores bewteen {$team1} and {$team2}  ";

        try {
            // Generate content from Gemini API
            $response = $this->client->geminiPro()->generateContent(
                new TextPart($text)
            );

            // Retrieve and format the response text as HTML
            $plainText = $response->text();

            // Convert plain text to HTML (basic formatting applied here)
            $htmlResponse = "<div class='score-prediction'>";
            $htmlResponse .= nl2br(htmlspecialchars($plainText)); // Convert new lines to <br> and escape HTML

            $htmlResponse .= "</div>";

            return $this->convertMarkupToHTML($response->text());
        } catch (Exception $e) {
            // Handle any exceptions that occur during the API request
            return "<div class='alert alert-danger'>Error fetching match details: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    }

    private function convertMarkupToHTML($text) {
        // Convert headings (lines starting with #)
        $text = preg_replace('/^# (.*)$/m', '<h2>$1</h2>', $text);

        // Convert list items (lines starting with -)
        $text = preg_replace('/^- (.*)$/m', '<li>$1</li>', $text);
        $text = preg_replace('/(<li>.*<\/li>)/s', '<ul>$1</ul>', $text); // Wrap list items in <ul>

        // Convert table-like patterns (lines with | separated values)
        $text = preg_replace_callback('/^(\|.+\|)$/m', function ($matches) {
            $rows = explode("\n", trim($matches[0]));
            $html = "<table class='table table-bordered'>";
            foreach ($rows as $row) {
                $cells = explode('|', trim($row, '|'));
                $html .= "<tr><td>" . implode('</td><td>', array_map('trim', $cells)) . "</td></tr>";
            }
            $html .= "</table>";
            return $html;
        }, $text);

        // Convert new lines to <br> for other text
        return nl2br($text);
    }
}
