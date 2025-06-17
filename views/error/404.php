<?php
include './views/partials/header.php';

$pageTitle = "Page non trouvée";
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-danger text-white text-center py-4">
                    <h1 class="h2 mb-0">Erreur 404 - Page non trouvée</h1>
                </div>
                <div class="card-body p-5 text-center">
                    <p class="lead mb-4">
                        Désolé, la page que vous recherchez est introuvable.
                    </p>
                    <p class="text-muted mb-4">
                        Il se peut que l'adresse ait été mal tapée, que la page ait été déplacée ou supprimée.
                    </p>
                    <a href="?controller=home" class="btn btn-primary btn-lg">
                        <i class="bi bi-house-door-fill me-2"></i> Retour à la page d'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include './views/partials/footer.php';
?>
