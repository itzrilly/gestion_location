<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Location - <?= $pageTitle ?? 'Tableau de bord' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="views/partials/style.css">
</head>
<body>
    <header class="bg-primary text-white">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="?controller=home">
                        <i class="bi bi-house-door"></i> Gestion Location
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="structureDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-building"></i> Structure
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="?controller=appartement&action=create"><i class="bi bi-plus-circle"></i> Créer Appartement</a></li>
                                    <li><a class="dropdown-item" href="?controller=proprietaire&action=create"><i class="bi bi-person-plus"></i> Créer Propriétaire</a></li>
                                    <li><a class="dropdown-item" href="?controller=tarif&action=create"><i class="bi bi-tag"></i> Créer Tarif</a></li>
                                    <li><a class="dropdown-item" href="?controller=locataire&action=create"><i class="bi bi-people"></i> Créer Locataire</a></li>
                                </ul>
                            </li>
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="traitementDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-file-earmark-text"></i> Traitement
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="?controller=contrat&action=create"><i class="bi bi-file-earmark-plus"></i> Passer Contrat</a></li>
                                    <li><a class="dropdown-item" href="?controller=contrat&action=edit"><i class="bi bi-pencil-square"></i> Modifier Contrat</a></li>
                                    <li><a class="dropdown-item" href="?controller=contrat&action=terminate"><i class="bi bi-file-earmark-x"></i> Résilier Contrat</a></li>
                                </ul>
                            </li>
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="impressionDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-printer"></i> Impression
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="?controller=locataire&action=print"><i class="bi bi-people"></i> Liste Locataires</a></li>
                                    <li><a class="dropdown-item" href="?controller=proprietaire&action=print"><i class="bi bi-person"></i> Liste Propriétaires</a></li>
                                    <li><a class="dropdown-item" href="?controller=contrat&action=print"><i class="bi bi-file-text"></i> Contrat</a></li>
                                </ul>
                            </li>
                        </ul>
                        
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="?controller=home&action=about"><i class="bi bi-info-circle"></i> À propos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?controller=home&action=contact"><i class="bi bi-envelope"></i> Contact</a>
                            </li>
                            <?php if(isset($_SESSION['user'])): ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-person-circle"></i> <?= $_SESSION['user']['username'] ?>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="?controller=user&action=profile"><i class="bi bi-person"></i> Profil</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="?controller=user&action=logout"><i class="bi bi-box-arrow-right"></i> Déconnexion</a></li>
                                    </ul>
                                </li>
                            <?php else: ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="?controller=user&action=login"><i class="bi bi-box-arrow-in-right"></i> Connexion</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main class="container my-4">
        <?php if(isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['flash']['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>