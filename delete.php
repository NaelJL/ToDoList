<?php
$pdo = new PDO('sqlite:db.sqlite', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);

// supprimer une tâche
if (isset($_POST['delete'])) {
    if (!empty($_POST['delete'])) {
        if (strlen($_POST['delete']) <= 3) {
            $id = intval($_POST['delete']);

            $query = $pdo->prepare('DELETE FROM todo WHERE id = :id');
            $query->execute([
                'id' => $id
            ]);

            Header('location:index.php');
        }
    }
}
