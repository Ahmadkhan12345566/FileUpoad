<html>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" type="text/css" href="vs/twbs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="CSS/style.css">
    <style>
        #loader {
            display: none;
        }

        body {
            padding: 0%;
            margin: 0%;
        }
    </style>
</head>
<body>
<div class="container" style="width: 100% ;height: 100%;">

    <div class="row">
        <div class="col-md-2 col-lg-2 col-sm-3 col-xs-4">
            <a id="samplelink" title="sampleform" href='#' download>
                <button id="sample" onclick="downloadsampalform()" class="btn btn-primary form-control">Sample Form
                    <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></button>

            </a>
        </div>
        <div class="col-xs-8 col-sm-9 col-md-7 col-lg-7">
            <form method="post" enctype='multipart/form-data'>
                <!-- image-preview-filename input [CUT FROM HERE]-->
                <div class="input-group image-preview">
                    <input type="file" id="browse" name="fileupload[]" accept="image/*" style="display: none" multiple
                          />
                    <input type="text" class="form-control image-preview-filename" id="check" title="selected files">
                    <!-- don't give a name === doesn't send on POST/GET -->
                    <span class="input-group-btn">
                    <!-- image-preview-input -->
                        <a id="submit" onclick="HandleBrowseClick()" class="btn  image-preview-input"> <span
                                    class="glyphicon glyphicon-folder-open"></span></a>

                </span>
                </div><!--<nput-group image-preview [TO HERE]-->
                <input type="submit" id="ok" name="uplaod" style="display: none">
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9 col-sm-12 col-lg-9  col-xs-12">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border"> Input Form</legend>
                <div class="row">
                    <div class="col-md-1 col-lg-1 col-sm-1 col-xs-2 button_div " style="margin-top: 25%">
                        <a href="#" id="previos" class="pull-right " ><i
                                    class="fa fa-chevron-left fa-4x "
                                    aria-hidden="true"></i></a>
                    </div>

                    <div class="col-md-10 col-lg-10 col-sm-10 col-xs-8 ">
                        <div class="thumbnail"><img id="display_image" style="width: 100%; height: auto  width: auto\9;"
                                                    src="raw/img.png" alt="Image">
                        </div>
                    </div>
                    <div class="col-md-1 col-lg-1 col-sm-1 col-xs-2  " style="margin-top: 25%">
                        <a href="#" id="next" onclick=""><i id="colorit"
                                                            class="fa fa-chevron-right fa-4x controlbuttons "
                                                            aria-hidden="true"></i></a>
                    </div>

                </div>
            </fieldset>

        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 col-lg-3">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border"> Extracted Text</legend>
                <div class="form-group">
                    <a href='savefiles/results.csv' title="Results">
                        <button class="btn btn-primary form-control">Download Processed Results</button>
                    </a>
                </div>
                <div class="form-group ">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name">
                </div>
                <div class="form-group ">
                    <label for="father_name">Father Name</label>
                    <input type="text" class="form-control" id="father_name">
                </div>
                <div class="form-group ">
                    <label for="cnic_no">CNIC No</label>
                    <input type="text" class="form-control" id="cnic_no">
                </div>
                <div class="row ">
                    <div class="col-md-5 col-sm-5 col-xs-5 col-lg-3"></div>
                    <div class="loader col-md-5 col-sm-5 col-xs-5 col-lg-5" id="loader"></div>
                </div>

            </fieldset>
        </div>
    </div>
</div>


