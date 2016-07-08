<!DOCTYPE html>
<html>
<?php
$testSh = file_get_contents('test.sh');
$output = shell_exec($testSh);
?>
 
<h1>Generate config of firewall</h1>

 
 <form  action="" method="post">
 <input type="hidden" name ="output" value="<?php echo $output; ?>">
  <p>
   <input type=submit value="do it!!!" />
  </p>
 </form>

<h4><?php echo "<pre>"; echo $_POST['output'];?></h4>
</body>
</html>
