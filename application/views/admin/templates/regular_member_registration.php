<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registration Confirmation</title>
</head>
<body>
    <h2>New Regular Member Registration</h2>
    <p>Dear team,</p>
    <p>Please find below the details for a new regular registration member:</p>
    <ul>
        <li><strong>Name:</strong> <?= $title ?> <?= $first_name ?> <?= $last_name ?></li>
        <li><strong>Mobile No.:</strong> <?= $mobile_no ?></li>
        <li><strong>Phone No.:</strong> <?= $phone_no ?></li>
        <li><strong>Member Type:</strong> <?= $member_type ?></li>
        <li><strong>Membership No:</strong> <?= $membership_no ?></li>
        <li><strong>ID No.:</strong> <?= $id_passport_no ?></li>
        <li><strong>LR. No.:</strong> <?= $regular_lr_no ?></li>
        <li><strong>Profession:</strong> <?= $profession ?></li>
        <li><strong>Postal Address:</strong> <?= $postal_address ?></li>
		<li><strong>Postal Code:</strong> <?= $postal_code ?></li>
        <li><strong>Notes:</strong> <?= $notes ?></li>
    </ul>

    <p>Regards,<br>New Muthaiga Residents Association Team</p>
</body>
</html>
