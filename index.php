<?php
session_start();

$fields = ['last_name', 'first_name', 'middle_name', 'dob', 'gender', 'civil_status', 'nationality', 'religion', 'tin', 'unit', 'unit2', 'blk', 'blk2', 'street', 'street2', 'phone', 'email', 'flast', 'ffirst', 'fmiddle', 'mlast', 'mfirst', 'mmiddle', 'subdivision', 'barangay', 'city', 'subdivision2', 'barangay2', 'city2',  'province', 'country', 'zip', 'province2', 'country2', 'zip2'];

$countries = ["United States", "Canada", "United Kingdom", "Australia", "Germany", "France", "India", "Japan", "China", "Philippines"];

$last_name = $first_name = $middle_name = $dob = $gender = $civil_status = $nationality = $religion = $tin = $unit = $unit2 = $blk = $street =
    $blk2 = $street2 = $phone = $email = $flast = $ffirst = $fmiddle = $mlast = $mfirst = $mmiddle = $subdivision = $barangay = $city = $province =
    $country = $zip = $zip2 = $country2 = $subdivision2 = $barangay2 = $city2 = $province2 = $phone2 = $email2 = $tele = '';

$inputNames = ['nationality', 'religion'];

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$errors = [];

if (!isset($_SESSION['form_data'])) {
    $_SESSION['form_data'] = [];
}

