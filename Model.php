<?php

/**
 * Class Model
 * Class works with database `testtask`
 */
class Model{
    /**
     * Instance of mysqli object which is used to set connection to database `testtask`.
     * @var
     */
    public $mysqli;

    /**
     * Title of table `news` in database.
     */
    const NEWS = 'news';

    /**
     * Title of table `comments` in database.
     */
    const COMMENTS = 'comments';

    /**
     * Amount of items(news) to show on one page.
     */
    const ITEMS_PER_PAGE = 5;

    /**
     * Constructor used to set connection to the database `testtask`.
     * Executes (connection is set) when new instance of Model is created.
     */
    function __construct(){
        $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->mysqli->connect_errno) {
            echo "Не удалось подключиться к MySQL: " . $this->mysqli->connect_error;
        }
        return $this->mysqli;
    }

    /**
     * Selects needed news item.
     * Used in action 'view' in Controller to show title and text of the news item.
     * @param $id. News item ID.
     * @return mixed. News item
     */
    function getItem($id){
        $result = $this->mysqli->query("SELECT `id`, `title` , `date` , `text` , `created_at` , `modified_at` FROM `". DB_NAME. "`.`". self::NEWS . "` WHERE id='".$id."'");
        return $result->fetch_assoc();
    }


    /**
     *
     * @return int. Amount of records in database in table `news`.
     */
    function countNewsRows(){
        $result = $this->mysqli->query("SELECT COUNT(*) FROM `". DB_NAME. "`.`". self::NEWS . "`");
        $rows = $result->fetch_assoc();
        $rowsAmount = (int)$rows['COUNT(*)'];
        return $rowsAmount;
    }

    /**
     * Method gets 5 news to show on current page.
     * @param $page. Current page from pagination.
     * @return array. Array of 5 news.
     */
    function getNewsList($page){
        $newsRows = $this->countNewsRows();
        $itemsPerPage = self::ITEMS_PER_PAGE;
        $from = $newsRows - $itemsPerPage * $page;
        if($from < 0){
            $from = 0;
            $itemsPerPage = $newsRows - ($itemsPerPage * ($page-1));
        }
        $result = $this->mysqli->query("SELECT `id`, `title` , `date` , `text` , `created_at` , `modified_at` FROM `". DB_NAME. "`.`". self::NEWS . "` LIMIT " . $from . "," . $itemsPerPage);
        $newsRowsArr = [];
        for($i = 0; $i < $result->num_rows; $i++){
            $newsRowsArr[] = $result->fetch_assoc();
        }
        return array_reverse($newsRowsArr);
    }

    /**
     * Inserts news item into database `testtask` into table `news`
     */
    function saveNewItem(){
        $this->mysqli->query(
            "INSERT INTO `". DB_NAME. "`.`".self::NEWS
        . "` (`id`, `title`, `date`, `text`, `created_at`, `modified_at`)
            VALUES (NULL, '".$this->purifyVal($_POST['title'])."', '".strtotime($this->purifyVal($_POST['date']))."', '".$this->purifyVal($_POST['text'])."', '".time()."', '".time()."')");
    }

    function removeItem($id){
        $this->mysqli->query("DELETE FROM `". DB_NAME. "`.`".self::NEWS
            . "` WHERE `" . self::NEWS . "`.`id` = '" . $id . "'");
    }

    /**
     * Updates news item into database `testtask` into table `news`
     */
    function updateItem($id){
        $this->mysqli->query(
            "UPDATE `" . DB_NAME . "`.`" . self::NEWS . "`
            SET `title` =  '" . $this->purifyVal($_POST['title']) . "',
                `date` =  '" . strtotime($this->purifyVal($_POST['date'])) . "',
                `text` =  '" . $this->purifyVal($_POST['text']) . "',
                `modified_at` =  '" . time() . "'
            WHERE  `" . DB_NAME . "`.`" . self::NEWS . "`.`id` ='" . $id."'");
    }

    /**
     * Method is used to validate news item form fields.
     * @return bool. Whether fields are validated or not.
     */
    function validateItemFields(){
        $title = $this->purifyVal($_POST['title']);
        $date = $this->purifyVal($_POST['date']);
        $text = $this->purifyVal($_POST['text']);

        if(isset($title) && $title != ''
            && isset($date) && $date != ''
            && isset($text) && $text != ''
        ){
            return true;
        }
        return false;
    }

    /**
     * Inserts comment into database `testtask` into table `comments`
     */
    function saveNewComment(){
        $this->mysqli->query(
            "INSERT INTO `". DB_NAME. "`.`".self::COMMENTS
            . "` (`id` , `news_id` , `name` , `message` , `created_at`)
            VALUES (NULL, '".$this->purifyVal($_POST['itemid'])."', '".$this->purifyVal($_POST['thename'])."', '".$this->purifyVal($_POST['comment'])."', '".time()."')");
    }



    /**
     * Method is used to validate comment form fields.
     * @return bool. Whether fields are validated or not.
     */
    function validateCommentFields(){
        $itemid = $this->purifyVal($_POST['itemid']);
        $thename = $this->purifyVal($_POST['thename']);
        $email = $this->purifyVal($_POST['email']);
        $comment = $this->purifyVal($_POST['comment']);

        if(isset($itemid) && $itemid != ''
            && isset($thename) && $thename != ''
            && isset($email) && $email != ''
            && isset($comment) && $comment != ''
        ){
            return true;
        }
        return false;
    }

    /**
     * Method gets all comments related to this news item.
     * @param $id. The news item ID.
     * @return array. All comments related to this news item.
     */
    function getComments($id){
        $result = $this->mysqli->query("SELECT `id` , `news_id` , `name` , `message` , `created_at` FROM `". DB_NAME. "`.`". self::COMMENTS . "` WHERE news_id='" . $id . "'");
        $commentsArr = [];
        for($i = 0; $i < $result->num_rows; $i++){
            $commentsArr[] = $result->fetch_array();
        }
        return array_reverse($commentsArr);
    }

    /**
     * Method gets pagination parameters.
     * @param $page. Current page.
     * @return array. Pagination parameters.
     */
    function getPaginationParams($page){
        $countPages = ceil($this->countNewsRows() / self::ITEMS_PER_PAGE);
        $active = $page;
        $countShowPages = 5;
        $url = "/index.php";
        $urlPage = $url . "?page=";
        $left = $active - 1;

        if ($left < floor($countShowPages / 2)){
            $start = 1;
        }else{
            $start = $active - floor($countShowPages / 2);
        }
        $end = $start + $countShowPages - 1;
        if ($end > $countPages) {
            $start -= ($end - $countPages);
            $end = $countPages;
            if ($start < 1) $start = 1;
        }
        $paginParams = [
            'countPages' => $countPages,
            'active' => $active,
            'countShowPages' => $countShowPages,
            'url' => $url,
            'urlPage' => $urlPage,
            'start' => $start,
            'end' => $end,
        ];
        return $paginParams;
    }

    /**
     * Basic purifying of global array $_GET value.
     * @param $get. Get integer parameter from global array $_GET
     * @return mixed
     */
    function getIntPurify($get){
        return (int)$this->mysqli->real_escape_string(htmlspecialchars(trim($get)));
    }

    /**
     * Basic purifying of global arrays $_POST and $_GET string value.
     * @param $param. POST string parameter from global arrays $_POST and $_GET
     * @return mixed
     */
    function purifyVal($param){
        return $this->mysqli->real_escape_string(htmlspecialchars(trim($param)));
    }

    /**
     * Method is used to get preview text of each news list item.
     * @param $text. Full text of news item passed here as param.
     * @return string, which is preview string showed in news list.
     */
    public static function getPreviewText($text)
    {
        if(strlen($text) > 200){
            $cutPiece = substr($text, 0, 200);
            $lastSpaceInCP = strrpos($cutPiece, ' ');
            if(!$lastSpaceInCP){
                $lastSpaceInCP = 30;
            }
            $thePreviewMessageBefore = substr($cutPiece, 0, $lastSpaceInCP) . '...';
            $thePreviewMessage = self::checkPreviewSpaces($thePreviewMessageBefore);
        }else{
            $thePreviewMessage = self::checkPreviewSpaces($text);
        }
        return $thePreviewMessage;
    }

    /**
     * Method checks preview spaces.
     * Used in static function getPreviewText() as helper.
     * @param $fullMessageText
     * @return string
     */
    public static function checkPreviewSpaces($fullMessageText){
        $words = explode(' ', $fullMessageText);
        $newFullMessageArray = [];
        foreach($words as $word){
            if(strlen($word) > 33){
                $word = substr($word,0,30) . '...';
            }
            array_push($newFullMessageArray, $word);
        }
        $newFullMessageText = implode(' ', $newFullMessageArray);
        return $newFullMessageText;
    }
}