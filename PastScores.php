<?php
require 'vendor/autoload.php';

use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;

class PastScores
{
    private $client;

    public function __construct($apiKey)
    {
        // Initialize the Gemini API client with the provided API key
        $this->client = new Client($apiKey);
    }

    public function getScorePrediction($team1, $team2)
    {
        // Formulate the prompt for past match scores
        $text = "What was the score between {$team1} and {$team2}? Give the LATEST match from the current day and show the date and the full squad list, tabulate the squad list, and have the scores in a heading.";

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

            return $htmlResponse;
        } catch (Exception $e) {
            // Handle any exceptions that occur during the API request
            return "<div class='alert alert-danger'>Error fetching match details: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    }
}
