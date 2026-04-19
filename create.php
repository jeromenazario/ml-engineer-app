<?php
require_once 'config/database.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name       = trim($_POST['first_name'] ?? '');
    $last_name        = trim($_POST['last_name'] ?? '');
    $email            = trim($_POST['email'] ?? '');
    $specialization   = trim($_POST['specialization'] ?? '');
    $programming_lang = trim($_POST['programming_lang'] ?? '');
    $years_experience = trim($_POST['years_experience'] ?? '');
    $education_level  = trim($_POST['education_level'] ?? '');

    // Simple validation
    if (empty($first_name))       $errors[] = "First name is required.";
    if (empty($last_name))        $errors[] = "Last name is required.";
    if (empty($email))            $errors[] = "Email is required.";
    if (empty($specialization))   $errors[] = "Specialization is required.";
    if (empty($programming_lang)) $errors[] = "Programming language is required.";
    if (!is_numeric($years_experience) || $years_experience < 0) $errors[] = "Years of experience must be a valid number.";
    if (empty($education_level))  $errors[] = "Education level is required.";

    if (empty($errors)) {
        $database = new Database();
        $db = $database->getConnection();

        $query = "INSERT INTO applicants
                  (first_name, last_name, email, specialization, programming_lang, years_experience, education_level)
                  VALUES (:first_name, :last_name, :email, :specialization, :programming_lang, :years_experience, :education_level)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':first_name',       $first_name);
        $stmt->bindParam(':last_name',        $last_name);
        $stmt->bindParam(':email',            $email);
        $stmt->bindParam(':specialization',   $specialization);
        $stmt->bindParam(':programming_lang', $programming_lang);
        $stmt->bindParam(':years_experience', $years_experience, PDO::PARAM_INT);
        $stmt->bindParam(':education_level',  $education_level);

        if ($stmt->execute()) {
            header("Location: index.php?success=created");
            exit();
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Applicant — ML Engineer App</title>
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
            <h2 class="fs-4 mb-0">Add New Applicant</h2>
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

        <form method="POST" action="create.php">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" class="form-control"
                           value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="last_name" class="form-control"
                           value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>" required>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">ML/AI Specialization <span class="text-danger">*</span></label>
                    <select name="specialization" class="form-select" required>
                        <option value="" disabled selected>Select specialization</option>
                        <option value="Machine Learning" <?= (($_POST['specialization'] ?? '') === 'Machine Learning') ? 'selected' : '' ?>>Machine Learning</option>
                        <option value="Deep Learning" <?= (($_POST['specialization'] ?? '') === 'Deep Learning') ? 'selected' : '' ?>>Deep Learning</option>
                        <option value="Natural Language Processing" <?= (($_POST['specialization'] ?? '') === 'Natural Language Processing') ? 'selected' : '' ?>>Natural Language Processing</option>
                        <option value="Computer Vision" <?= (($_POST['specialization'] ?? '') === 'Computer Vision') ? 'selected' : '' ?>>Computer Vision</option>
                        <option value="Reinforcement Learning" <?= (($_POST['specialization'] ?? '') === 'Reinforcement Learning') ? 'selected' : '' ?>>Reinforcement Learning</option>
                        <option value="Data Science" <?= (($_POST['specialization'] ?? '') === 'Data Science') ? 'selected' : '' ?>>Data Science</option>
                        <option value="MLOps" <?= (($_POST['specialization'] ?? '') === 'MLOps') ? 'selected' : '' ?>>MLOps</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Primary Programming Language <span class="text-danger">*</span></label>
                    <select name="programming_lang" class="form-select" required>
                        <option value="" disabled selected>Select language</option>
                        <option value="Python" <?= (($_POST['programming_lang'] ?? '') === 'Python') ? 'selected' : '' ?>>Python</option>
                        <option value="R" <?= (($_POST['programming_lang'] ?? '') === 'R') ? 'selected' : '' ?>>R</option>
                        <option value="Julia" <?= (($_POST['programming_lang'] ?? '') === 'Julia') ? 'selected' : '' ?>>Julia</option>
                        <option value="Java" <?= (($_POST['programming_lang'] ?? '') === 'Java') ? 'selected' : '' ?>>Java</option>
                        <option value="C++" <?= (($_POST['programming_lang'] ?? '') === 'C++') ? 'selected' : '' ?>>C++</option>
                        <option value="Scala" <?= (($_POST['programming_lang'] ?? '') === 'Scala') ? 'selected' : '' ?>>Scala</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Years of Experience <span class="text-danger">*</span></label>
                    <input type="number" name="years_experience" class="form-control" min="0" max="50"
                           value="<?= htmlspecialchars($_POST['years_experience'] ?? '') ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Education Level <span class="text-danger">*</span></label>
                    <select name="education_level" class="form-select" required>
                        <option value="" disabled selected>Select level</option>
                        <option value="Bachelor's Degree" <?= (($_POST['education_level'] ?? '') === "Bachelor's Degree") ? 'selected' : '' ?>>Bachelor's Degree</option>
                        <option value="Master's Degree" <?= (($_POST['education_level'] ?? '') === "Master's Degree") ? 'selected' : '' ?>>Master's Degree</option>
                        <option value="PhD" <?= (($_POST['education_level'] ?? '') === 'PhD') ? 'selected' : '' ?>>PhD</option>
                        <option value="Associate Degree" <?= (($_POST['education_level'] ?? '') === 'Associate Degree') ? 'selected' : '' ?>>Associate Degree</option>
                        <option value="Bootcamp / Self-taught" <?= (($_POST['education_level'] ?? '') === 'Bootcamp / Self-taught') ? 'selected' : '' ?>>Bootcamp / Self-taught</option>
                    </select>
                </div>

                <div class="col-12 mt-2">
                    <button type="submit" class="btn btn-primary px-4">Submit Application</button>
                    <a href="index.php" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
