<?php
$pdo = new PDO('sqlite:db.sqlite', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);

// modifier une tâche
if (isset($_POST['edit'])) {
    if (!empty($_POST['edit'])) {
        $new_task = trim(htmlspecialchars($_POST['edit']));

        if (isset($_POST['id'])) {
            if (!empty($_POST['id'])) {
                if (strlen($_POST['id']) <= 3) {
                    $id = intval($_POST['id']);

                    $query = $pdo->prepare('UPDATE todo SET task = :task WHERE id = :id');
                    $query->execute([
                        'task' => $new_task,
                        'id' => $id
                    ]);

                    Header('location:index.php');
                }
            }
        }
    }
}
