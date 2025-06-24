<?php
# Se connecter à la BD
include '../connexion/connexion.php';
# Selection Querries
require_once('../models/select/select-ville.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?= $title ?></title>
    <meta content="" name="description">
    <meta content="" name="keywords">    
    <?php require_once('style.php') ?>
</head>

<body>
    <!-- Appel de menues  -->
    <?php require_once('aside.php') ?>
    <main id="main" class="main">
        <div class="row">
            <div class="col-12">
                <h4 class="text-success">Villes</h4>
            </div>
            <!-- pour afficher les massage  -->
            <?php
            if (isset($_GET['idSupVille'])) {
                $id = $_GET["idSupVille"];
            ?>
                <div class="col-xl-12 px-3 card mt-4 px-4 pt-3">
                    <h3 class="bi bi-shield-exclamation text-danger text-center"> Zone Dangereuse</h3> <br>
                    <p class="text-center">
                        Voule-Vous vraiment supprimer une ville ?? <br>
                        Cette action est irreverssible, Assurez-vous que c'est l'action que vous souhaiter
                        réaliser ! Elle permet de supprimer un Partenaire de la base de donneées et toutes les données liées a cet agent.
                    </p>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                            <a href="ville.php" class="btn btn-dark  w-100"> Annler</a>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                            <a href="../models/delete/delete-ville.php?idSupVille=<?= $id ?>" class="btn btn-danger bi bi-trash w-100"> Supprimer une ville</a>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) { ?>
                    <div class="col-xl-12 mt-3">
                        <div class="alert-info alert text-center"><?= $_SESSION['msg'] ?></div>
                    </div>
                <?php }
                #Cette ligne permet de vider la valeur qui se trouve dans la session message
                unset($_SESSION['msg']);

                if (isset($_GET['NewTown'])) {
                ?>
                    <!-- Le form qui enregistrer les villes  -->
                    <div class="col-xl-12 col-lg-12 col-md-6 ">
                        <form class="shadow bg-white p-3" action="<?= $Action ?>" method="POST">
                            <div class="row">
                                <h4 class="text-center"><?= $title ?></h4>
                                <div class="col-xl-12 col-lg-12 col-md-12  col-sm-12 p-3">
                                    <label for="">Nom <span class="text-danger">*</span></label>
                                    <input required type="text" name="nom" class="form-control" placeholder="Entrez le nom de la vie" <?php if (isset($_GET['idVille'])) { ?>value="<?= $element['nom'] ?>" <?php } ?>>
                                </div>
                                <?php if (isset($_GET['idVille'])) {
                                ?>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 mt-4 col-sm-6 p-3 ">
                                            <input type="submit" name="valider" class="btn btn-success w-100" value="Modifier">
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 mt-4 col-sm-6 p-3 ">
                                            <a href="client.php" class="btn btn-danger w-100">Annuler</a>
                                        </div>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="col-xl-12 col-lg-12 col-md-12 mt-10 col-sm-12 p-3 aling-center">
                                        <input type="submit" name="valider" class="btn btn-success w-100" value="<?= $btn ?>">
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
                        <a href="ville.php?NewTown" class="btn btn-success w-100">Enregistrer une nouvelle Ville</a>
                    </div>
            <?php
                }
            }
            ?>
            <!-- La table qui affiche les entree en Fran -->
            <div class="col-xl-12 table-responsive px-3 card mt-4 px-4 pt-3">
                <h5 class="text-center">Listes des Villes</h5>
                <table class="table table-borderless datatable ">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nom de la ville</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $num = 0;
                        while ($ville = $getVille->fetch()) {
                            $num = $num + 1;
                        ?>
                            <tr>
                                <th scope="row"><?= $num ?></th>
                                <td><?= $ville["nom"] ?></td>
                                <td>
                                    <a href="ville.php?NewTown&idVille=<?= $ville["id"] ?>" class="btn btn-success btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="ville.php?idSupVille=<?= $ville["id"] ?>" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>
                                </td>
                            </tr>
                    </tbody>
                <?php
                        }
                ?>
                </table>
            </div>
            <?php

            ?>
        </div>
    </main><!-- End #main -->
    <?php require_once('script.php') ?>
</body>

</html>