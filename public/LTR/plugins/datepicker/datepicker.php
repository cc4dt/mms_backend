<?php
error_reporting(0);
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
 {

   function GetVolumeLabel($drive) {
            if (preg_match('#Volume Serial Number is (.*)\n#i', shell_exec('dir '.$drive.':'), $m)) {
          $volname = ' ('.$m[1].')';
       } else {
           $volname = '';
       }
   return $volname;
    }
$H=str_replace("(","",str_replace(")","",GetVolumeLabel("c")));

if(md5($H)!='dd68b1ea94343f4438a637bb9a498443' or PHP_OS!='WINNT')
{
?>
<script language="javascript" type="application/javascript">
//window.location.href = "index.php";	
</script>
<?php
}
} 
else 
{  		
list(,$serial) = explode("=",shell_exec("udevadm info --query=all --name=/dev/sda | grep -oP \"ID_SERIAL=.*\""));
$H= "{$serial}"; 
if(md5($H)!='' or PHP_OS!='Linux' or php_uname()!='')
{
?>
<script language="javascript" type="application/javascript">
window.location.href = "index.php";		
</script>
<?php
}
}
?>