<script src="jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    document.getElementById("browse").addEventListener("change", clickbuttonupload);

    function downloadsampalform() {
        $("#samplelink").attr("href", "raw/img.jpg");
    }
    function clickbuttonupload() {
        document.getElementById("ok").click();
    }

    function HandleBrowseClick() {
        var fileinput = document.getElementById("browse");
        fileinput.click();
    }


    function loadImage() {
        var action = "main";
        $.post('core.php', {postaction: action},
            function (data) {
                if (data[1]=="one") {
                    $("#display_image").attr("src", data[0]);
                    processImage("maindac");
                }
                else {
                    $("#display_image").attr("src", data[0]);
                    processImage("main");
                }
            }, "json");
    }
    function nextImage() {
        reset();
        var action = "next";
        var img = $('#display_image');
        var imgName = img.attr('src');
        $.post('core.php', {postaction: action, postimgname: imgName},
            function (data) {
                $("#display_image").attr("src", data[0]);
                //processImage(data[1]);
                Status = "revise";
                getdata(data[1], Status);
            }, "json");
    }

    function previousImage() {
        reset();
        var action = "previous";
        var img = $('#display_image');
        var imgName = img.attr('src');
        $.post('core.php', {postaction: action, postimgname: imgName},
            function (data) {
                $("#display_image").attr("src", data[0]);
                //processImage(data[1]);
                Status = "revise";
                getdata(data[1], Status);
            }, "json");
    }
    function processImage(loc) {
        disableprevious();
        disableNext();
        $("#loader").show();
        var img = $('#display_image');
        var action = "process";
        var imgaddr = img.attr('src');
        var imgName = imgaddr.slice(12, imgaddr.length);
        $.post('core.php', {postaction: action, postimgname: imgName},
            function (data) {
                if (data == "wronginput") {
                    alert("You Input a Wrong Image");
                }
                else {
                    getdata(loc);
                }
            });
    }
    function getdata(loc, status) {
        disableprevious();
        disableNext();
        $("#loader").show();
        var img = $('#display_image');
        var action = "process";
        var imgaddr = img.attr('src');
        var imgName = imgaddr.slice(12, imgaddr.length);

        if (status == "revise") {
            stat = "review";
            action = "getdata";
            $.post('core.php', {postaction: action, postimgname: imgName, poststatus: stat},
                function (data) {
                    if (data[0] == "notexists") {
                        processImage(loc);
                    }
                    else {
                        $('#loader').hide();
                        $('#name').val(data[0]);
                        $('#father_name').val(data[1]);
                        $('#cnic_no').val(data[2]);
                        //       saveInToFile();
                        setbuttons(loc);
                    }
                }, "json");
        }
        else {
            stat = "newcreated"
            action = "getdata";
            $.post('core.php', {postaction: action, postimgname: imgName, poststatus: stat},
                function (data) {
                    if (data[0] == "notexists") {
                        $('#loader').hide();
                        alert("You Input wrong Image")
                        setbuttons(loc);
                    }
                    else {
                        $('#loader').hide();
                        $('#name').val(data[0]);
                        $('#father_name').val(data[1]);
                        $('#cnic_no').val(data[2]);
                               saveInToFile();
                        setbuttons(loc);
                    }
                }, "json");
        }
    }
    function setbuttons(setbuton) {
        if (setbuton == "main") {
            disableprevious();
            enableNext();
        }
        else if (setbuton == "maindac") {
            disableprevious();
            disableNext();
        }
        else if (setbuton == "start") {
            disableprevious();
            enableNext();
        }
        else if (setbuton == "end") {
            disableNext();
            enableprevious();
        }
        else {
            enableNext();
            enableprevious();
        }
    }
    function saveInToFile() {
        var img = $('#display_image');
        var imgName = img.attr('src');
        var action = "writefile";
        var name = $('#name').val();
        var fathername = $('#father_name').val();
        var cninc = $('#cnic_no').val();

        $.post('core.php', {
            postimgname: imgName,
            postname: name,
            postaction: action,
            postcnic: cninc,
            postfathername: fathername
        }, function (data) {
            //  alert(data);
        });
    }

    function reset() {
        $('#name').val("");
        $('#father_name').val("");
        $('#cnic_no').val("");
    }
    function enableNext() {
        document.getElementById("next").disabled = false;
        $("#next").attr("onclick", "nextImage()");
    }
    function disableNext() {
        document.getElementById("next").disabled = true;
        $("#next").attr("onclick", "");
    }
    function enableprevious() {
        document.getElementById("previos").disabled = false;
        $("#previos").attr("onclick", "previousImage()");
    }
    function disableprevious() {
        document.getElementById("previos").disabled = true;
        $("#previos").attr("onclick", "");
    }


</script>
</body>

</html>
<?php
//require Core;

require('Del.php');
use DelSpace\del;

if (isset($_POST['uplaod'])) {
    //   Core::deleteFile();
    $destination = "for_testing";
    $myFile = $_FILES['fileupload'];
    $fileCount = count($myFile["name"]);
    if ($fileCount >= 1) {
        del::deleteUploadedfiles();
    }
    for ($i = 0; $i < $fileCount; $i++) {


        $info = pathinfo($_FILES['fileupload']['name'][$i]);
        $ext = $info['extension']; // get the extension of the file
        $newname = "newname".$i.".".$ext;
        $target = 'raw2/'.$newname;;
        move_uploaded_file($_FILES['fileupload']['tmp_name'][$i], $target);
    }
    echo '<script type="text/javascript">
         loadImage(); 
    </script>';
}


?>
