<?php
    use Src\Boot;
    use Src\Engine\Dictionary\Dictionary;
    use Src\Engine\Scrabble;

    require_once 'Src/Boot.php';

    $boot = new Boot();

    $dictionary = new Dictionary($boot);

    $scrabble = new Scrabble($dictionary);

    $rack = "";

    $letters = range("a", "z");

    function removeLetter($rack, $letter) { // Removes the first occurence of the given character from the given string
        if ($rack) {
            $pos = strpos($rack, $letter);

            if ($pos !== false) {
                return substr_replace($rack, "", $pos, 1);
            }
        }

        return $rack;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["rack"])) {
        $rack = $_POST["rack"];
    }
?>

<h1>Scrabble Word Generator</h1>

<h2>Rack</h2>

<?php
    if ($rack) {
        echo "<form action=\"index.php\" method=\"post\">";

        foreach (str_split($rack) as $letter) { // Generate a button for each letter in the rack
            echo "<button type=\"submit\" name=\"rack\" value=\"" . removeLetter($rack, $letter) . "\">" . strtoupper($letter) . "</button>";
        }

        echo "</form>";

        if (strlen($rack) > 7) { // Warn if not a realistic Scrabble rack (my own addition)
            echo "<p style=\"color: red\">In a real game of Scrabble, a rack cannot hold more than 7 letters.</p>";
        }

        echo "Click a letter above to remove it from the rack. ";
    } else {
        echo "The rack is empty. ";
    }
?>

Click a letter below to add it to the rack.

<br>
<br>

<form action="index.php" method="post">

<?php
    foreach ($letters as $letter) { // Generate a button for each letter in the alphabet
        echo "<button type=\"submit\" name=\"rack\" value=\"$rack$letter\">" . strtoupper($letter) . "</button>";
    }
?>

</form>

<h2>Words and Scores</h2>

<?php
    if ($rack) {
        $matches = $scrabble->matchInDictionary($rack);

        if ($matches) {
            foreach ($scrabble->matchInDictionary($rack) as $key => $value) { // Display all possible words and their scores
                echo "$key $value<br>";
            }
        } else {
            echo "No words can be made with the letters in the rack.<br>";
        }
    } else {
        echo "No words can be made with an empty rack.<br>";
    }
?>
