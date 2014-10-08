<?php
session_start();
include 'my_Functions.php';
if ($_SESSION['is_logged']===true)
{
	db_init();
	$post_id = (int)$_GET['id'];
	$rs = mysql_query_UTF8('SELECT * FROM posts WHERE post_id='.$post_id);
	if (mysql_num_rows($rs)==1) 
	{
		if (isset($_POST['isSubmit']) && $_POST['isSubmit']==667) 
		{
			$new_content = addslashes(trim($_POST['post_content']));
			(strlen($new_content) > 6000) ? $error_array['content'] = 'съдържанието е прекалено дълго': '';
			(strlen($new_content) < 1) ? $error_array['content'] = 'съдържанието е прекалено кратко': '';
			if (!isset($error_array))
			{
				mysql_query_UTF8('INSERT INTO `in-posts` (post_id, added_by, date_added, content) 
				VALUES ('.$post_id.','.$_SESSION['user_info']['user_id'].',
				'.time().',"'.htmlspecialchars($new_content).'")');
				redirect('in-post.php?id='.$post_id); //
				mysql_error();
				
			}
		}		
		$row = mysql_fetch_assoc($rs);
		
		my_header($row['title']);
		
			
			echo $row['title']."<br />".$row['content']."<br />";
		$rss = mysql_query_UTF8('SELECT * FROM `in-posts` WHERE post_id='.$post_id);
		while($roww = mysql_fetch_assoc($rss)) 
		{
			echo '<p>'.date('d-m-y',$roww['date_added']).'</p>';
			echo $roww['content'];			
			echo '</div></div><hr>';
		}
		echo '</div>';
		
		
		my_footer();
		
		?>
			<form method="POST" action="in-post.php?id=<?= $post_id ?>">
				 <textarea name="post_content" rows="5" cols="30"></textarea>
				<?php
					isset($error_array['content'])? print($error_array['content']): '' ;
				?>
				<br />
							<input type="submit" value="post">
							<input type="hidden" name="isSubmit" value="667" />
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
	redirect("login.php");
}