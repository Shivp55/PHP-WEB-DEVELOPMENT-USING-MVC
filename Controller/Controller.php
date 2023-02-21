<?php

date_default_timezone_set('Asia/Kolkata');
require_once('Model/Model.php');
session_start();

class Controller extends Model {
	function __construct() {
		parent::__construct();

		if(isset($_SERVER['PATH_INFO'])) {
			switch ($_SERVER['PATH_INFO']) {
				case '/index':
						include 'Views/index.php';
					break;
				case '/register':
					// echo "<h1>Successfully Register</h1>";
					if(isset($_POST['regist'])) {
						$path = 'uploads/';
						    $extention = pathinfo($_FILES['profile']['name'],PATHINFO_EXTENSION);
						    $file_name = $_POST['fname'].'_'.date('YmdHis').'.'.$extention;
						    $profile = (file_exists($_FILES['profile']['tmp_name'])) ? $file_name : null;

						    $insert_data = [
						        
						        'fname' => $_POST['fname'],
						        'lname' => $_POST['lname'],
						        'email' => $_POST['email'],
						        'pass' => password_hash($_POST['password'],PASSWORD_DEFAULT),
						        'contact' => $_POST['mobile'],
						        'gender' => $_POST['gender'],
						        'address' => $_POST['address'],
						        'state' => $_POST['state'],
						        'profile' => $profile,
						        'hobbies' => implode(',',$_POST['hobbies'])
						    ];

						    $insertEx = $this->InsertData('users', $insert_data);

							if($insertEx['Code']){
								if(! is_null ($profile)){
									move_uploaded_file($_FILES['profile']['tmp_name'], $path.$file_name);
								}

								?>
								
								<script>
							        alert('<?php echo $insertEx['Message'];?>');													window.location.href='/mvc_create/login';
								</script>
								<?php
							}else{
								?>
								<script>
							        alert('<?php echo $insertEx['Message'];?>');													window.location.href='/register';




								<?php
							}

							

						}


					include('Views/header.php');
					include('Views/register.php');
					include('Views/footer.php');					break;
				case '/login':
					echo "<h1>Successfully Login</h1>";
					break;
				default:

					break;
			}
		}
	}
}

$obj = new Controller;


?>