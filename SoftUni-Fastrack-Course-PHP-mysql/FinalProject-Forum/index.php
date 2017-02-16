  <?php
  session_start();
  include 'my_Functions.php';
  
  my_header("Начало ---inteXXX.php---");
  
  if (!isset($_SESSION['is_logged'])) 
  {
  		$_SESSION['is_logged'] = FALSE;
  }
  db_init();
 // echo "Hello";
  $rs = mysql_query_UTF8('SELECT name,group_cat_id FROM group_cat WHERE active = 1');
  while ($row = mysql_fetch_assoc($rs)) 
  {
	  $groups[] = $row;
  }
  
  foreach ($groups as $value) 
  {
	  $rs = mysql_query_UTF8('SELECT name,cat_id,`desc` FROM cat WHERE active = 1 AND group_cat_id ='.$value['group_cat_id']);
	  echo '<div class="group_cat"><p>'.$value['name'].'</p>';
	
		  while ($row = mysql_fetch_assoc($rs)) 
		  {
			echo '<div class="cat"><a href="topic.php?id='.$row['cat_id'].'">'.$row['name'].'</a><p>'.$row['desc'].'</p></div>';  
		  }
		  echo '</div>';
  }
  
  my_footer();
  ?>
  
  
  