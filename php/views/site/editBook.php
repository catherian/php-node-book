<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$actionName = isset($book) ? '编辑' : '创建';

$this->title = $actionName.'图书';

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="container">
        <form>
            <div class="form-group">
                <label>图书名称</label>
                <input type="text" name="title" class="form-control" placeholder="请输入图书名称" value="<?php echo $book['title'] ?>">
            </div>

            <div class="form-group">
                <label>图书描述</label>
                <input type="text" name="describe" class="form-control" placeholder="请输入图书描述" value="<?php echo $book['describe'] ?>">
            </div>

            <div class="form-group">
                <label>图书内容</label>
                <textarea name="content" cols="30" rows="10" class="form-control" placeholder="请输入图书内容"><?php echo $book['content'] ?></textarea>
            </div>

            <div id="update-book" class="btn btn-primary"><?php echo $actionName ?>创建</button>

        </form>
    </div>
</div>

<script>
    $(function() {
        var mathchId = window.location.search.match(/id=(\d*)/);
        $.getJSON('/index.php?r=site/get-book', { id: mathchId[1] }, function(data) {
            $('form [name="title"]').val(data.title);
            $('form [name="describe"]').val(data.describe);
            $('form [name="content"]').val(data.content);
            $('form').append('<input type="hidden" name="id" value="' + data.id + '">');
        });
    });
</script>