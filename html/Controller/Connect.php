<?php
/**
 * データベースへ接続します。
 * @category  PHP
 * @author  shion0625 <xkaito0912@gmail.com>
 * @link  https://codelikes.com/phpDocumentor
 */

namespace Controller;

use Controller\Pdo;

class Connect extends Pdo
{
    /** @var string $DSN */
    private $DSN;
    /** @var string $USER */
    private $USER;
    /** @var string $PASSWORD */
    private $PASSWORD;

    /**
     * 環境変数からデータベースの情報を受け取ります。
     */
    public function __construct()
    {
        $this-> DSN = getenv('DB_DSN');
        $this-> USER = getenv('DB_USER');
        $this->PASSWORD = getenv('DB_PASSWORD');
        echo $this->DSN;
        echo "hi";
    }

    /**
     * データベースと接続します。そしてインスタンスを返します。
     * @return mixed
     */
    protected function connectDb():object
    {
        try {
            $dbh = new Pdo($this->DSN, $this->USER, $this->PASSWORD);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print_r("Connect 接続失敗: ".$e->getMessage()."\n");
            exit();
        }
        return $dbh;
    }
}
