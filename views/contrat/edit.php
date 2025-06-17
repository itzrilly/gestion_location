<?php
include './views/partials/header.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Modifier le contrat #<?= htmlspecialchars($this->contrat->numContrat ?? '') ?></h2>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?= $_SESSION['flash']['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['flash']['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
    
    <form action="?controller=contrat&action=edit" method="post" class="bg-white p-4 rounded shadow">
        <input type="hidden" name="numContrat" value="<?= htmlspecialchars($this->contrat->numContrat ?? '') ?>">

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="etat" class="form-label">État du contrat <span class="text-danger">*</span></label>
                <select class="form-select" id="etat" name="etat" required>
                    <option value="">Sélectionnez un état</option>
                    <option value="Actif" <?= (isset($this->contrat->etat) && $this->contrat->etat == 'Actif') ? 'selected' : '' ?>>Actif</option>
                    <option value="En attente" <?= (isset($this->contrat->etat) && $this->contrat->etat == 'En attente') ? 'selected' : '' ?>>En attente</option>
                    <option value="Terminé" <?= (isset($this->contrat->etat) && $this->contrat->etat == 'Terminé') ? 'selected' : '' ?>>Terminé</option>
                    <option value="Résilier" <?= (isset($this->contrat->etat) && $this->contrat->etat == 'Résilier') ? 'selected' : '' ?>>Résilier</option>
                </select>
            </div>
            
            <div class="col-md-6">
                <label for="dateCreation" class="form-label">Date de création <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="dateCreation" name="dateCreation" required value="<?= htmlspecialchars($this->contrat->dateCreation ?? date('Y-m-d')) ?>">
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="dateDebut" class="form-label">Date de début <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="dateDebut" name="dateDebut" required value="<?= htmlspecialchars($this->contrat->dateDebut ?? '') ?>">
            </div>
            
            <div class="col-md-6">
                <label for="dateFin" class="form-label">Date de fin <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="dateFin" name="dateFin" required value="<?= htmlspecialchars($this->contrat->dateFin ?? '') ?>">
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
                            <option value="<?= htmlspecialchars($appartement->numLocation) ?>"
                                <?= (isset($this->contrat->numAppartement) && $this->contrat->numAppartement == $appartement->numLocation) ? 'selected' : '' ?>>
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
                            <option value="<?= htmlspecialchars($locataire->numLocataire) ?>"
                                <?= (isset($this->contrat->numLocataire) && $this->contrat->numLocataire == $locataire->numLocataire) ? 'selected' : '' ?>>
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
            <a href="index.php?controller=contrat&action=index" class="btn btn-outline-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </div>
    </form>
</div>

<?php
include './views/partials/footer.php';
?>