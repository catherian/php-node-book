<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = '图书列表';

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="container">
        <div class="mb-20">
            <a class="btn btn-primary" href="/index.php?r=site/edit-book">Create a new book 📖</a>
        </div>
        <table id="JS-books-table" class="table table-bordered">
            <colgroup>
            <col width="10%"/>
            <col width="30%"/>
            <col width="20%"/>
            <col width="20%"/>


            </colgroup>
            <thead>
                <tr>
                <th>图书编号</th>
                <th>书名</th>
                <th>描述</th>
                <th>创建时间</th>
                <th>操作</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div class="mt--15">
        </div>
    </div>
</div>

<script>
    $(function() {
        $.getJSON('/index.php?r=site/get-books', function(books) {
            $('#JS-books-table tbody').html(
                books.map((book) => {
                    return (
                        "<tr>"+
                        "<td>" + book.id + "</td>" +
                        "<td>" + book.title + "</td>" +
                        "<td>" + book.describe + "</td>" +
                        "<td>" + book.create_time_at + "</td>" +
                        "<td>" +
                            "<a class='btn btn-default btn-sm' href='/index.php?r=site/edit-book&id=" + book.id + "'>编辑</a>" +
                            "<div data-id='" + book.id + "' class='btn btn-danger btn-sm ml-10 JS-delete-book'>删除</div>" +
                        "</td>" +
                        "</tr>"
                    )
                }).join('')
            );
        });
    });
</script>