<?php 
include './views/partials/header.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="container mt-4">
    <h2 class="mb-4">Créer un nouveau locataire</h2>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?= $_SESSION['flash']['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['flash']['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
    
    <form action="index.php?controller=locataire&action=create" method="POST" class="bg-light p-4 rounded shadow-sm">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nomLocataire" class="form-label">Nom <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nomLocataire" name="nomLocataire" required placeholder="Entrez le nom">
            </div>
            <div class="col-md-6">
                <label for="prenomLocataire" class="form-label">Prénom <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="prenomLocataire" name="prenomLocataire" required placeholder="Entrez le prénom">
            </div>
        </div>

        <div class="mb-3">
            <label for="adresse1Locataire" class="form-label">Adresse 1 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="adresse1Locataire" name="adresse1Locataire" required placeholder="Ex: 123 Rue Principale">
        </div>
        
        <div class="mb-3">
            <label for="adresse2Locataire" class="form-label">Adresse 2 (optionnel)</label>
            <input type="text" class="form-control" id="adresse2Locataire" name="adresse2Locataire" placeholder="Ex: Appartement 4B">
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="codePostalLocataire" class="form-label">Code Postal <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="codePostalLocataire" name="codePostalLocataire" required placeholder="Ex: 75001">
            </div>
            <div class="col-md-6">
                <label for="villeLocataire" class="form-label">Ville <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="villeLocataire" name="villeLocataire" required placeholder="Ex: Yaoundé">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="numTel1Locataire" class="form-label">Numéro de Téléphone 1 <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" id="numTel1Locataire" name="numTel1Locataire" required placeholder="Ex: +237 6 12 34 56 78">
            </div>
            <div class="col-md-6">
                <label for="numTel2Locataire" class="form-label">Numéro de Téléphone 2 (optionnel)</label>
                <input type="tel" class="form-control" id="numTel2Locataire" name="numTel2Locataire" placeholder="Ex: +237 7 98 76 54 32">
            </div>
        </div>

        <div class="mb-4">
            <label for="emailLocataire" class="form-label">Email (optionnel)</label>
            <input type="email" class="form-control" id="emailLocataire" name="emailLocataire" placeholder="Ex: nom.prenom@example.com">
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="index.php?controller=home&action=index" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">Créer le locataire</button>
        </div>
    </form>
</div>

<?php include './views/partials/footer.php'; ?>