<?php
require_once('config.php');

$sql = "SELECT nome, COUNT(*) as count FROM receitas GROUP BY nome HAVING COUNT(*) > 1;";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Duplicate Recipes Found:\n";
    while($row = $result->fetch_assoc()) {
        echo "- " . $row['nome'] . " (Count: " . $row['count'] . ")\n";
    }
} else {
    echo "No duplicate recipes found.\n";
}

$conn->close();
?>
