<?php
// # DB connection
// include 'connexion/connexion.php';
// # Selection Querries
// require_once("models/select/select-article.php");
?>
<?php
$chambres = [
    ['id' => 1, 'numero' => '101', 'type' => 'Simple', 'prix' => '50.00'],
    ['id' => 2, 'numero' => '102', 'type' => 'Double', 'prix' => '75.00'],
];

$editId = isset($_GET['edit']) ? intval($_GET['edit']) : null;
$chambreEdit = null;

if ($editId) {
    foreach ($chambres as $c) {
        if ($c['id'] === $editId) {
            $chambreEdit = $c;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr" class="<?php echo $theme === 'dark' ? 'dark' : ''; ?>">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Chambres</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Tailwind CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3/dist/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Active le mode sombre par classe -->
    <script>
        tailwind.config = {
            darkMode: 'class'
        };
    </script>

</head>

<body class="bg-gray-100 text-gray-100 <?php if (isset($_POST['ajouter'])) echo 'overflow-hidden'; ?>">

    <!-- Appel de menues  -->
    <?php require_once('aside.php') ?>

    <!-- Contenu principal -->
    <main class="ml-64 pt-6 p-4">
        <!-- Formulaire pour afficher le bouton "Ajouter une chambre" -->
        <div class="flex justify-between items-center mb-4 mt-10">
            <h2 class="text-xl font-bold text-gray-900 text-center">Liste des chambres</h2>
            <form method="post">
                <button type="submit" name="ajouter" value="1"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 font-semibold shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Chambre
                </button>
            </form>


        </div>

        <!-- Formulaire d'ajout de chambre affiché seulement si on a cliqué -->
        <?php if (isset($_POST['ajouter']) || $editId): ?>
            <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
                <form action="<?= $editId ? 'modifier.php' : 'traitement.php' ?>" method="post"
                    class="bg-gray-900 text-white p-6 rounded-2xl shadow-2xl w-full max-w-lg mx-4">
                    <h3 class="text-xl font-bold mb-6 text-center">
                        <?= $editId ? 'Modifier la chambre' : 'Ajouter une chambre' ?>
                    </h3>

                    <?php if ($editId): ?>
                        <input type="hidden" name="id" value="<?= $chambreEdit['id'] ?>">
                    <?php endif; ?>

                    <div class="mb-4">
                        <label for="numero" class="block text-gray-300 mb-1">Numéro de chambre</label>
                        <input type="text" name="numero" id="numero" required
                            value="<?= $editId ? htmlspecialchars($chambreEdit['numero']) : '' ?>"
                            class="w-full px-4 py-2 border border-gray-700 bg-gray-800 text-white rounded" />
                    </div>

                    <div class="mb-4">
                        <label for="type" class="block text-gray-300 mb-1">Type</label>
                        <input type="text" name="type" id="type" required
                            value="<?= $editId ? htmlspecialchars($chambreEdit['type']) : '' ?>"
                            class="w-full px-4 py-2 border border-gray-700 bg-gray-800 text-white rounded" />
                    </div>

                    <div class="mb-6">
                        <label for="prix" class="block text-gray-300 mb-1">Prix</label>
                        <input type="number" name="prix" id="prix" step="0.01" required
                            value="<?= $editId ? htmlspecialchars($chambreEdit['prix']) : '' ?>"
                            class="w-full px-4 py-2 border border-gray-700 bg-gray-800 text-white rounded" />
                    </div>

                    <div class="flex justify-between">
                        <a href="?" class="px-4 py-2 rounded bg-red-500 hover:bg-gray-600 text-white font-semibold">
                            Annuler
                        </a>
                        <button type="submit"
                            class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white font-semibold">
                            <?= $editId ? 'Modifier' : 'Ajouter' ?>
                        </button>
                    </div>

                </form>
            </div>
        <?php endif; ?>

        <!-- Tableau -->
        <section>
            <div class="overflow-x-auto">
                <table id="search-table" class="min-w-full bg-white dark:bg-gray-800 rounded shadow text-sm">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-100">
                            <th class="px-4 py-2">Numéro</th>
                            <th class="px-4 py-2">Type</th>
                            <th class="px-4 py-2">Prix</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($chambres as $chambre): ?>
                            <tr class="border-t dark:border-gray-700">
                                <td class="px-4 py-2"><?= htmlspecialchars($chambre['numero']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($chambre['type']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($chambre['prix']) ?> €</td>
                                <td class="px-4 py-2 flex gap-2">
                                    <!-- Modifier -->
                                    <a href="?edit=<?= $chambre['id'] ?>"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded inline-flex items-center"
                                        title="Modifier">
                                        ✏️
                                    </a>

                                    <!-- Supprimer -->
                                    <form method="post" action="supprimer.php" onsubmit="return confirm('Supprimer cette chambre ?');">
                                        <input type="hidden" name="id" value="<?= $chambre['id'] ?>">
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded"
                                            title="Supprimer">
                                            🗑️
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </section>
    </main>



    <script>
        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#search-table", {
                searchable: true,
                sortable: true
            });
        }
    </script>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Simple DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3/dist/style.css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3" defer></script>

</body>


</html>