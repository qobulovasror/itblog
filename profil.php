<?php 
    function headerFun($link){
            header("Location:$link");
    }
    require("script/main.php");
    session_start();
    $alertMessage = '';
    function alert($ele){
			$alertMessage = $ele;
		}
 ?> 
 <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Profil</title>
	<link rel="stylesheet" href="css/col.css">
	<link rel="stylesheet" href="css/profil.css">
</head>
<body>
	<?php 

		if(empty($_SESSION['auth'])){
			headerFun('index.php');
		}
		$id = $_SESSION['id'];

		// shaxsiy malumotlar uchun
		if (!empty($_GET)){
			$UpName = $_GET['name'];
			$UpLogin = $_GET['login'];
			$UpEmail = $_GET['email'];

			if(!empty($UpName) and !empty($UpLogin) and !empty($UpEmail)){
				$query = "UPDATE user SET name='$UpName',login='$UpLogin',email='$UpEmail' WHERE id='$id'"; 			
				mysqli_query($link,$query)or die(mysqli_error($link));
				$_SESSION['login'] = $UpLogin;
			}
			
		}

		// password uchun
		if(!empty($_POST['pass0']) and !empty($_POST['pass']) and $_POST['repass']==$_POST['pass']){
			$pass0 = $_POST['pass0'];
			$pass1 = $_POST['pass'];

			$query = "SELECT * FROM user WHERE id='$id'";
            $resoult = mysqli_fetch_assoc(mysqli_query($link,$query));

            if(!empty($resoult)){
              $hash = $resoult['parol'];
              if(password_verify($pass0, $hash)){
              	$pass1=password_hash($pass1, PASSWORD_DEFAULT);
                $query = "UPDATE user SET parol='$pass1' WHERE id='$id'";
                mysqli_query($link,$query)or die(mysqli_error($link));
              }
			}
		}

		$query = "SELECT * FROM user WHERE id='$id'";
		$result = mysqli_query($link,$query);
		for($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

		$login = $data[0]['login'];
		$name = $data[0]['name'];
		$email = $data[0]['email'];
		$passw = $data[0]['parol'];
	?>

	 <header>
      <div class="container">
      	<div class="row between">
      		<a href="index.php" class="logo">Online test</a>
      		<a href="index.php" class="home">Bosh sahifaga qaytish</a>
        	<div class="log row" id="userName">
            <?php 
                  echo "<div class='profil'> <b>$login</b>
                          <ul class='prof-win'>
                              <li><a href='?logout=0'>Chiqish</a></li>
                          </ul>
                      </div>
                  ";
                  if(isset($_GET['logout'])){
                    session_destroy();
                    headerFun("index.php");
                  }
            ?>
          	</div>
      	</div>
      </div>
    </header>

	 <div class="box">
	 	<div id="alert"></div>
	 	<div class="container">
	 		<h2 class="doc">Profil sahifasia xush kelibsiz. Bu yerda siz shaxsi ma'lumotlarni ko'rish va tahrirlashingiz munkin. </h2>
	 		 <div class="row">
	 		 	<div class="box-form">
	 		 		<h3>Shaxsiy ma'lumotlar</h3>
		 		 	<form action="" method="get">
		 		 		<?php echo $alertMessage;?>
			 		 	<label for="name">Ism Familiya:</label>
			 		 	<input type="text" name="name" id="name" value="<?=$data[0]['name']?>">

			 		 	<label for="login">Login:</label>
			 		 	<input type="text" name="login" id="login" value="<?=$data[0]['login']?>">

			 		 	<label for="email">Email:</label>
			 		 	<input type="text" name="email" id="email" value="<?=$data[0]['email']?>">

			 		 	<input type="submit" value="Saqlash" id="logSub">
		 		 	</form>
	 		 	</div>

	 		 	<div class="box-form">
	 		 		<h3>Maxfiylik</h3>
	 		 		<form action="" method="post">
						<label for="pass0">Joriy parol:</label>
			 		 	<input type="password" id="pass0" name="pass0">

			 		 	<label for="pass">Yangi parol:</label>
			 		 	<input type="password" id="pass" name="pass">

			 		 	<label for="repass">Yangi parolni qayta kiriting</label>
			 		 	<input type="password" id="repass" name="repass">

			 		 	<input type="submit" value="Saqlash" id="passSub">
	 		 		</form>
	 		 	</div>
	 		 </div>
	 	</div>
	 </div>
	 <div class="box2">
	 		<div class="container">
	 			<h2>Bloglaringiz</h2>
	 			<div class="content1">
	 				<?php 
	 					$query = "SELECT * FROM post WHERE author='$id'";
	 					$resoult=mysqli_query($link,$query);
	 					for($data=[];$row=mysqli_fetch_assoc($result);$data[]=$row);
	 					if (!empty($data)) {
	 						$result='';
	 						foreach($data as $value){
	 							// $result.="<table><tr>";
	 							// $result.="<th>";
	 						}
	 					}else{
	 						echo "<h3>Hozircha siz blog yozmagansiz</h3><br><a href='inputBlog.php'>Blog yozish uchun havola</a>";
	 					}
	 				?>
	 			</div>
	 		</div>
	 </div>
	 <!-- <table>
	 	<tr>
	 		<th>fafea</th>
	 		<th>dvdv</th>
	 	</tr>
	 	<tr>
	 		<td>sf</td>
	 		<td>dcsc</td>
	 	</tr>
	 </table> -->
</body>
<script>
		// target alert
	let alert1 = document.getElementById('alert');


	let parolold = document.getElementById('pass0'),
		parol = document.getElementById('pass'),
    	reparol = document.getElementById('repass');

    let passSubmit = document.getElementById('passSub');
    passSubmit.addEventListener('click',function(e){
    	// parol
	    if( parolold.value.length < 4 || parol.value.length < 4 || reparol.value.length < 4){
	        e.preventDefault();
	        alert1.innerHTML = "Parol  xato";
	        alertBlock(parolold);
	        alertBlock(parol);
	        alertBlock(reparol);
	    }else{
	        if(parol.value !== reparol.value){
	            e.preventDefault();
	            alert1.innerHTML = "Birinchi va ikkinchi parollar mos emas";
	            alertBlock(parol);
	            alertBlock(reparol);
	        }
	    }
    });


// ma'lumotlar form
    let name1 = document.getElementById('name'),
	    email = document.getElementById('email'),
	    login = document.getElementById('login');

	// Submit function
	let btnRegis = document.getElementById('logSub');
	btnRegis.addEventListener('click',function(e){
	    // name

	    if(name1.value.length < 4){
	        e.preventDefault();
	        alert1.innerHTML = "Familiya va Ism kiritilmagan";
	        alertBlock(name1); 
	    }

	    // email
	    emailTest =  /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/ ;
	    if( ! emailTest.test(email.value) ){
	        e.preventDefault();
	        alert1.innerHTML = "Email xato";
	        alertBlock(email); 
	    }

	    // login
	    if( login.value =="" || login.value.length < 4 || login.value[0]== Number){
	        e.preventDefault();
	        alert1.innerHTML = "Login  xato";
	        alertBlock(login); 
	    }
	    
	    
	})

	// Alert window 
	function alertBlock(element) {
		element.style.border = "2px solid red";
	    alert1.style.display = "block"; 
	    setTimeout(() => {
	        alert1.style.display = "none";
	    }, 4000);
	}
	alert1.addEventListener('click',function() {
	    this.style.display = "none";
	})

</script>
</html>