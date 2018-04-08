<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Book extends Model {
    public $title; // 书名
    public $describe; // 描述
    public $content; // 内容
    public $create_time_at; // 创建时间
    public $update_time_at; // 更新时间

    /**
     * 统计图书数量
     */
    public function countBooks() {
        $result = Yii::$app->db->createCommand("
            select count(`id`) as count from books
        ")->queryOne();

        return $result['count'];
    }

    /**
     * 获取图书列表
     */
    public function getBookList($pageNumber) {
        return Yii::$app->db->createCommand("
            select * from books order by create_time_at desc
        ")->queryAll();
    }

    /**
     * 删除图书
     */
    public function deleteBookById($id) {
        return Yii::$app->db->createCommand("delete from books where id = $id")->execute();
    }

    /**
     * 获取单个图书
     */
    public function getBookDetailById($id) {
        return Yii::$app->db->createCommand("select * from books where id = $id")->queryOne();
    }

    /**
     * 创建、更新图书
     */
    public function createOrUpdateBookById($data) {

        if (isset($data['id'])) {
            $isExist = Yii::$app->db->createCommand('select * from books where id = '.$data['id'])->queryAll();
        }

        if (!isset($isExist) || !$isExist) {
            return Yii::$app->db->createCommand("
                insert into books (
                    `title`,
                    `describe`,
                    `content`
                    ) values (
                    '".$data['title']."',
                    '".$data['describe']."',
                    '".$data['content']."'
                    );
            ")->execute();
        }

        return Yii::$app->db->createCommand("
            update books set
            `title` = '".$data['title']."',
            `describe` = '".$data['describe']."',
            `content` = '".$data['content']."'
            where `id` = ".$data['id'].";
        ")->execute();
    }
}

?>