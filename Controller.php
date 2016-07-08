<?php

/**
 * Class Controller
 * Main class which contains all actions.
 * Works with Model and view templates.
 */
class Controller{
    /**
     * Method to get route and page.
     * @return mixed
     */
    function getRoute(){
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
     * Method includes header and sidebar into the document.
     */
    function getTop(){
        include_once('header.php');
        include_once('sidebar.php');
    }

    /**
     * Method includes footer into the document.
     */
    function getBottom(){
        include_once('footer.php');
    }

    /**
     * Action shows single news item with title, text, comment form and comments list.
     */
    function view(){
        $model = new Model();
        $id = $model->getIntPurify($_GET['id']);
        $row = $model->getItem($id);
        $comments = $model->getComments($id);
        include_once('single-view.php');
    }

    /**
     * Action shows news list.
     */
    function newsList(){
        $model = new Model();
        $page = $_GET['page'] ? $model->getIntPurify($_GET['page']) : 1;
        $model->countNewsRows();
        $paginParams = $model->getPaginationParams($page);
        $newsArr = $model->getNewsList($page);
        include_once('list.php');
    }

    /**
     * Action shows page of creating new news item.
     */
    function create(){
        include_once('add-edit.php');
    }

    /**
     * Action handles XMLHttpResuqst to create new news item.
     */
    function createAJAX(){
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
    function edit(){
        $model = new Model();
        $id = $model->getIntPurify($_GET['id']);
        $row = $model->getItem($id);
        include_once('add-edit.php');
    }

    /**
     * Action handles XMLHttpResuqst to edit news item.
     */
    function editAJAX(){
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
    function deleteAJAX(){
        $model = new Model();
        $id = $model->getIntPurify($_GET['id']);
        $model->removeItem($id);
    }

    /**
     * Action handles XMLHttpResuqst to create new comment.
     */
    function createCommentAJAX(){
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