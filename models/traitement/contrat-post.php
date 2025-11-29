<?php
# Se connecter à la BD
include '../../connexion/connexion.php';

// Fonction pour valider les dates
function validerDates($date_debut, $date_fin, $date_paiement) {
    $erreurs = [];
    
    // Vérifier que la date de début est valide
    if (!strtotime($date_debut)) {
        $erreurs[] = "La date de début n'est pas une date valide";
    }
    
    // Vérifier que la date de paiement est valide
    if (!strtotime($date_paiement)) {
        $erreurs[] = "La date limite de paiement n'est pas une date valide";
    }
    
    // Vérifier que la date de début n'est pas dans le futur (optionnel)
    // if (strtotime($date_debut) > time()) {
    //     $erreurs[] = "La date de début ne peut pas être dans le futur";
    // }
    
    // Vérifier que la date de paiement est après la date de début
    if (strtotime($date_paiement) < strtotime($date_debut)) {
        $erreurs[] = "La date limite de paiement doit être après la date de début";
    }
    
    // Si une date de fin est fournie
    if (!empty($date_fin)) {
        // Vérifier que la date de fin est valide
        if (!strtotime($date_fin)) {
            $erreurs[] = "La date de fin n'est pas une date valide";
        }
        
        // Vérifier que la date de fin est après la date de début
        if (strtotime($date_fin) <= strtotime($date_debut)) {
            $erreurs[] = "La date de fin doit être après la date de début";
        }
        
        // Vérifier que la date de paiement n'est pas après la date de fin
        if (strtotime($date_paiement) > strtotime($date_fin)) {
            $erreurs[] = "La date limite de paiement ne peut pas être après la date de fin du contrat";
        }
    }
    
    return $erreurs;
}

