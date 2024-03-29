<?php

/**
 * データベースにユーザの画像を保存します。
 *
 * @category  PHP
 * @author  shion0625 <xkaito0912@gmail.com>
 * @link  https://codelikes.com/phpDocumentor
 */

namespace Classes\Image;

use Controller\Pdo;
use Controller\Connect;

class InsertImage extends Connect
{
    /** @var string $name */
    private $name;
    /** @var string $type*/
    private $type;
    /** @var mediumblob $content */
    private $content;
    /** @var int $size */
    private $size;
    /** @var string $user_id */
    private $user_id;

    public function __construct()
    {
        $this->name = $_FILES['image']['name'];
        $this->type = $_FILES['image']['type'];
        $this->content = file_get_contents($_FILES['image']['tmp_name']);
        $this->size = $_FILES['image']['size'];
        $this->user_id = $_SESSION['userID'];
    }

    /**
     *  データベースに取得した画像を保存します。
     * @return boolean
     */
    public function insertImage():bool
    {
        parent::__construct();
        $dbh = $this->connectDb();
        try {
            $query = "INSERT INTO user_image (image_name, image_type, image_content, image_size, user_id) VALUES (:image_name, :image_type, :image_content, :image_size, :user_id)";
            $stmt = $dbh->prepare($query);
            $stmt->bindValue(':image_name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':image_type', $this->type, PDO::PARAM_STR);
            $stmt->bindValue(':image_content', $this->content, PDO::PARAM_STR);
            $stmt->bindValue(':image_size', $this->size, PDO::PARAM_INT);
            $stmt->bindValue(':user_id', $this->user_id, PDO::PARAM_STR);
            $flag = $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
            exit('データベースエラー insertImage');
        }
        return $flag;
    }
}
