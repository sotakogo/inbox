<?php
/* 内部文字エンコーディングからSJISに変換 */
  $str = mb_convert_encoding("UTF-8", "SJIS");
  $date = date("Y/m/d H:i:s");
  $filename = 'kadai25.txt';
  $files = @file("kadai25.txt");
  $delpass = 1994;
  $editpass = 1210;
// 登録ボタンがクリックされた場合
if(isset($_POST['submit']) && $_POST["hensyu"] == 0)	{
 
	if(file_exists($filename ))	{
		$cnt = count($files) +1;
					} else	{
		$cnt = 1;
						}

		print("投稿されました\n");
  		$name = $_POST["name"];
  		$comment = $_POST["input"]; //echo $filename;
		$fp = fopen($filename, 'ab');
		fprintf($fp, "%d<>%s<>%s<>%s\n", $cnt, $name, $comment, $date); //fwrite($fp, $cnt."<名前>"$name.);
		fclose($fp);
		print ('<番号>');
		print ($cnt. '<名前>');
		print ($name. '<コメント>');
		print ($comment.'<入力時刻>');
		echo date("Y/m/d H:i:s");
				}
// 変更 (idがある場合)
if(isset($_POST["submit"]) && $_POST["hensyu"] != 0) {
  print ($_POST["hensyu"].'を編集しました。');
  $contents = file("kadai25.txt");
  $fp1 = fopen('kadai25.txt','w');
  $edit_num =  $_POST["hensyu"];
  foreach($contents as $content) {
    $parts = explode("<>", $content);
    if($parts[0] == $edit_num){
      $name = $_POST["name"];
      $comment = $_POST["input"];
      $timestamp = date("Y/m/d H:i:s");
      fwrite($fp1, "$edit_num<>$name<>$comment<>$timestamp\n");
    } else {
      fwrite($fp1, "$content");
    }
  }
  fclose($fp1);
  $edit = 0;
}
// 削除ボタンがクリックされた場合
if (isset($_POST['sdelete']))	{
	if($_POST["pass"] == $delpass)	{
	$fp = fopen('kadai25.txt','a');
        $file_make = file("kadai25.txt");
        for($k = 0;$k <count($file_make); ++$k)	{ //配列のうち，該当削除番号と等しいものをさがす
        	$delData = explode("<>",$file_make[$k]);
        	if($delData[0] == ($_POST['delete']))	{
			array_splice($file_make, $k, 1); //$k番目の配列を消去する
			file_put_contents($filename, $file_make); //消去したファイルのデータを上書きする
			echo ($_POST['delete'] . "を削除しました。");
							}
						}
	$file_remake = file("kadai25.txt"); //投稿番号を修正する
	for($k = 0;$k <count($file_remake); ++$k)	{
		$revdata = explode("<>", $file_remake[$k]); 
		$rev = array(); //新しい関数に，新しい番号と既存データを代入
		$rev[] = $k +1;
		$rev[] = $revdata[1];
		$rev[] = $revdata[2];
		$rev[] = $revdata[3];
		$remake = implode("<>", $rev);
		$file_remake[$k] = $remake; //代入
							}
	file_put_contents($filename, $file_remake); //全ての配列に対して操作を行った後，そのデータを上書き 
				}
	else	{
	echo "認証失敗\n";
		}
				}
// 編集ボタンがクリックされた場合
if (isset($_POST['sedit']))	{
	if($_POST["pass"] == $editpass)	{
	$fp = fopen('kadai25.txt','a');
        $file_make = file("kadai25.txt");
        for($k = 0;$k <count($file_make); ++$k)	{ //配列のうち，該当削除番号と等しいものをさがす
        	$delData = explode("<>",$file_make[$k]);
        	if($delData[0] == ($_POST['edit']))	{
			$edit = $delData;
			print ($edit[0].'を編集します。');
?>
			<html>
			<body>
			<p><input type="hidden" name="hensyu" value="<?= $edit[0] ?>"><p>
			</body>
			</html>
<?php
							}
						}
				}
	else	{
	echo "認証失敗\n";
		}
	}
?>
<html>
<head><meta http-equiv="content-type" content="text/html;charset=shift_jis"><title>プログラミング掲示板</title></head>
<body>
<div class="demo demo3">
  <div class="heading"><span>プログラミング掲示板</span></div>
</div>
<p>お名前と，ひと言お願い致します^^</p>
<form action="mission_2-5o.php" method="post">
<p>お名前<input type="text" name="name" value="<?= $edit[1] ?>"></p>
<p>コメント<input type="text" name="input" value="<?= $edit[2] ?>" size="30" maxlength="30"></p>
<p><input type="hidden" name="hensyu" value="<?= $edit[0] ?>"><p>
<p><input type="submit"name="submit" value="投稿"></p>
  </table>
</form>
<form action="mission_2-5o.php" method="post">
<p>削除番号入力<input type="number" name="delete"></p>
<p>PASS<input name="pass" type="number"></p>
<p><input type="submit" name="sdelete" value="削除"></p>
  </table>
</form>
<form action="mission_2-5o.php" method="post">
<p>編集する<input type="number" name="edit"></p>
<p>PASS<input name="pass" type="number"></p>
<p><input type="submit" name="sedit" value="編集"></p>
<p><input type="hidden" name="sedit" value="hensyu"></p>
  </table>
</form>
<?php
print ("<hr />");
$contents = file("kadai25.txt");
foreach ($contents as $content) {
  $parts = explode("<>", $content);
  $parts[0] = "投稿番号:$parts[0]";
  $parts[1] = "投稿者:$parts[1]";
  $parts[2] = "投稿内容:$parts[2]";
  $parts[3] = "投稿日時:$parts[3]";
  $parts[4] = "<hr />";
  foreach ($parts as $part) {
    echo "<table><tr>$part</tr></table>";
  }
}
?>
</body>
</html>