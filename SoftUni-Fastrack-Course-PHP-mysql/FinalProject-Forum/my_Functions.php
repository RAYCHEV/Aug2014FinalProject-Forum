<?php
function my_header($title)
{
	
?>
<!DOCTYPE html>
<html>
<head>
	
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<title><?= $title; ?></title>
	
</head>
<body>
	<div id="top_menu">
	
		<?php
		if (isset($_SESSION['is_logged']) && $_SESSION['is_logged'] === TRUE) 
		{
			echo 'Здравей: '.$_SESSION['user_info']['login']; // or ['real_name']
			if ($_SESSION['user_info']['type']==3) // isAdmin 
			{
				echo '<a href="admin/admin.php">[admin panel]</a>';
			}
			echo '<a href="index.php">[начало]</a>';
			echo '<a href="logout.php">[exit]</a>';	 
		}
		else 
		{
			echo '<a href="register.php">[регистрирай се] </a>';	
			echo " или ";
			echo '<a href="login.php">[Вход] </a>';
		}
		
		?>
	</div>
	<div id="content">
<?php
}

function my_footer(){
	echo "
	  </div> <!--end content -->
	</body>	
</html>";
} 

function db_init(){
	
mysql_connect('localhost', 'gru', '123') or die('Грешка с базата данни');  //? show arguments ? 
mysql_select_db('forum');	
	
}

function redirect($url){
	header("Location: $url");
	exit;
}

function my_admin_header($title)
{
	
?>
<!DOCTYPE html>
<html>
<head>
	
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../css/style.css" type="text/css" />
	<title><?= $title; ?></title>
	
</head>
<body>
	<div id="top_menu">
	
		<?php
		if (isset($_SESSION['is_logged']) && $_SESSION['is_logged'] === TRUE && 
			isset($_SESSION['user_info']) && $_SESSION['user_info']['type'] == 3) 
		{
			echo "Admin Panel ";
			echo '<a href="../index.php">[начало]</a> | <a href="groups.php">[групи]</a> | <a href="sub_groups.php">[под групи]</a> | <a href="../logout.php">[Изход]</a>';
				
		}
		else 
		{
			redirect('../index.php');
			exit;
		}
		?>
	</div>
	<div id="content">
<?php
}

function mysql_query_UTF8($SQL)
{
	mysql_query('SET NAMES utf8');
	return mysql_query($SQL);
}

function vardump($var)
{
	  echo "<pre>";
      echo var_dump($var);
      echo  "</pre>";  	
}

?>