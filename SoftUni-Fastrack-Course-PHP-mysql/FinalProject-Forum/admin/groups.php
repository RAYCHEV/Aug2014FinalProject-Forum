<?php 
session_start();
include '../my_Functions.php';
my_admin_header('Групи форуми');

db_init();

if (isset($_POST['isSubmit']) && $_POST['isSubmit']==331) 
{
	$group_name=trim(addslashes($_POST['group_name']));
	$desc=trim(addslashes($_POST['desc']));
	isset($_POST['edit_id']) ? $edit_id =(int)$_POST['edit_id']: $edit_id=0;
	
	$rs = mysql_query_UTF8('SELECT * FROM group_cat WHERE name="'.$group_name.'"');
	if (!mysql_num_rows($rs)>0)
	{
		if (strlen(trim($group_name))>0) 
		{
			if(isset($edit_id) && $edit_id>0) //if (isset($_SESSION['edit_group_Cat_id']) && ((int)$_SESSION['edit_group_Cat_id'])>0) 
			{
				//$id = (int)$_SESSION['edit_group_Cat_id'];
				mysql_query_UTF8('UPDATE group_cat SET name="'.$group_name.'",`desc`="'.$desc.'" WHERE group_cat_id='.$edit_id);
				$message_arr['edit']= "Успешно обновяване (името на групата)";
				$edit_id=0;
				//$_SESSION['edit_group_Cat_id']=0;
			}
			else 
			{
				mysql_query_UTF8('INSERT INTO group_cat (name,date_added,`desc`)
							VALUES ("'.$group_name.'",'.time().',"'.$desc. '")');	
				echo "записа е успешен<br />";			
			}
		}
		else {
			$error_array['group_name'] = "* невалидно име на група!";
		}
	}
	else
	{
		if(isset($edit_id) && $edit_id>0)//if (isset($_SESSION['edit_group_Cat_id']) && ((int)$_SESSION['edit_group_Cat_id'])>0)
		{
				//$id = (int)$_SESSION['edit_group_Cat_id'];
				mysql_query_UTF8('UPDATE group_cat SET `desc`="'.$desc.'" WHERE group_cat_id='.$edit_id);
				$message_arr['edit']= "Успешно обновяване на описанието";
				$edit_id = 0;
				//$_SESSION['edit_group_Cat_id']=0;
				
				// // //№№№ hardcode group_name  - да неможе да се променя полето ;)
		}
		else 
		{
			$error_array['group_name'] = "* Името на групата вече съществува!"; 
		}
	}
}
	
$rs = mysql_query_UTF8('SELECT * FROM group_cat');
while ($row = mysql_fetch_assoc($rs))
{
	echo $row['name']." |-| ".$row['desc']." |-| ".'<a href=groups.php?mode=edit&id='.$row['group_cat_id'].'>редактирай</a><br />';
}

if (isset($_GET['mode']) && isset($_GET['id']) && $_GET['mode']=="edit" && $_GET['id']>0)
{
	$id=(int)$_GET['id'];
	$rs=mysql_query_UTF8('SELECT * FROM group_cat WHERE group_cat_id='.$id);
	$edit_info=mysql_fetch_assoc($rs);
	//$_SESSION['edit_group_Cat_id'] = $edit_info['group_cat_id'];
}

?>
<form method="post" action="groups.php">
	Group Name: <input type="text" name="group_name" value="<?php if (isset($edit_info['name'])){ echo $edit_info['name']; } ?>"/>
		<?php 
			if (isset($error_array['group_name'])) {
				echo $error_array['group_name'];
			}
		?><br />
	Description: <textarea name="desc" rows="3" cols="30"><?php if (isset($edit_info['desc'])){ echo $edit_info['desc']; } ?></textarea><br />
	<input type="hidden" name="isSubmit" value="331">
	<input type="submit" value="Go" /> 
	<?php
		if (isset($message_arr['edit'])) 
		{
			echo $message_arr['edit'];
		}
		if (isset($_GET['id']) && $_GET['mode'] ="edit")
		{
			echo '<input type="hidden" name="edit_id" value="'.$_GET['id'].'">';
		}
	?>
</form>

<?php 
my_footer();
?>