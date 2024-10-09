<?php 
include 'config/db.php';

$sql = "SELECT content FROM views WHERE title = 'Contact' ";
$stmt = $pdo->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo $row['content'];
} else {
    echo "Content not found.";
}