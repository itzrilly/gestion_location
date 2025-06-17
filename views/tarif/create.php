<?php include './views/partials/header.php'; ?>

<div class="container mt-4">
    <h2>Créer un nouveau tarif</h2>
    <form action="index.php?controller=tarif&action=create" method="POST">
        <div class="mb-3">
            <label for="prixSemHs" class="form-label">Prix Semaine Haute Saison</label>
            <input type="number" step="0.01" class="form-control" id="prixSemHs" name="prixSemHs" required>
        </div>
        <div class="mb-3">
            <label for="prixSemBs" class="form-label">Prix Semaine Basse Saison</label>
            <input type="number" step="0.01" class="form-control" id="prixSemBs" name="prixSemBs" required>
        </div>
        <button type="submit" class="btn btn-primary">Créer le tarif</button>
        <a href="index.php?controller=home&action=index" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php include './views/partials/footer.php'; ?>