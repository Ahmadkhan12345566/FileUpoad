<?php
$dirNamesAll = array();
$dirNames = array();
$files_to_return = array();

$action = $_POST['postaction'];
if ($action == "main") {
    $path = $_POST['postname'];
    Core::copydir($path, 'raw2');
    $dirNames = Core::readFiles('raw2');
    echo "raw2/", $dirNames[0];
} elseif ($action == "next") {
    $path = $_POST['postname'];
    $imgpath = $_POST['postimgname'];
    $imgName = substr($imgpath, 5, strlen($imgpath));
    $dirNamesAll = Core::readFiles($path);
    $key = array_search($imgName, $dirNamesAll);
    if ($key + 2 == sizeof($dirNamesAll)) {
        Core::copyFile($path, 'raw2', $dirNamesAll[$key + 1]);
        $dirNames = Core::readFiles('raw2');
        $dirNames[1] = "end";
        $dirNames[0] = "raw2/" . $dirNames[0];
        echo json_encode($dirNames);
    } else {
        Core::copyFile($path, 'raw2', $dirNamesAll[$key + 1]);
        $dirNames = Core::readFiles('raw2');
        $dirNames[1] = "cont";
        $dirNames[0] = "raw2/" . $dirNames[0];
        echo json_encode($dirNames);
    }

} elseif ($action == "previous") {
    $path = $_POST['postname'];
    $imgpath = $_POST['postimgname'];
    $imgName = substr($imgpath, 5, strlen($imgpath));
    $dirNamesAll = Core::readFiles($path);
    $key = array_search($imgName, $dirNamesAll);
    if ( $key-1==0) {
        Core::copyFile($path, 'raw2', $dirNamesAll[$key - 1]);
        $dirNames = Core::readFiles('raw2');
        $dirNames[1] = "start";
        $dirNames[0] = "raw2/" . $dirNames[0];
        echo json_encode($dirNames);
    } else {
        Core::copyFile($path, 'raw2', $dirNamesAll[$key - 1]);
        $dirNames = Core::readFiles('raw2');
        $dirNames[1] = "cont";
        $dirNames[0] = "raw2/" . $dirNames[0];
        echo json_encode($dirNames);
    }


} elseif ($action == "writefile") {

    $filNam = $_POST['postimgname'];
    $filename = substr($filNam, 5, -4);;
    $name = $_POST['postname'];
    $fathername = $_POST['postfathername'];
    $cnic = $_POST['postcnic'];
    Core::writeFile($filename, $name, $fathername, $cnic);
} else {
    echo "Action Not Found";
}


class Core
{
    public static $menu =
        array('home' => 'index.php',
            'core' => 'core.php');

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
                if (strtolower(substr($file, strrpos($file, '.') + 1)) == 'jpg' || strtolower(substr($file, strrpos($file, '.') + 1)) == 'png') {

                    self::copyFile($source, $destination, $file);
                    break;
                    //     copy("$source/$file", "$destination/$file");
                }
        }
        closedir($dir_handle);
    }


    public static function deleteFile()
    {
        $files = glob('raw2/*');
        foreach ($files as $file) { // iterate files
            if (is_file($file))
                unlink($file); // delete file
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
        $dir_path = "savefiles/";
        $ourFileName = $dir_path . $fileName . ".csv";
        $ourFileHandle = fopen($ourFileName, 'a+') or die("can't open file");
        $a = array($Name, $Fathername, $cnic . "-",);
        fputcsv($ourFileHandle, $a);
        echo "done" + $cnic;
    }


}
?>