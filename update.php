<?php
include 'db.php';

if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $name = $_POST['name'];
    $quantity = (int)$_POST['quantity'];

    $stmt = $conn->prepare("UPDATE entries SET name = ?, quantity = ? WHERE id = ?");
    $stmt->bind_param("sii", $name, $quantity, $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: index.php");
exit();
?>
