<?php
session_start();
if ($_SESSION['is_logged']===true)
{
	include 'my_Functions.php';
	db_init();
	$cat_id = (int)$_GET['id'];
	$rs = mysql_query_UTF8('SELECT name FROM cat WHERE cat_id='.$cat_id.' AND active = 1');
	if (mysql_num_rows($rs)==1) 
	{
		if (isset($_POST['isSubmit']) && $_POST['isSubmit']==885) {
			
			$new_name = addslashes(trim($_POST['post_title']));
			$new_content = addslashes(trim($_POST['post_content']));
			
		 	(strlen($new_name) < 2) ? $error_array['name'] = 'името е прекалено кратко': '';
			(strlen($new_content) > 6000) ? $error_array['content'] = 'съдържанието е прекалено дълго': '';
			(strlen($new_content) < 3) ? $error_array['content'] = 'съдържанието е прекалено кратко': '';
			if (!isset($error_array))
			{
				mysql_query_UTF8('INSERT INTO posts (cat_id, added_by, date_added, title, content)
				VALUES ('.$cat_id.','.$_SESSION['user_info']['user_id'].',
				'.time().',"'.$new_name.'","'.htmlspecialchars($new_content).'")');
				redirect('topic.php?id='.$cat_id);
			}
		}		
		$row = mysql_fetch_assoc($rs);
		my_header("Нова Тема".$row['name']);
		?>
			<form method="POST" action="post.php?id=<?= $cat_id ?>">
				Заглавие: <input type="text" name="post_title">
				<?php
					isset($error_array['name'])? print($error_array['name']): '' ;
				?>
				<br />
				Съдържание: <textarea name="post_content" rows="15" cols="25"></textarea>
				<?php
					isset($error_array['content'])? print($error_array['content']): '' ;
				?>
				<br />
							<input type="submit" value="OK">
							<input type="hidden" name="isSubmit" value="885" />
			</form>	
		<?php
		
		
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



?>