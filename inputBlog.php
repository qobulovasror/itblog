<?php 
	function headerFun($link){
			header("Location:$link");
		}
	session_start();
	if (empty($_SESSION['auth'])) {
		headerFun('login.php');
	}
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
	<title>Blog yozish</title>
	<link rel="stylesheet" href="css/col.css">
	<link rel="stylesheet" href="css/inPost.css">
</head>
<body>
	<header>
      <div class="container">
      	<div class="row between">
      		<a href="index.php" class="logo">IT Blog</a>
      		<a href="index.php" class="home">Bosh sahifaga qaytish</a>
        	<div class="log row" id="userName">
            <?php 
                  echo "<div class='profil'> <b>$login</b>
                          <ul class='prof-win'>
                          	  <li><a href='profil.php'>$login (profil)</a></li>
                              <li><a href='?logout=0'>Chiqish</a></li>
                          </ul>
                      </div>
                  ";
            ?>
          	</div>
      	</div>
      </div>
    </header>

    <div class="box">
    	<div class="container">
    		<h2>Blog yozish</h2>

    		<?php 

    				if(!empty($_POST['title']) and !empty($_POST['intoText']) and !empty($_POST['text']) ){

    					// fayl yuklash
    					$uploadphoto = '';
    					if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){
    						$allowed = ["jpg" => "image/jpg", "jpeg" =>"image/jpeg", "gif" => "image/gif", "png" => "image/png"];
    						$filename = $_FILES["photo"]["name"];
						 	$filetype = $_FILES["photo"]["type"];
						 	$filesize = $_FILES["photo"]["size"];
						 	
						 	// Fayl kengaytmasi tasdiqlandimi
						 	$ext = pathinfo($filename, PATHINFO_EXTENSION);
						 	if(!array_key_exists($ext, $allowed)) die("Error: Iltimos mavjud fayl formatida yuklang.");

						 	// Fayl hajmi tasdiqlandimi? (5mb max)
						 	$maxsize = 5 * 1024 * 1024;
						 	if($filesize > $maxsize) die("Error: Ruxsat etilgan hajmdan oshib ketti");
						 	// Faylning MIME turi tekshirildimi?
							if(in_array($filetype, $allowed)){
								// Uni yuklashdan oldin mavjudligi tekshirildimi?
								if(file_exists("img/postimg/" . $filename)){
								 	$uploadphoto = $filename;
								} else{
									move_uploaded_file($_FILES["photo"]["tmp_name"], "img/postimg/".$filename);
									$uploadphoto = $filename;
				 				}
				 			} else{
				 				echo "Error: Faylni yuklashda xatolik. Qayta urunib ko'ring";
				 			}
    					}

    					$title = $_POST['title'];
    					$intoText = $_POST['intoText'];
    					$text = $_POST['text'];
    					if(!empty($_POST['searchKey'])){
    						$searchKey = "other,Boshqalar";
    					}else{
    						$searchKey = $_POST['searchKey'].",other,Boshqalar";
    					}

    					$author = $_SESSION['id'];
    					$creatdate = date("Y-m-d");
				 		$creattime = date("H:i:s");

    					$query = 'INSERT INTO post SET title="'.$title.'",intoText="'.$intoText.'",maintext="'.$text.'",searchKey="'.$searchKey.'",img="'.$uploadphoto.'",author="'.$author.'",creatdate="'.$creatdate.'",creatTime="'.$creattime.'"';
    					
    					mysqli_query($link,$query)or die(mysqli_error($link));
    							
    				}	
    			
    		 ?>

    		<form action="" method="post" enctype="multipart/form-data">
    			<label for="title">
    				<h3>Sarlavha</h3>
    			</label>
    			<input type="text" id="title" placeholder="Sarlavha" name="title">

    			<label for="titleimg">
    				<h3>Sarlavha rasmi (max.5mb)</h3>
    			</label>
    			<input type="file" id="titleimg" name="photo">

    			<label for="intoText">
    				<h3>Qisqacha mazmuni</h3>
    			</label>
    			<textarea name="intoText" id="intoText" placeholder="Qisqacha mazmuni"></textarea>

    			<div class="text-box">
    				<label for="text">
    				    <h3>Matn</h3>
    			    </label>
    			    <textarea name="text" id="text" placeholder="Matin"></textarea>

    			    <!-- <input type="file" name="textimg" id="textimg"> -->
    			    <div class="btn" id="textLink">Havola</div>
    			</div>
    			<label for="seaKey">
    				<h3>Qidiruv kalit so'zlar</h3>
    			</label>
    			<input type="text" name="searchKey" id="seaKey" placeholder="Dasturlash,Javascript,Php,...">
    			
                <div class="btn" id="forsubbtn">Yuborish</div>

                <!-- form submit -->
                <div id="fsubwin" class="column">
			    	<h3>yubormoqchimisiz ?</h3>
			    	<div class="row around">
			    		<!-- <a href="?formsub=1" class="btn">Xa</a> -->
			    		<input type="submit" value="ok" class="btn">
			    		<div class="btn" id="noSub">Yo'q</div>
			    	</div>
			    </div>
    		</form>
    	</div>
    </div>

    <!-- form submit -->
    <div id="boxBack"></div>
    <!-- error window -->
    <div id="error">Xatolik bor</div>

    <!-- link window -->
    <div id="forLink" class="column">
    	<h3>Havola joylash</h3>
    	<input type="text" id="linktext" placeholder="text">
    	<input type="text" id="linklink" placeholder="manzil">
    	<div class="row around">
    		<div class="btn" id="subbtn">Joylash</div>
    		<div class="btn" id="linkcancel">Bekor qil.</div>
    	</div>
    </div>

    <script>
    	let forsubbtn = document.getElementById('forsubbtn'),
    		boxBack = document.getElementById('boxBack'),
    		fsubwin = document.getElementById('fsubwin'),
    		noSub = document.getElementById('noSub'),
    		body1 = document.querySelector('body');

    		// submit
    	let title = document.getElementById('title'),
    		titleimg = document.getElementById('titleimg'),
    		intoText = document.getElementById('intoText'),
    		error = document.getElementById('error');

    		// link
    	let forLink = document.getElementById('forLink'),
    		linkcancel = document.getElementById('linkcancel'),
    		textLink = document.getElementById('textLink');

    	let linktext = document.getElementById('linktext'),
    		formtext = document.getElementById('text'),
    		linklink = document.getElementById('linklink'),
    		subbtn = document.getElementById('subbtn');

    	// form submit
    	forsubbtn.addEventListener('click',function(){
    		// if (title.value<4 || intoText.value<4 || formtext.value<4) {
    		// 	error.style.display = "block";
    		// 	setTimeout(function(){
    		// 		error.style.display = 'none';
    		// 	},4000)
    		// }else{
	    		boxBack.style.display = 'block';
	    		body1.style.overflow = 'hidden';
	    		fsubwin.style.display = 'block';
    		// }
    	})

    	error.addEventListener('click',function(){
    		error.style.display = 'none';
    	})


    	noSub.addEventListener('click',function(){
    		boxBack.style.display = 'none';
    		body1.style.overflow = 'hidden scroll';
    		fsubwin.style.display = 'none';
    	})

    	// form link 
    	textLink.addEventListener('click',function(){
    		forLink.style.display = 'block';
    		boxBack.style.display = 'block';
    	})
    	linkcancel.addEventListener('click',function(){
    		forLink.style.display = 'none';
    		boxBack.style.display = 'none';
    	})

    	
    	subbtn.addEventListener('click',function(){
    		if(linktext.value<4 || linklink.value < 4){
    			linktext.style.border = "1px solid red";
    			linklink.style.border = "1px solid red";
    		}else{
    			let aherh= `<a href=\\'`+linklink.value+`\\'>`+linktext.value+`</a>`;
    			formtext.value = formtext.value + aherh;
    			forLink.style.display = 'none';
    			boxBack.style.display = 'none';
    		}
    	})



    	// back win close All
    	boxBack.addEventListener('click',function(){
    		boxBack.style.display = 'none';
    		fsubwin.style.display = 'none';
    		forLink.style.display = 'none';
    	})
    </script>
</body>
</html>