<?php
include 'assets/konektor.php';
function generateAvatar($username)
{
    $initial = strtoupper($username[0]);
    return "https://ui-avatars.com/api/?name=$initial&background=random&color=fff";
}

function namauser($user_id)

{
    global $konektor;
    $query = mysqli_query($konektor, "SELECT nama FROM users WHERE idusers = $user_id");
    $result = mysqli_fetch_assoc($query);
    return $result['nama'];
}
