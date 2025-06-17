<?php
include './views/partials/header.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Passer un nouveau contrat</h2>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?= $_SESSION['flash']['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['flash']['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
    
    <form action="?controller=contrat&action=create" method="post" class="bg-white p-4 rounded shadow">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="etat" class="form-label">État du contrat <span class="text-danger">*</span></label>
                <select class="form-select" id="etat" name="etat" required>
                    <option value="">Sélectionnez un état</option>
                    <option value="Actif">Actif</option>
                    <option value="En attente">En attente</option>
                    <option value="Terminé">Terminé</option>
                    <option value="Résilier">Résilier</option>
                </select>
            </div>
            
            <div class="col-md-6">
                <label for="dateCreation" class="form-label">Date de création <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="dateCreation" name="dateCreation" required value="<?= date('Y-m-d') ?>">
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="dateDebut" class="form-label">Date de début <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="dateDebut" name="dateDebut" required>
            </div>
            
            <div class="col-md-6">
                <label for="dateFin" class="form-label">Date de fin <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="dateFin" name="dateFin" required>
            </div>
        </div>
        
        <div class="row mb-4">
            <div class="col-md-6">
                <label for="numAppartement" class="form-label">Appartement <span class="text-danger">*</span></label>
                <select class="form-select" id="numAppartement" name="numAppartement" required>
                    <option value="">Sélectionnez un appartement</option>
                    <?php 
                    if (isset($appartements) && (is_array($appartements) || is_object($appartements))) {
                        foreach($appartements as $appartement): ?>
                            <option value="<?= htmlspecialchars($appartement->numLocation) ?>">
                                <?= htmlspecialchars($appartement->adresseLocation) ?> (<?= htmlspecialchars($appartement->categorie) ?> - <?= htmlspecialchars($appartement->type) ?>)
                            </option>
                        <?php endforeach;
                    } else {
                        echo '<option value="">Aucun appartement disponible</option>';
                    }
                    ?>
                </select>
            </div>
            
            <div class="col-md-6">
                <label for="numLocataire" class="form-label">Locataire <span class="text-danger">*</span></label>
                <select class="form-select" id="numLocataire" name="numLocataire" required>
                    <option value="">Sélectionnez un locataire</option>
                    <?php 
                    if (isset($locataires) && (is_array($locataires) || is_object($locataires))) {
                        foreach($locataires as $locataire): ?>
                            <option value="<?= htmlspecialchars($locataire->numLocataire) ?>">
                                <?= htmlspecialchars($locataire->prenomLocataire) ?> <?= htmlspecialchars($locataire->nomLocataire) ?>
                            </option>
                        <?php endforeach;
                    } else {
                        echo '<option value="">Aucun locataire disponible</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        
        <div class="d-flex justify-content-end gap-2">
            <a href="index.php?controller=home&action=index" class="btn btn-outline-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">Passer le contrat</button>
        </div>
    </form>
</div>

<?php
include './views/partials/footer.php';
?>