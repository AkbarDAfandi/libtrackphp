<?php
include 'configs/db.php';
$sql = "SELECT content FROM views WHERE title = 'Home'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row['content'];
} else {
    echo "Content not found.";
}
