<?php 
	function headerFun($link){
            header("Location:$link");
    }
    require('../script/main.php');
    session_start();

    if(empty($_SESSION['admin'])){
        headerFun('../index.php');
    }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Panel</title>
    <link rel="stylesheet" href="../css/col.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <!-- header -->
<header>
      <div class="container">
        <div class="menu row between fullMenu">
          <a href="../index.php" class="logo">IT Blog</a>
          <ul class="row">
            <li><a href="../index.php">Bosh sahifa</a></li>
          </ul>
          <div class="log row" id="userName">
            <?php 
                if(!empty($_SESSION["auth"])){
                  $login = $_SESSION["login"];
                  $cout = "<div class='profil'> <b>$login</b>
                          <ul class='prof-win'>
                              <li><a href='../profil.php'>Profil sozlanmalari</a></li>
                              <li><a href='../inputBlog.php'>Blog yozish</a></li>
                  ";
                  $cout .= "<li><a href='?logout=0'>Chiqish</a></li>
                          </ul>
                      </div>
                  ";
                  echo $cout;
                  if(isset($_GET['logout'])){
                    $_SESSION['admin'] = null;
                    session_destroy();
                    headerFun("../index.php");
                  }
                }else{
                  echo "<a href='login.php' class='login'>Kirish</a>
                      <h3>/</h3>
                      <a href='regstr.php' class='regs'>Ro`yxatdan o`tish</a>";
                }
            ?>
            
          </div>
        </div>
      </div>
</header>

    <!-- /header  -->
    <!-- table 1 -->
	<div class="box1">
     <div class="container">
        <h2>Foydalanuvchilar ro'yxati</h2>
         <table>
        <tr>
            <th>id</th>
            <th>Ismi Familiyasi</th>
            <th>Email</th>
            <th>Login</th>
            <th>Yaratilgan sana</th>
            <th>O'chirish</th>
        </tr>
    <?php
        if (isset($_GET['del'])) {
            $del = $_GET['del'];
            $query = "DELETE FROM user WHERE id=$del"; 
            mysqli_query($link,$query) or die(mysqli_error($link));
        }
        $query = "SELECT * FROM user";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        $result = '';
        foreach ($data as $elem) {
        $result .= '<tr>';
            $result .= '<td>' . $elem['id'] . '</td>';
            $result .= '<td>' . $elem['name'] . '</td>';
            $result .= '<td>' . $elem['email'] . '</td>';
            $result .= '<td>' . $elem['login'] . '</td>';
            $result .= '<td>' . $elem['creatdate'] . '</td>';
            if ($elem['login']=="Admin") {
                $result .= '<td>O`chirich</td>';
            }else{
                $result .= '<td><a href="?del='.$elem['id'] . '">o`chirish</a></td>';
            }
        $result .= '</tr>';
        }
        echo $result;
    ?>
    </table>
    <br><br>
     </div>   
    </div>  

    <!-- table 2 -->

    <div class="box2">
     <div class="container">
        <h2>Barcha maqolalar</h2>
         <table>
        <tr>
            <th>id</th>
            <th>Sarlavha</th>
            <th>Mazmuni</th>
            <th>Asosiy matin</th>
            <th>Qidiruv uchun<br> kalit so`zlar</th>
            <th>Rasm manzili</th>
            <th>Muharrir</th>
            <th>Kiritilgan vaqt</th>
            <th>O'chirish</th>
        </tr>
    <?php
        if (isset($_GET['del2'])) {
            $del2 = $_GET['del2'];
            $query = "DELETE FROM post WHERE id=$del2"; 
            mysqli_query($link,$query) or die(mysqli_error($link));
        }
        $query = "SELECT * FROM post";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        $result = '';
        foreach ($data as $elem) {
        $result .= '<tr>';
            $result .= '<td>' . $elem['id'] . '</td>';
            $result .= '<td><p>' . $elem['title'] . '</p></td>';
            $result .= '<td><p>' . $elem['intoText'] . '</p></td>';
            $result .= '<td><p>' . $elem['maintext'] . '</p></td>';
            $result .= '<td><p>' . $elem['searchKey'] . '</p></td>';
            $result .= '<td><p>' . $elem['img'] . '</p></td>';

            $user1 = $elem['author'];

            $query = "SELECT * FROM user WHERE id='$user1'";
            $resoult = mysqli_fetch_assoc(mysqli_query($link,$query));

            $result .= '<td><p>' . $resoult['name'] . '</p></td>';

            $result .= '<td><p>' . $elem['creatdate'] ."<br>".$elem['creatTime']. '</p></td>';
            $result .= '<td><a href="?del2='.$elem['id'] . '">o`chirish</a></td>';
        $result .= '</tr>';
        }
        echo $result;
    ?>
    </table>
     </div>   
    </div>
    <br><br>
    
    <!-- table 3 -->

    <div class="box3">
     <div class="container">
        <h2>Izohlar ro`yxati</h2>
         <table>
        <tr>
            <th>id</th>
            <th>Foydalanuvchi</th>
            <th>Maqola</th>
            <th>Izoh</th>
            <th>Izoh qol. vaqt</th>
            <th>O'chirish</th>
        </tr>
    <?php
        if (isset($_GET['del3'])) {
            $del3 = $_GET['del3'];
            $query = "DELETE FROM comment WHERE id=$del3"; 
            mysqli_query($link,$query) or die(mysqli_error($link));
        }
        $query = "SELECT * FROM comment";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        $result = '';
        foreach ($data as $elem) {
        $result .= '<tr>';
            $result .= '<td>' . $elem['id'] . '</td>';
            $teacher1 = $elem['userId'];
            $query = "SELECT * FROM user WHERE id='$teacher1'";
            $resoult = mysqli_fetch_assoc(mysqli_query($link,$query));
            $result .= '<td>' . $resoult['name'] . '</td>';

            $postCout = $elem['postId'];
            $query = "SELECT * FROM post WHERE id='$postCout'";
            $resoult = mysqli_fetch_assoc(mysqli_query($link,$query));
            $result .= '<td>'.$resoult['title']."<br><p>".$resoult['intoText'].'</p></td>';


            $result .= '<td><p>' . $elem['comText'] . '</p></td>';
            $result .= '<td><p>' . $elem['creatdate'] ."<br>".$elem['creattime']. '</p></td>';
            $result .= '<td><a href="?del3='.$elem['fanId'] . '">o`chirish</a></td>';
        $result .= '</tr>';
        }
        echo $result;
    ?>
    </table>
     </div>   
    </div>
    <br>
    <br>
    <br>
</body>
</html>