<?php

session_start();

if (!isset($_SESSION["tarefas"])) {
    $_SESSION["tarefas"] = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $acao = $_POST["acao"] ?? "";

    if ($acao == "adicionar") {
        $tarefa = trim($_POST["tarefa"] ?? "");

        if ($tarefa != "") {
            $_SESSION["tarefas"][] = $tarefa;
        }
    }

    if ($acao == "remover") {
        $indice = (int) ($_POST["indice"] ?? -1);

        if (isset($_SESSION["tarefas"][$indice])) {
            unset($_SESSION["tarefas"][$indice]);
            $_SESSION["tarefas"] = array_values($_SESSION["tarefas"]);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Minha To-Do List</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 40px auto;
            padding: 0 20px;
            background-color: #f4f4f4;
        }

        h1 {
            color: #333;
        }

        form {
            display: flex;
            gap: 8px;
        }

        input {
            flex: 1;
            padding: 10px;
        }

        button {
            padding: 10px 14px;
            cursor: pointer;
        }

        ul {
            padding: 0;
            list-style: none;
        }

        li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            padding: 12px;
            background-color: white;
            border: 1px solid #ddd;
        }

        li form {
            margin-left: 12px;
        }
    </style>

</head>

<body>

    <h1>Minha To-Do List</h1>

    <form method="POST">

        <input type="hidden" name="acao" value="adicionar">

        <input
            type="text"
            name="tarefa"
            placeholder="Digite uma tarefa"
            required
        >

        <button type="submit">
            Adicionar
        </button>

    </form>

    <?php if (count($_SESSION["tarefas"]) > 0): ?>
        <ul>
            <?php foreach ($_SESSION["tarefas"] as $indice => $tarefa): ?>
                <li>
                    <span><?= htmlspecialchars($tarefa) ?></span>

                    <form method="POST">
                        <input type="hidden" name="acao" value="remover">
                        <input type="hidden" name="indice" value="<?= $indice ?>">
                        <button type="submit">Remover</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Nenhuma tarefa adicionada.</p>
    <?php endif; ?>

</body>

</html>