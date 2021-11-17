<?php

namespace Classes;

use Controller\Pdo;
use Controller\Connect;
use Classes\GetImageAtUserId;
use Classes\GetImageAtImageId;

class UsingGetImage extends Connect
{
    /** @var string $case ('user_id','image_id')*/
    private $case;
    private $id;
    public function __construct(string $case, string $id)
    {
        $this->case = $case;
        $this->id =$id;
    }
    /**
     * データベースから取得した画像データを表示できるようにエンコードして出力します。
     *
     * @return array
     */
    public function usingGetImage():array
    {
        switch ($this->case) {
            case 'user_id':
                $get_image_user_id=new GetImageAtUserId($this->id);
                $get_image = $get_image_user_id->getImageAtUserId();
                break;
            case 'image_id':
                $get_image_image_id= new GetImageAtImageId($this->id);
                $get_image = $get_image_image_id->getImageAtImageId();
                break;
        }
        if ($get_image) {
            $send_image['image_type'] = $get_image['image_type'];
            $send_image['image_content'] = base64_encode($get_image['image_content']);
            return $send_image;
        }
        return $get_image;
    }
}
