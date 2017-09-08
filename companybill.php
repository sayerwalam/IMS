<!DOCTYPE html>
<!--
My Project

This is my Project which shows how to handle license file in netbeans
-->
<?php
require_once 'functions.php';
session_start();
$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>IMS-Order</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
            
            $(document).on('click','.delete-row', function(){
              $(this).parents('tr').remove();
                })
            
            function addRow() {
                var rows = "";
                var name = document.getElementById("pname").value;
                var qty = document.getElementById("qty").value;
                rows += "<tr><td> <input type='radio' name='radio' class='delete-row' id='radio'> </td><td>" + name + "</td><td>" + qty + "</td></tr>";
                $(rows).appendTo("#list tbody");
            }
            function clean() {
                document.getElementById("bill").reset();
            }
        </script>
        <style>
            .btn.btn-default{
                background-color: black;
                color: white;
            }
            .btn.btn-success{
                font-family: Elephant;   
            }

            body {
                background-image: url('images/imagesbill.jpg');
                background-size:cover;
            }
            .form-control{
                width : 30%;
            }
            td{
                padding-left: 20px;
                margin-left: 20px;
                font-style: Bold;
                font-family: Elephant;
            }
            @media print {
                .container {display: none;}
                #printable {display: block;}
            }
              strong{
                margin-left: 35%;
                font-size: 20px;
              }
              #bill{
                  margin-left: 40%;
              }
              #printable{
                  color: black;
                  font-size: 18px;
              }
        </style>
    </head>
    <body>
        <div class="container" style="margin-left: 85%;margin-top: 20px;" id="container">
            <input type="button" id="home" name="home" class="btn btn-success" value="Home" onclick="window.location = 'home.php'">
        </div>
        <div id="conatiner">
            <form id="bill">  
                <div class="form-group">
                    <label> Enter product name : </label>
                    <input type="text" class="form-control" name="pname" id="pname" />  </div>
                <div class="form-group">
                    <label> Enter Quantity :    </label>
                    <input type="text" class="form-control" id="qty" name="qty" /> </div>
                <input type="button" name="submit" id="submit" onclick="addRow();" value="ADD" class="btn btn-default" />  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" name="clear" id="clear" value="Clear" onclick="clean();"class="btn btn-default">
            </form> <br> <br> <br> </div>
        <div id = "printable">
             <span> <strong>  Date : <?php echo  date("Y/m/d"); ?> &nbsp;&nbsp;&nbsp;&nbsp; Location : <?php echo $_SESSION['location']; ?> </strong> </span>
            <table id = "list" cellspacing = "0px" cellpadding = "20px" text-align = "center" class="table table-stripped">
                <thead>
                    <tr>
                        <td>Delete</td>
                        <td>Item Name</td>
                        <td>Quantity</td>
                    </tr>
                </thead>

                <tbody>

                </tbody>
            </table> <br> <br></div>
        <div id="conatiner">
            <input type="button" onclick="window.print()" value="Print Bill" class="btn btn-success" style="margin-left: 45%;" />
        </div>
    </body>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</html>