<?php
// Database configuration
$host = 'localhost';
$dbname = 'todo_list';
$username = 'root';
$password = ''; // Consider using environment variables for sensitive information

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the task_name parameter is set in the POST request
    if (isset($_POST['task_name']) && !empty($_POST['task_name'])) {
        // Get the task_name from the POST request
        $task_name = $_POST['task_name'];

        // Prepare SQL statement to insert a new task into the tasks table
        $stmt = $pdo->prepare("INSERT INTO tasks (task_name) VALUES (:task_name)");

        // Bind parameters and execute the statement
        $stmt->bindParam(':task_name', $task_name, PDO::PARAM_STR);
        $stmt->execute();

        // Return JSON response with success message
        echo json_encode(['status' => 'success', 'message' => 'Task added successfully.']);
    } else {
        // Return JSON response with error message
        echo json_encode(['status' => 'error', 'message' => 'Task name is required.']);
    }
} catch (PDOException $e) {
    // Return JSON response with error message
    echo json_encode(['status' => 'error', 'message' => 'Error adding task: ' . $e->getMessage()]);
}
?>
