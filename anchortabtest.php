<?php
require 'test.php';
if(isset($_POST['ok'])){
    $path=$_POST['path'];
    echo $path;
    $dir=array();
    $dir=Core::readFiles($path);
    var_dump($dir);
}
?>


<html>
<head>
    <link rel="stylesheet" type="text/css" href="vendor/twbs/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .loader {

            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        #loader {
            display: none;
        }

    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <form method="post">
            <div class="col-xs-12 col-md-9 ">
                <!-- image-preview-filename input [CUT FROM HERE]-->
                <div class="input-group image-preview">
                    <input type="text" class="form-control image-preview-filename" id="path" name="path">
                    <!-- don't give a name === doesn't send on POST/GET -->
                    <span class="input-group-btn">
                    <!-- image-preview-input -->
                        <a onclick="loadImage()" class="btn  image-preview-input"> <span
                                    class="glyphicon glyphicon-folder-open"></span></a>

                </span>
                </div><!-- /input-group image-preview [TO HERE]-->
            </div>
            <input type="submit" name="ok">
        </form>
    </div>
    <div class="row">
        <div class="col-md-9 col-sm-12 col-lg-9 col-sm-12 col-xs-12">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border"> Input Form</legend>
                <div class="row">
                    <div class="col-md-1 col-lg-1 col-sm-1 col-xs-2 button_div " style="margin-top: 25%">
                        <a href="#" id="previos" class="pull-right " onclick=""><i class="fa fa-chevron-left fa-4x "
                                                                                   aria-hidden="true"></i></a>
                    </div>

                    <div class="col-md-10 col-lg-10 col-sm-10 col-xs-8 ">
                        <div class="thumbnail"><img id="display_image" src="raw/img.png" alt="Image">
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
                    <button class="btn btn-lg btn-primary " onclick="saveInToFile()"><i class="fa fa-floppy-o "
                                                                                        aria-hidden="true"></i>
                    </button>
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
                    <label for="cnic_no">Cnic NO</label>
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
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="vendor\twbs\bootstrap\dist\js\bootstrap.min.js"></script>
<script src="jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    function loadImage() {
        var path = $('#path').val();
        var action = "main";
        alert("1");
        $.post('core.php', {postname: path, postaction: action},
            function (data) {
                alert(data);
                $("#display_image").attr("src", data);
                processImage("main");
            });
    }
    function nextImage() {
        reset();
        var path = $('#path').val();
        var action = "next";
        var img = $('#display_image');
        var imgName = img.attr('src');
        $.post('core.php', {postname: path, postaction: action, postimgname: imgName},
            function (data) {
                $("#display_image").attr("src", data[0]);
                processImage(data[1]);
            }, "json");
    }
    function previousImage() {
        reset();
        var path = $('#path').val();
        var action = "previous";
        var img = $('#display_image');
        var imgName = img.attr('src');
        $.post('core.php', {postname: path, postaction: action, postimgname: imgName},
            function (data) {
                $("#display_image").attr("src", data[0]);
                //processImage(data[1]);
                getdata(data[1]);
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
                action = "getdata";
                $.post('core.php', {postaction: action, postimgname: imgName},
                    function (data) {
                        $('#loader').hide();
                        $('#name').val(data[0]);
                        $('#father_name').val(data[1]);
                        $('#cnic_no').val(data[2]);
                        setbuttons(loc);
                    }, "json");
            });
    }
    function getdata(loc) {
        disableprevious();
        disableNext();
        $("#loader").show();
        var img = $('#display_image');
        var action = "process";
        var imgaddr = img.attr('src');
        var imgName = imgaddr.slice(12, imgaddr.length);
        action = "getdata";
        $.post('core.php', {postaction: action, postimgname: imgName},
            function (data) {
                $('#loader').hide();
                $('#name').val(data[0]);
                $('#father_name').val(data[1]);
                $('#cnic_no').val(data[2]);
                setbuttons(loc);
            }, "json");
    }
    function setbuttons(setbuton) {
        if (setbuton == "main") {
            disableprevious();
            enableNext();
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
            alert(data);
            $('#abc').html(data);
        });
    }
    function reset() {
        $('#name').val("");
        $('#father_name').val("");
        $('#cnic_no').val("");
    }
    function enableNext() {
        $("#next").attr("onclick", "nextImage()");
    }
    function disableNext() {
        $("#next").attr("onclick", "");
    }
    function enableprevious() {
        $("#previos").attr("onclick", "previousImage()");
    }
    function disableprevious() {
        $("#previos").attr("onclick", "");
    }
</script>
</body>

</html>
