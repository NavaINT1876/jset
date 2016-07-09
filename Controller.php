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
            case 'approve':
                $this->approveAction();
                break;
            case 'disapprove':
                $this->disapproveAction();
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
        if (isset($_SESSION['admin'])) {
            $comments = $model->getAdminComments($sortValue, $sortOrder);
        } else {
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
            $model->updateComment($id);
            header("Location: /?r=edit&id=" . $id);
            die;
        }
        include_once('view-edit.php');
    }

    public function approveAction()
    {
        $model = new Model();
        $id = (int)$model->purifyVal($_GET['id']);
        $model->approveComment($id, 1);
        header("Location: /");
        die;
    }

    public function disapproveAction()
    {
        $model = new Model();
        $id = (int)$model->purifyVal($_GET['id']);
        $model->approveComment($id, 0);
        header("Location: /");
        die;
    }
}