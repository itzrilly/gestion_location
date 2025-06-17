<?php include './views/partials/header.php'; ?>

<div class="container my-4">
    <h2 class="mb-4 text-center">Liste des Contrats</h2>

    <?php
    if (isset($_SESSION['flash'])) {
        $flashType = $_SESSION['flash']['type'];
        $flashMessage = $_SESSION['flash']['message'];
        echo '<div class="alert alert-' . ($flashType === 'success' ? 'success' : 'danger') . ' alert-dismissible fade show" role="alert">';
        echo $flashMessage;
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
        unset($_SESSION['flash']);
    }
    ?>

    <?php if (!empty($contrats)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">N° Contrat</th>
                        <th scope="col">État</th>
                        <th scope="col">Date Création</th>
                        <th scope="col">Début</th>
                        <th scope="col">Fin</th>
                        <th scope="col">Appartement</th>
                        <th scope="col">Locataire</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contrats as $contrat): ?>
                        <tr>
                            <td><?= htmlspecialchars($contrat['numContrat']) ?></td>
                            <td><?= htmlspecialchars($contrat['etat']) ?></td>
                            <td><?= htmlspecialchars($contrat['dateCreation']) ?></td>
                            <td><?= htmlspecialchars($contrat['dateDebut']) ?></td>
                            <td><?= htmlspecialchars($contrat['dateFin']) ?></td>
                            <td><?= htmlspecialchars($contrat['adresseLocation']) ?> (<?= htmlspecialchars($contrat['categorie']) ?>)</td>
                            <td><?= htmlspecialchars($contrat['prenomLocataire']) ?> <?= htmlspecialchars($contrat['nomLocataire']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center" role="alert">
            Aucun contrat n'a été trouvé. <a href="?controller=contrat&action=create" class="alert-link">Créez-en un maintenant !</a>
        </div>
    <?php endif; ?>
</div>

<?php include './views/partials/footer.php'; ?>