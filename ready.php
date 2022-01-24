<?php 
	
		function headerFun($link){
			$_SESSION['ready'] = null;
			header("Location:$link");
		}
		session_start();
		require('script/main.php');
		$login = $_SESSION['login'];

		if (isset($_GET['logout'])) {
        session_destroy();
        headerFun("index.php");
		}

		if (!empty($_SESSION['ready'])) {
				$readyId = $_SESSION['ready'] ;
		}else{
				headerFun('index.php');
		}

		// menu target
		if (!empty($_GET['menuSea'])) {
			$_SESSION['search'] = $_GET['menuSea'];
			headerFun('index.php');
		}
 ?> 
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ITBlog</title>
	<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="css/col.css">
	<link rel="stylesheet" href="css/ready.css">
</head>
<body>
	<header>
		<div class="container">
			<div class="navbar row between">
				<a href="index.php" class="logo">IT Blog</a>
				<ul class="nav row">
					<li><a href="#" class="activ">Barcha blog</a></li>
					<li class="addMenu">Dasturlash +
						<ul class="navAddBox column">
							<li><a href="?menuSea=javascript">Javascript</a></li>
							<li><a href="?menuSea=php">Php</a></li>
							<li><a href="?menuSea=python">Python</a></li>
							<li><a href="?menuSea=cpp">C++</a></li>
							<li><a href="?menuSea=csh">C#</a></li>
							<li><a href="?menuSea=java">Java</a></li>
							<li><a href="?menuSea=other">Boshqalar</a></li>
						</ul>
					</li>
					<li><a href="?menuSea=administrator" class="noactiv">Administrator</a></li>
					<li><a href="?menuSea=Dizayner" class="noactiv">Dizayner</a></li>
					<li><a href="?menuSea=Qiziqarli" class="noactiv">Qiziqarli</a></li>
					<li><a href="?menuSea=Boshqalar" class="noactiv">Boshqalar</a></li>
				</ul>
				<ul class="profil row">
					<li id="search"><i class="bx bx-search"></i></li>
					<?php 
						if (!empty($_SESSION['auth'])) {
							  echo "<li><a href='inputBlog.php'><i class='bx bx-edit'></i></a></li>
											<li><a href='profil.php'><i class='bx bx-user'></i></a></li>
											<li class='prBox'>
												<div class='out column'>
													<a href='profil.php'>$login</a>
													<a href='inputBlog.php'>Blog yozish</a>
													<a href='?logout=0'>Chiqish</a>
												</div>
											</li>										
											";
						}else{
							echo '
							<li><a href="login.php"><i class="bx bx-edit"></i></a></li>
							<li><a href="login.php"><i class="bx bx-user"></i></a></li>
							<li class="prBox">
								<div class="out">
									<a href="login.php">Tizimga kirish</a>
								</div>
							</li>
							 ';
						}
					 ?>					
				</ul>
			</div>
				
			<?php 
				// code for search
				if (!empty($_GET['searchKey'])) {
						$_SESSION['search'] = $_GET['searchKey'];
						headerFun('index.php');
				}
			 ?>

			<form action="index.php" method="get" class="row" id="searchWin">
				<input type="text" name="searchKey" id="searchKey">
				<input type="submit" value="Search">
				<div id="searchCancel"><i class='bx bx-x'></i></div>
			</form>
		</div>
	</header>
	<div class="blog">
		<div class="container row">
			<ul class="blogmain column">
				<?php 

						$query = "SELECT * FROM post WHERE id='$readyId' ORDER BY id DESC";
						$result = mysqli_query($link,$query)or die(mysqli_error($link));
						for($data = []; $row = mysqli_fetch_assoc($result);$data[] = $row);
						$result = '';
							foreach ($data as $value) {
								$result.="<li class='post column'> <div class='row author'>";

								$author = $value['author'];
								$query = "SELECT * FROM user WHERE id = '$author'";
								$resoult=mysqli_fetch_assoc(mysqli_query($link,$query));

								$result.='<img src="img/userimg/'.$resoult['img'].'" alt="author img">';
								$result.='<h3>'.$resoult['name'].'</h3>';
								$result.='<div class="data">'.$value['creatdate'].'</div> </div>';
								$result.='<h2 class="postTitle">'.$value['title'].' </h2>';
								$result.='<img src="img/postimg/'.$value['img'].'"alt="post-01" class="postImg">';
								$result.='<p class="post-text">'.$value['text'].'</p>';
								$result.='</li>';
							}
							echo $result;
					

				 ?>

				 <div class="comment">
				 	<h2>Izohlar</h2>
				 	<ul class="comm">
				 		<?php 

				 		// izoh o'chirish
				 		if (!empty($_GET['delCom'])) {
				 				$delCom = $_GET['delCom'];
				 				$query = "DELETE FROM comment WHERE id='$delCom'";
				 				mysqli_query($link,$query)or die(mysqli_error($link));
				 		}
				 		// izoh chiqarish
				 			$query = "SELECT * FROM comment WHERE postId='$readyId'";
				 			$result = mysqli_query($link,$query);
				 			for($data = [];$row=mysqli_fetch_assoc($result);$data[]=$row);
				 			$result='';
				 			if (!empty($data)) {
				 				foreach($data as $value){
					 				$result.='<li class="row">';
					 				$author = $value['userId'];
									$query = "SELECT * FROM user WHERE id = '$author'";
									$resoult=mysqli_fetch_assoc(mysqli_query($link,$query));

					 				$result.='<img src="img/userimg/'.$resoult['img'].'" alt="author img">';
									$result.='<div class="com-text">';
									$result.='<div class="row"><h3>'.$resoult['name'].'</h3>';
									$result.='<div class="data">'.$value['creatdate'].'</div>';
									$result.='<div class="time">'.$value['creattime'].'</div> ';
									if (!empty($_SESSION['id']) and $_SESSION['id']==$value['userId'] ) {
										 $result.="<a class='delCom' href='?delCom=".$value['id']."'>O'chirish</a>";
									}	
									$result.="</div>";
									$result.='<p>'.$value['comText'].'</p> </div>';

									$result.='</li>';
				 				}
				 			echo $result;
				 			}else{
				 				echo "Hozircha izoh yo'q";
				 			}
				 			
				 		 ?>
				 </ul>
				  <?php 
				 		 		if (!empty($_GET['comment'])) {
				 		 			$com = $_GET['comment'];
				 		 			$userId = $_SESSION['id'];
				 		 			$postId = $readyId;
				 		 			$creatdate = date("Y-m-d");
				 		 			$creattime = date("H:i:s");
				 		 			$query = "INSERT INTO comment (userId,postId,creatdate,creattime,comText) VALUES('$userId','$postId','$creatdate','$creattime','$com')";
				 		 			mysqli_query($link,$query)or die(mysqli_error($link));
				 		 			headerFun('ready.php');
				 		 		}


				 		 		if (!empty($_SESSION['auth']) and !empty($_SESSION['id'])) {
				 		 				echo '
				 		 					<form class="addcom" method="get">
				 		 						<input type="text" placeholder="Izoh yozing" name="comment">
				 		 						<input type="submit" value="Joylash">
				 		 					</form>
				 		 				';
				 		 		}else{
				 		 			echo '
				 		 				<div class="addcom" method="get">
				 		 					<a href="login.php">Ro\'yhatdan o\'ting va izoh yozing</a>
				 		 				</div>
				 		 			';
				 		 		}
				 		  ?>
				 </div>
			</ul>
			<div class="contextMenu column">
				<div class="textsearch">
					<h2>Ko'p o'qiladigan</h2>
					<ul class="column">
						<li><a href="#">JavaScript nima uchun ishlatiladi ?</a></li>
						<li><a href="#">JavaScript nima uchun ishlatiladi ?</a></li>
					</ul>
				</div>
				<ul class="tegsearch">
					<h2>Teglar</h2>
					<li><a href="#">Javascript</a></li>
					<li><a href="#">Javascript</a></li>
					<li><a href="#">Javascript</a></li>
				</ul>
			</div>
		</div>
	</div>
	<footer id="contact">
        <div class="container">
            <div class="row">
                <div class="item item1 column">
                  <h4>IT Blok</h4>
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum commodi eos blanditiis pariatur laboriosam tenetur dolor ex facilis, dolorum officia laudantium minima voluptatibus ratione atque aliquam in sed unde magnam?</p>
                </div>
                <div class="item column">
                  <h4>Sizning accaunt</h4>
                  <ul class="column">
                    <li><a href="login.php">Kirish</a></li>
                    <li><a href="regstr.php">Ro'yxatdan o'tish</a></li>
                    <li><a href="<?php 
                    if(!empty($_SESSION['auth'])){
                    	echo "profil.php";
                    }else{
                    	echo "login.php";
                    } ?>">Profil</a></li>
                    <li><a href="<?php 
                    if(!empty($_SESSION['auth'])){
                    	echo "profil.php";
                    }else{
                    	echo "inputBlog.php";
                    } ?>">Post yozish</a></li>
                  </ul>
                </div>
                <div class="item column">
                  <h4>Bo'glanish turlari</h4>
                  <ul class="column">
                    <li><i class="bx bx-phone"></i><b>Tel.:</b> +998 (93) 358 28 27</li>
                    <li><a href="#"><i class="bx bx-mail-send"></i><b>Gmail:</b> qobulovasror0@gmail.com</a></li>
                    <li><a href="#"><i class="bx bxl-telegram"></i>Telegram</a></li>
                  </ul>
                </div>
            </div>
            <hr>
            <div class="copry">
                <h5>Copyright &copy; 2021 All rights reserved | This site is made with by <a href="#">Qobulov Asror</a></h5>
            </div>
        </div>
    </footer>
	<script src="script/script.js"></script>
</body>
</html>