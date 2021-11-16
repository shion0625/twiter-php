<?php
/**
 * データベースに保存されているすべての投稿を取得します
 * @category  PHP
 * @author  shion0625 <xkaito0912@gmail.com>
 * @link  https://codelikes.com/phpDocumentor
 */

namespace Classes;

use Controller\Pdo;
use Controller\Connect;

class GetPostDB extends Connect
{
    /**
     *データベースに保存されているすべての投稿を取得します。
     *
     * @return mixed $post
     */
    public function getPosts()
    {
        parent::__construct();
        $dbh = $this->connectDb();
        try {
            $query = "SELECT u.user_name, t.*, i.image_type, i.image_content FROM users AS u INNER JOIN tweet AS t ON u.email_encode = t.user_id LEFT OUTER JOIN user_image AS i ON t.user_id = i.user_id ORDER BY t.date_time DESC";
            $stmt = $dbh->prepare($query);
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e;
            exit('データベースエラー getPosts');
        }
        return $posts;
    }
}
