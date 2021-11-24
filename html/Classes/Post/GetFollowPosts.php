<?php
/**
 * データベースに保存されているすべての投稿を取得します
 * @category  PHP
 * @author  shion0625 <xkaito0912@gmail.com>
 * @link  https://codelikes.com/phpDocumentor
 */

namespace Classes\Post;

use Controller\Pdo;
use Controller\Connect;

class GetFollowPost extends Connect
{
    private $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }
}