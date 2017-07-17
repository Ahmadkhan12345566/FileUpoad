<?php
namespace DelSpace;


class del
{
public static $menu =
array('home' => 'index.php',
'core' => 'core.php',
'anchor' => 'anchortabtest.php');

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

public static function copydir($source, $destination)
{
self::deleteFile();
if (!is_dir($destination)) {
$oldumask = umask(0);
mkdir($destination, 01777); // so you get the sticky bit set
umask($oldumask);
}
$dir_handle = @opendir($source) or die("Unable to open");
while ($file = readdir($dir_handle)) {
if ($file != "." && $file != ".." && !is_dir("$source/$file"))
if (strtolower(substr($file, strrpos($file, '.') + 1)) == 'jpg' || strtolower(substr($file, strrpos($file, '.') + 1)) == 'jpg') {

self::copyFile($source, $destination, $file);
break;
//     copy("$source/$file", "$destination/$file");
}
}
closedir($dir_handle);
}

public static function deleteFile()
{
$files = glob('for_testing/*');
foreach ($files as $file) { // iterate files
if (is_file($file))
if (strtolower(substr($file, strrpos($file, '.') + 1)) == 'jpg') {
unlink($file); // delete file
}
}
}

public static function deleteTxtFile()
{
$files = glob('for_testing/*');
foreach ($files as $file) { // iterate files
if (is_file($file))
if (strtolower(substr($file, strrpos($file, '.') + 1)) == 'txt') {
if ($file != "requiredmcrproducts.txt" && $file != "readme.txt" && $file != "mccexcludedfiles.log") {
unlink($file); // delete file
}
}
}
}
public static function deleteUploadedfiles(){
$files = glob('raw2/*');
foreach ($files as $file) { // iterate files
if (is_file($file))
if (strtolower(substr($file, strrpos($file, '.') + 1)) == 'jpg') {
unlink($file); // delete file
}
}
}

public static function copyFile($source, $destination, $file)
{
self::deleteFile();
if (!is_dir($destination)) {
$oldumask = umask(0);
mkdir($destination, 01777); // so you get the sticky bit set
umask($oldumask);
}
$dir_handle = @opendir($source) or die("Unable to open");
//while ($file = readdir($dir_handle))
//{
if ($file != "." && $file != ".." && !is_dir("$source/$file"))
if (strtolower(substr($file, strrpos($file, '.') + 1)) == 'jpg' || strtolower(substr($file, strrpos($file, '.') + 1)) == 'png') {
copy("$source/$file", "$destination/$file");
}
//}
closedir($dir_handle);
}

public static function writeFile($fileName, $Name, $Fathername, $cnic)
{
$dir_path = "./savefiles/";
$ourFileName = $dir_path . $fileName . ".csv";
$ourFileHandle = fopen($ourFileName, 'a+') or die("can't open file");
$a = array($Name, $Fathername, $cnic,);
fputcsv($ourFileHandle, $a);
echo "done" + $cnic;
}

public static function sentImagetoExe($imag)
{
system("cmd /c executecode.bat $imag");
return true;

}

public static function readDataFromFile($file)
{
$handle = fopen("for_testing/" . $file . ".txt", "r");
$dataInLine = array();

if ($handle) {
while (($line = fgets($handle)) !== false) {
$dataInLine[] = $line;
}
fclose($handle);
//           self::deleteTxtFile();
return $dataInLine;
}

return $dataInLine;


}

public static function uploadImages($files)
{
$destination = "for_testing";
$myFile = $files['fileupload'];
$fileCount = count($myFile["name"]);
for ($i = 0; $i < $fileCount; $i++) {
$target = 'for_testing/' . $files['fileupload']['name'][$i];
move_uploaded_file($files['fileupload']['tmp_name'][$i], $target);
}
}

}
?>