// Traitement des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        // Variable pour stocker les messages de statut
        $message = [];
        
        switch($_POST['action']) {
            case 'ajouter':
                // Traitement de l'ajout
                $date_debut = $_POST['date_debut'];
                $date_fin = !empty($_POST['date_fin']) ? $_POST['date_fin'] : null;
                $loyer_mensuel = $_POST['loyer_mensuel'];
                $date_paiement = $_POST['date_paiement'];
                $conditions_speciales = !empty($_POST['conditions_speciales']) ? $_POST['conditions_speciales'] : null;
                
                // Valider les dates
                $erreurs_dates = validerDates($date_debut, $date_fin, $date_paiement);
                
                if (!empty($erreurs_dates)) {
                    $message = [
                        'type' => 'error',
                        'text' => 'Erreurs de validation des dates: ' . implode(', ', $erreurs_dates)
                    ];
                    break;
                }
                
                // Valider le loyer
                if ($loyer_mensuel <= 0) {
                    $message = [
                        'type' => 'error',
                        'text' => 'Le loyer mensuel doit être supérieur à 0'
                    ];
                    break;
                }
                
                try {
                    // Vérifier les conflits de dates avec d'autres contrats actifs
                    $stmt = $pdo->prepare("SELECT id FROM contrats WHERE statut = 0 
                        AND (
                            (date_debut <= ? AND (date_fin IS NULL OR date_fin >= ?)) OR
                            (date_debut <= ? AND (date_fin IS NULL OR date_fin >= ?)) OR
                            (? BETWEEN date_debut AND COALESCE(date_fin, ?)) OR
                            (? BETWEEN date_debut AND COALESCE(date_fin, ?))
                        )
                    ");
                    
                    // Pour l'ajout, on vérifie si la nouvelle période chevauche une période existante
                    $stmt->execute([
                        $date_debut, $date_debut,
                        $date_fin ?: '9999-12-31', $date_fin ?: '9999-12-31',
                        $date_debut, $date_fin ?: '9999-12-31',
                        $date_fin ?: '9999-12-31', $date_fin ?: '9999-12-31'
                    ]);
                    
                    $conflit = $stmt->fetch();
                    
                    if ($conflit) {
                        $message = [
                            'type' => 'error',
                            'text' => 'Un contrat actif existe déjà pour cette période'
                        ];
                        break;
                    }
                    
                    // Insérer le contrat (requête préparée)
                    $stmt = $pdo->prepare("INSERT INTO contrats (date_debut, date_fin, loyer_mensuel, date_paiement, conditions_speciales, statut) VALUES (?, ?, ?, ?, ?, 0)");
                    $stmt->execute([$date_debut, $date_fin, $loyer_mensuel, $date_paiement, $conditions_speciales]);
                    
                    $message = [
                        'type' => 'success',
                        'text' => 'Contrat créé avec succès'
                    ];
                } catch (PDOException $e) {
                    $message = [
                        'type' => 'error',
                        'text' => 'Erreur lors de la création du contrat: ' . $e->getMessage()
                    ];
                }
                break;
                
            case 'modifier':
                // Traitement de la modification
                $id = $_POST['id'];
                $date_debut = $_POST['date_debut'];
                $date_fin = !empty($_POST['date_fin']) ? $_POST['date_fin'] : null;
                $loyer_mensuel = $_POST['loyer_mensuel'];
                $date_paiement = $_POST['date_paiement'];
                $conditions_speciales = !empty($_POST['conditions_speciales']) ? $_POST['conditions_speciales'] : null;
                
                // Valider les dates
                $erreurs_dates = validerDates($date_debut, $date_fin, $date_paiement);
                
                if (!empty($erreurs_dates)) {
                    $message = [
                        'type' => 'error',
                        'text' => 'Erreurs de validation des dates: ' . implode(', ', $erreurs_dates)
                    ];
                    break;
                }
                
                // Valider le loyer
                if ($loyer_mensuel <= 0) {
                    $message = [
                        'type' => 'error',
                        'text' => 'Le loyer mensuel doit être supérieur à 0'
                    ];
                    break;
                }
                
                try {
                    // Vérifier les conflits de dates avec d'autres contrats actifs (exclure le contrat en cours de modification)
                    $stmt = $pdo->prepare("
                        SELECT id FROM contrats 
                        WHERE statut = 0 
                        AND id != ?
                        AND (
                            (date_debut <= ? AND (date_fin IS NULL OR date_fin >= ?)) OR
                            (date_debut <= ? AND (date_fin IS NULL OR date_fin >= ?)) OR
                            (? BETWEEN date_debut AND COALESCE(date_fin, ?)) OR
                            (? BETWEEN date_debut AND COALESCE(date_fin, ?))
                        )
                    ");
                    
                    $stmt->execute([
                        $id,
                        $date_debut, $date_debut,
                        $date_fin ?: '9999-12-31', $date_fin ?: '9999-12-31',
                        $date_debut, $date_fin ?: '9999-12-31',
                        $date_fin ?: '9999-12-31', $date_fin ?: '9999-12-31'
                    ]);
                    
                    $conflit = $stmt->fetch();
                    
                    if ($conflit) {
                        $message = [
                            'type' => 'error',
                            'text' => 'Un autre contrat actif existe déjà pour cette période'
                        ];
                        break;
                    }
                    
                    // Mettre à jour le contrat (requête préparée)
                    $stmt = $pdo->prepare("UPDATE contrats SET date_debut=?, date_fin=?, loyer_mensuel=?, date_paiement=?, conditions_speciales=? WHERE id=?");
                    $stmt->execute([$date_debut, $date_fin, $loyer_mensuel, $date_paiement, $conditions_speciales, $id]);
                    
                    $message = [
                        'type' => 'success',
                        'text' => 'Contrat modifié avec succès'
                    ];
                } catch (PDOException $e) {
                    $message = [
                        'type' => 'error',
                        'text' => 'Erreur lors de la modification du contrat: ' . $e->getMessage()
                    ];
                }
                break;
                
            case 'supprimer':
                // Soft delete
                $id = $_POST['id'];
                try {
                    $stmt = $pdo->prepare("UPDATE contrats SET statut=1 WHERE id=?");
                    $stmt->execute([$id]);
                    $message = [
                        'type' => 'success',
                        'text' => 'Contrat désactivé avec succès'
                    ];
                } catch (PDOException $e) {
                    $message = [
                        'type' => 'error',
                        'text' => 'Erreur lors de la désactivation du contrat: ' . $e->getMessage()
                    ];
                }
                break;

            case 'reactiver':
                // Réactivation d'un contrat
                $id = $_POST['id'];
                try {
                    // Vérifier s'il n'y a pas de conflit avec un contrat actif pour la même période
                    $stmt = $pdo->prepare("
                        SELECT c1.date_debut, c1.date_fin 
                        FROM contrats c1 
                        WHERE c1.id = ?
                    ");
                    $stmt->execute([$id]);
                    $contrat_a_reactiver = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($contrat_a_reactiver) {
                        $stmt = $pdo->prepare("
                            SELECT id FROM contrats 
                            WHERE statut = 0 
                            AND id != ?
                            AND (
                                (date_debut <= ? AND (date_fin IS NULL OR date_fin >= ?)) OR
                                (date_debut <= ? AND (date_fin IS NULL OR date_fin >= ?)) OR
                                (? BETWEEN date_debut AND COALESCE(date_fin, ?)) OR
                                (? BETWEEN date_debut AND COALESCE(date_fin, ?))
                            )
                        ");
                        
                        $stmt->execute([
                            $id,
                            $contrat_a_reactiver['date_debut'], $contrat_a_reactiver['date_debut'],
                            $contrat_a_reactiver['date_fin'] ?: '9999-12-31', $contrat_a_reactiver['date_fin'] ?: '9999-12-31',
                            $contrat_a_reactiver['date_debut'], $contrat_a_reactiver['date_fin'] ?: '9999-12-31',
                            $contrat_a_reactiver['date_fin'] ?: '9999-12-31', $contrat_a_reactiver['date_fin'] ?: '9999-12-31'
                        ]);
                        
                        $conflit = $stmt->fetch();
                        
                        if ($conflit) {
                            $message = [
                                'type' => 'error',
                                'text' => 'Impossible de réactiver le contrat: un autre contrat actif existe pour cette période'
                            ];
                            break;
                        }
                    }
                    
                    $stmt = $pdo->prepare("UPDATE contrats SET statut=0 WHERE id=?");
                    $stmt->execute([$id]);
                    $message = [
                        'type' => 'success',
                        'text' => 'Contrat réactivé avec succès'
                    ];
                } catch (PDOException $e) {
                    $message = [
                        'type' => 'error',
                        'text' => 'Erreur lors de la réactivation du contrat: ' . $e->getMessage()
                    ];
                }
                break;
        }
        
        // Stocker le message dans la session
        $_SESSION['message'] = $message;
        
        // Redirection vers la page des contrats
        header('Location: ../../views/contrats.php');
        exit;
    }
}