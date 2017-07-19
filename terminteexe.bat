taskkill /im formProcessingFunction.exe /f

if exist *.txt echo "csv file found"


while not exist *.txt (echo " not exist")