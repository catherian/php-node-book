<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Book;

class SiteController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Dispalys books page.
     */
    public function actionBooks() {
        return $this->render('books');
    }

    public function actionGetBooks() {
        $pageNumber = Yii::$app->request->get('page', 1);

        $model = new Book();

        $books = $model->getBookList($pageNumber);

        Yii::$app->response->format=Response::FORMAT_JSON;

        return $books;
    }

    /**
     * Dispalys books page.
     */
    public function actionEditBook() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // create and update.
            $data = Yii::$app->request->post();

            $bookModel = new Book();

            $bookModel->createOrUpdateBookById($data);

            Yii::$app->response->format=Response::FORMAT_JSON;

            return [
                "success" => true,
                "message" => (isset($data['id']) ? "更新" : "创建")."成功",
            ];
        }

        // render page.
        return $this->render('editBook', [
            'book' => isset($book) ? $book : null,
        ]);
    }

    /**
     * Get a Book
     */
    public function actionGetBook() {
        $model = new Book();

        $book = $model->getBookDetailById(Yii::$app->request->get('id'));      

        Yii::$app->response->format=Response::FORMAT_JSON;

        return $book;
    }

    /**
     * Delete book
     */
    public function actionDeleteBook() {
        $getParams = Yii::$app->request->get();

        if (isset($getParams['id'])) {
            $model = new Book();

            $model->deleteBookById($getParams['id']);
        }

        Yii::$app->response->format=Response::FORMAT_JSON;

        return [
            "success" => true,
            "message" => "删除成功",
        ];
    }
}
