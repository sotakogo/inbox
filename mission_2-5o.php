<?php
/* ���������G���R�[�f�B���O����SJIS�ɕϊ� */
  $str = mb_convert_encoding("UTF-8", "SJIS");
  $date = date("Y/m/d H:i:s");
  $filename = 'kadai25.txt';
  $files = @file("kadai25.txt");
  $delpass = 1994;
  $editpass = 1210;
// �o�^�{�^�����N���b�N���ꂽ�ꍇ
if(isset($_POST['submit']) && $_POST["hensyu"] == 0)	{
 
	if(file_exists($filename ))	{
		$cnt = count($files) +1;
					} else	{
		$cnt = 1;
						}

		print("���e����܂���\n");
  		$name = $_POST["name"];
  		$comment = $_POST["input"]; //echo $filename;
		$fp = fopen($filename, 'ab');
		fprintf($fp, "%d<>%s<>%s<>%s\n", $cnt, $name, $comment, $date); //fwrite($fp, $cnt."<���O>"$name.);
		fclose($fp);
		print ('<�ԍ�>');
		print ($cnt. '<���O>');
		print ($name. '<�R�����g>');
		print ($comment.'<���͎���>');
		echo date("Y/m/d H:i:s");
				}
// �ύX (id������ꍇ)
if(isset($_POST["submit"]) && $_POST["hensyu"] != 0) {
  print ($_POST["hensyu"].'��ҏW���܂����B');
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
// �폜�{�^�����N���b�N���ꂽ�ꍇ
if (isset($_POST['sdelete']))	{
	if($_POST["pass"] == $delpass)	{
	$fp = fopen('kadai25.txt','a');
        $file_make = file("kadai25.txt");
        for($k = 0;$k <count($file_make); ++$k)	{ //�z��̂����C�Y���폜�ԍ��Ɠ��������̂�������
        	$delData = explode("<>",$file_make[$k]);
        	if($delData[0] == ($_POST['delete']))	{
			array_splice($file_make, $k, 1); //$k�Ԗڂ̔z�����������
			file_put_contents($filename, $file_make); //���������t�@�C���̃f�[�^���㏑������
			echo ($_POST['delete'] . "���폜���܂����B");
							}
						}
	$file_remake = file("kadai25.txt"); //���e�ԍ����C������
	for($k = 0;$k <count($file_remake); ++$k)	{
		$revdata = explode("<>", $file_remake[$k]); 
		$rev = array(); //�V�����֐��ɁC�V�����ԍ��Ɗ����f�[�^����
		$rev[] = $k +1;
		$rev[] = $revdata[1];
		$rev[] = $revdata[2];
		$rev[] = $revdata[3];
		$remake = implode("<>", $rev);
		$file_remake[$k] = $remake; //���
							}
	file_put_contents($filename, $file_remake); //�S�Ă̔z��ɑ΂��đ�����s������C���̃f�[�^���㏑�� 
				}
	else	{
	echo "�F�؎��s\n";
		}
				}
// �ҏW�{�^�����N���b�N���ꂽ�ꍇ
if (isset($_POST['sedit']))	{
	if($_POST["pass"] == $editpass)	{
	$fp = fopen('kadai25.txt','a');
        $file_make = file("kadai25.txt");
        for($k = 0;$k <count($file_make); ++$k)	{ //�z��̂����C�Y���폜�ԍ��Ɠ��������̂�������
        	$delData = explode("<>",$file_make[$k]);
        	if($delData[0] == ($_POST['edit']))	{
			$edit = $delData;
			print ($edit[0].'��ҏW���܂��B');
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
	echo "�F�؎��s\n";
		}
	}
?>
<html>
<head><meta http-equiv="content-type" content="text/html;charset=shift_jis"><title>�v���O���~���O�f����</title></head>
<body>
<div class="demo demo3">
  <div class="heading"><span>�v���O���~���O�f����</span></div>
</div>
<p>�����O�ƁC�Ђƌ����肢�v���܂�^^</p>
<form action="mission_2-5o.php" method="post">
<p>�����O<input type="text" name="name" value="<?= $edit[1] ?>"></p>
<p>�R�����g<input type="text" name="input" value="<?= $edit[2] ?>" size="30" maxlength="30"></p>
<p><input type="hidden" name="hensyu" value="<?= $edit[0] ?>"><p>
<p><input type="submit"name="submit" value="���e"></p>
  </table>
</form>
<form action="mission_2-5o.php" method="post">
<p>�폜�ԍ�����<input type="number" name="delete"></p>
<p>PASS<input name="pass" type="number"></p>
<p><input type="submit" name="sdelete" value="�폜"></p>
  </table>
</form>
<form action="mission_2-5o.php" method="post">
<p>�ҏW����<input type="number" name="edit"></p>
<p>PASS<input name="pass" type="number"></p>
<p><input type="submit" name="sedit" value="�ҏW"></p>
<p><input type="hidden" name="sedit" value="hensyu"></p>
  </table>
</form>
<?php
print ("<hr />");
$contents = file("kadai25.txt");
foreach ($contents as $content) {
  $parts = explode("<>", $content);
  $parts[0] = "���e�ԍ�:$parts[0]";
  $parts[1] = "���e��:$parts[1]";
  $parts[2] = "���e���e:$parts[2]";
  $parts[3] = "���e����:$parts[3]";
  $parts[4] = "<hr />";
  foreach ($parts as $part) {
    echo "<table><tr>$part</tr></table>";
  }
}
?>
</body>
</html>