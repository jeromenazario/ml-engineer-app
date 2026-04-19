<?php
require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM applicants ORDER BY date_added DESC";
$stmt  = $db->prepare($query);
$stmt->execute();
$applicants = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ML Engineer Application System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f4f8; }
        .navbar { background: linear-gradient(135deg, #1a1a2e, #16213e); }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
        .table thead { background: linear-gradient(135deg, #0f3460, #16213e); color: white; }
        .badge-spec { background-color: #0f3460; color: white; font-size: 0.75rem; padding: 4px 8px; border-radius: 8px; }
        h1 { font-weight: 700; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark px-4 py-3 mb-4">
    <span class="navbar-brand fs-4">🤖 ML / AI Engineer Application System</span>
</nav>

<div class="container">

    <?php if (isset($_GET['success'])): ?>
        <?php if ($_GET['success'] === 'created'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                ✅ Applicant successfully added!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($_GET['success'] === 'updated'): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                ✏️ Applicant record successfully updated!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($_GET['success'] === 'deleted'): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                🗑️ Applicant record successfully deleted!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="fs-4 mb-0">Applicant Records</h1>
            <a href="create.php" class="btn btn-primary">+ Add New Applicant</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Specialization</th>
                        <th>Language</th>
                        <th>Experience</th>
                        <th>Education</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($applicants) > 0): ?>
                        <?php foreach ($applicants as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><span class="badge-spec"><?= htmlspecialchars($row['specialization']) ?></span></td>
                            <td><?= htmlspecialchars($row['programming_lang']) ?></td>
                            <td><?= htmlspecialchars($row['years_experience']) ?> yr(s)</td>
                            <td><?= htmlspecialchars($row['education_level']) ?></td>
                            <td><?= htmlspecialchars(date('M d, Y', strtotime($row['date_added']))) ?></td>
                            <td>
                                <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                                <a href="delete.php?id=<?= $row['id'] ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">No applicants found. <a href="create.php">Add one now!</a></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
