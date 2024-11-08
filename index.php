<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Future Scores</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Past Scores</h1>
        <form method="POST" action="" class="mt-4">
            <div class="form-group">
                <label for="team1">Team 1</label>
                <input type="text" class="form-control" id="team1" name="team1" placeholder="Enter first team" required>
            </div>
            <div class="form-group">
                <label for="team2">Team 2</label>
                <input type="text" class="form-control" id="team2" name="team2" placeholder="Enter second team" required>
            </div>
            <button type="submit" class="btn btn-primary">Get Scores</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Include the PastScores class
            require_once 'PastScores.php';

            // Set your API key here
            $apiKey = 'AIzaSyCzhcvDNXlCYq80xGjaieIJOuGapDwCtFc';

            // Initialize the predictor
            $predictor = new PastScores($apiKey);

            // Get team names from the form
            $team1 = $_POST['team1'];
            $team2 = $_POST['team2'];

            // Get prediction
            $prediction = $predictor->getScorePrediction($team1, $team2);

            // Display result
            echo "<div class='mt-4 alert alert-info'>$prediction</div>";
        }
        ?>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>