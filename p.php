<?php
session_start(); // Start the session

// Initialize variables
$name = $password = $age = $gender = "";
$errors = [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $errors['name'] = "Name is required.";
    } else {
        $name = htmlspecialchars(trim($_POST["name"]));
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $errors['password'] = "Password is required.";
    } elseif (strlen($_POST["password"]) < 6) {
        $errors['password'] = "Password must be at least 6 characters.";
    } else {
        $password = htmlspecialchars(trim($_POST["password"]));
    }

    // Validate age
    if (empty(trim($_POST["age"]))) {
        $errors['age'] = "Age is required.";
    } elseif (!is_numeric($_POST["age"]) || $_POST["age"] <= 0) {
        $errors['age'] = "Please enter a valid age.";
    } else {
        $age = htmlspecialchars(trim($_POST["age"]));
    }

    // Validate gender
    if (empty($_POST["gender"])) {
        $errors['gender'] = "Gender is required.";
    } else {
        $gender = htmlspecialchars($_POST["gender"]);
    }

    // If no errors, save data to session and cookies
    if (empty($errors)) {
        $submittedData = [
            'name' => $name,
            'password' => $password,
            'age' => $age,
            'gender' => $gender
        ];

        // Store in session
        $_SESSION['formData'] = $submittedData;

        // Store in cookies (expire in 3 seconds)
        foreach ($submittedData as $key => $value) {
            setcookie($key, $value, time() + 3, "/"); // 3 seconds expiration
        }

        header("Location: " . $_SERVER['PHP_SELF']); // Prevent form resubmission
        exit;
    }
}

// Retrieve form data from cookies if available and not expired
if (empty($name) && isset($_COOKIE['name'])) {
    $name = $_COOKIE['name'];
}
if (empty($age) && isset($_COOKIE['age'])) {
    $age = $_COOKIE['age'];
}
if (empty($gender) && isset($_COOKIE['gender'])) {
    $gender = $_COOKIE['gender'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Form with Validation and Cookies</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">PHP Form</h1>
    <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="p-4 border rounded">
        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control <?= isset($errors['name']) ? 'is-invalid' : ''; ?>" value="<?= htmlspecialchars($name); ?>">
            <div class="invalid-feedback"><?= $errors['name'] ?? ''; ?></div>
        </div>
        
        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : ''; ?>">
            <div class="invalid-feedback"><?= $errors['password'] ?? ''; ?></div>
        </div>
        
        <!-- Age -->
        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="text" name="age" id="age" class="form-control <?= isset($errors['age']) ? 'is-invalid' : ''; ?>" value="<?= htmlspecialchars($age); ?>">
            <div class="invalid-feedback"><?= $errors['age'] ?? ''; ?></div>
        </div>
        
        <!-- Gender -->
        <div class="mb-3">
            <label class="form-label">Gender</label>
            <div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="gender" id="genderMale" value="Male" class="form-check-input" <?= $gender === "Male" ? "checked" : ""; ?>>
                    <label for="genderMale" class="form-check-label">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="gender" id="genderFemale" value="Female" class="form-check-input" <?= $gender === "Female" ? "checked" : ""; ?>>
                    <label for="genderFemale" class="form-check-label">Female</label>
                </div>
            </div>
            <?php if (isset($errors['gender'])): ?>
                <div class="text-danger mt-1"><?= $errors['gender']; ?></div>
            <?php endif; ?>
        </div>
        
        <!-- Submit Button -->
        <div class="mb-3">
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </div>
    </form>

    <!-- Display Submitted Data -->
    <?php if (!empty($_SESSION['formData'])): ?>
        <div class="alert alert-success mt-4">
            <h4>Submitted Data:</h4>
            <p><strong>Name:</strong> <?= htmlspecialchars($_SESSION['formData']['name']); ?></p>
            <p><strong>Password:</strong> <?= htmlspecialchars($_SESSION['formData']['password']); ?></p>
            <p><strong>Age:</strong> <?= htmlspecialchars($_SESSION['formData']['age']); ?></p>
            <p><strong>Gender:</strong> <?= htmlspecialchars($_SESSION['formData']['gender']); ?></p>
        </div>
        <?php unset($_SESSION['formData']); ?>
    <?php endif; ?>
</div>
<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
