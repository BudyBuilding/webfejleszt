<?php
// Ellenőrizzük, hogy a POST kérés érkezett-e
function decodeString($encodedString, $shiftValues) {
    $decodedString = '';
    $shiftCount = count($shiftValues);
    
    // Iterate through each character in the encoded string
    for ($i = 0; $i < strlen($encodedString); $i++) {
        // If it's not an EOL (A0), apply the reverse shift
        if ($encodedString[$i] !== "\xA0") {
            $decodedChar = ord($encodedString[$i]) - $shiftValues[$i % $shiftCount];

            // Ensure the result is within the valid ASCII range (32 to 126)
            while ($decodedChar < 32) {
                $decodedChar += 95; // Wrap around to the end of the printable ASCII characters
            }

            $decodedString .= chr($decodedChar);
        } else {
            // If it's an EOL, simply append it to the decoded string
            $decodedString .= "\xA0";
        }
    }

    return $decodedString;
}

$shiftValues = [5, -14, 31, -9, 3]; // Your shift values

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fogadjuk el a felhasználói adatokat a formból
    $input_username = $_POST["username"];
    $input_password = $_POST["password"];

    // Assuming you have a database connection established, replace these values with your actual database credentials
    $host = "localhost";
    $db_username = "id21550826_admin";
    $db_password = "Nefelejsdel.1";
    $db_name = "id21550826_adatok";

    // Create a new MySQLi instance
    $mysqli = new mysqli($host, $db_username, $db_password, $db_name);

    // Check the connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Ellenőrizzük, hogy a password.txt fájl létezik-e
    if (file_exists("password.txt")) {
        // Olvassuk be a password.txt tartalmát soronként
        $lines = file("password.txt", FILE_IGNORE_NEW_LINES);

        // Ellenőrizzük, hogy a felhasználónév megtalálható-e a fájlban
        foreach ($lines as $line) {
            $decoded = decodeString($line, $shiftValues);
            $parts = explode("*", $decoded);
            $stored_username = trim($parts[0]);
            $stored_password = trim($parts[1]);

            if ($input_username === $stored_username && $input_password === $stored_password) {
                echo "Sikeres bejelentkezés!";

                // Your SQL query
                $sql = "SELECT titkos FROM tabla WHERE Username = ?";
                
                // Use prepared statements to prevent SQL injection
                $stmt = $mysqli->prepare($sql);

                // Bind the parameter
                $stmt->bind_param("s", $stored_username);

                // Execute the query
                $stmt->execute();

                // Bind the result variable
                $stmt->bind_result($titkos);

                // Fetch the results
                while ($stmt->fetch()) {
                    // Process each date
                    //if $titkos is zold the the background color should be green, if piros then red, if sarga then yellow, if kek then blue, if fekete then black and if feher then white
                    $backgroundColor = '';

                    switch ($titkos) {
                        case 'zold':
                            $backgroundColor = 'green';
                            break;
                        case 'piros':
                            $backgroundColor = 'red';
                            break;
                        case 'sarga':
                            $backgroundColor = 'yellow';
                            break;
                        case 'kek':
                            $backgroundColor = 'blue';
                            break;
                        case 'fekete':
                            $backgroundColor = 'black';
                            break;
                        case 'feher':
                            $backgroundColor = 'white';
                            break;
                        default:
                            // Handle other cases or set a default color
                            $backgroundColor = 'grey';
                    }
                
                }
                

                // Close the statement
                $stmt->close();

                // Close the database connection
                $mysqli->close();

                echo "<style>body { background-color: $backgroundColor; }</style>";
                exit;
            }
        }
    }

    // Ha a felhasználónév vagy a jelszó nem megfelelő, hibaüzenetet jelenítünk meg
    echo "Hibás felhasználónév vagy jelszó!";
}
?>
