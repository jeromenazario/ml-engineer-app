<?php
require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

$errors = [];
$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: index.php");
    exit();
}

// Fetch existing record
$query = "SELECT * FROM applicants WHERE id = :id LIMIT 1";
$stmt  = $db->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$applicant = $stmt->fetch();

if (!$applicant) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name       = trim($_POST['first_name'] ?? '');
    $last_name        = trim($_POST['last_name'] ?? '');
    $email            = trim($_POST['email'] ?? '');
    $specialization   = trim($_POST['specialization'] ?? '');
    $programming_lang = trim($_POST['programming_lang'] ?? '');
    $years_experience = trim($_POST['years_experience'] ?? '');
    $education_level  = trim($_POST['education_level'] ?? '');

    if (empty($first_name))       $errors[] = "First name is required.";
    if (empty($last_name))        $errors[] = "Last name is required.";
    if (empty($email))            $errors[] = "Email is required.";
    if (empty($specialization))   $errors[] = "Specialization is required.";
    if (empty($programming_lang)) $errors[] = "Programming language is required.";
    if (!is_numeric($years_experience) || $years_experience < 0) $errors[] = "Years of experience must be a valid number.";
    if (empty($education_level))  $errors[] = "Education level is required.";

    if (empty($errors)) {
        $update = "UPDATE applicants
                   SET first_name       = :first_name,
                       last_name        = :last_name,
                       email            = :email,
                       specialization   = :specialization,
                       programming_lang = :programming_lang,
                       years_experience = :years_experience,
                       education_level  = :education_level
                   WHERE id = :id";

        $stmt = $db->prepare($update);
        $stmt->bindParam(':first_name',       $first_name);
        $stmt->bindParam(':last_name',        $last_name);
        $stmt->bindParam(':email',            $email);
        $stmt->bindParam(':specialization',   $specialization);
        $stmt->bindParam(':programming_lang', $programming_lang);
        $stmt->bindParam(':years_experience', $years_experience, PDO::PARAM_INT);
        $stmt->bindParam(':education_level',  $education_level);
        $stmt->bindParam(':id',               $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: index.php?success=updated");
            exit();
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
    }

    // Keep posted values on error
    $applicant['first_name']       = $first_name;
    $applicant['last_name']        = $last_name;
    $applicant['email']            = $email;
    $applicant['specialization']   = $specialization;
    $applicant['programming_lang'] = $programming_lang;
    $applicant['years_experience'] = $years_experience;
    $applicant['education_level']  = $education_level;
}

// Helper for selected state
function sel($val, $match) { return ($val === $match) ? 'selected' : ''; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Applicant — ML Engineer App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f4f8; }
        .navbar { background: linear-gradient(135deg, #1a1a2e, #16213e); }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
        .btn-primary { background: #0f3460; border-color: #0f3460; }
        .btn-primary:hover { background: #16213e; border-color: #16213e; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark px-4 py-3 mb-4">
    <span class="navbar-brand fs-4">🤖 ML / AI Engineer Application System</span>
</nav>

<div class="container" style="max-width: 700px;">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fs-4 mb-0">Edit Applicant <span class="text-muted fs-6">(ID: <?= $id ?>)</span></h2>
            <a href="index.php" class="btn btn-sm btn-outline-secondary">← Back to List</a>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="update.php?id=<?= $id ?>">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" class="form-control"
                           value="<?= htmlspecialchars($applicant['first_name']) ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="last_name" class="form-control"
                           value="<?= htmlspecialchars($applicant['last_name']) ?>" required>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control"
                           value="<?= htmlspecialchars($applicant['email']) ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">ML/AI Specialization <span class="text-danger">*</span></label>
                    <select name="specialization" class="form-select" required>
                        <option value="" disabled>Select specialization</option>
                        <option value="Machine Learning" <?= sel($applicant['specialization'], 'Machine Learning') ?>>Machine Learning</option>
                        <option value="Deep Learning" <?= sel($applicant['specialization'], 'Deep Learning') ?>>Deep Learning</option>
                        <option value="Natural Language Processing" <?= sel($applicant['specialization'], 'Natural Language Processing') ?>>Natural Language Processing</option>
                        <option value="Computer Vision" <?= sel($applicant['specialization'], 'Computer Vision') ?>>Computer Vision</option>
                        <option value="Reinforcement Learning" <?= sel($applicant['specialization'], 'Reinforcement Learning') ?>>Reinforcement Learning</option>
                        <option value="Data Science" <?= sel($applicant['specialization'], 'Data Science') ?>>Data Science</option>
                        <option value="MLOps" <?= sel($applicant['specialization'], 'MLOps') ?>>MLOps</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Primary Programming Language <span class="text-danger">*</span></label>
                    <select name="programming_lang" class="form-select" required>
                        <option value="" disabled>Select language</option>
                        <option value="Python" <?= sel($applicant['programming_lang'], 'Python') ?>>Python</option>
                        <option value="R" <?= sel($applicant['programming_lang'], 'R') ?>>R</option>
                        <option value="Julia" <?= sel($applicant['programming_lang'], 'Julia') ?>>Julia</option>
                        <option value="Java" <?= sel($applicant['programming_lang'], 'Java') ?>>Java</option>
                        <option value="C++" <?= sel($applicant['programming_lang'], 'C++') ?>>C++</option>
                        <option value="Scala" <?= sel($applicant['programming_lang'], 'Scala') ?>>Scala</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Years of Experience <span class="text-danger">*</span></label>
                    <input type="number" name="years_experience" class="form-control" min="0" max="50"
                           value="<?= htmlspecialchars($applicant['years_experience']) ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Education Level <span class="text-danger">*</span></label>
                    <select name="education_level" class="form-select" required>
                        <option value="" disabled>Select level</option>
                        <option value="Bachelor's Degree" <?= sel($applicant['education_level'], "Bachelor's Degree") ?>>Bachelor's Degree</option>
                        <option value="Master's Degree" <?= sel($applicant['education_level'], "Master's Degree") ?>>Master's Degree</option>
                        <option value="PhD" <?= sel($applicant['education_level'], 'PhD') ?>>PhD</option>
                        <option value="Associate Degree" <?= sel($applicant['education_level'], 'Associate Degree') ?>>Associate Degree</option>
                        <option value="Bootcamp / Self-taught" <?= sel($applicant['education_level'], 'Bootcamp / Self-taught') ?>>Bootcamp / Self-taught</option>
                    </select>
                </div>

                <div class="col-12 mt-2">
                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                    <a href="index.php" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
