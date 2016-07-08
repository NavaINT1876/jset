
<?php
$result77 = mysql_query("SELECT str FROM options", $db);
$myrow77 = mysql_fetch_array($result77);
$num = $myrow77["str"];
// Извлекаем из URL текущую страницу
$page = $_GET['page'];
// Определяем общее число сообщений в базе данных
$result00 = mysql_query("SELECT COUNT(*) FROM data WHERE secret = 0 AND cat='$cat'");
$temp = mysql_fetch_array($result00);
$posts = $temp[0];
// Находим общее число страниц
$total = (($posts - 1) / $num) + 1;
$total =  intval($total);
// Определяем начало сообщений для текущей страницы
$page = intval($page);
// Если значение $page меньше единицы или отрицательно
// переходим на первую страницу
// А если слишком большое, то переходим на последнюю
if (empty($page) or $page < 0) $page = 1;
	if($page > $total) $page = $total;
// Вычисляем начиная с какого номера
// следует выводить сообщения
$start = $page * $num - $num;
// Выбираем $num сообщений начиная с номера $start

$result = mysql_query("SELECT id,cat,title,description,date,source,mini_img,view,rating,q_vote FROM data",$db);
if (!$result){
	echo "<p>Запрос на выборку данных из базы не прошел. Напишите об этом администратору admin@mkrukov.com.<br> <strong>Код ошибки:</strong></p>";
	exit(mysql_error());
}
if (mysql_num_rows($result)>0) {
	$myrow = mysql_fetch_array($result);

	}
else {
	echo "<p>Информация по запросу не может быть извелчена. В таблице нет записей.</p>";
	exit();
}
do {
	//Тащим из базы название категории
	$cat = $myrow["cat"];
	$result1=mysql_query("SELECT title FROM categories WHERE id = $cat",$db);
	if (!$result1)	{
		echo "<p>Запрос на выборку данных из базы не прошел. Напишите об этом администратору<br> <strong>Код ошибки:</strong></p>";
		exit(mysql_error());
	}
	if (mysql_num_rows($result1)>0) {
		$myrow1=mysql_fetch_array($result1);
		$cat_name = $myrow1["title"];
	}
	else {
		echo "<p>Информация по запросу не может быть извелчена. В таблице нет записей.</p>";
		exit();
	}

	$r = $myrow['rating']/$myrow['q_vote'];
	$r = intval($r);

	printf("
	<div class='post'>
		<div class='postTitle'>
			<h2>
				<a href='view_post.php?id=%s'>%s</a>
			</h2>
		</div>
		<div class='postInfo'>Источник:&nbsp; %s <br/>Дата добавления:&nbsp; %s  &nbsp;&nbsp;| &nbsp;&nbsp;  рубрика:
			<a href='view_cat.php?cat=%s'>&nbsp;%s</a>&nbsp;&nbsp;|&nbsp;&nbsp;Просмотров:&nbsp; %s &nbsp;<img src='img/eye.png'>
		</div>
		<img src='%s'>
		<div class='postContent'>%s</div>
		<div class='post_rating'><p>Рейтинг:&nbsp; <img src='img/%s.gif'/></p></div>
		<div class='postMeta'>
			<span class='postLink'>
				<a href='view_post.php?id=%s'>подробнее</a>
			</span>
			<span class='postComments'>
				<a href='view_post.php?id=%s#com'>Комментировать</a>
			</span>
		</div>
	</div>",$myrow["id"],$myrow["title"],$myrow["source"],$myrow["date"],$cat,$cat_name,$myrow["view"],$myrow["mini_img"],$myrow["description"],$r,$myrow["id"],$myrow["id"]);
}
while ($myrow = mysql_fetch_array($result));

// Проверяем нужны ли стрелки назад
if ($page != 1) $pervpage = '<a href=view_cat.php?cat='.$cat.'&page=1>Первая</a> | <a href=view_cat.php?cat='.$cat.'&page='. ($page - 1) .'>Предыдущая</a> | ';
// Проверяем нужны ли стрелки вперед
if ($page != $total) $nextpage = ' | <a href=view_cat.php?cat='.$cat.'&page='. ($page + 1) .'>Следующая</a> | <a href=view_cat.php?cat='.$cat.'&page=' .$total. '>Последняя</a>';

// Находим две ближайшие станицы с обоих краев, если они есть
if($page - 5 > 0) $page5left = ' <a href=view_cat.php?cat='.$cat.'&page='. ($page - 5) .'>'. ($page - 5) .'</a> | ';
if($page - 4 > 0) $page4left = ' <a href=view_cat.php?cat='.$cat.'&page='. ($page - 4) .'>'. ($page - 4) .'</a> | ';
if($page - 3 > 0) $page3left = ' <a href=view_cat.php?cat='.$cat.'&page='. ($page - 3) .'>'. ($page - 3) .'</a> | ';
if($page - 2 > 0) $page2left = ' <a href=view_cat.php?cat='.$cat.'&page='. ($page - 2) .'>'. ($page - 2) .'</a> | ';
if($page - 1 > 0) $page1left = '<a href=view_cat.php?cat='.$cat.'&page='. ($page - 1) .'>'. ($page - 1) .'</a> | ';

if($page + 5 <= $total) $page5right = ' | <a href=view_cat.php?cat='.$cat.'&page='. ($page + 5) .'>'. ($page + 5) .'</a>';
if($page + 4 <= $total) $page4right = ' | <a href=view_cat.php?cat='.$cat.'&page='. ($page + 4) .'>'. ($page + 4) .'</a>';
if($page + 3 <= $total) $page3right = ' | <a href=view_cat.php?cat='.$cat.'&page='. ($page + 3) .'>'. ($page + 3) .'</a>';
if($page + 2 <= $total) $page2right = ' | <a href=view_cat.php?cat='.$cat.'&page='. ($page + 2) .'>'. ($page + 2) .'</a>';
if($page + 1 <= $total) $page1right = ' | <a href=view_cat.php?cat='.$cat.'&page='. ($page + 1) .'>'. ($page + 1) .'</a>';

// Вывод меню если страниц больше одной

if ($total > 1) {
Error_Reporting(E_ALL & ~E_NOTICE);
echo "<div class=\"pstrnav\">";
echo $pervpage.$page5left.$page4left.$page3left.$page2left.$page1left.'<b>'.$page.'</b>'.$page1right.$page2right.$page3right.$page4right.$page5right.$nextpage;
echo "</div>";
}