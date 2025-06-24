<?php
# DB connection
include '../connexion/connexion.php';
# Selection Querries
require_once("../models/select/select-membre.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Membres</title>
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
                <h4 class="text-success">Membres</h4>
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
            if (isset($_GET['NewMember'])) {
            ?>
                <!-- Le form qui enregistrer les données du membre   -->
                <div class="col-xl-12 ">
                    <form action="<?= $Action ?>" method="POST" class="shadow p-3" enctype="multipart/form-data">
                        <div class="row">
                            <h4 class="text-center"><?= $title ?></h4>

                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Nom <span class="text-danger">*</span></label>
                                <input required type="text" name="nom" class="form-control" placeholder="Entrez le nom" <?php if (isset($_GET['idMembre'])) { ?>value="<?= $element['nom'] ?>" <?php } ?>>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Postnom <span class="text-danger">*</span></label>
                                <input required type="text" name="postnom" class="form-control" placeholder="Entrez le postnom" <?php if (isset($_GET['idMembre'])) { ?>value="<?= $element['postnom'] ?>" <?php } ?>>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Prenom <span class="text-danger">*</span></label>
                                <input required type="text" name="prenom" class="form-control" placeholder="Entrez le prenom" <?php if (isset($_GET['idMembre'])) { ?>value="<?= $element['prenom'] ?>" <?php } ?>>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Genre <span class="text-danger">*</span></label>
                                <select required id="" name="genre" class="form-control select2">
                                    <?php
                                    if (isset($_GET['idMembre'])) {
                                    ?>

                                        <?php if ($tab['genre'] == 'Masculin') { ?>
                                            <option value="Masculin" Selected>Masculin</option>
                                            <option value="Feminin">Feminin</option>

                                        <?php } else {
                                        ?>
                                            <option value="Masculin">Masculin</option>
                                            <option value="Feminin" Selected>Feminin</option>

                                        <?php }
                                    } else {
                                        ?>
                                        <option value="" desabled>Choisir un genre</option>
                                        <option value="Masculin">Masculin</option>
                                        <option value="Feminin">Feminin</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Date de naissance <span class="text-danger">*</span></label>
                                <input required type="date" name="dateNaiss" class="form-control" placeholder="Entrer votre date de naissance" <?php if (isset($_GET['idMembre'])) { ?>value="<?= $element['dateNaissance'] ?>" <?php } ?>>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Etat civil <span class="text-danger">*</span></label>
                                <select required id="" name="EtatCivil" class="form-select">
                                    <?php
                                    if (isset($_GET['idMembre'])) {
                                        $EtatCvl = $element['etatCivil'];
                                        if ($EtatCvl == "Celibataire") {
                                    ?>
                                            <option value="Celibataire" Selected>Célibataire</option>
                                            <option value="Fiance">Fiancé(e)</option>
                                            <option value="Marie">Marié(e)</option>
                                        <?php
                                        } else if ($EtatCvl == "Fiance") {
                                        ?>
                                            <option value="Celibataire">Célibataire</option>
                                            <option value="Fiance" Selected>Fiancé(e)</option>
                                            <option value="Marie">Marié(e)</option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="Celibataire">Célibataire</option>
                                            <option value="Fiance">Fiancé(e)</option>
                                            <option value="Marie" Selected>Marié(e)</option>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <option value="Celibataire">Célibataire</option>
                                        <option value="Fiance">Fiancé(e)</option>
                                        <option value="Marie">Marié(e)</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Adresse <span class="text-danger">*</span></label>
                                <input required type="text" name="adress" class="form-control" placeholder="Entrez l'adresse" <?php if (isset($_GET['idMembre'])) { ?>value="<?= $element['adress'] ?>" <?php } ?>>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Ville <span class="text-danger">*</span></label>
                                <select required id="" name="ville" class="form-select ">
                                    <?php
                                    while ($Ville = $getVille->fetch()) {
                                        if (isset($_GET['idMembre'])) {
                                            $VilleModif=$element['ville'];
                                    ?>
                                            <option <?php if ($VilleModif == $Ville['id']) { ?>Selected <?php } ?> value="<?= $Ville['id'] ?>"><?= $Ville['nom'] ?></option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="<?= $Ville['id'] ?>"><?= $Ville['nom'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Telephone <span class="text-danger">*</span></label>
                                <input required type="text" name="telephone" class="form-control" placeholder="Entrez le N° Tel" <?php if (isset($_GET['idMembre'])) { ?>value="<?= $element['telephone'] ?>" <?php } ?>>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Profession<span class="text-danger">*</span></label>
                                <input required type="text" name="profession" class="form-control" placeholder="Entrez votre profession" <?php if (isset($_GET['idMembre'])) { ?>value="<?= $element['profession'] ?>" <?php } ?>>
                            </div>

                            <?php if (isset($_GET['idMembre'])) {
                            ?>
                                <div class="col-xl-6 col-lg-6 col-md-6 mt-4 col-sm-6 p-3 ">
                                    <input type="submit" name="valider" class="btn btn-success w-100" value="Modifier">
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 mt-4 col-sm-6 p-3 ">
                                    <a href="jeunes.php" class="btn btn-danger w-100">Annuler</a>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="col-xl-4 col-lg-4 col-md-4  col-sm-6 p-3">
                                    <label for="">Photo de profil<span class="text-danger">*</span></label>
                                    <input autocomplete="off" value="" name="picture" class="img-fluid" type="file" class="form-control" placeholder="Aucun fichier">
                                </div>
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
                    <a href="Membre.php?NewMember" class="btn btn-success w-100">Enregistrer un nouveau membre</a>
                </div>
            <?php
            }
            ?>

            <!-- La table qui affiche les données  -->
            <div class="col-xl-12 table-responsive px-3 mt-3">
                <h5 class="text-center">Listes des Membres</h5>
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nom</th>
                            <th>Genre</th>
                            <th>Age</th>
                            <th>Adresse</th>
                            <th>Etat civil</th>
                            <th>Profession</th>
                            <th>Tel</th>
                            <th>Ville</th>
                            <th>Profil</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $numero = 0;
                        while ($affiche = $getMember->fetch()) {
                            $numero++;
                            $age = $affiche['age'];
                        ?>
                            <tr>
                                <th scope="row"><?php echo $numero ?></th>
                                <td><?php echo $affiche['nom'] . " " . $affiche['postnom'] . " " . $affiche['prenom'] ?></td>

                                <td><?php echo $affiche['genre'] ?></td>
                                <?php
                                if ($age > 12) {
                                ?>
                                    <td><?php echo $age ?> Ans</td>
                                <?php
                                } else {
                                ?>
                                    <td class="text-danger"><?php echo $age ?> Ans</td>
                                <?php
                                }
                                ?>
                                <td><?php echo $affiche['adress'] ?></td>
                                <td><?php echo $affiche['etatCivil'] ?></td>
                                <td><?php echo $affiche['profession'] ?></td>
                                <td><?php echo $affiche['telephone'] ?></td>
                                <td><?php echo $affiche['NomVille'] ?></td>
                                <td><img src="../assets/img/profiles/<?= $affiche["photo"] ?>" alt="" class="rounded-circle mt-2" width="65px" height="60px"></td>
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
    </main><!-- End #main -->
    <?php require_once('script.php') ?>

</body>

</html>