<?php
session_start();

if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task'])) {
    $task = trim($_POST['task']);
    if ($task) {
        $_SESSION['tasks'][] = $task;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $taskToDelete = $_POST['delete'];
    $_SESSION['tasks'] = array_filter($_SESSION['tasks'], function($task) use ($taskToDelete) {
        return $task !== $taskToDelete;
    });
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">To-Do List</h1>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form method="POST" action="">
                    <div class="form-group">
                        <input type="text" name="task" class="form-control" placeholder="Enter a new task">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Add Task</button>
                </form>
                <ul class="list-group mt-3" id="taskList">
                    <?php foreach ($_SESSION['tasks'] as $task): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo htmlspecialchars($task); ?>
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="delete" value="<?php echo htmlspecialchars($task); ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
