<?php
session_start();
include 'my_Functions.php';
my_header("Вход");
if(isset($_POST['isSubmit']) && $_POST['isSubmit']==643)
{
	$login = trim($_POST['login_name']);
	$pass = trim($_POST['login_pass']);
	
	if (strlen($login)>2 && strlen($pass)>2) 
	{
		db_init();
		$rs=mysql_query_UTF8('SELECT * FROM users WHERE login="'.addslashes($login).'" AND pass="'.$pass.'"'); //md5($pass)
		if (mysql_num_rows($rs)==1)
		{
			$row=mysql_fetch_assoc($rs);
			if ($row['active']==1) 
			{
				$_SESSION['is_logged']=TRUE;
				$_SESSION['user_info']=$row;
				echo "Okey";	//TEST	
				redirect('index.php');
				exit;		
			}
			else 
			{
				echo "<h1>Достъпът Ви е ограничен!</h1>моля свържете се с администратор<br /><br />";	
			}
		}
		elseif (mysql_num_rows($rs)==0)
		{
			// грешен логин и/или парола	
			echo "<h1>Грешно име или парола</h1>";
		}
		else
		{
			// hack !!! Ненормално поведение	
		}
	}  
}

?> 

<form action="login.php" method="post">
	name:<input type="text" name="login_name" /><br />
	password:<input type="text" name="login_pass" /><br /> <!-- type -- > password !!! -->
	<input type="hidden" name="isSubmit" value="643" />
	<input type="submit" value="enter" />
</form>

<?php
my_footer();
?>