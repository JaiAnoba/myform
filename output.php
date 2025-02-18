<?php
session_start();

// Function to calculate age
function calculateAge($dob)
{
    $birthDate = new DateTime($dob);
    $today = new DateTime();
    return $today->diff($birthDate)->y;
}

$last_name = $first_name = $middle_name = $dob = $gender = $civil_status = $nationality = $religion = $tin =
    $unit = $blk = $street = $phone = $email = $flast = $ffirst = $fmiddle = $mlast = $mfirst = $mmiddle =
    $subdivision = $barangay = $city = $province = $country = $country2 = $zip = $zip2 = $unit2 = $blk2 =
    $street2 = $subdivision2 = $barangay2 = $city2 = $province2 = $tele = $otherStatus = $age = $status_display = '';

// Checks if form data exists in the session
if (isset($_SESSION['form_data'])) {
    $formData = $_SESSION['form_data'];

    // Simplified loop to extract and sanitize form data
    $fields = [
        'last_name',
        'first_name',
        'middle_name',
        'dob',
        'gender',
        'civil_status',
        'nationality',
        'religion',
        'tin',
        'unit',
        'blk',
        'street',
        'phone',
        'email',
        'flast',
        'ffirst',
        'fmiddle',
        'mlast',
        'mfirst',
        'mmiddle',
        'subdivision',
        'barangay',
        'city',
        'province',
        'country',
        'country2',
        'zip',
        'zip2',
        'unit2',
        'blk2',
        'street2',
        'subdivision2',
        'barangay2',
        'city2',
        'province2',
        'tele',
        'otherStatus'
    ];

    foreach ($fields as $field) {
        $$field = htmlspecialchars($formData[$field] ?? ''); 
    }

    // Calculate age
    $age = calculateAge($dob);

    // Determine civil status display
    $status_display = ($civil_status === 'Others' && !empty($otherStatus)) ? htmlspecialchars($otherStatus) : htmlspecialchars($civil_status);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Output</title>
</head>

<body>
    <div class="header1">
        <img src="pics/F_LOGO.png" class="logo1">
        <p class="h_label1">Personal Data</p>
    </div>
    <section class="output_display">

        <div class="section-1">
            <div class="container-1">
                <img src="pics/4.png" class="profile">
                <div class="wrap-1">
                    <p><span class="o_name"><?php echo  $last_name . ', ' . $first_name . ' ' . substr($middle_name, 0, 1) . '.'; ?> </span></p>
                    <p><span class="o_status"><?php echo $status_display; ?></span></p>
                </div>
            </div>
            <div class="container-2">
                <div class="wrap-2">
                    <label>Age</label>
                    <p><span class="o_age"><?php echo $age; ?></span></p>
                    <label>Date of Birth</label>
                    <p><span class="o_dob"><?php echo $dob; ?></span></p>
                    <label>Gender</label>
                    <p><span class="o_sex"><?php echo $gender; ?></span></p>
                </div>
                <div class="wrap-3">
                    <label>Nationality</label>
                    <p><span class="o_nationality"><?php echo $nationality; ?></span></p>
                    <label>Religion</label>
                    <p><span class="o_religion"><?php echo $religion; ?></span></p>
                    <label>TIN</label>
                    <p><span class="o_tin"><?php echo $tin; ?></span></p>
                </div>
            </div>
            <div class="container-3">
                <div class="wrap-4">
                    <div class="sub-wrap-4">
                        <label>Phone no.</label>
                        <p><span class="o_phone"><?php echo $phone; ?></span></p>
                    </div>
                    <div class="sub-wrap-5">
                        <label>Telephone no.</label>
                        <p><span class="o_tele"><?php echo $tele; ?></span></p>
                    </div>
                </div>
                <div class="wrap-5">
                    <label>Email Address</label>
                    <p><span class="o_email"><?php echo $email; ?></span></p>
                </div>
            </div>
        </div>

        <div class="section-2">
            <h3>Place of Birth</h3>
            <div class="container-group">
                <div class="container-4">
                    <div class="separator">
                        <label>Country</label>
                        <p><span class="o_country"><?php echo $country; ?></span></p>
                    </div>
                    <div class="separator">
                        <label>Province</label>
                        <p><span class="o_province"><?php echo $province; ?></span></p>
                    </div>
                    <div class="separator">
                        <label>City/Municipality</label>
                        <p><span class="o_city"><?php echo $city; ?></span></p>
                    </div>
                    <div class="separator">
                        <label>Zip Code</label>
                        <p><span class="o_zip"><?php echo $zip; ?></span></p>
                    </div>
                    <div class="separator">
                        <label>Barangay/District/Locality</label>
                        <p><span class="o_barangay"><?php echo $barangay; ?></span></p>
                    </div>
                    <label>Street Name</label>
                    <p><span class="o_street"><?php echo $street; ?></span></p>
                    <label>Subdivision</label>
                    <p><span class="o_subdivision"><?php echo $subdivision; ?></span></p>
                    <label>House/Lot & Blk. No.</label>
                    <p><span class="o_blk"><?php echo $blk; ?></span></p>
                    <label>RM/FLR/Unit No. & Bldg. Name</label>
                    <p><span class="o_unit"><?php echo $unit; ?></span></p>
                </div>
            </div>
        </div>

        <div class="section-3">
            <h3>Home Address</h3>
            <div class="container-group">
                <div class="container-5">
                    <label>Country</label>
                    <p><span class="o_country1"><?php echo $country2; ?></span></p>
                    <label>Province</label>
                    <p><span class="o_province1"><?php echo $province2; ?></span></p>
                    <label>City/Municipality</label>
                    <p><span class="o_city1"><?php echo $city2; ?></span></p>
                    <label>Zip Code</label>
                    <p><span class="o_zip1"><?php echo $zip2; ?></span></p>
                    <label>Barangay/District/Locality</label>
                    <p><span class="o_barangay1"><?php echo $barangay2; ?></span></p>
                    <label>Street Name</label>
                    <p><span class="o_street1"><?php echo $street2; ?></span></p>
                    <label>Subdivision</label>
                    <p><span class="o_subdivision1"><?php echo $subdivision2; ?></span></p>
                    <label>House/Lot & Blk. No.</label>
                    <p><span class="o_blk1"><?php echo $blk2; ?></span></p>
                    <label>RM/FLR/Unit No. & Bldg. Name</label>
                    <p><span class="o_unit1"><?php echo $unit2; ?></span></p>
                </div>
            </div>
        </div>

        <div class="section-4">
            <h3>Parental Information</h3>
            <div class="container-8">
                <label>Father's Name</label>
                <p><span class="o_fname"><?php echo $flast . ', ' . $ffirst . ' ' . $fmiddle; ?></span></p>
            </div>
            <div class="container-9">
                <label>Mother's Maiden Name</label>
                <p><span class="o_mname"><?php echo $mlast . ', ' . $mfirst . ' ' . $mmiddle; ?></span></p>
            </div>
        </div>
    </section>
</body>

</html>