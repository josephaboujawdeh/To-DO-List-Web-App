<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags necessary for Bootstrap and responsive design -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Day To-Do List</title>
    <!-- Bootstrap CSS for styling and responsiveness -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Custom CSS file for additional styles -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
// Include the database connection file
include 'db.php';

// Fetch types for the dropdown from the database
$typeSql = "SELECT * FROM types";
$typeResult = $conn->query($typeSql);
?>

<!-- Main container for the to-do app -->
<div class="todo-app-container">
    <!-- Header section with logo and date -->
    <div class="app-header">
        <img src="logo.png" alt="App Logo">
        <h2>My Day</h2>
        <div class="app-date"><?php echo date("l, F j"); ?></div>
    </div>
    
    <!-- Form for adding a new task -->
    <form action="task.php" method="POST" class="row">
        <!-- Input field for entering a new task -->
        <div class="col-8">
            <input type="text" class="form-control task-input" name="task" placeholder="Enter a new task" required>
        </div>
        <!-- Dropdown for selecting task type -->
        <div class="col-2">
            <select name="type_id" class="form-control" required>
                <option value="">Type</option>
                <?php
                // Loop through each type and create a dropdown option
                if ($typeResult->num_rows > 0) {
                    while($typeRow = $typeResult->fetch_assoc()) {
                        echo "<option value='" . $typeRow["id"] . "'>" . $typeRow["type_name"] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <!-- Button to add the new task -->
        <div class="col-2">
            <button type="submit" name="add" class="btn btn-primary w-100 add-task-btn">Add Task</button>
        </div>
    </form>

    <!-- List to display tasks -->
    <ul>
        <?php
        // SQL query to fetch tasks and their types
        $taskSql = "SELECT tasks.*, types.type_name FROM tasks LEFT JOIN types ON tasks.type_id = types.id";
        $taskResult = $conn->query($taskSql);

        // Display each task with its type
        if ($taskResult->num_rows > 0) {
            while($taskRow = $taskResult->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($taskRow["task"]) . " - " . htmlspecialchars($taskRow["type_name"]);
                // Link to delete the task
                echo "<a href='task.php?delete=" . $taskRow["id"] . "'>Delete</a></li>";
            }
        } else {
            echo "<li>No tasks yet</li>";
        }
        ?>
    </ul>
</div>

<!-- Bootstrap scripts for interactivity and responsiveness -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
