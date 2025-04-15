<?php
include 'db.php'; // Include database connection

// Set the filename for the CSV file
$filename = "saved_entries_" . date('Y-m-d_H-i-s') . ".csv";

// Query the database for all saved entries
$sql = "SELECT * FROM entries ORDER BY id DESC";
$result = $conn->query($sql);

// Open the output stream for the CSV file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Open the PHP output stream for writing CSV content
$output = fopen('php://output', 'w');

// Add the header row (column names)
fputcsv($output, ['ID', 'Name', 'Quantity']);

// Fetch each row and write it to the CSV file
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

// Close the output stream
fclose($output);
exit();
?>
