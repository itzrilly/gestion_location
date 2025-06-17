<?php
include './views/partials/header.php';

if (session_status() == PHP_SESSION_NONE) {
    // session_start();
}
?>

<div class="container mt-4">
    <h2 class="mb-4">Créer un nouveau propriétaire</h2>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?= $_SESSION['flash']['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['flash']['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <form action="index.php?controller=proprietaire&action=create" method="POST" class="bg-light p-4 rounded shadow-sm">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nom" name="nom" required placeholder="Entrez le nom">
            </div>
            
            <div class="col-md-6">
                <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="prenom" name="prenom" required placeholder="Entrez le prénom">
            </div>
        </div>

        <div class="mb-3">
            <label for="adresse1" class="form-label">Adresse 1 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="adresse1" name="adresse1" required placeholder="Ex: 123 Rue Principale">
        </div>
        
        <div class="mb-3">
            <label for="adresse2" class="form-label">Adresse 2 (optionnel)</label>
            <input type="text" class="form-control" id="adresse2" name="adresse2" placeholder="Ex: Appartement 4B">
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="codePostal" class="form-label">Code Postal <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="codePostal" name="codePostal" required placeholder="Ex: 75001">
            </div>
            
            <div class="col-md-6">
                <label for="ville" class="form-label">Ville <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="ville" name="ville" required placeholder="Ex: Yaoundé">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="numTel1" class="form-label">Numéro de Téléphone 1 <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" id="numTel1" name="numTel1" required placeholder="Ex: +237 6 12 34 56 78">
            </div>
            
            <div class="col-md-6">
                <label for="numTel2" class="form-label">Numéro de Téléphone 2 (optionnel)</label>
                <input type="tel" class="form-control" id="numTel2" name="numTel2" placeholder="Ex: +237 7 98 76 54 32">
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <label for="email" class="form-label">Email (optionnel)</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Ex: nom.prenom@example.com">
            </div>
            
            <div class="col-md-6">
                <label for="caCumule" class="form-label">Chiffre d'affaires cumulé</label>
                <input type="number" step="0.01" class="form-control" id="caCumule" name="caCumule" value="0.00" placeholder="Ex: 1500.50">
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="index.php?controller=home&action=index" class="btn btn-outline-danger">Annuler</a>
            <button type="submit" class="btn btn-primary">Créer le propriétaire</button>
        </div>
    </form>
</div>

<?php
include './views/partials/footer.php';
?>