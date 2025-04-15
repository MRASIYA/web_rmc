<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

if (isset($_POST['data']) && !empty($_POST['data'])) {
    $data = json_decode($_POST['data'], true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        die("❌ JSON decode error: " . json_last_error_msg());
    }

    if (is_array($data)) {
        $stmt = $conn->prepare("INSERT INTO entries (name, quantity) VALUES (?, ?)");

        foreach ($data as $item) {
            $name = $item['name'];
            $quantity = (int)$item['quantity'];
            $stmt->bind_param("si", $name, $quantity);
            $stmt->execute();
        }

        $stmt->close();
        echo "✅ Data saved to RMC Counting Form! <a href='index.php'>Back</a>";
    } else {
        echo "❌ Data is not an array.";
    }
} else {
    echo "❌ No data received!";
}
$conn->close();
?>
