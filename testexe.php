<?php
$oper="*";
$first_number=1;
$second_number=2;
//system('cmd /c for_testing/formProcessingFunction.exe "for_testing/hammad.jpg"');
//$answer = shell_exec("calu.exe *,1,2");
//var_dump($answer);
//echo $answer."</br>";
//exec("executecode.bat");
$var1="hammad.jpg";
system("cmd /c executecode.bat $var1");

$data=array();
$fun = new Core();
$file="hammad";
   $data=$fun->readDataFromFile($file);
print_r($data);
   // var_dump($data);
class Core
{

    public  function readDataFromFile($file)
    {    $handle = fopen("for_testing/" . $file . ".txt", "r");
  /*      sleep(3);
        if(!$handle){
            sleep(7);
        }
    */
 //       while (1) {
        $handle = fopen("for_testing/" . $file . ".txt", "r");
        if ($handle) {
            $dataInLine = array();
            while (($line = fgets($handle)) !== false) {
                $dataInLine[] = $line;
            }
            fclose($handle);
            return $dataInLine;
   //              break;
     //   }
        }
        /*
                if ($handle) {
                    $dataInLine = array();
                    while (($line = fgets($handle)) !== false) {
                        $dataInLine[] = $line;
                    }
                    fclose($handle);
             //      unlink($fulpath);
                  return $dataInLine;
                }
        */


    }
  /*  public function readDataFromFile()
    {
        $file="hammad";
        $handle = fopen("for_testing/".$file.".txt", "r");
        if ($handle) {
            $dataInLine = array();
            while (($line = fgets($handle)) !== false) {
                $dataInLine[] = $line;
            }
            fclose($handle);
            var_dump($dataInLine);
        } else {
            // error opening the file.
        }
    }*/
}


?>
