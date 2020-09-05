<?php
    $filename="3-5.txt";
    
    $lines=file($filename, FILE_IGNORE_NEW_LINES);
    
    $editNumber="";
    $editName="";
    $editComment="";
    $editPw="";
    $i=0;

    date_default_timezone_set('Asia/Tokyo');
    $date=date("Y/m/d h:i:s");

    if(!empty($_POST["number"]) && !empty($_POST["pwCheck_edit"])){
      foreach($lines as $row){
        $bbsRowData=explode("<>",$row);
        if($bbsRowData[4]==$_POST["pwCheck_edit"]){
          if($bbsRowData[0]==$_POST["number"]){
            $editNumber=$bbsRowData[0];
            $editName=$bbsRowData[1];
            $editComment=$bbsRowData[2];
            $editPw=$bbsRowData[4];
          break;
          }
        }
      }
    }
    else if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pw"])){
      if(!empty($_POST["edit_post"])){
        $writeData=$_POST["edit_post"]."<>".$_POST["name"]."<>".$_POST["comment"]."<>".$date."<>".$_POST["pw"]."<>";
        $fp=fopen($filename,"w");
        foreach($lines as $row){
        $bbsRowData=explode("<>",$row);
          if($_POST["edit_post"]==$bbsRowData[0]){
            $row=$writeData;
          }
          fwrite($fp,$row.PHP_EOL);
        }
        fclose($fp);
      }
      else{
        foreach($lines as $row){
          $i++;
        }
        $writeData=($i + 1)."<>".$_POST["name"]."<>".$_POST["comment"]."<>".$date."<>".$_POST["pw"]."<>";
        $fp=fopen($filename,"a");
        fwrite($fp,$writeData.PHP_EOL);
        fclose($fp);
      }
    }
    if(!empty($_POST["deleteNumber"]) && !empty($_POST["pwCheck_delete"])){
      $deleteNumber=$_POST["deleteNumber"];
      $fp_d=fopen($filename,"w");
      foreach($lines as $row){
        $parts=explode("<>",$row);
        // if($parts[4]==$_POST["pwCheck_delete"]){}
        if(($deleteNumber!=$parts[0]) || ($_POST["pwCheck_delete"]!=$parts[4])){
          // ↑削除対象番号じゃないもの　または　パスワードが間違ってる場合↑
          $i++;
          $record_delete=$i."<>".$parts[1]."<>".$parts[2]."<>".$parts[3]."<>".$parts[4]."<>";
          fwrite($fp_d,$record_delete.PHP_EOL);
        }
      }
      fclose($fp_d);
    }

    if(file_exists($filename)){
      $file=file($filename,FILE_IGNORE_NEW_LINES);
          foreach ($file as $item){
          $parts=explode("<>",$item);
          // print_r($parts);
          // echo "<br>";
          echo $parts[0].$parts[1].$parts[2].$parts[3]."<br>";
      }
      }
    
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission3-5</title>
        <style>
          p,input,textarea{
            margin: 0;
            padding: 0;
          }
        </style>
    </head>
    <body>
        <form action="" method="POST">
            <p>入力用</p>
            <input type="hidden" name="edit_post" value="<?php echo $editNumber; ?>">
            <p>名前</p>
            <input type="text" name="name" value="<?php echo $editName; ?>">
            <br>
            <p>コメント</p>
            <!-- <textarea name="comment" rows="4" cols="40"><?php echo $editComment; ?></textarea> -->
            <input type="text" name="comment" value="<?php echo $editComment; ?>">
            <br>
            <p>パスワード</p>
            <input type="text" name="pw" value="<?php echo $editPw; ?>">
            <input type="submit" name="normal">
        </form>
        <hr>
        <form action="" method="POST">
          <p>削除用</p>
          <br>
          <p>番号</p>
            <input type="text" name="deleteNumber">
          <p>パスワード</p>
            <input type="text" name="pwCheck_delete">
            <input type="submit" name="deleteSubmit">
        </form>
        <hr>
        <form action="" method="POST">
          <p>編集用</p>
          <br>
          <p>番号</p>
          <input type="text" name="number">
          <p>パスワード</p>
          <input type="text" name="pwCheck_edit">
          <input type="submit" name="edit">
        </form>
    </body>
</html>