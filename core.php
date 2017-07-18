<?php
namespace CoreSpace;
$ReadedFileNames = array();
$dirNamesAll = array();
$dirNames = array();
$path = "raw2";
$action = $_POST['postaction'];
if ($action == "main") {
    //$path = $_POST['postname'];
    Core::deleteTxtFile();
    Core::copydir($path, 'for_testing');
    $dirNames = Core::readFiles('for_testing');
    $AlldirNames = Core::readFiles('raw2');
    if(sizeof($AlldirNames)==1){
       $dirNames[1]="one";
       $dirNames[0]="for_testing/".$dirNames[0];
        echo json_encode($dirNames);
    }
    else {
        $dirNames[1]=sizeof($dirNames);
        $dirNames[0]="for_testing/".$dirNames[0];
        echo json_encode($dirNames);
    }
} elseif ($action == "next") {
    //$path = $_POST['postname'];
    $imgpath = $_POST['postimgname'];
    $imgName = substr($imgpath, 12, strlen($imgpath));
    $dirNamesAll = Core::readFiles($path);
    $key = array_search($imgName, $dirNamesAll);
    if ($key + 2 == sizeof($dirNamesAll)) {
        Core::copyFile($path, 'for_testing', $dirNamesAll[$key + 1]);
        $dirNames = Core::readFiles('for_testing');
        $dirNames[1] = "end";
        $ReadedFileNames[] = $dirNames[0];
        $dirNames[0] = "for_testing/" . $dirNames[0];
        echo json_encode($dirNames);
    } else {
        Core::copyFile($path, 'for_testing', $dirNamesAll[$key + 1]);
        $dirNames = Core::readFiles('for_testing');
        $dirNames[1] = "cont";
        //$ReadedFileNames[]=$dirNames[0];
        $dirNames[0] = "for_testing/" . $dirNames[0];
        echo json_encode($dirNames);
    }

} elseif ($action == "previous") {
    //$path = $_POST['postname'];
    $imgpath = $_POST['postimgname'];
    $imgName = substr($imgpath, 12, strlen($imgpath));
    $dirNamesAll = Core::readFiles($path);
    $key = array_search($imgName, $dirNamesAll);
    if ($key - 1 == 0) {
        Core::copyFile($path, 'for_testing', $dirNamesAll[$key - 1]);
        $dirNames = Core::readFiles('for_testing');
        $dirNames[1] = "start";
        $dirNames[0] = "for_testing/" . $dirNames[0];
        echo json_encode($dirNames);
    } else {
        Core::copyFile($path, 'for_testing', $dirNamesAll[$key - 1]);
        $dirNames = Core::readFiles('for_testing');
        $dirNames[1] = "cont";
        $dirNames[0] = "for_testing/" . $dirNames[0];
        //$dirNames[0] = "for_testing/" . $ReadedFileNames[0];
        echo json_encode($dirNames);
    }

} elseif ($action == "writefile") {
    $filNam = $_POST['postimgname'];
    $filename = substr($filNam, 12, -4);;
    $name = $_POST['postname'];
    $fathername = $_POST['postfathername'];
    $cnic = $_POST['postcnic'];
    Core::writeFile($filename, $name, $fathername, $cnic);

} elseif ($action == "process") {
    $imgName = $_POST['postimgname'];
    Core::sentImagetoExe($imgName);
    $name = substr($imgName, 0, -4);
    echo "wronginput";
    // if(file_exists("for_testing/" . $name . ".txt")) {
     //   echo  "not working";
    //}
    //else{
      //  echo  "You Input a Wrong Image";
    //}
} elseif ($action == "getdata") {
    $status=$_POST['poststatus'];
    $imgName = $_POST['postimgname'];
    $dataFormFile = array();
    $name = substr($imgName, 0, -4);
    if($status=="revise") {
        if (file_exists("for_testing/" . $name . ".txt")) {
            $dataFormFile = Core::readDataFromFile($name);
        } else {
            $dataFormFile[0] = "notexists";   //this is for movining in process forms
        }
        echo json_encode($dataFormFile);
    }
    else{
        if (file_exists("for_testing/" . $name . ".txt")) {
            $dataFormFile = Core::readDataFromFile($name);
        } else {
            $dataFormFile[0] = "notexists";   //this is for movining in process forms
        }
        echo json_encode($dataFormFile);
    }


} else {
    echo "notexists";
}


class Core
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
        $fileName="results";
        $dir_path = "./savefiles/";
        $ourFileName = $dir_path . $fileName . ".csv";
        $ourFileHandle = fopen($ourFileName, 'a+') or die("can't open file");
        $a = array($Name, $Fathername, $cnic,);
        fputcsv($ourFileHandle, $a);
    }

    public static function sentImagetoExe($imag)
    {
        $name = substr($imag, 0, -4);
        system("cmd /c executecode.bat $imag");
/*        while(1) {
            if (file_exists("for_testing/" . $name . ".txt")) {
                system("cmd /c terminteexe.bat");
                break;
            }

        }*/
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
        $myFile = $files['fileupload'];
        $fileCount = count($myFile["name"]);
        for ($i = 0; $i < $fileCount; $i++) {
            $target = 'for_testing/' . $files['fileupload']['name'][$i];
            move_uploaded_file($files['fileupload']['tmp_name'][$i], $target);
        }
    }

}

?>