<?php
function image_get_image_content()
{
    $dbh = connect_db();
    $query = 'SELECT * FROM user_image WHERE image_id = :id LIMIT 1';
    $stmt = $dbh->prepare($query);
    $stmt->bindValue(':id', (int)1, PDO::PARAM_INT);
    $stmt->execute();
    $image = $stmt->fetch(PDO::FETCH_ASSOC);
    $img = base64_encode($image['image_content']);
    $image_type = $image['image_type'];
    return array($image_type, $img);
}
