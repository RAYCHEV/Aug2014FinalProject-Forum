<?php 
session_start();
include '../my_Functions.php';
my_admin_header('Под групи форуми');

db_init();

if (isset($_POST['isSubmit']) && $_POST['isSubmit']==445) 
{
	$cat_name=trim(addslashes($_POST['cat_name']));
	$desc=trim(addslashes($_POST['desc']));
	isset($_POST['edit_id']) ? $edit_id =(int)$_POST['edit_id']: $edit_id=0;
	$group_cat_id = (int)$_POST['group_select'];
	if(($group_cat_id)<0) {redirect("../logout.php");}  

	
	$rs = mysql_query_UTF8('SELECT * FROM cat WHERE name="'.$cat_name.'"');
	if (!mysql_num_rows($rs)>0)
	{
		if (strlen(trim($cat_name))>0) 
		{
			if(isset($edit_id) && $edit_id>0) //if (isset($_SESSION['edit_group_Cat_id']) && ((int)$_SESSION['edit_group_Cat_id'])>0) 
			{
				//$id = (int)$_SESSION['edit_group_Cat_id'];
				mysql_query_UTF8('UPDATE cat SET name="'.$cat_name.'",`desc`="'.$desc.'", group_cat_id='.$group_cat_id. ' WHERE cat_id='.$edit_id);
				$message_arr['edit']= "Успешно обновяване (името на групата)";
				$edit_id=0;
				//$_SESSION['edit_group_Cat_id']=0;
			}
			else 
			{
				mysql_query_UTF8('INSERT INTO cat (name,date_added,`desc`,group_cat_id)
							VALUES ("'.$cat_name.'",'.time().',"'.$desc.'",'.$group_cat_id.')');	
				echo "записа е успешен<br />";			
			}
		}
		else {
			$error_array['cat_name'] = "* невалидно име на група!";
		}
	}
	else
	{
		if(isset($edit_id) && $edit_id>0)//if (isset($_SESSION['edit_group_Cat_id']) && ((int)$_SESSION['edit_group_Cat_id'])>0)
		{
				//$id = (int)$_SESSION['edit_group_Cat_id'];
				mysql_query_UTF8('UPDATE cat SET `desc`="'.$desc.'" WHERE cat_id='.$edit_id);
				$message_arr['edit']= "Успешно обновяване на описанието";
				$edit_id = 0;
				//$_SESSION['edit_group_Cat_id']=0;
				
				// // //№№№ hardcode group_name  - да неможе да се променя полето ;)
		}
		else 
		{
			$error_array['cat_name'] = "* Името на групата вече съществува!"; 
		}
	}
}
	
$rs = mysql_query_UTF8('SELECT group_cat.name as grName, cat.name as cName, cat.desc as cDesc, cat.cat_id as cat_id FROM group_cat, cat WHERE group_cat.group_cat_id = cat.group_cat_id');
while ($row = mysql_fetch_assoc($rs))
{
	echo $row['grName']." |-| ".$row['cName']." |-| ".$row['cDesc']." |-| ".
	'<a href=sub_groups.php?mode=edit&id='.$row['cat_id'].'>редактирай</a><br />';
}

if (isset($_GET['mode']) && isset($_GET['id']) && $_GET['mode']=="edit" && $_GET['id']>0)
{
	$id=(int)$_GET['id'];
	$rs=mysql_query_UTF8('SELECT * FROM cat WHERE cat_id='.$id);
	$edit_info=mysql_fetch_assoc($rs);
	//$_SESSION['edit_group_Cat_id'] = $edit_info['group_cat_id'];
}

$rs=mysql_query_UTF8('SELECT * FROM group_cat')
?>

<form method="post" action="sub_groups.php">
	Group: <select name="group_select">
		<?php
			while ($row = mysql_fetch_assoc($rs)) 
			{
				if ($row['group_cat_id'] ==$edit_info['group_cat_id']) 
				{
					echo '<option value="'.$row['group_cat_id'].'" selected="selected">'.$row['name'].'</option>';
				}
				else 
				{
					echo '<option value="'.$row['group_cat_id'].'">'.$row['name'].'</option>';
				}
			}
		?>
		</select><br />
	Sub Group Name: <input type="text" name="cat_name" value="<?php if (isset($edit_info['name'])){ echo $edit_info['name']; } ?>"/>
		<?php 
			if (isset($error_array['cat_name'])) {
				echo $error_array['cat_name'];
			}
		?><br />
	Description: <textarea name="desc" rows="3" cols="30">
				<?php if (isset($edit_info['desc'])){ echo $edit_info['desc']; } ?>
			</textarea><br />
	<input type="hidden" name="isSubmit" value="445">
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