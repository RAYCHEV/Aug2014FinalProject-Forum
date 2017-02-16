 <?php
session_start();
	include 'my_Functions.php';
	
	if (isset($_SESSION['is_logged']) && !$_SESSION['is_logged'] === TRUE) 
	{
		my_header("Регистрация");
		
		if (isset($_POST['form_submit']) && $_POST['form_submit'] == 1) 
		{
		// submited 
			$login = $_POST['login']; //addslashes(trim(..))
			$pass = $_POST['password']; 
			$pass2 = $_POST['password2'];
			$email = $_POST['email'];  //addslashes(trim(..))
			$full_name = $_POST['full_name'];  //addslashes(trim(..))
			
			if (strlen($login)<2) {
				
				$error_array['login'] = 'invalid login';
			}
			
			if (strlen($pass)<2) {
				
				$error_array['pass'] = 'password too short';
			}
			
			if ($pass != $pass2) {
				
				$error_array['pass_do_no_match'] = 'pass do no match';
			}
			
			if (FALSE) {  // !eregi(""), $email
				$error_array['mail'] = 'invalid mail';
			}
			
			if (FALSE) {  // !eregi("^[a-zA-Z]{3,16}$"), $name  //samo bukwi ...
				$error_array['name'] = 'invalid name';
			}
			
			if (!isset($error_array)) { // if ( !count($error_array) > 0 ) // ако няма грешки
				db_init(); // свързване с базата
				//проверка дали името или  емайла съществуват т.е. > 0
				$sql = 'SELECT COUNT(*) as cnt FROM users WHERE login="'.addslashes($login).'" OR email="'.addslashes($email).'"';
				
				echo $sql; // TEST 
				
				$res = mysql_query_UTF8($sql);  // mySQL resource
				$row = mysql_fetch_assoc($res); //обработване на ресурс
				
				 print_r($row); //TEST
				
				if ($row['cnt']==0) { // ако няма регистрирани (записани) логин , парола
					
					$query='INSERT INTO users(login,pass,real_name,email,date_registred)
					VALUES("'.addslashes($login).'","'.$pass.'","'.addslashes($full_name).'",
					"'.addslashes($email).'",'.time().')'; // md5($pass)
					
					echo "<br/>$query"; //TEST
					mysql_query_UTF8($query);
					
					if (mysql_error()) // проверяваме последната заявка дали е минала успешно 
					{
						// echo mysql_error(); 
						echo "грешка в mysql заявката";
					}
					else {
						redirect('index.php');
						exit; 
					}
				} else {
					$error_array['login'] = 'името или адреса са заети';
					$error_array['mail'] = 'името или адреса за заети';
				}
			}
		}
		else{
			echo "not submited";
		}
		
		?>
		<form action="register.php" method="post">
			login :<input type="text" name="login" />
			<?php 	if (isset($error_array['login']))
					{
					echo $error_array['login']; // невалидно име
					} ?> <br />
			password :    <input type="password" name="password" />
			<?php 	if (isset($error_array['pass']))
					{
					echo $error_array['pass']; // short pass
					} ?> <br />
			password again : <input type="password" name="password2" />
			<?php 	if (isset($error_array['pass_do_no_match']))
					{
					echo $error_array['pass_do_no_match']; // short pass
					} ?><br />

			email: <input type="text" name="email" />
			<?php 	if (isset($error_array['mail']))
					{
					echo $error_array['mail']; // 
					} ?><br />
			full name<input type="text" name="full_name" />
			<?php 	if (isset($error_array['name']))
					{
					echo $error_array['name']; // 
					} ?><br />
			<input type="hidden" name="form_submit" value="1"/>
			<input type="submit" value="регистрирай се" />
		</form>
		<?php
		my_footer();
	}
	else 
	{
		echo "<!-- re direct -->"; //TEST
		redirect('index.php');	// header('Location: index.php');
		exit;  	
	}
?> 