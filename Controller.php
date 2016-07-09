<?php

/**
 * Class Controller
 *
 * Main class which contains all actions.
 * Works with Model and view templates.
 */
class Controller
{
    /**
     * Method to get route and page.
     * @return mixed
     */
    public function getRoute()
    {
        $model = new Model();
        $route = $model->purifyVal($_GET['r']);

        $sortValue = $model->purifyVal($_GET['sortVal']);
        $sortOrder = $model->purifyVal($_GET['sortOrder']);
        if (empty($sortValue) || empty($sortOrder)) {
            $sortValue = 'created_at';
            $sortOrder = 'desc';
        }
        switch ($route) {
            case '':
                $this->getTop();
                $this->mainAction($sortValue, $sortOrder);
                $this->getBottom();
                break;
            case 'login':
                $this->getTop();
                $this->loginAction();
                $this->getBottom();
                break;
            case 'logout':
                $this->logoutAction();
                break;
            case 'edit':
                $this->getTop();
                $this->editAction();
                $this->getBottom();
                break;
            default:
                include_once('404.php');
        }
        return $route;
    }

    /**
     * Method includes header into the document.
     */
    public function getTop()
    {
        include_once('header.php');
    }

    /**
     * Method includes footer into the document.
     */
    public function getBottom()
    {
        include_once('footer.php');
    }

    public function loginAction()
    {
        if (isset($_POST['submit'])) {
            session_start();
            if (Model::checkCredentials($_POST['login'], $_POST['password'])) {
                $_SESSION['admin'] = 'verified';
                header("Location: /");
                die;
            } else {
                $_SESSION['error'] = 'Wrong login or password';
                header("Location: /?r=login");
                die;
            }
        }

        include_once('view-login.php');
    }

    public function logoutAction()
    {
        session_start();
        unset($_SESSION['admin']);
        header("Location: /");
        die;
    }

    /**
     * Action shows news list.
     * @param null $sortValue
     * @param null $sortOrder
     */
    public function mainAction($sortValue, $sortOrder)
    {
        $model = new Model();
        session_start();
        if(isset($_SESSION['admin'])){
            $comments = $model->getAdminComments($sortValue, $sortOrder);
        }else{
            $comments = $model->getComments($sortValue, $sortOrder);
        }

        if (isset($_POST['submit'])) {
            $model->saveNewComment();
        }
        include_once('view-main.php');
    }
    public function editAction()
    {
        $model = new Model();
        $id = (int)$model->purifyVal($_GET['id']);

        $comment = $model->getComment($id);

        if (isset($_POST['submit'])) {
            $model->saveNewComment();
        }
        include_once('view-edit.php');
    }

//    /**
//     * Action shows page of creating new news item.
//     */
//    public function create(){
//        include_once('add-edit.php');
//    }
//
//    /**
//     * Action handles XMLHttpResuqst to create new news item.
//     */
//    public function createAJAX(){
//        $model = new Model();
//        if($model->validateItemFields()){
//            $model->saveNewItem();
//            echo 'Item was created!';
//        }else{
//            echo 'Fields missing!';
//        }
//    }
//
//    /**
//     * Action shows page of editing new news item.
//     */
//    public function edit(){
//        $model = new Model();
//        $id = $model->getIntPurify($_GET['id']);
//        $row = $model->getItem($id);
//        include_once('add-edit.php');
//    }
//
//    /**
//     * Action handles XMLHttpResuqst to edit news item.
//     */
//    public function editAJAX(){
//        $model = new Model();
//        if($model->validateItemFields()){
//            $model->updateItem($model->purifyVal($_POST['id']));
//            echo 'Changes saved!';
//        }else{
//            echo 'Fields missing!';
//        }
//    }
//
//    /**
//     * Action handles XMLHttpResuqst to remove new news item.
//     */
//    public function deleteAJAX(){
//        $model = new Model();
//        $id = $model->getIntPurify($_GET['id']);
//        $model->removeItem($id);
//    }
//
//    /**
//     * Action handles XMLHttpResuqst to create new comment.
//     */
//    public function createCommentAJAX(){
//        $model = new Model();
//        $id = $model->getIntPurify($_GET['id']);
//        $row = $model->getItem($id);
//        if($model->validateCommentFields()){
//            $model->saveNewComment();
//            echo 'Your comment was added!';
//        }else{
//            echo 'Fields missing!';
//        }
//    }
}