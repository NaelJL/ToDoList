<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="main.js" defer></script>
    <title>To Do List</title>
</head>

<body>
    <?php
    $pdo = new PDO('sqlite:db.sqlite', null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);

    $error = null;

    try {
        // enregistrer la nouvelle tâche dans la table todo
        if (isset($_POST['add'])) {
            if (!empty($_POST['add'])) {

                $task_ok = trim(htmlspecialchars($_POST['add']));

                $query = $pdo->prepare('INSERT INTO todo (task) VALUES (:task)');
                $query->execute([
                    'task' => $task_ok
                ]);
            }
        }

        // afficher les tâches
        $all = $pdo->query('SELECT * FROM todo');
        $tasks = $all->fetchAll();
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
    ?>

    <main>
        <header>
            <p>
                Nous sommes le
                <?php
                date_default_timezone_set('Europe/Paris');
                $date_actual = time();
                $format_date = 'd/m/Y';
                $date = date($format_date, $date_actual);
                echo $date;
                ?>
                , il est
                <?php
                $format_date = 'H:i';
                $hour = date($format_date, $date_actual);
                echo $hour;
                ?>
            </p>
            <form action="" method="POST" class="add-task-form">
                <input type="text" id="add" name="add" value="" placeholder="Ajouter une nouvelle tâche" />
                <input type="submit" value="Sauvegarder" />
            </form>
        </header>

        <section>
            <h3>Les choses à faire :</h3>
            <?php
            foreach ($tasks as $task) :
            ?>
                <div class="task">
                    <div class="icons">
                        <!-- Supprimer une tâche -->
                        <form action="./delete.php" method="POST">
                            <input type="hidden" name="delete" value="<?php echo $task->id ?>" />
                            <button><img src="./ressources/cross.png" class="logo" alt="supprimer la tâche" /></button>
                        </form>
                        <!-- Modifier une tâche -->
                        <img src="./ressources/edit.png" class="logo" id="edit_logo" alt="modifier la tâche" />
                    </div>
                    <div class="edit">
                        <form action="./edit.php" method="POST" class="edit-form">
                            <input type="text" name="edit" value="" />
                            <input type="hidden" name="id" value="<?php echo $task->id ?>" />
                            <input type="submit" />
                        </form>
                    </div>
                    <!-- Afficher une tâche -->
                    <p><?php echo $task->task ?></p>
                </div>
            <?php endforeach ?>
        </section>
    </main>

</body>

</html>