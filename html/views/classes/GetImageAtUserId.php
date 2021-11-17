<?php
/**
 * @category  PHP
 * @author  shion0625 <xkaito0912@gmail.com>
 * @link  https://codelikes.com/phpDocumentor
 */

namespace Classes;

use Controller\Pdo;
use Controller\Connect;

class GetImageAtUserId extends Connect
{
    /** @var string $user_id */
    private $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * ユーザの画像がデータベースに保存されているかユーザIDを用いて
     * 調べる。
     *
     * @return array
     */
    public function getImageAtUserId():array
    {
        parent::__construct();
        $dbh = $this->connectDb();
        try {
            $query = "SELECT image_type, image_content FROM user_image WHERE user_id = :user_id LIMIT 1";
            $stmt = $dbh->prepare($query);
            $stmt->bindValue(":user_id", $this->user_id);
            $stmt->execute();
            $image = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e;
            exit('データベースエラー getImageAtUserId');
        }
        return $image;
    }
}
