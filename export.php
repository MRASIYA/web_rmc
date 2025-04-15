<?php
include 'db.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=entries.csv');

$output = fopen("php://output", "w");
fputcsv($output, ['Name', 'Quantity']);

$result = $conn->query("SELECT name, quantity FROM entries");
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}
fclose($output);
$conn->close();
exit();
?>
