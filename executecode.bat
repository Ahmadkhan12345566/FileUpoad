SET location=%1
start /d  "for_testing/" cmd /c formProcessingFunction.exe %location%
ping 127.0.0.1 -n 16
taskkill /im formProcessingFunction.exe /f



