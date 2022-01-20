<?php 
	
		function headerFun($link){
			header("Location:$link");
		}
		session_start();
		require('script/main.php');
		$login = $_SESSION['login'];

		if (isset($_GET['logout'])) {
        session_destroy();
        headerFun("index.php");
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
	<link rel="stylesheet" href="css/style.css">
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
							<li><a href="#">Javascript</a></li>
							<li><a href="#">Php</a></li>
							<li><a href="#">Python</a></li>
							<li><a href="#">C++</a></li>
							<li><a href="#">C#</a></li>
							<li><a href="#">Java</a></li>
							<li><a href="#">Boshqalar</a></li>
						</ul>
					</li>
					<li><a href="#" class="noactiv">Administrator</a></li>
					<li><a href="#" class="noactiv">Dizayner</a></li>
					<li><a href="#" class="noactiv">Qiziqarli</a></li>
					<li><a href="#" class="noactiv">Boshqalar</a></li>
				</ul>
				<ul class="profil row">
					<li id="search"><i class="bx bx-search"></i></li>
					<?php 
						if (!empty($_SESSION['auth'])) {
							  echo "<li><a href='inputBlog.php'><i class='bx bx-edit'></i></a></li>
											<li><a href='profil.php'><i class='bx bx-user'></i></a></li>
												<div class='out column'>
													<a href='profil.php'>$login</a>
													<a href='inputBlog.php'>Blog yozish</a>
													<a href='?logout=0'>Chiqish</a>
												</div>
										";
						}else{
							echo '
							<li><a href="login.php"><i class="bx bx-edit"></i></a></li>
							<li><a href="login.php"><i class="bx bx-user"></i></a></li>
							<div class="out">
								<a href="login.php">Tizimga kirish</a>
							</div>
							 ';
						}
					 ?>					
				</ul>
			</div>

			<?php 
				// code for search
				if (!empty($_GET['searchKey'])) {
						$searchKey = $_GET['searchKey'];
						$query = "SELECT * FROM post WHERE searchKey='$searchKey'";
						$result = mysqli_fetch_assoc(mysqli_query($link,$query));
						$searchResoult = '';
						$search = "";
						if (!empty($result)) {
							$search = "active";
							$searchResoult = $result;
						}else{
							$search = "noactive";
						}
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
					if (!empty($_GET['ready'])) {
							$_SESSION['ready'] = $_GET['ready'];
							headerFun('ready.php');
					}
				 ?>

				<!-- <li class="post column">
					<div class="row author">
						<img src="img/userimg/user.svg" alt="author img">
						<h3>Qobulov Asror</h3>
						<div class="data">15.01.2021</div>
					</div>
					<img src="img/post-01.png" alt="post-01" class="postImg">
					<h2 class="postTitle">
						JavaScript nima uchun ishlatiladi ?
					</h2>
					<p class="post-text">
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim distinctio cumque tempore dolor minima sed sunt culpa quis illo provident. Voluptatibus suscipit repellat asperiores aliquid eos ducimus possimus quisquam provident, ipsam repudiandae aspernatur saepe reprehenderit nesciunt officiis illum harum ad molestiae deleniti reiciendis, nobis et blanditiis cum a recusandae? Natus fuga sequi repudiandae voluptatum quas provident velit, a libero blanditiis, nostrum, explicabo vero voluptatem placeat distinctio omnis voluptas aspernatur esse?
					</p>
					<a href="#" class="more btn">Ko'proq o'qish</a>
				</li> -->
				<?php 

					if (!empty($search)) {
							if ($search == "active") {
								
							}else{
								echo "Natija yuq !";
							}
					}else{

						$query = "SELECT * FROM post";
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
							// $text = explode(' ', $value['text']);
							// $text1 = 
							$result.='<p class="post-text">'.$value['text'].'</p>';
							$result.="<a href='?ready=".$value['id']."' class='more btn'>Ko'proq o'qish</a>";
							$result.='</li>';
						}
						echo $result;
					}

				 ?>
				<div class="driction row between">
					<a href="#" class="btn row"><i class='bx bx-left-arrow-alt'></i>Oldingi</a>
					<ul class="row drictnum">
						<li><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li>. . .</li>
						<li><a href="#">15</a></li>
					</ul>
					<a href="#" class="btn row">Keyingi <i class='bx bx-right-arrow-alt'></i></a>
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
                    <li><a href="register.php">Ro'yxatdan o'tish</a></li>
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