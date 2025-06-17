<?php
include './views/partials/header.php';

$pageTitle = "À propos de l'application";
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2 class="h3 mb-0">À propos de notre application de Gestion de Location</h2>
                </div>
                <div class="card-body p-5">
                    <p class="lead text-center mb-4">
                        Bienvenue sur l'application de Gestion de Location, votre solution complète pour une administration fluide et efficace de vos biens immobiliers.
                    </p>
                    <p class="text-muted">
                        Conçue pour les propriétaires, les agences et les gestionnaires immobiliers, notre plateforme simplifie toutes les étapes du processus de location, de la création des fiches d'appartements à la gestion des contrats et des locataires.
                    </p>
                    <h4 class="mt-5 mb-3 text-primary">Fonctionnalités clés :</h4>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex align-items-center">
                            <i class="bi bi-building-fill-add text-success me-3 fs-5"></i>
                            <div>
                                <strong>Gestion des Appartements :</strong> Ajoutez, modifiez et consultez les détails de vos biens, y compris les catégories, types, nombre de personnes, adresses, photos et équipements.
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="bi bi-person-circle text-info me-3 fs-5"></i>
                            <div>
                                <strong>Gestion des Propriétaires :</strong> Enregistrez et suivez les informations de tous vos propriétaires, incluant leurs coordonnées et leur chiffre d'affaires cumulé.
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="bi bi-tag-fill text-warning me-3 fs-5"></i>
                            <div>
                                <strong>Gestion des Tarifs :</strong> Définissez et gérez les tarifs de location pour les hautes et basses saisons, applicables à vos différents appartements.
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="bi bi-people-fill text-danger me-3 fs-5"></i>
                            <div>
                                <strong>Gestion des Locataires :</strong> Centralisez toutes les informations de vos locataires, facilitant la communication et le suivi.
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="bi bi-file-earmark-ruled-fill text-primary me-3 fs-5"></i>
                            <div>
                                <strong>Gestion des Contrats :</strong> Passez, modifiez et résiliez des contrats de location, avec un suivi clair de l'état et des dates.
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="bi bi-printer-fill text-secondary me-3 fs-5"></i>
                            <div>
                                <strong>Fonctionnalités d'Impression :</strong> Générez des listes imprimables de vos locataires, propriétaires et contrats pour vos besoins administratifs.
                            </div>
                        </li>
                    </ul>
                    <p class="text-center mt-5">
                        Notre objectif est de vous offrir un outil simple, intuitif et puissant pour optimiser la gestion de votre activité de location.
                    </p>
                </div>
                <div class="card-footer text-center py-3">
                    <a href="?controller=home" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i> Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include './views/partials/footer.php';
?>