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

		// menu target 
		if (!empty($_GET['menuSea'])) {
			$_SESSION['search'] = $_GET['menuSea'];
		}
		
		if(isset($_GET['admin'])){
      // if(condation){}
      headerFun('Admin/admin.php');
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
				<div id="resMenu"><i class='bx bx-menu'></i></div>
				<a href="index.php" class="logo">IT Blog</a>
				<ul class="nav row">
					<li><a href="index.php" class="activ">Barcha blog</a></li>
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
							  $cout ="<li><a href='inputBlog.php'><i class='bx bx-edit'></i></a></li>
											<li><a href='profil.php'><i class='bx bx-user'></i></a></li>
											<li class='prBox'>
												<div class='out column'>
													<a href='profil.php'>$login(profil)</a>
													<a href='inputBlog.php'>Blog yozish</a>";
												if (!empty($_SESSION['admin']) and $_SESSION['admin'] = 'Admin01') {
                    				$cout .= "<a href='?admin=0'>Admin panel</a>";
                  				}
													$cout .="<a href='?logout=0'>Chiqish</a>
												</div>
											</li>
										";
										echo $cout;

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

			<form action="index.php" method="get" class="row" id="searchWin">
				<input type="text" name="searchKey" id="searchKey">
				<input type="submit" value="Search" id="searchSubmit">
				<div id="searchCancel"><i class='bx bx-x'></i></div>
			</form>
		</div>
		<div id="resmenuwin">
				<div id="menucancel"><i class='bx bx-x'></i></div>
				<ul class="nav row">
					<li><a href="index.php" class="activ">Barcha blog</a></li>
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
					// boshqaruv
					$postHead = 1;
					$postEnd= 10;
					if (!empty($_GET['nextpage'])) {
							
					}
					$query = "SELECT * FROM post ORDER BY id DESC";
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
							$result.='<p class="post-text">'.$value['intoText'].'</p>';
							$result.="<a href='?ready=".$value['id']."' class='more btn'>Ko'proq o'qish</a>";
							$result.='</li>';
						}


				// 
				if (!empty($_GET['searchKey']) or !empty($_SESSION['search'])) {
					if (!empty($_SESSION['search'])) {
						$searchKey = $_SESSION['search'];
						$searchKey = strtolower($searchKey);
					}else{
						$searchKey = $_GET['searchKey'];
						$searchKey = strtolower($searchKey);
					}

						$query = "SELECT * FROM post";
						$result1 = mysqli_query($link,$query);
						for($data = []; $row = mysqli_fetch_assoc($result1);$data[] = $row);
						$serchRes='';
						$searchValue = array();

						foreach($data as $value){
							$serchRes = $value['searchKey'];
							if(!empty(strpos($serchRes, ','))){
								
								$posArr = explode("," , $serchRes);

								foreach($posArr as $value1){
									$value1 = strtolower($value1);
									if ($value1 == $searchKey) {
										array_push($searchValue, $value['id']);
										break;
									}
								}
								
							}else{
								if ($serchRes == $searchKey) {
										array_push($searchValue, $value['id']);
									}
							}
							
						}
						
						if (!empty($searchValue)) {
							$SeaResVal = '';
							foreach($searchValue as $value2){
								$query = "SELECT * FROM post WHERE id='$value2'";
								$result2 = mysqli_fetch_assoc(mysqli_query($link,$query));

								$SeaResVal.="<li class='post column'> <div class='row author'>";

								$author = $result2['author'];
								$query = "SELECT * FROM user WHERE id = '$author'";
								$resoult=mysqli_fetch_assoc(mysqli_query($link,$query));

								$SeaResVal.='<img src="img/userimg/'.$resoult['img'].'" alt="author img">';
								$SeaResVal.='<h3>'.$resoult['name'].'</h3>';
								$SeaResVal.='<div class="data">'.$result2['creatdate'].'</div> </div>';
								$SeaResVal.='<h2 class="postTitle">'.$result2['title'].' </h2>';
								$SeaResVal.='<img src="img/postimg/'.$result2['img'].'"alt="post-01" class="postImg">';
								$SeaResVal.='<p class="post-text">'.$result2['intoText'].'</p>';
								$SeaResVal.="<a href='?ready=".$result2['id']."' class='more btn'>Ko'proq o'qish</a>";
								$SeaResVal.='</li>';
							}
							echo $SeaResVal; 
						}else{
							echo "<div class='searchError'>Siz izlagan ma'lumot topilmadi :( </div>";
							echo "<br><br><br>";
							echo $result;
						}

						$_SESSION['search'] = null;
				}else{
					// no search box
						echo $result;
					}

				 ?>
				<div class="driction row between">
					<a href="?nextpage=level" class="btn row"><i class='bx bx-left-arrow-alt'></i>Oldingi</a>
					<ul class="row drictnum">
						<li><a href="nextpage=1-10">1-10</a></li>
						<li><a href="nextpage=10-20">10-20</a></li>
						<li>. . .</li>
						<li><a href="#">15</a></li>
					</ul>
					<a href="next" class="btn row">Keyingi <i class='bx bx-right-arrow-alt'></i></a>
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
                <h5>Copyright &copy; 2021 All rights reserved | This site is made with by <a href="#">Qobulov Asror &#xf368;</a></h5>
            </div>
        </div>
    </footer>
	<script src="script/script.js"></script>
</body>
</html>