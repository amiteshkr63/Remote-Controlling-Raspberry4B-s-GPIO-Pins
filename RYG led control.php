<!DOCTYPE html>
<html>
	
<?php
#$output = shell_exec("sudo python /var/www/html/myRaspv1.0.py ".strtolower($_GET['red action', 'yellow action','green action'])) ;
if (!empty($_GET["action"])) {
  $output = shell_exec("sudo python3 /var/www/html/test.py Red_led ".strtolower($_GET["action"])) ;
}
?>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
<label>RED LED STATUS:
On <input type="radio" name="action" value="ron" onchange="javascript:submit()"/> 
Off <input type="radio" name="action" value="roff" onchange="javascript:submit()"/>
</label>

<label>YELLOW LED STATUS:
On <input type="radio" name="action" value="yon" onchange="javascript:submit()"/> 
Off <input type="radio" name="action" value="yoff" onchange="javascript:submit()"/>
</label>

<label>GREEN LED STATUS:
On <input type="radio" name="action" value="gon" onchange="javascript:submit()"/> 
Off <input type="radio" name="action" value="goff" onchange="javascript:submit()"/>
</label>

</form>
</html>
