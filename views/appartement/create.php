<?php 
include './views/partials/header.php'; 

if (session_status() == PHP_SESSION_NONE) {
    // session_start();
}
?>

<div class="container mt-4">
    <h2 class="mb-4">Créer un nouvel appartement</h2>

    <?php
        if (isset($_SESSION['flash'])) {
            $flashType = $_SESSION['flash']['type'];
            $flashMessage = $_SESSION['flash']['message'];
            echo '<div class="p-4 mb-4 text-sm rounded-lg ' . ($flashType === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') . '" role="alert">';
            echo $flashMessage;
            echo '</div>';
            unset($_SESSION['flash']);
        }
    ?>
    
    <form action="?controller=appartement&action=create" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="categorie" class="form-label">Catégorie</label>
            <input type="text" class="form-control" id="categorie" name="categorie" required>
        </div>
        
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" class="form-control" id="type" name="type" required>
        </div>
        
        <div class="mb-3">
            <label for="nbPersonnes" class="form-label">Nombre de personnes</label>
            <input type="number" class="form-control" id="nbPersonnes" name="nbPersonnes" required>
        </div>
        
        <div class="mb-3">
            <label for="adresseLocation" class="form-label">Adresse</label>
            <input type="text" class="form-control" id="adresseLocation" name="adresseLocation" required>
        </div>
        
        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
            <small class="text-muted">Formats acceptés: JPG, PNG, GIF (Max 2MB)</small>
        </div>

        <div class="mb-3">
            <label for="equipements" class="form-label">Équipements</label>
            <textarea class="form-control" id="equipements" name="equipements" rows="3"></textarea>
        </div>
        
        <div class="mb-3">
            <label for="codeTarif" class="form-label">Tarif</label>
            <select class="form-control" id="codeTarif" name="codeTarif" required>
                <option value="">Sélectionnez un tarif</option>
                <?php foreach($tarifs as $tarif): ?>
                    <option value="<?= $tarif->codeTarif ?>">
                        Tarif <?= $tarif->codeTarif ?> - HS: <?= $tarif->prixSemHs ?> FCFA / BS: <?= $tarif->prixSemBs ?> FCFA
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="numProprietaire" class="form-label">Propriétaire</label>
            <select class="form-control" id="numProprietaire" name="numProprietaire" required>
                <option value="">Sélectionnez un propriétaire</option>
                <?php foreach($proprietaires as $proprietaire): ?>
                    <option value="<?= $proprietaire->num ?>">
                        <?= $proprietaire->prenom ?> <?= $proprietaire->nom ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>

<?php include './views/partials/footer.php'; ?>