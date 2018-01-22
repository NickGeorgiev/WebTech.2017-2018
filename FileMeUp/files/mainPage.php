<?php
  require_once "Session.php";
  $session = new Session();
  if(!$session->isLogged()){
    header("Location: index.php");
  }
?>
<?php
  require_once "Database.php";
  $files=array();
  if(!isset($_GET['name'])){
    $db = new Database('pfiles');
    $st="SELECT * FROM `files` WHERE shared='YES' ORDER BY date DESC LIMIT 20";
    $result=$db->dbConnection->query($st);
    $indx=0;
    while($row=$result->fetch(PDO::FETCH_ASSOC)){
      $files[$indx]=$row;
      $indx++;
    }
  }
  else{
    $search=$_GET['name'];
    $db = new Database('pfiles');
    $st="SELECT * FROM `files` WHERE shared='YES' and name like '%$search%'";
    $result=$db->dbConnection->query($st);
    $indx=0;
    while($row=$result->fetch(PDO::FETCH_ASSOC)){
      $files[$indx]=$row;
      $indx++;
    }
  }

 ?>
<!--DOCTYPE html-->
<html>
<head>
  <title>pFiles</title>
  <meta charset="utf-8" />
  <meta lang="bg" />
  <meta name="author" content="Nikola Georgiev" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="./styles/global.css" />
  <link rel="stylesheet" type="text/css" href="./styles/forms.css" />
</head>
<body>
<header class="siteLogo">
  <p id="siteName">pFiles</p>
</header>
<nav class="siteNavigation">
  <ul id="leftMenu">
    <li id="mainPage"><a href="mainPage.php" class="active">Начало</a></li>
    <li id="files"><a href="#">Файлове</a>
      <ul>
        <li><a id="myFiles" href="myFiles.php">Моите файлове</a></li>
        <li><a id="addFiles" href="addFiles.php">Добави файлове</a></li>
      </ul>
    </li>
  </ul>
  <ul id="rightMenu">
    <li><p>Добре дошъл, <span><?php echo $_SESSION['acc_name'];?></span> </p></li>
    <li id="settings"><img src="./imgs/settings.ico" alt="Settings"/>
      <ul>
        <li id="accountInfo"><a href="accountInfo.php">Акаунт</a></li>
        <li id="exitSite"><a href="exit.php">Изход</a></li>
      </ul>
    </li>
  </ul>
</nav>
<div id="searchZone" class="information">
  <p class="infoLabel">Добре дошъл в pFiles</p>
  <form class="searchForm" name="search" method="get">
    <input type="text" name="name" placeholder="Търси" />
  </form>
</div>
<div id="mainZone" class="mainContent">
  <table id="userFiles" class="customTable">
    <tr>
      <th onclick="sortTable(0,0)">Тип</th>
      <th onclick="sortTable(1,0)">Име</th>
      <th onclick="sortTable(2,1)">Размер</th>
      <th onclick="sortTable(3,0)">Дата на добавяне</th>
      <th onclick="sortTable(4,0)">Собственик</th>
    </tr>
    <?php if(empty($files)){?>
    <tr>
      <td colspan="5">Все още нямате качени файлове.</td>
    </tr>
  <?php }else for($i=0;$i<count($files);$i++){?>
    <tr id="<?php echo 'tr'.$i;?>">
      <td align="center"><?php if(preg_match("/image\/*/",$files[$i]['type'])){?>
                 <img class="type" src="./imgs/imageIco.png" alt="<?php echo $files[$i]['type'];?>" />
           <?php }else if(preg_match("/video\/*/",$files[$i]['type'])){?>
                       <img src="./imgs/video.png" alt="<?php echo $files[$i]['type'];?>" />
                     <?php }else{?><img class="type" src="./imgs/other.png" alt="<?php echo $files[$i]['type'];?>" /><?php }?>
      </td>
      <td>
        <a class="tooltip"href="<?php echo "../users/".$files[$i]['owner']."/".$files[$i]['name'];?>"><p><?php echo $files[$i]['name'];?></p>
          <span class="tooltipContent">
            <?php if (preg_match("/image\/*/",$files[$i]['type'])){?>
                   <img src="<?php echo "../users/".$files[$i]['owner']."/".$files[$i]['name'];?>">
           <?php }else{ if(preg_match("/video\/*/",$files[$i]['type'])){?>
                           <img src="./imgs/video.png">
                       <?php } else {?><img src="./imgs/other.png"><?php }}?>
          </span>
        </a>
      </td>
      <td><?php echo round($files[$i]['size']/1024,2);?></td>
      <td><?php echo $files[$i]['date'];?></td>
      <td><?php echo $files[$i]['owner'];?></td>
    </tr><?php }?>
  </table>
</div>
</body>
<script>
function sortTable(n,numbers) {
var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
table = document.getElementById("userFiles");
switching = true;
dir = "asc";
while (switching) {
  switching = false;
  rows = table.getElementsByTagName("TR");
  for (i = 1; i < (rows.length - 1); i++) {
    shouldSwitch = false;
    x = rows[i].getElementsByTagName("TD")[n];
    y = rows[i + 1].getElementsByTagName("TD")[n];
    if (dir == "asc") {
      if(numbers==1){
          if(parseFloat(x.innerHTML) > parseFloat(y.innerHTML)){
              shouldSwitch= true;
              break;
          }
      }
      else{
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
              shouldSwitch= true;
              break;
          }
      }
    }
      else if (dir == "desc") {
      if(numbers==1){
          if(parseFloat(x.innerHTML) < parseFloat(y.innerHTML)){
              shouldSwitch= true;
              break;
          }
      }
      else{
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
              shouldSwitch= true;
              break;
          }
      }
    }
  }
  if (shouldSwitch) {
    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
    switching = true;
    switchcount ++;
  }else {
    if (switchcount == 0 && dir == "asc") {
      dir = "desc";
      switching = true;
    }
  }
}
}
</script>
</html>
