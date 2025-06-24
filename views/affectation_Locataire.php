<?php
# DB connection
include '../connexion/connexion.php';
# Selection Querries
require_once("../models/select/select-activite.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Activites</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <?php require_once('style.php'); ?>

</head>

<body>

    <!-- Appel de menues  -->
    <?php require_once('aside.php') ?>
    <main id="main" class="main">
        <div class="row">
            <div class="col-12">
                <h4 class="text-success">Activités</h4>
            </div>
            <!-- pour afficher les massage  -->
            <?php
            if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) { ?>
                <div class="col-xl-12 mt-3">
                    <div class="alert-info alert text-center"><?= $_SESSION['msg'] ?></div>
                </div>
            <?php }
            #Cette ligne permet de vider la valeur qui se trouve dans la session message
            unset($_SESSION['msg']);
            if (isset($_GET['NewShow'])) {
            ?>
                <!-- Le form qui enregistrer les données d'un article  -->
                <div class="col-xl-12 ">
                    <form action="<?= $Action ?>" method="POST" class="shadow p-3">
                        <div class="row">
                            <h5 class="text-center"><?= $title ?></h5>

                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Théme <span class="text-danger">*</span></label>
                                <input required type="text" name="theme" class="form-control" placeholder="Entrez le nom" <?php if (isset($_GET['idMembre'])) { ?>value="<?= $element['nom'] ?>" <?php } ?>>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Lieu <span class="text-danger">*</span></label>
                                <input required type="text" name="lieu" class="form-control" placeholder="Entrez le postnom" <?php if (isset($_GET['idMembre'])) { ?>value="<?= $element['postnom'] ?>" <?php } ?>>
                            </div>

                            <?php if (isset($_GET['idMembre'])) {
                            ?>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 mt-4 col-sm-6 p-3 ">
                                    <input type="submit" name="valider" class="btn btn-success w-100" value="Modifier">
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 mt-4 col-sm-6 p-3 ">
                                    <a href="jeunes.php" class="btn btn-danger w-100">Annuler</a>
                                </div>
                            </div>
                                
                            <?php
                            } else {
                            ?>
                                <div class="col-xl-12 col-lg-12 col-md-12 mt-10 col-sm-12 p-3 aling-center">
                                    <input type="submit" name="valider" class="btn btn-success w-100" value="Enregistrer">
                                </div>
                            <?php
                            }
                            ?>

                        </div>
                    </form>
                </div>
            <?php
            } else {
            ?>
                <div class="col-xl-12 col-lg-12 col-md-12 mt-10 col-sm-12 p-3 aling-center">
                    <a href="activite.php?NewShow" class="btn btn-success w-100">Enregistrer une nouvelle activité</a>
                </div>
            <?php
            }
            ?>

            <!-- La table qui affiche les données  -->
            <div class="col-xl-12 table-responsive px-3 mt-3">
                <h5 class="text-center">Listes des activités</h5>
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Date</th>
                            <th>Theme</th>
                            <th>Lieu</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $numero = 0;
                        while ($affiche = $getArticle->fetch()) {
                            $numero++;
                        ?>
                            <tr>
                                <th scope="row"><?php echo $numero ?></th>
                                <td><?php echo $affiche['date'] ?></td>
                                <td><?php echo $affiche['Theme'] ?></td>
                                <td><?php echo $affiche['lieu'] ?></td>
                                <td>
                                    <a href="Membre.php?NewMember&idMembre=<?php echo $affiche['id'] ?>" class="btn btn-success btn-sm mt-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a onclick=" return confirm('Voulez-vous vraiment supprimer cette information ?')" href="../models/delete/deletjeunes.php?idMembre=<?php echo $affiche['id'] ?>" class="btn btn-danger btn-sm mt-2">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Exemple pour ajouter un bâtiment -->
        <form method="POST" class="max-w-md mx-auto mt-8 p-4 bg-white rounded shadow">
            <div class="mb-4">
                <label class="block text-gray-700">Nom du bâtiment</label>
                <input type="text" name="name" class="mt-1 block w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Adresse</label>
                <input type="text" name="address" class="mt-1 block w-full border rounded p-2" required>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Enregistrer</button>
        </form>
    </main><!-- End #main -->
    <?php require_once('script.php') ?>

</body>

</html>