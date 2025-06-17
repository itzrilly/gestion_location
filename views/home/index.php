<?php include 'views/partials/header.php'; ?>

<div class="dashboard">
    <h1>Tableau de Bord</h1>
    
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Propriétaires</h3>
            <p><?= $stats['total_proprietaires'] ?></p>
        </div>
        <div class="stat-card">
            <h3>Appartements</h3>
            <p><?= $stats['total_appartements'] ?></p>
        </div>
        <div class="stat-card">
            <h3>Locataires</h3>
            <p><?= $stats['total_locataires'] ?></p>
        </div>
        <div class="stat-card">
            <h3>Contrats</h3>
            <p><?= $stats['total_contrats'] ?></p>
        </div>
        <div class="stat-card">
            <h3>Contrats Actifs</h3>
            <p><?= $stats['contrats_actifs'] ?></p>
        </div>
    </div>
    
    <div class="recent-section">
        <h2>Derniers Contrats</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>N° Contrat</th>
                    <th>Locataire</th>
                    <th>Appartement</th>
                    <th>Date Début</th>
                    <th>Date Fin</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($latestContracts as $contract): ?>
                <tr>
                    <td><?= $contract->numContrat ?></td>
                    <td><?= $contract->prenomLocataire ?> <?= $contract->nomLocataire ?></td>
                    <td><?= $contract->adresseLocation ?></td>
                    <td><?= date('d/m/Y', strtotime($contract->dateDebut)) ?></td>
                    <td><?= date('d/m/Y', strtotime($contract->dateFin)) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="recent-section">
        <h2>Derniers Appartements</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>N° Appartement</th>
                    <th>Catégorie</th>
                    <th>Type</th>
                    <th>Adresse</th>
                    <th>Propriétaire</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($latestApartments as $apartment): ?>
                <tr>
                    <td><?= $apartment->numLocation ?></td>
                    <td><?= $apartment->categorie ?></td>
                    <td><?= $apartment->type ?></td>
                    <td><?= $apartment->adresseLocation ?></td>
                    <td><?= $apartment->prenomProprietaire ?> <?= $apartment->nomProprietaire ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'views/partials/footer.php'; ?>