<?php
include 'db.php';

// Add task
if (isset($_POST['add'])) {
    $task = $_POST['task'];
    $typeId = $_POST['type_id'];

    $addSql = $conn->prepare("INSERT INTO tasks (task, type_id) VALUES (?, ?)");
    $addSql->bind_param("si", $task, $typeId);
    $addSql->execute();
    $addSql->close();

    header("Location: index.php");
}

// Delete task
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $deleteSql = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $deleteSql->bind_param("i", $id);
    $deleteSql->execute();
    $deleteSql->close();

    header("Location: index.php");
}

$conn->close();
?>
