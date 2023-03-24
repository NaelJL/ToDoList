<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Dosis:wght@300&family=Gochi+Hand&display=swap');

        body {
            background: url('ressources/kelly-sikkema-Oz_J_FXKvIs-unsplash_medium.jpg');
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            min-height: 100%;
        }

        main {
            font-family: 'Dosis', sans-serif;
            font-size: 20px;
            color: rgb(8, 21, 31);
            background-color: rgba(221, 222, 226, 0);
            border: none;
            width: 900px;
            height: 510px;
            overflow: scroll;
            margin: 230px auto auto 150px;
        }

        h1 {
            text-shadow: 3px 3px 1px #303039;
            font-family: 'Gochi Hand', sans-serif;
            font-size: 50px;
        }

        h3 {
            margin-top: 50px;
            font-size: 32px;
            font-family: 'Gochi Hand', sans-serif;
            text-shadow: 1.5px 1.5px 1px #303039;
        }

        .add-task {
            margin: 40px auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .add-task input[type='text'] {
            font-family: 'Dosis', sans-serif;
            font-size: 16px;
            border-radius: 5px;
            border: 0.5px solid rgb(60, 59, 59);
            padding: 7px;
            width: 350px;
            background-color: transparent;
            color: rgb(36, 36, 36);
        }

        input[type="submit"] {
            width: 100px;
            font-size: 16px;
            font-family: 'Dosis', sans-serif;
            color: rgb(60, 59, 59);
            border-radius: 5px;
            padding: 7px;
            border: 0.5px solid rgb(60, 59, 59);
            background: transparent;
        }

        input[type="submit"]:hover {
            color: rgb(0, 0, 0);
            text-shadow: 0.8px 0.8px 0.8px grey;
        }

        button {
            border: none;
            background-color: transparent;
        }

        .task {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: baseline;
            justify-content: baseline;
            gap: 10px;
            margin: 0px;
        }

        .task p {
            padding: none;
        }

        .logo-close {
            width: 20px;
            height: 20px;
            margin: 0px;
        }

        .logo-close:hover {
            cursor: pointer;
        }

        @media only screen and (max-width: 1120px) {
            body {
                background: url('ressources/kseniya-lapteva-qgWQuzpazWw-unsplash.jpg');
            }

            main {
                background-color: rgba(221, 222, 226, 0.8);
                padding: 20px;
                border-radius: 5px;
                margin: 100px auto;
                width: 80%;
            }
        }
    </style>
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
        // récupérer les tâches depuis form et les stocker dans la table
        if (isset($_POST['add'])) {
            if (!empty($_POST['add'])) {

                $task_ok = trim(htmlspecialchars($_POST['add']));

                $query = $pdo->prepare('INSERT INTO todo (task) VALUES (:task)');
                $query->execute([
                    'task' => $task_ok
                ]);
                echo "<p style='color: darkcyan '>La tâche a été ajoutée avec succès.</p>";
            } else {
                echo "<p>Vous devez écrire une nouvelle tâche pour pouvoir l'ajouter.</p>";
            }
        }

        // supprimer la tâche
        if (isset($_POST['id'])) {
            if (!empty($_POST['id'])) {
                $id = trim(htmlspecialchars($_POST['id']));

                $query = $pdo->prepare('DELETE FROM todo WHERE id = :id');
                $query->execute([
                    'id' => $id
                ]);
                echo "<p style='color: hotpink'>La tâche a été supprimée avec succès.</p>";
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
            <h1>To Do list</h1>

            <form action="" method="POST" class="add-task">
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
                    <form action="" method="POST">
                        <input type="hidden" name="id" value="<?php echo $task->id ?>" />
                        <button><img src="./ressources/cross.png" class="logo-close" alt="supprimer la tâche" /></button>
                    </form>
                    <p><?php echo $task->task ?></p>
                </div>
            <?php endforeach ?>
        </section>
    </main>

</body>

</html>