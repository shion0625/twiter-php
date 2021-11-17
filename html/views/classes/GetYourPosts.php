<?php
/**
 * データベースにユーザの投稿を保存します。
 *
 * @category  PHP
 * @author  shion0625 <xkaito0912@gmail.com>
 * @link  https://codelikes.com/phpDocumentor
 */

namespace Classes;

use Controller\Pdo;
use Controller\Connect;

class GetYourPosts extends Connect
{
    /** @var string $user_id */
    private $user_id;

    public function __construct($user_id)
    {
        $this-> user_id= $user_id;
    }

    public function getYourPosts()
    {
        parent::__construct();
        $dbh = $this->connectDb();
        try {
            $query = "SELECT u.user_name, t.* FROM users u INNER JOIN tweet t ON u.email_encode = t.user_id WHERE t.user_id=:user_id ORDER BY t.date_time DESC";
            $stmt = $dbh->prepare($query);
            $stmt->bindValue("user_id", $this->user_id);
            $stmt->execute();
            $your_posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e;
            exit('データベースエラー getYourPosts');
        }
        return $your_posts;
    }
}
