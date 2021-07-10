<?php
foreach ($data['users'] as $user) {
    echo "Information: " . $user->user_name . " " . $user->user_email;
    echo "<br>";
}
?>