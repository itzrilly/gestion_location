<?php include './views/partials/header.php'; ?>

<div class="container my-4">
    <h2 class="mb-4 text-center">Liste des Locataires</h2>

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

    <?php if (!empty($locataires)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">N° Locataire</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Adresse</th>
                        <th scope="col">Code Postal</th>
                        <th scope="col">Ville</th>
                        <th scope="col">Téléphone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($locataires as $locataire): ?>
                        <tr>
                            <td><?= htmlspecialchars($locataire['numLocataire']) ?></td>
                            <td><?= htmlspecialchars($locataire['nomLocataire']) ?></td>
                            <td><?= htmlspecialchars($locataire['prenomLocataire']) ?></td>
                            <td><?= htmlspecialchars($locataire['adresse1Locataire']) ?></td> <td><?= htmlspecialchars($locataire['codePostalLocataire']) ?></td>    <td><?= htmlspecialchars($locataire['villeLocataire']) ?></td>
                            <td><?= htmlspecialchars($locataire['numTel1Locataire']) ?></td>    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center" role="alert">
            Aucun locataire n'a été trouvé. <a href="?controller=locataire&action=create" class="alert-link">Ajoutez un locataire maintenant !</a>
        </div>
    <?php endif; ?>
</div>

<?php include './views/partials/footer.php'; ?>