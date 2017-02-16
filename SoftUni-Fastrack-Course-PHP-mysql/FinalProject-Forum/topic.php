<?php
session_start();
include 'my_Functions.php';
db_init();

$cat_id=(int)$_GET['id'];
if ($cat_id>0)
{
	$rs = mysql_query_UTF8('SELECT name,active,`desc` FROM cat WHERE cat_id='.$cat_id.' AND active = 1');

	if ((mysql_num_rows($rs))==1) 
	{
		$row = mysql_fetch_assoc($rs);
		my_header($row['name'].' - '.$row['desc']);
		
		if (isset($_SESSION['is_logged']) && $_SESSION['is_logged'] === TRUE) 
		{
			echo '<div id="topic_menu"><a href="post.php?id='.$cat_id.'">Нова тема</a></div>';
		}
		
		echo '<div id="post">';
		$rs = mysql_query_UTF8('SELECT * FROM posts as p , users as u WHERE p.cat_id='.$cat_id.' 
		AND p.added_by=u.user_id ORDER BY p.date_added DESC');
		while($row = mysql_fetch_assoc($rs)) 
		{
			echo '<div class="post"><div id="autor">';
			echo $row['login'];
			echo '<p>'.date('d-m-y',$row['date_added']).'</p>';
			echo '<div class="cpost"><p class="title"><a href="in-post.php?id='.$row['post_id'].'">'.$row['title'].'</p>'.$row['content'].'</a>';			
			echo '</div></div><hr>';
		}
		echo '</div>';
		my_footer();
	}
	else 
	{
		redirect("index.php");
	}
}
else 
{
	redirect("index.php");
}




