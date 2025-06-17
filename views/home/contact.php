<?php
include './views/partials/header.php';

$pageTitle = "Contactez-nous";
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2 class="h3 mb-0">Contactez-nous</h2>
                </div>
                <div class="card-body p-5">
                    <p class="lead text-center mb-4">
                        Nous sommes là pour répondre à toutes vos questions et vous aider. N'hésitez pas à nous contacter via le formulaire ci-dessous ou par les moyens directs.
                    </p>

                    <h4 class="mt-5 mb-3 text-primary">Nos coordonnées :</h4>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex align-items-center">
                            <i class="bi bi-geo-alt-fill text-info me-3 fs-5"></i>
                            <div>
                                <strong>Adresse :</strong> 123 Rue de la Location, 75000 Yaoundé, Cameroun
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="bi bi-telephone-fill text-success me-3 fs-5"></i>
                            <div>
                                <strong>Téléphone :</strong> +237 699 50 12 39
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="bi bi-envelope-fill text-danger me-3 fs-5"></i>
                            <div>
                                <strong>Email :</strong> rilwanougarbarilly@gmail.com
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="bi bi-clock-fill text-secondary me-3 fs-5"></i>
                            <div>
                                <strong>Horaires :</strong> Du lundi au vendredi, de 9h00 à 17h00
                            </div>
                        </li>
                    </ul>

                    <h4 class="mt-5 mb-3 text-primary">Envoyez-nous un message :</h4>
                    <form action="#" method="POST">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom complet</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="sujet" class="form-label">Sujet</label>
                            <input type="text" class="form-control" id="sujet" name="sujet" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Votre Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-send-fill me-2"></i> Envoyer le message
                            </button>
                        </div>
                    </form>
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
