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
   <link rel="stylesheet" type="text/css" href="./styles/forms.css" />
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
 <div class="information">
   <p class="infoLabel">Твоите файлове</p><br />
   <p class="infoText">Всички твои файлове и информация за тях.</p><br />
 </div>
 <div class="mainContent">
   <table id="userFiles" class="customTable">
     <tr>
       <th onclick="sortTable(0,0)">Тип</th>
       <th onclick="sortTable(1,0)">Име</th>
       <th onclick="sortTable(2,1)">Размер</th>
       <th onclick="sortTable(3,0)">Дата на добавяне</th>
       <th onclick="sortTable(4,0)">Споделен</th>
       <th>Действие</th>
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
         <a class="tooltip"href="<?php echo "../users/".$userInfo['name']."/".$files[$i]['name'];?>"><p><?php echo $files[$i]['name'];?></p>
           <span class="tooltipContent">
             <?php if (preg_match("/image\/*/",$files[$i]['type'])){?>
                    <img src="<?php echo "../users/".$userInfo['name']."/".$files[$i]['name'];?>">
            <?php }else{ if(preg_match("/video\/*/",$files[$i]['type'])){?>
                            <img src="./imgs/video.png">
                        <?php } else {?><img src="./imgs/other.png"><?php }}?>
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
                  <img class="icon" src="./imgs/private.gif" alt="lock" onclick="share(<?php echo $i;?>,0)"/>
                  <img class="icon" src="./imgs/delete.ico" alt="delete" onclick="deleteRow(<?php echo $i;?>)"/>
          <?php }else{?>
                  <img class="icon" src="./imgs/share.ico" alt="share" onclick="share(<?php echo $i;?>,1)"/>
                  <img class="icon" src="./imgs/delete.ico" alt="delete" onclick="deleteRow(<?php echo $i;?>)"/><?php }?>
       </td>
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
    function handleResponse(response,target){
        if(response == "Success"){
            var targetId="tr"+target;
            var toChange = document.getElementById(targetId).getElementsByTagName("td")[4].getElementsByTagName('p')[0];
            if(toChange.innerHTML=="Да"){
                toChange.className='private';
                toChange.innerHTML='Не';
            }
            else{
                toChange.className='shared';
                toChange.innerHTML='Да';
            }
        }
    }
    function deleteRow(element){
        var elemId = "tr"+element;
        var tableRow = document.getElementById(elemId);
        var fileName = tableRow.getElementsByTagName("td")[1];
        var fileType = tableRow.getElementsByTagName("td")[0].getElementsByTagName('img')[0].alt;
        var fileNameText=fileName.getElementsByTagName("a")[0].childNodes[0].innerHTML;
        var deleteForm = new FormData();
        var xhrReq = new XMLHttpRequest();
        deleteForm.append('name',fileNameText);
        deleteForm.append('type',fileType);
        xhrReq.open('post','deleteFile.php');
        xhrReq.send(deleteForm);
        xhrReq.onload=function(){
            var response = this.responseText;
            if(response=="Success"){
                location.reload();
            }
        }
    }
    function share(element,type){
        var elemId = "tr"+element;
        var tableRow = document.getElementById(elemId);
        var fileName = tableRow.getElementsByTagName("td")[1];
        var fileType = tableRow.getElementsByTagName("td")[0].getElementsByTagName('img')[0].alt;
        var fileNameText=fileName.getElementsByTagName("a")[0].childNodes[0].innerHTML;
        var shareForm = new FormData();
        var xhrReq = new XMLHttpRequest();
        shareForm.append('name',fileNameText);
        shareForm.append('type',fileType);
        if(type==1)shareForm.append('share','YES');
        else shareForm.append('share','NO');
        xhrReq.open('post','shareFile.php');
        xhrReq.send(shareForm);
        xhrReq.onload=function(){
            var response = this.responseText;
            handleResponse(response,element);
        }
    }
</script>
 </html>