$form_data = $_SESSION['form_data'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['form_data'] = $_POST;

    // Loop through each field and perform validation using a for loop
    for ($i = 0; $i < count($fields); $i++) {
        $field = $fields[$i];
        $$field = trim($_POST[$field] ?? '');
        if (empty($$field)) {
            $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . " is required.";
        }
    }

    // Name Validations
    $name_fields = ['last_name', 'first_name', 'middle_name', 'flast', 'ffirst', 'fmiddle', 'mlast', 'mfirst', 'mmiddle'];
    for ($i = 0; $i < count($name_fields); $i++) {
        $field = $name_fields[$i];
        if (empty($$field) || preg_match("/^\s+$/", $$field)) {
            $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . " is required and cannot contain only spaces.";
        } elseif ($field == 'middle_name' && !preg_match("/^[a-zA-Z\.]*$/", $$field)) { // Allow period for middle initial
            $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . " must contain only letters and a period (for middle initial).";
        } elseif (!preg_match("/^[a-zA-Z\s]*$/", $$field)) { // Reject numbers for other name fields
            $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . " must contain only letters and spaces.";
        }
    }

    // RELIGION AND NATIONALTY
    for ($j = 0; $j < count($inputNames); $j++) {
        if (!empty($_POST[$inputNames[$j]])) {
            $value = trim($_POST[$inputNames[$j]]);
            $isValid = true;

            for ($k = 0; $k < strlen($value); $k++) {
                if (is_numeric($value[$k])) {
                    $isValid = false;
                    break;
                }
            }

            if (!$isValid || ctype_space($value)) {
                $errors[$inputNames[$j]] = ucfirst($inputNames[$j]) . " must contain only letters.";
            }
        }
    }

    // General Text Fields Validation (Ensuring No Spaces Only Input)
    $text_fields = ['nationality', 'religion', 'unit', 'blk', 'street', 'subdivision', 'barangay', 'city', 'province'];
    for ($i = 0; $i < count($text_fields); $i++) {
        $field = $text_fields[$i];
        if (empty($$field) || preg_match("/^\s+$/", $$field)) {
            $errors[$field] = ucfirst($field) . " is required and cannot contain only spaces.";
        }
    }

    // Date of Birth Validation
    if (empty($dob)) {
        $errors['dob'] = "Date of Birth is required.";
    } elseif (strtotime($dob) > strtotime('-18 years')) {
        $errors['dob'] = "You must be at least 18 years old.";
    }

    // Gender Validation
    if (empty($gender)) {
        $errors['gender'] = "Gender is required.";
    }

    // Civil Status Validation
    if (empty($civil_status)) {
        $errors['civil_status'] = "Civil Status is required.";
    }

    // TIN Validation
    if (empty($tin) || preg_match("/^\s+$/", $tin)) {
        $errors['tin'] = "Tax Identification No. is required and cannot contain only spaces.";
    } elseif (!preg_match("/^[0-9]{9,15}$/", $tin)) {
        $errors['tin'] = "Tax Identification No. must contain only numbers (9-15 digits).";
    }

    // Zip Code Validation
    if (empty($zip) || preg_match("/^\s+$/", $zip)) {
        $errors['zip'] = "Zip Code is required and cannot contain only spaces.";
    } elseif (!preg_match("/^[0-9]{4,6}$/", $zip)) {
        $errors['zip'] = "Zip Code must contain only 4-6 digits.";
    }

    // Phone Validation
    if (empty($phone) || preg_match("/^\s+$/", $phone)) {
        $errors['phone'] = "Phone No. is required and cannot contain only spaces.";
    } elseif (!preg_match("/^[0-9]{10,15}$/", $phone)) {
        $errors['phone'] = "Phone No. must contain only 10-15 digits.";
    }

    // Email Validation
    if (empty($email) || preg_match("/^\s+$/", $email)) {
        $errors['email'] = "E-mail Address is required and cannot contain only spaces.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }


    if ($page != 4) {
        header("Location: ?page=" . ($page + 1));
        exit();
    }


    $_SESSION['errors'] = $errors;

    if (empty($errors)) {
        if ($page < 4) {
            header("Location: ?page=" . ($page + 1));
            exit();
        } else {
            exit();
        }
    }
}


$errors = $_SESSION['errors'] ?? [];
$form_data = $_SESSION['form_data'] ?? [];

// Form fields values
$last_name = $form_data['last_name'] ?? '';
$first_name = $form_data['first_name'] ?? '';
$middle_name = $form_data['middle_name'] ?? '';
$dob = $form_data['dob'] ?? '';
$gender = $form_data['gender'] ?? '';
$civil_status = $form_data['civil_status'] ?? '';
$nationality = $form_data['nationality'] ?? '';
$religion = $form_data['religion'] ?? '';
$tin = $form_data['tin'] ?? '';
$unit = $form_data['unit'] ?? '';
$blk = $form_data['blk'] ?? '';
$street = $form_data['street'] ?? '';
$phone = $form_data['phone'] ?? '';
$email = $form_data['email'] ?? '';
$flast = $form_data['flast'] ?? '';
$ffirst = $form_data['ffirst'] ?? '';
$fmiddle = $form_data['fmiddle'] ?? '';
$mlast = $form_data['mlast'] ?? '';
$mfirst = $form_data['mfirst'] ?? '';
$mmiddle = $form_data['mmiddle'] ?? '';
$subdivision = $form_data['subdivision'] ?? '';
$barangay = $form_data['barangay'] ?? '';
$city = $form_data['city'] ?? '';
$province = $form_data['province'] ?? '';
$country = $form_data['country'] ?? '';
$country2 = $form_data['country2'] ?? '';
$zip = $form_data['zip'] ?? '';
$zip2 = $form_data['zip2'] ?? '';
$unit2 = $form_data['unit2'] ?? '';
$blk2 = $form_data['blk2'] ?? '';
$street2 = $form_data['street2'] ?? '';
$subdivision2 = $form_data['subdivision2'] ?? '';
$barangay2 = $form_data['barangay2'] ?? '';
$city2 = $form_data['city2'] ?? '';
$province2 = $form_data['province2'] ?? '';
$phone = $form_data['phone'] ?? '';
$email = $form_data['email'] ?? '';
$tele = $form_data['tele'] ?? '';
?>

<select name="country" class="<?php echo isset($errors['country']) ? 'error' : ''; ?> <?php echo ($page != 3) ? 'hide-country' : ''; ?>" style="display: none;">
    <?php for ($i = 0; $i < count($countries); $i++) { ?>
        <option value="<?php echo $countries[$i]; ?>" <?php echo ($country == $countries[$i]) ? 'selected' : ''; ?>>
            <?php echo $countries[$i]; ?>
        </option>
    <?php } ?>
</select>
<span class="error"><?php echo isset($errors['country']) ? $errors['country'] : ''; ?></span>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Form</title>

</head>

<body>
    <section class="main">
        <h1 class="label1"> Personal Data </h1>
        <form method="POST" action="?page=<?php echo $page; ?>">
            <section class="wrapper" id="pageContainer" data-page="<?php echo $page; ?>">
                <!-- Page 1 -->
                <div class="page1" style="display: <?php echo ($page == 1) ? 'block' : 'none'; ?>">
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
                        <div class="status-container">
                            <label id="civilStatusLabel">Civil Status</label>

                            <select id="civilStatus" name="civil_status" class="<?php echo isset($errors['civil_status']) ? 'error' : ''; ?>">
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widowed">Widowed</option>
                                <option value="Legally Separated">Legally Separated</option>
                                <option value="Others">Others</option>
                            </select>

                            <input type="text" id="otherStatus" name="otherStatus" placeholder="Enter your civil status">
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
                <div class="page2" style="display: <?php echo ($page == 2) ? 'block' : 'none'; ?>">
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
                        <div>
                            <label for="subdivision">Subdivision</label>
                            <input type="text" name="subdivision" class="<?php echo isset($errors['subdivision']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($subdivision); ?>">
                            <span class="error"><?php echo isset($errors['subdivision']) ? $errors['subdivision'] : ''; ?></span>
                        </div>

                        <div>
                            <label for="barangay">Barangay/District/Locality</label>
                            <input type="text" name="barangay" class="<?php echo isset($errors['barangay']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($barangay); ?>">
                            <span class="error"><?php echo isset($errors['barangay']) ? $errors['barangay'] : ''; ?></span>
                        </div>

                        <div>
                            <label for="city">City/Municipality</label>
                            <input type="text" name="city" class="<?php echo isset($errors['city']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($city); ?>">
                            <span class="error"><?php echo isset($errors['city']) ? $errors['city'] : ''; ?></span>
                        </div>

                        <div>
                            <label for="province">Province</label>
                            <input type="text" name="province" class="<?php echo isset($errors['province']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($province); ?>">
                            <span class="error"><?php echo isset($errors['province']) ? $errors['province'] : ''; ?></span>
                        </div>

                        <div>
                            <label for="country">Country</label>
                            <select name="country" id="country" class="<?php echo isset($errors['country']) ? 'error' : ''; ?>">
                                <?php for ($i = 0; $i < count($countries); $i++) { ?>
                                    <option value="<?php echo $countries[$i]; ?>" <?php echo ($country == $countries[$i]) ? 'selected' : ''; ?>>
                                        <?php echo $countries[$i]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <span class="error"><?php echo isset($errors['country']) ? $errors['country'] : ''; ?></span>
                        </div>

                        <div>
                            <label for="zip">Zip Code</label>
                            <input type="text" name="zip" class="<?php echo isset($errors['zip']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($zip); ?>">
                            <span class="error"><?php echo isset($errors['zip']) ? $errors['zip'] : ''; ?></span>
                        </div>

                    </div>
                </div>

                <!-- Page 3 -->
                <div class="page3" style="display: <?php echo ($page == 3) ? 'block' : 'none'; ?>">
                    <p class="sublabel3"> Home Address </p>
                    <div class="address-grid">
                        <div>
                            <label for="unit">RM/FLR/Unit No. & Bldg. Name</label>
                            <input type="text" name="unit2" class="<?php echo isset($errors['unit2']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($unit2); ?>">
                            <span class="error"><?php echo isset($errors['unit2']) ? $errors['unit2'] : ''; ?></span>
                        </div>
                        <div>
                            <label for="blk">House/Lot & Blk. No</label>
                            <input type="text" name="blk2" class="<?php echo isset($errors['blk2']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($blk2 ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            <span class="error"><?php echo isset($errors['blk2']) ? $errors['blk2'] : ''; ?></span>
                        </div>
                        <div>
                            <label for="street">Street Name</label>
                            <input type="text" name="street2" class="<?php echo isset($errors['street2']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($street2 ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            <span class="error"><?php echo isset($errors['street2']) ? $errors['street2'] : ''; ?></span>
                        </div>
                        <div>
                            <label for="subdivision">Subdivision</label>
                            <input type="text" name="subdivision2" class="<?php echo isset($errors['subdivision2']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($subdivision); ?>">
                            <span class="error"><?php echo isset($errors['subdivision2']) ? $errors['subdivision2'] : ''; ?></span>
                        </div>

                        <div>
                            <label for="barangay">Barangay/District/Locality</label>
                            <input type="text" name="barangay2" class="<?php echo isset($errors['barangay2']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($barangay); ?>">
                            <span class="error"><?php echo isset($errors['barangay2']) ? $errors['barangay2'] : ''; ?></span>
                        </div>

                        <div>
                            <label for="city">City/Municipality</label>
                            <input type="text" name="city2" class="<?php echo isset($errors['city2']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($city); ?>">
                            <span class="error"><?php echo isset($errors['city2']) ? $errors['city2'] : ''; ?></span>
                        </div>

                        <div>
                            <label for="province">Province</label>
                            <input type="text" name="province2" class="<?php echo isset($errors['province2']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($province); ?>">
                            <span class="error"><?php echo isset($errors['province2']) ? $errors['province2'] : ''; ?></span>
                        </div>

                        <div>
                            <label for="country">Country</label>
                            <select name="country2" class="<?php echo isset($errors['country2']) ? 'error' : ''; ?> <?php echo ($page != 3) ? 'hide-country' : ''; ?>">
                                <?php for ($i = 0; $i < count($countries); $i++) { ?>
                                    <option value="<?php echo $countries[$i]; ?>" <?php echo ($country == $countries[$i]) ? 'selected' : ''; ?>>
                                        <?php echo $countries[$i]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <span class="error"><?php echo isset($errors['country2']) ? $errors['country2'] : ''; ?></span>
                        </div>

                        <div>
                            <label for="zip">Zip Code</label>
                            <input type="text" name="zip2" class="<?php echo isset($errors['zip2']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($zip); ?>">
                            <span class="error"><?php echo isset($errors['zip2']) ? $errors['zip2'] : ''; ?></span>
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
                        <div>
                            <label for="tele">Telephone</label>
                            <input type="text" name="tele" class="<?php echo isset($errors['tele']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($tele); ?>">
                            <span class="error"><?php echo isset($errors['phone']) ? $errors['phone'] : ''; ?></span>
                        </div>
                    </div>
                </div>

                <!-- Page 4 -->
                <div class="page4" style="display: <?php echo ($page == 4) ? 'block' : 'none'; ?>">
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

                <div class="btn"><button type="submit" class="next">Proceed</button></div>
                <div class="btn1"><button type="submit" class="done">Submit</button></div>

            </section>
        </form>
    </section>

    <section class="output_display">
        <h2>Personal Data</h2>
        <div class="section">
            <h3>Personal Details</h3>
            <div class="field-container">
                <label>Name:</label>
                <p class="o_name"></p>
            </div>
            <div class="field-container">
                <label>Age:</label>
                <p class="o_age"></p>
                <label>Civil Status:</label>
                <p class="o_status"></p>
            </div>
            <div class="field-container">
                <label>Nationality:</label>
                <p class="o_nationality"></p>
                <label>Religion:</label>
                <p class="o_religion"></p>
            </div>
            <div class="field-container">
                <label>Tax Identification No.:</label>
                <p class="o_tin"></p>
                <label>E-mail Address:</label>
                <p class="o_email"></p>
            </div>
            <div class="field-container">
                <label>Phone No.:</label>
                <p class="o_phone"></p>
                <label>Telephone:</label>
                <p class="o_tele"></p>
            </div>
        </div>
        <div class="section">
            <h3>Place of Birth</h3>
            <div class="field-container">
                <label>Country:</label>
                <p class="o_country"></p>
                <label>Province:</label>
                <p class="o_province"></p>
            </div>
            <div class="field-container">
                <label>City/Municipality:</label>
                <p class="o_city"></p>
                <label>Barangay/District/Locality:</label>
                <p class="o_barangay"></p>
            </div>
            <div class="field-container">
                <label>Subdivision:</label>
                <p class="o_subdivision"></p>
                <label>House/Lot & Blk. No.:</label>
                <p class="o_blk"></p>
            </div>
            <div class="field-container">
                <label>RM/FLR/Unit No. & Bldg. Name:</label>
                <p class="o_unit"></p>
                <label>Street Name:</label>
                <p class="o_street"></p>
            </div>
            <div class="field-container">
                <label>Zip Code:</label>
                <p class="o_zip"></p>
            </div>
        </div>
        <div class="section">
            <h3>Home Address</h3>
            <div class="field-container">
                <label>Country:</label>
                <p class="o_country1"></p>
                <label>Province:</label>
                <p class="o_province1"></p>
            </div>
            <div class="field-container">
                <label>City/Municipality:</label>
                <p class="o_city1"></p>
                <label>Barangay/District/Locality:</label>
                <p class="o_barangay1"></p>
            </div>
            <div class="field-container">
                <label>Subdivision:</label>
                <p class="o_subdivision1"></p>
                <label>House/Lot & Blk. No.:</label>
                <p class="o_blk1"></p>
            </div>
            <div class="field-container">
                <label>RM/FLR/Unit No. & Bldg. Name:</label>
                <p class="o_unit1"></p>
                <label>Street Name:</label>
                <p class="o_street1"></p>
            </div>
            <div class="field-container">
                <label>Zip Code:</label>
                <p class="o_zip1"></p>
            </div>
        </div>
        <div class="section">
            <h3>Parental Information</h3>
            <div class="field-container">
                <label>Father's Name:</label>
                <p class="o_fname"></p>
            </div>
            <div class="field-container">
                <label>Mother's Name:</label>
                <p class="o_mname"></p>
            </div>
        </div>
    </section>


    <script src="main.js"></script>

</body>

</html>