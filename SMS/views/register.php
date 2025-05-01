<?php
session_start();
require_once('../api/db.php');

$errorMsg = "";
$successMsg = "";

function generateUserId($type) {
    $prefixMap = [
        'STUDENT' => 'ST',
        'TEACHER' => 'TE',
        'PARENT'  => 'PA',
        'VISITOR' => 'VI'
    ];
    $prefix = $prefixMap[$type] ?? 'VI';
    $year = date('Y');
    $random = rand(1000, 9999);
    return $prefix . $year . $random;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $USER_NAME = $_POST['USER_NAME'];
    $PASSWORD = $_POST['PASS'];
    $CONTACT_NUMBER = $_POST['CONTACT_NUMBER'];
    $EMAIL = $_POST['EMAIL'];
    $USER_TYPE = $_POST['USER_TYPE'];
    $USER_ID = generateUserId($USER_TYPE);
    $USER_STATUS = 'ACTIVE';
    $JOINED_ON = date('Y-m-d');

    $hashedPassword = password_hash($PASSWORD, PASSWORD_BCRYPT);

    $check = $conn->prepare("SELECT USER_ID FROM USERS WHERE USER_ID = ?");
    $check->bind_param("s", $USER_ID);
    $check->execute();
    $check->store_result();

    if ($check->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO USERS (USER_NAME, USER_ID, PASS, CONTACT_NUMBER, EMAIL, USER_TYPE, USER_STATUS, JOINED_ON) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $USER_NAME, $USER_ID, $hashedPassword, $CONTACT_NUMBER, $EMAIL, $USER_TYPE, $USER_STATUS, $JOINED_ON);

        if ($stmt->execute()) {
            $successMsg = "🎉 Registration successful! Your User ID is <strong>$USER_ID</strong>. <a href='login.php' class='text-success fw-bold'>Login here</a>.";
        } else {
            $errorMsg = "❌ Error: " . $stmt->error;
        }
    } else {
        $errorMsg = "⚠️ User ID conflict. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - School Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            color: #333;
        }
        .card {
            width: 100%;
            max-width: 550px;
            border: none;
            border-radius: 16px;
            padding: 35px;
            background: #fff;
            box-shadow: 0 12px 24px rgba(0,0,0,0.2);
        }
        .btn-primary {
            background-color: #2c5364;
            border: none;
            transition: background 0.3s ease-in-out;
        }
        .btn-primary:hover {
            background-color: #203a43;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #2c5364;
        }
        .form-step {
        display: none;
    }
    .form-step.active {
        display: block;
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    </style>
</head>
<body>
    <div class="card">
        <h3 class="text-center mb-4 text-primary">Create an Account</h3>

        <?php if (!empty($errorMsg)): ?>
            <div class="alert alert-danger"><?php echo $errorMsg; ?></div>
        <?php elseif (!empty($successMsg)): ?>
            <div class="alert alert-success"><?php echo $successMsg; ?></div>
        <?php endif; ?>

        <form method="post" onsubmit="return validateForm()">
    <div class="mb-3 form-step active" data-step="1">
        <label class="form-label">Full Name</label>
        <input type="text" name="USER_NAME" class="form-control" oninput="nextStep(1)" required>
    </div>

    <div class="mb-3 form-step" data-step="2">
        <label class="form-label">Password</label>
        <input type="password" id="PASS" name="PASS" class="form-control" oninput="nextStep(2); updateStrength()" required>
        <div id="strength" class="form-text text-muted"></div>
    </div>

    <div class="mb-3 form-step" data-step="3">
        <label class="form-label">Confirm Password</label>
        <input type="password" id="CONFIRM_PASS" class="form-control" oninput="checkPasswordMatch(); nextStep(3)" required>
        <div id="passwordMatchMessage" class="form-text text-danger d-none">Passwords do not match.</div>
    </div>

    <div class="mb-3 form-step" data-step="4">
        <label class="form-label">Contact Number</label>
        <input type="text" name="CONTACT_NUMBER" class="form-control" oninput="nextStep(4)">
    </div>

    <div class="mb-3 form-step" data-step="5">
        <label class="form-label">Email Address</label>
        <input type="email" name="EMAIL" class="form-control" oninput="nextStep(5)" required>
    </div>

    <div class="mb-3 form-step" data-step="6">
        <label class="form-label">User Type</label>
        <select name="USER_TYPE" class="form-select" onchange="nextStep(6)" required>
            <option value="">Select user type</option>
            <option value="STUDENT">Student</option>
            <option value="TEACHER">Teacher</option>
            <option value="PARENT">Parent</option>
            <option value="VISITOR">Visitor</option>
        </select>
    </div>

    <div class="form-step" data-step="7">
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </div>
</form>


        <p class="mt-4 text-center">Already have an account? <a href="login.php" class="text-decoration-none text-primary">Login here</a></p>
    </div>

    <script>
    const pass = document.getElementById('PASS');
    const confirmPass = document.getElementById('CONFIRM_PASS');
    const msg = document.getElementById('passwordMatchMessage');
    const strength = document.getElementById('strength');

    function checkPasswordMatch() {
        if (pass.value === confirmPass.value && pass.value !== "") {
            confirmPass.classList.remove("is-invalid");
            confirmPass.classList.add("is-valid");
            msg.classList.add("d-none");
        } else {
            confirmPass.classList.remove("is-valid");
            confirmPass.classList.add("is-invalid");
            msg.classList.remove("d-none");
        }
    }

    function updateStrength() {
        const val = pass.value;
        let strengthText = "Weak";
        if (val.length >= 8 && /[A-Z]/.test(val) && /\d/.test(val) && /[\W]/.test(val)) {
            strengthText = "Strong";
        } else if (val.length >= 6) {
            strengthText = "Moderate";
        }
        strength.textContent = `Password Strength: ${strengthText}`;
    }

    function nextStep(step) {
        const currentField = document.querySelector(`.form-step[data-step="${step}"] input, .form-step[data-step="${step}"] select`);
        const isFilled = currentField.type === 'select-one'
            ? currentField.value !== ''
            : currentField.value.trim() !== '';

        if (isFilled) {
            const next = document.querySelector(`.form-step[data-step="${step + 1}"]`);
            if (next) next.classList.add('active');
        }
    }

    function validateForm() {
        if (pass.value !== confirmPass.value) {
            msg.classList.remove("d-none");
            confirmPass.focus();
            return false;
        }
        return true;
    }
</script>

</body>
</html>
