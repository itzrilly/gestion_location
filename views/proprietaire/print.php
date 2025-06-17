<?php include './views/partials/header.php'; ?>

<div class="container my-4">
    <h2 class="mb-4 text-center">Liste des Propriétaires</h2>

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

    <?php if (!empty($proprietaires)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">N° Propriétaire</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Adresse</th>
                        <th scope="col">Code Postal</th>
                        <th scope="col">Ville</th>
                        <th scope="col">Téléphone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($proprietaires as $proprietaire): ?>
                        <tr>
                            <td><?= htmlspecialchars($proprietaire['num']) ?></td>
                            <td><?= htmlspecialchars($proprietaire['nom']) ?></td>
                            <td><?= htmlspecialchars($proprietaire['prenom']) ?></td>
                            <td><?= htmlspecialchars($proprietaire['adresse1']) ?></td>
                            <td><?= htmlspecialchars($proprietaire['codePostal']) ?></td>
                            <td><?= htmlspecialchars($proprietaire['ville']) ?></td>
                            <td><?= htmlspecialchars($proprietaire['numTel1']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center" role="alert">
            Aucun propriétaire n'a été trouvé. <a href="?controller=proprietaire&action=create" class="alert-link">Ajoutez un propriétaire maintenant !</a>
        </div>
    <?php endif; ?>
</div>

<?php include './views/partials/footer.php'; ?>