<?php
// Get the raw POST data
$input = file_get_contents('php://input');

// Decode the JSON data
$data = json_decode($input, true);

// Check if the necessary fields are provided
if (isset($data['todoID']) && isset($data['done'])) {
    $todoID = $data['todoID'];
    $done = $data['done'];

    // You can connect to your database here and update the task
    include 'connection.php';  // Assuming connection.php has the DB connection logic

    // Update the task's done status
    if ($done == 1) {
        $sql = "UPDATE tasks SET done = 'Complete' WHERE id = $todoID";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(['success' => true, 'message' => 'Task marked as done']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating task']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid done status']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing required data']);
}

?>
