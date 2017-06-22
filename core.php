<?php
namespace CoreSpace;
class Core
{


public static $menu =
array('home' => 'index.php',
'courses' => 'lectures.php',
'labs' => '../labs/hsn/med/index.html',
'faculty' => 'faculty.php',
'faqs' => 'faq.php',
'contactus' => 'contact.php',
'aboutus' => 'about.php');

public static function readFiles($arg)
{
$files = array();
// directory handle
$dir = dir($arg);
while (false !== ($entry = $dir->read())) {
if ($entry != '.' && $entry != '..' && $entry != '.DS_Store'
&& strtolower(substr($entry, strrpos($entry, '.') + 1)) == 'jpg'
|| strtolower(substr($entry, strrpos($entry, '.') + 1)) == 'png'
|| strtolower(substr($entry, strrpos($entry, '.') + 1)) == 'docx'
|| strtolower(substr($entry, strrpos($entry, '.') + 1)) == 'doc'
|| strtolower(substr($entry, strrpos($entry, '.') + 1)) == 'docx'
|| strtolower(substr($entry, strrpos($entry, '.') + 1)) == 'xls'
|| strtolower(substr($entry, strrpos($entry, '.') + 1)) == 'xlsx'
|| strtolower(substr($entry, strrpos($entry, '.') + 1)) == 'pdf'
|| strtolower(substr($entry, strrpos($entry, '.') + 1)) == 'mp4'
) {
if (is_file($arg . '/' . $entry)) {
$files[] = $entry;
}
}
}
return $files;
}

}
?>