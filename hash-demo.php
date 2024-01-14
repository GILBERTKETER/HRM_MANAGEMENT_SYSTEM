<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Hash the password
    if (isset($_POST['hash'])) {
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    }

    // Dehash the password
    if (isset($_POST['dehash'])) {
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $hashedPasswordToDehash = $_POST['hashedPassword'];
        $isMatch = password_verify($password, $hashedPasswordToDehash);
        $dehashedPassword = $isMatch ? 'Password Matched!' : 'Password does not match.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Hashing Example</title>
</head>

<body>
    <form method="post">
        <label for="password">Enter Password:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit" name="hash">Hash</button>
        <br>

        <?php if (isset($hashedPassword)) : ?>
            <label for="hashedPassword">Hashed Password:</label>
            <input type="text" name="hashedPassword" id="hashedPassword" value="<?= $hashedPassword ?>" readonly>
        <?php endif; ?>

        <?php if (isset($dehashedPassword)) : ?>
            <br>
            <label for="dehashedPassword">Dehashed Password:</label>
            <input type="text" name="dehashedPassword" id="dehashedPassword" value="<?= $dehashedPassword ?>" readonly>
        <?php endif; ?>

        <br>
        <button type="submit" name="dehash">Dehash</button>
    </form>
</body>

</html>
