<?php
/**
 *emailから登録されてるユーザが判別します。
 *
 * @category  PHP
 * @author  shion0625 <xkaito0912@gmail.com>
 * @link  https://codelikes.com/phpDocumentor
 */

namespace Classes;

use Controller\Pdo;
use Controller\Connect;

class LoginDB extends Connect
{
    /** @var string $email */
    private $email;
    /** @var string  $password*/
    private $password;

    /**
     * 文字列型でemailを受け取ります。
     *
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password)
    {
        $this-> email = $email;
        $this->  password = $password;
    }

    /**
     * データベースからemailが一致するデータベースの情報を取得しています。
     *
     * @return array
     */
    private function getLoginInfo():array
    {
        parent::__construct();
        $dbh = $this->connectDb();
        try {
            $login_query = "SELECT * FROM users WHERE email=:email";
            $stmt = $dbh->prepare($login_query);
            $stmt->bindValue(":email", $this-> email, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            exit($e.'データベースエラー LoginDB > getLoginInfo');
        }
        return $result;
    }

    /**
     * 検索したユーザー名に対してパスワードが正しいかを検証
     *
     * @return void
     */
    public function checkLogin():void
    {
        $result = $this->getLoginInfo();
        if (!password_verify($this->password, $result['password'])) {
            $_SESSION['messageAlert'] = fun_h('ログインに失敗しました。');
            header('Location: /?page=login');
            exit();
        } else {
            session_regenerate_id(true); //セッションidを再発行
            $_SESSION['userID'] = $result['email_encode']; //セッションにログイン情報を登録
            $_SESSION['messageAlert'] = fun_h('ログインに成功しました。');
            $_SESSION['time'] = time();
            header('Location: /');//ログイン後のページにリダイレクト
            exit();
        }
        return;
    }
}
