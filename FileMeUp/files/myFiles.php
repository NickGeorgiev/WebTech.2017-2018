<?php
  require_once "Session.php";
  $session = new Session();
  if(!$session->isLogged()){
    header("Location: index.php");
  }
?>
<?php
  require_once "FileClass.php";
  require_once "UserClass.php";
  $userInfo = getUserById($_SESSION['user_id']);
  $files= getFilesForUser($userInfo['name']);
  //echo count($files);

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
 </head>
 <body>
 <header class="siteLogo">
   <p id="siteName">pFiles</p>
 </header>
 <nav class="siteNavigation">
   <ul id="leftMenu">
     <li id="mainPage"><a href="mainPage.php">Начало</a></li>
     <li id="files"><a href="#">Файлове</a>
       <ul>
         <li><a class="active "id="myFiles" href="myFiles.php">Моите файлове</a></li>
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
 <div class="mainContent">
   <table id="userFiles" class="customTable">
     <tr>
       <th>Тип</th>
       <th>Име</th>
       <th>Размер</th>
       <th>Дата на добавяне</th>
       <th>Споделен</th>
       <th>Действие</th>
     </tr>
     <?php if(empty($files)){?>
     <tr>
       <td colspan="5">Все още нямате качени файлове.</td>
     </tr>
   <?php }else for($i=0;$i<count($files);$i++){?>
     <tr>
       <td align="center"><?php if(preg_match("/image\/*/",$files[$i]['type'])){?>
                  <img class="type" src="./imgs/imageIco.png" alt="Изображение" />
            <?php }else if(preg_match("/video\/*/",$files[$i]['type'])){?>
                        <img src="./imgs/video.png" alt="Видео" />
                      <?php }else{?><img class="type" src="./imgs/other.png" alt="Изображение" /><?php }?>
       </td>
       <td>
         <a class="tooltip"href="<?php echo "../users/".$userInfo['name']."/".$files[$i]['name'];?>"><?php echo $files[$i]['name'];?>
           <span class="tooltipContent">
             <?php if (preg_match("/image\/*/",$files[$i]['type'])){?>
                    <img src="<?php echo "../users/".$userInfo['name']."/".$files[$i]['name'];?>">
            <?php }else?>
           </span>
         </a>
       </td>
       <td><?php echo round($files[$i]['size']/1024,2);?></td>
       <td><?php echo $files[$i]['date'];?></td>
       <td><?php if($files[$i]['shared']==="YES"){?>
                  <p class="shared">Да</p>
          <?php }else{?>
                  <p class="private">Не</p><?php }?>
       </td>
       <td><?php if($files[$i]['shared']==="YES"){?>
                  <button>Заключи</button>
                  <p class="delete">X</p>
          <?php }else{?>
                  <button>Отключи</button>
                  <p class="delete">X</p><?php }?>
       </td>
     </tr><?php }?>
   </table>
 </div>
 </body>
 </html>
