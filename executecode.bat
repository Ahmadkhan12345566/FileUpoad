SET location=%1
SET name=%2
start /d  "for_testing/" cmd /c formProcessingFunction.exe %location%
cls
set /a time=20
cls
:loop
if exist for_testing/%name%.txt exit
ping localhost -n 2 >nul
set /a time=%time%-1
if %time%==0 (
taskkill /im formProcessingFunction.exe /f
exit
) 
goto loop

