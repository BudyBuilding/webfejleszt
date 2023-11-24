<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Bejelentkezés</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Bejelentkezés</h2>
        <form method="POST" action="feldolgozas.php">
            <label for="username">Felhasználónév:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Jelszó:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <input type="submit" value="Bejelentkezés">
        </form>
    </div>
</body>
</html>
