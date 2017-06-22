<?php
require('Core.php');
use CoreSpace\Core;
if(isset($_POST['submit_name'])){
    $path="raw";
    $path=$_POST['path'];
    $dirNames=Core::readFiles($path);
    echo "i readhed";
    var_dump($dirNames);

}
elseif(isset($_POST['next'])){

}
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="vendor/twbs/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="container">
    <form method="post">
        <div class="row">
            <input type="text" name="path">
            <input type="submit" name="submit_name" >

        </div>
    </form>
    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <!-- image-preview-filename input [CUT FROM HERE]-->
            <div class="input-group image-preview">
                <input type="file" id="browse" name="fileupload" style="display: none" onChange="Handlechange();"/>
                <input type="text" class="form-control image-preview-filename" id="check"> <!-- don't give a name === doesn't send on POST/GET -->
                <span class="input-group-btn">
                    <!-- image-preview-input -->

                        <a onclick="HandleBrowseClick();" class="btn  image-preview-input"> <span class="glyphicon glyphicon-folder-open" ></span></a>

                </span>
            </div><!-- /input-group image-preview [TO HERE]-->
        </div>
    </div>


    <div class="row">
        <div class="col-md-9 col-sm-12 col-lg-9 col-sm-12 col-xs-12">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border"> Input Form</legend>
                <div class="row">
                    <div class="col-md-1 col-lg-1 col-sm-1 col-xs-2 button_div " style="margin-top: 25%" >
                        <a href="#" class="pull-right" ><i class="fa fa-chevron-left fa-4x " aria-hidden="true"></i></a>
                    </div>

                    <div class="col-md-10 col-lg-10 col-sm-10 col-xs-8 ">
                        <div class="thumbnail"><img id="display_image" src="raw/s.JPG" alt="Image">
                        </div>
                    </div>
                    <div class="col-md-1 col-lg-1 col-sm-1 col-xs-2 button_div " style="margin-top: 25%">
                        <a href="#"><i class="fa fa-chevron-right fa-4x p" aria-hidden="true"></i></a>
                    </div>

                </div>
            </fieldset>

        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 col-lg-3">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border"> Extracted Text</legend>
                <div class="form-group">
                    <button class="btn btn-lg btn-primary "><i class="fa fa-floppy-o " aria-hidden="true"></i>

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

            </fieldset>
        </div>

    </div>
    <div class=" row">
        <div class="col-md-9 " id="process_div">
            <button class="btn btn-primary pull-right"> Process</button>
        </div>
    </div>
</div>
<script type="text/javascript">

    function PreviewImage() {
        var imgReader = new FileReader();
        imgReader.readAsDataURL(document.getElementById("browse").files[0]);

        imgReader.onload = function (oFREvent) {
            document.getElementById("display_image").src = oFREvent.target.result;

        };
    }
    function HandleBrowseClick()
    {
        var fileinput = document.getElementById("browse");
        fileinput.click();
    }
    function Handlechange()
    {

        var fileinput = document.getElementById("browse");
        var textinput = document.getElementById("check");
        textinput.value = fileinput.value;
        PreviewImage();
    }


</script>
</body>

</html>