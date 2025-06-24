<?php
# Se connecter à la BD
include '../connexion/connexion.php';
# Appel de la page qui fait les affichages
require_once('../models/select/select-utilisateur.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Utilisateurs</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <?php require_once('style.php'); ?>

</head>

<body>

    <!-- Appel de menues  -->
    <?php require_once('aside.php'); ?>

    <main id="main" class="main">
        <div class="row">
            <div class="col-12">
                <h4 class=""><?= $title ?></h4>
            </div>
            <!-- pour afficher les massage  -->
            <?php if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) {
            ?>
                <div class="alert-info alert text-center">
                    <?php echo $_SESSION['msg']; ?>
                </div>
            <?php
            }
            unset($_SESSION['msg']);
            if (isset($_GET['NewUser'])) {
            ?>
                <div class="col-xl-12 ">
                    <form action="<?= $url ?>" method="POST" class="shadow p-3" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4  col-sm-6 p-3">
                                <label for="">Nom <span class="text-danger">*</span></label>
                                <input autocomplete="off" name="nom" required type="text" class="form-control"
                                    placeholder="EX: Muhindo" <?php if (isset($_GET['iduser'])) { ?>value="<?= $element['nom'] ?>" <?php } ?>>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4  col-sm-6 p-3">
                                <label for="">Postnom <span class="text-danger">*</span></label>
                                <input autocomplete="off" name="postnom" required type="text" class="form-control"
                                    placeholder="EX: Kombi" <?php if (isset($_GET['iduser'])) { ?>value="<?= $element['postnom'] ?>" <?php } ?>>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4  col-sm-6 p-3">
                                <label for="">Prenom <span class="text-danger">*</span></label>
                                <input autocomplete="off" name="prenom" required type="text" class="form-control"
                                    placeholder="EX: Glad" <?php if (isset($_GET['iduser'])) { ?>value="<?= $element['prenom'] ?>" <?php } ?>>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4  col-sm-4 p-3">
                                <label for="">telephone</span></label>
                                <input autocomplete="off" required type="text" class="form-control" placeholder="+243....." id="telephone" name="telephone" <?php if (isset($id)) { ?> value="<?= $element['telephone'] ?>" <?php } ?>>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-4  col-sm-6 p-3">
                                <label for="">Password <span class="text-danger">*</span></label>
                                <input autocomplete="off" name="pwd" required type="text" class="form-control"
                                    placeholder="EX: ********" <?php if (isset($_GET['iduser'])) { ?>value="<?= $element['pwd'] ?>" <?php } ?>>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4  col-sm-4 p-3">
                                <label for="">Fonction <span class="text-danger">*</span></label>
                                <select required id="" name="fonction" class="form-select">
                                    <?php
                                    if (isset($_GET['idUser'])) {
                                        $EtatCvl = $element['fonction'];
                                        if ($EtatCvl == "Admin") {
                                    ?>
                                            <option value="Admin" Selected>Administrateur</option>
                                            <option value="coordonateur">Coodonateur</option>
                                            <option value="Comunity">Community M.</option>
                                        <?php
                                        } else if ($EtatCvl == "coordonateur") {
                                        ?>
                                            <option value="Admin">Administrateur</option>
                                            <option value="coordonateur" Selected>Coodonateur</option>
                                            <option value="Comunity">Community M.</option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="Admin">Administrateur</option>
                                            <option value="coordonateur">Coodonateur</option>
                                            <option value="Comunity" Selected>Community M.</option>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <option value="Admin">Administrateur</option>
                                        <option value="coordonateur">Coodonateur</option>
                                        <option value="Comunity">Community M.</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4  col-sm-6 p-3">
                                <label for="">Photo de profil<span class="text-danger">*</span></label>
                                <input autocomplete="off" value="" name="picture" class="img-fluid" type="file" class="form-control" placeholder="Aucun fichier">
                            </div>
                            <?php if (isset($_GET['iduser'])) {
                            ?>
                                <div class="col-xl-6 col-lg-6 col-md-6 mt-4 col-sm-6 p-3 ">
                                    <input type="submit" name="modifier" class="btn btn-success w-100" value="Modifier">
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 mt-4 col-sm-6 p-3 ">
                                    <a href="utilisateur.php" class="btn btn-danger w-100">Annuler</a>
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
                    <a href="utilisateur.php?NewUser" class="btn btn-success w-100">Enregistrer un nouvel utilisateur</a>
                </div>
            <?php
            }
            ?>

            <!-- La table qui affiche les données  -->
            <div class="col-xl-12 table-responsive px-3 mt-3">
                <h5 class="text-center">Listes des Utilisateurs</h5>
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Noms</th>
                            <th>Fonction</th>
                            <th>Telephone</th>
                            <th>Password</th>
                            <th>Mail</th>
                            <th>Profile</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $n = 0;
                        while ($idUser = $getData->fetch()) {
                            $n++;
                        ?>
                             <tr>
                                <th scope="row"><?php echo $n ?></th>
                                <td><?php echo $idUser['nom'] . " " . $idUser['postnom'] . " " . $idUser['prenom'] ?></td>                                
                                <td><?php echo $idUser['fonction'] ?></td>
                                <td><?php echo $idUser['telephone'] ?></td>
                                <td><?php echo $idUser['pwd'] ?></td>
                                <td><?php echo $idUser['user_name'] ?></td>
                                <td><img src="../assets/img/profiles/<?= $idUser["profil"] ?>" alt="" class="rounded-circle mt-2" width="65px" height="60px"></td>
                                <td>
                                    <a href="utilisateur.php?NewUser&idUser=<?php echo $idUser['id'] ?>" class="btn btn-success btn-sm mt-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a onclick=" return confirm('Voulez-vous vraiment supprimer cette information ?')" href="../models/delete/deletjeunes.php?idMembre=<?php echo $idUser['id'] ?>" class="btn btn-danger btn-sm mt-2">
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
    </main><!-- End #main -->
    <?php require_once('script.php') ?>

</body>

</html>