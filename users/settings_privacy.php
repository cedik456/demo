<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings & Privacy</title>
</head>
<body>

    <form method="POST" action="settings_privacy.php" enctype="multipart/form-data">
        <input type="hidden" name="reg_id" value="<?php echo $user_details['reg_id'];?>" >
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($user_details['first_name'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <input type="file" name="profile-pic" accept="image/*">

        <button type="submit"></button>
    </form>
    
</body>
</html>