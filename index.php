<?php
// Initialize variables
$errors = [];
$last_name = $first_name = $middle_name = $dob = $gender = $civil_status = $nationality = $religion = $tin = $unit = $blk = $street = $phone = $email = $flast = $ffirst = $fmiddle = $mlast = $mfirst = $mmiddle = "";

// Process form data if POST request is made
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate fields
    $last_name = trim($_POST['last_name'] ?? '');
    if (empty($last_name)) {
        $errors['last_name'] = "Last Name is required and cannot be empty or spaces.";
    } elseif (!preg_match("/^[a-zA-Z\s]*$/", $last_name)) {
        $errors['last_name'] = "Last Name must not contain numbers or special characters.";
    }

    $first_name = trim($_POST['first_name'] ?? '');
    if (empty($first_name)) {
        $errors['first_name'] = "First Name is required and cannot be empty or spaces.";
    } elseif (!preg_match("/^[a-zA-Z\s]*$/", $first_name)) {
        $errors['first_name'] = "First Name must not contain numbers or special characters.";
    }

    $middle_name = trim($_POST['middle_name'] ?? '');
    if (empty($middle_name)) {
        $errors['middle_name'] = "Middle Initial is required and cannot be empty or spaces.";
    } elseif (!preg_match("/^[a-zA-Z\s\.]*$/", $middle_name)) {
        $errors['middle_name'] = "Middle Initial must not contain numbers or special characters.";
    }

    $dob = $_POST['dob'] ?? '';
    if (empty($dob)) {
        $errors['dob'] = "Date of Birth is required.";
    } elseif (strtotime($dob) > strtotime('-18 years')) {
        $errors['dob'] = "You must be at least 18 years old.";
    }

    $gender = $_POST['gender'] ?? '';
    if (empty($gender)) {
        $errors['gender'] = "Gender is required.";
    }

    $civil_status = trim($_POST['civil_status'] ?? '');
    if (empty($civil_status)) {
        $errors['civil_status'] = "Civil Status is required.";
    }

    $nationality = trim($_POST['nationality'] ?? '');
    if (empty($nationality)) {
        $errors['nationality'] = "Nationality is required and cannot be empty or spaces.";
    } elseif (!preg_match("/^[a-zA-Z\s]*$/", $nationality)) {
        $errors['nationality'] = "Nationality must not contain numbers or special characters.";
    }

    $religion = trim($_POST['religion'] ?? '');
    if (empty($religion)) {
        $errors['religion'] = "Religion is required and cannot be empty or spaces.";
    } elseif (!preg_match("/^[a-zA-Z\s]*$/", $religion)) {
        $errors['religion'] = "Religion must not contain numbers or special characters.";
    }

    $tin = trim($_POST['tin'] ?? '');
    if (empty($tin)) {
        $errors['tin'] = "Tax Identification No. is required and cannot be empty or spaces.";
    } elseif (!preg_match("/^\d+$/", $tin)) {
        $errors['tin'] = "Tax Identification No. must only contain numbers.";
    }

    $unit = trim($_POST['unit'] ?? '');
    $blk = trim($_POST['blk'] ?? '');
    $street = trim($_POST['street'] ?? '');

    $phone = trim($_POST['phone'] ?? '');
    if (empty($phone)) {
        $errors['phone'] = "Phone No. is required and cannot be empty or spaces.";
    }

    $email = trim($_POST['email'] ?? '');
    if (empty($email)) {
        $errors['email'] = "E-mail Address is required and cannot be empty or spaces.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    // Parental information
    $flast = trim($_POST['flast'] ?? '');
    $ffirst = trim($_POST['ffirst'] ?? '');
    $fmiddle = trim($_POST['fmiddle'] ?? '');
    $mlast = trim($_POST['mlast'] ?? '');
    $mfirst = trim($_POST['mfirst'] ?? '');
    $mmiddle = trim($_POST['mmiddle'] ?? '');

    // If there are errors, display them
    if (empty($errors)) {
        // Redirect to the next page
        if (isset($_POST['next_page'])) {
            header("Location: next_page.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Form</title>
    <script>
        function toggleCivilStatusField() {
            const civilStatusSelect = document.querySelector('select[name="civil_status"]');
            const othersInput = document.getElementById('othersInput');

            if (civilStatusSelect.value === 'Others') {
                othersInput.style.display = 'block';
                civilStatusSelect.style.display = 'none';
            } else {
                othersInput.style.display = 'none';
                civilStatusSelect.style.display = 'block';
            }
        }
    </script>
</head>

<body>
    <section class="main">
        <h1 class="label1"> Personal Data </h1>
        <form method="POST" action="">
            <section class="wrapper">
                <!-- Page 1 -->
                <div class="page1">
                    <p class="sublabel1"> Personal Information </p>

                    <div class="row1">
                        <div>
                            <label for="lastname">Last Name</label>
                            <input type="text" name="last_name" id="lastname" class="<?php echo isset($errors['last_name']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($last_name); ?>">
                            <span class="error"><?php echo isset($errors['last_name']) ? $errors['last_name'] : ''; ?></span>
                        </div>
                        <div>
                            <label for="firstname">First Name</label>
                            <input type="text" name="first_name" id="firstname" class="<?php echo isset($errors['first_name']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($first_name); ?>">
                            <span class="error"><?php echo isset($errors['first_name']) ? $errors['first_name'] : ''; ?></span>
                        </div>
                        <div>
                            <label for="middle">Middle Initial</label>
                            <input type="text" name="middle_name" id="middle" class="<?php echo isset($errors['middle_name']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($middle_name); ?>">
                            <span class="error"><?php echo isset($errors['middle_name']) ? $errors['middle_name'] : ''; ?></span>
                        </div>
                    </div>

                    <!-- Date of Birth -->
                    <div class="details-grid">
                        <div>
                            <label>Date of Birth</label>
                            <input type="date" name="dob" class="<?php echo isset($errors['dob']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($dob); ?>">
                            <span class="error"><?php echo isset($errors['dob']) ? $errors['dob'] : ''; ?></span>
                        </div>

                        <!-- Gender -->
                        <div>
                            <label>Sex</label>
                            <div class="sex-options">
                                <label><input type="radio" name="gender" value="Male" <?php echo $gender === 'Male' ? 'checked' : ''; ?>> Male</label>
                                <label><input type="radio" name="gender" value="Female" <?php echo $gender === 'Female' ? 'checked' : ''; ?>> Female</label>
                            </div>
                            <span class="error"><?php echo isset($errors['gender']) ? $errors['gender'] : ''; ?></span>
                        </div>

                        <!-- Civil Status -->
                        <div>
                            <label id="civilStatusLabel">Civil Status</label>
                            <select name="civil_status" class="<?php echo isset($errors['civil_status']) ? 'error' : ''; ?>" onchange="toggleCivilStatusField()">
                                <option>Single</option>
                                <option>Married</option>
                                <option>Widowed</option>
                                <option>Legally Separated</option>
                                <option>Others</option>
                            </select>
                            <span class="error"><?php echo isset($errors['civil_status']) ? $errors['civil_status'] : ''; ?></span>
                        </div>

                        <div id="othersInput" style="display:none;">
                            <label for="others">Please specify:</label>
                            <input type="text" name="others" id="others" class="<?php echo isset($errors['others']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($_POST['others'] ?? ''); ?>">
                            <span class="error"><?php echo isset($errors['others']) ? $errors['others'] : ''; ?></span>
                        </div>

                        <!-- Nationality -->
                        <div>
                            <label for="nationality">Nationality</label>
                            <input type="text" name="nationality" class="<?php echo isset($errors['nationality']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($nationality); ?>">
                            <span class="error"><?php echo isset($errors['nationality']) ? $errors['nationality'] : ''; ?></span>
                        </div>

                        <!-- Religion -->
                        <div>
                            <label for="religion">Religion</label>
                            <input type="text" name="religion" class="<?php echo isset($errors['religion']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($religion); ?>">
                            <span class="error"><?php echo isset($errors['religion']) ? $errors['religion'] : ''; ?></span>
                        </div>

                        <!-- Tax Identification No. -->
                        <div>
                            <label for="tax">Tax Identification No.</label>
                            <input type="text" name="tin" class="<?php echo isset($errors['tin']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($tin); ?>">
                            <span class="error"><?php echo isset($errors['tin']) ? $errors['tin'] : ''; ?></span>
                        </div>
                    </div>
                </div>

                <!-- Page 2 -->
                <div class="page2">
                    <p class="sublabel2"> Place of Birth </p>
                    <div class="place-grid">
                        <div>
                            <label for="unit">RM/FLR/Unit No. & Bldg. Name</label>
                            <input type="text" name="unit" class="<?php echo isset($errors['unit']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($unit); ?>">
                            <span class="error"><?php echo isset($errors['unit']) ? $errors['unit'] : ''; ?></span>
                        </div>
                        <div>
                            <label for="blk">House/Lot & Blk. No</label>
                            <input type="text" name="blk" class="<?php echo isset($errors['blk']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($blk); ?>">
                            <span class="error"><?php echo isset($errors['blk']) ? $errors['blk'] : ''; ?></span>
                        </div>
                        <div>
                            <label for="street">Street Name</label>
                            <input type="text" name="street" class="<?php echo isset($errors['street']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($street); ?>">
                            <span class="error"><?php echo isset($errors['street']) ? $errors['street'] : ''; ?></span>
                        </div>
                    </div>
                </div>

                <!-- Page 3 -->
                <div class="page3">
                    <p class="sublabel3"> Home Address </p>
                    <div class="address-grid">
                        <div>
                            <label for="unit">RM/FLR/Unit No. & Bldg. Name</label>
                            <input type="text" name="unit2" class="<?php echo isset($errors['unit2']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($unit2); ?>">
                            <span class="error"><?php echo isset($errors['unit2']) ? $errors['unit2'] : ''; ?></span>
                        </div>
                        <div>
                            <label for="blk">House/Lot & Blk. No</label>
                            <input type="text" name="blk2" class="<?php echo isset($errors['blk2']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($blk2); ?>">
                            <span class="error"><?php echo isset($errors['blk2']) ? $errors['blk2'] : ''; ?></span>
                        </div>
                        <div>
                            <label for="street">Street Name</label>
                            <input type="text" name="street2" class="<?php echo isset($errors['street2']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($street2); ?>">
                            <span class="error"><?php echo isset($errors['street2']) ? $errors['street2'] : ''; ?></span>
                        </div>
                        <div>
                            <label for="phone">Phone No.</label>
                            <input type="text" name="phone" class="<?php echo isset($errors['phone']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($phone); ?>">
                            <span class="error"><?php echo isset($errors['phone']) ? $errors['phone'] : ''; ?></span>
                        </div>
                        <div>
                            <label for="email">E-mail Address</label>
                            <input type="text" name="email" class="<?php echo isset($errors['email']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($email); ?>">
                            <span class="error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
                        </div>
                    </div>
                </div>

                <!-- Page 4 -->
                <div class="page4">
                    <p class="sublabel4"> Parental Information </p>
                    <div class="parent-grid">
                        <p class="section-label">Father's Name</p>
                        <div>
                            <label for="flast">Last Name</label>
                            <input type="text" name="flast" class="<?php echo isset($errors['flast']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($flast); ?>">
                            <span class="error"><?php echo isset($errors['flast']) ? $errors['flast'] : ''; ?></span>
                        </div>
                        <div>
                            <label for="ffirst">First Name</label>
                            <input type="text" name="ffirst" class="<?php echo isset($errors['ffirst']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($ffirst); ?>">
                            <span class="error"><?php echo isset($errors['ffirst']) ? $errors['ffirst'] : ''; ?></span>
                        </div>
                        <div>
                            <label for="fmiddle">Middle Name</label>
                            <input type="text" name="fmiddle" class="<?php echo isset($errors['fmiddle']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($fmiddle); ?>">
                            <span class="error"><?php echo isset($errors['fmiddle']) ? $errors['fmiddle'] : ''; ?></span>
                        </div>

                        <p class="section-label1">Mother's Maiden Name</p>
                        <div>
                            <label for="mlast">Last Name</label>
                            <input type="text" name="mlast" class="<?php echo isset($errors['mlast']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($mlast); ?>">
                            <span class="error"><?php echo isset($errors['mlast']) ? $errors['mlast'] : ''; ?></span>
                        </div>
                        <div>
                            <label for="mfirst">First Name</label>
                            <input type="text" name="mfirst" class="<?php echo isset($errors['mfirst']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($mfirst); ?>">
                            <span class="error"><?php echo isset($errors['mfirst']) ? $errors['mfirst'] : ''; ?></span>
                        </div>
                        <div>
                            <label for="mmiddle">Middle Name</label>
                            <input type="text" name="mmiddle" class="<?php echo isset($errors['mmiddle']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($mmiddle); ?>">
                            <span class="error"><?php echo isset($errors['mmiddle']) ? $errors['mmiddle'] : ''; ?></span>
                        </div>
                    </div>
                </div>

                <div class="btn"><button type="submit" class="done">Proceed</button></div>
            </section>
        </form>
    </section>

</body>

</html>
