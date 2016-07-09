<?php

/**
 * Class Controller
 *
 * Main class which contains all actions.
 * Works with Model and view templates.
 */
class Controller {
    /**
     * Method to get route and page.
     * @return mixed
     */
    public function getRoute(){
        $model = new Model();
        $route = $model->purifyVal($_GET['r']);
        switch ($route){
            case '':
                $this->getTop();
                $this->newsList();
                $this->getBottom(); break;
            case 'single-view':
                $this->getTop();
                $this->view();
                $this->getBottom(); break;
            case 'add-news':
                $this->getTop();
                $this->create();
                $this->getBottom(); break;
            case 'edit-news':
                $this->getTop();
                $this->edit();
                $this->getBottom(); break;
            case 'edit-news-ajax':
                $this->editAJAX(); break;
            case 'create-news-ajax':
                $this->createAJAX(); break;
            case 'delete-news-ajax':
                $this->deleteAJAX(); break;
            case 'add-comment-ajax':
                $this->createCommentAJAX(); break;
            default:
                include_once('404.php');
        }
        return $route;
    }

    /**
     * Method includes header into the document.
     */
    public function getTop(){
        include_once('header.php');
    }

    /**
     * Method includes footer into the document.
     */
    public function getBottom(){
        include_once('footer.php');
    }

    /**
     * Action shows single news item with title, text, comment form and comments list.
     */
    public function view(){
        $model = new Model();
        $id = $model->getIntPurify($_GET['id']);
        $row = $model->getItem($id);
        $comments = $model->getComments($id);
        include_once('single-view.php');
    }

    /**
     * Action shows news list.
     */
    public function newsList(){
//        $model = new Model();
//        $page = $_GET['page'] ? $model->getIntPurify($_GET['page']) : 1;
//        $model->countNewsRows();
//        $paginParams = $model->getPaginationParams($page);
//        $newsArr = $model->getNewsList($page);
        include_once('view-main.php');
    }

    /**
     * Action shows page of creating new news item.
     */
    public function create(){
        include_once('add-edit.php');
    }

    /**
     * Action handles XMLHttpResuqst to create new news item.
     */
    public function createAJAX(){
        $model = new Model();
        if($model->validateItemFields()){
            $model->saveNewItem();
            echo 'Item was created!';
        }else{
            echo 'Fields missing!';
        }
    }

    /**
     * Action shows page of editing new news item.
     */
    public function edit(){
        $model = new Model();
        $id = $model->getIntPurify($_GET['id']);
        $row = $model->getItem($id);
        include_once('add-edit.php');
    }

    /**
     * Action handles XMLHttpResuqst to edit news item.
     */
    public function editAJAX(){
        $model = new Model();
        if($model->validateItemFields()){
            $model->updateItem($model->purifyVal($_POST['id']));
            echo 'Changes saved!';
        }else{
            echo 'Fields missing!';
        }
    }

    /**
     * Action handles XMLHttpResuqst to remove new news item.
     */
    public function deleteAJAX(){
        $model = new Model();
        $id = $model->getIntPurify($_GET['id']);
        $model->removeItem($id);
    }

    /**
     * Action handles XMLHttpResuqst to create new comment.
     */
    public function createCommentAJAX(){
        $model = new Model();
        $id = $model->getIntPurify($_GET['id']);
        $row = $model->getItem($id);
        if($model->validateCommentFields()){
            $model->saveNewComment();
            echo 'Your comment was added!';
        }else{
            echo 'Fields missing!';
        }
    }
}