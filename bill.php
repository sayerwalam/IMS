<!DOCTYPE html>
<!--
Here comes the text of your license
Each line should be prefixed with 
-->
<?php
require_once 'functions.php';
session_start();
$location = $_SESSION['location'];
$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>IMS-Bill</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <style type="text/css">
            body {
                background-image: url('images/imagesbill.jpg');
                background-size:cover;
            }
            @media print {
                #container {display: none;}
                #printable {display: block;}
            }
            .form-control{
                width : 100%;
            }
            td{
                padding-left: 20px;
                margin-left: 20px;
                font-style: Bold;
                font-family: Elephant;
            }
            .btn.btn-default{
                background-color: black;
                color: white;
            }
            .btn.btn-success{
                font-family: Elephant;   
            }
            strong{
                margin-left: 35%;
                font-size: 20px;
            }
            #billform{
                margin-left: 32%;
            }
            #printable{
                color:black;
                font-size: 18px;
            }
        </style>
        <script type="text/javascript">

             $(document).on('click','.delete-row', function(){
              $(this).parents('tr').remove();
                })
            function addRow() {
                var rows = "";
                var technician = document.getElementById("technames");
                var techid = technician.value;
                var techname = technician.options[technician.selectedIndex].text;
                var product = document.getElementById("product");
                var prodid = product.value;
                var prodname = product.options[product.selectedIndex].text;
                var qty = document.getElementById("qty").value;
                var price = document.getElementById("price").value;

                rows += "<tr><td> <input type='radio' name='radio' class='delete-row' id='radio'> </td><td>" + techname + "</td><td>" + prodname + "</td><td>" + qty + "</td><td>" + price + "</td></tr>";
                $(rows).appendTo("#list tbody");
              }

            function clean() {
                document.getElementById("form").reset();
            }

            function checkq(product) {
                var productDropdown = document.getElementById(product);
                var productSelected = productDropdown.options[productDropdown.selectedIndex].value;

                var data = {
                    "functions": "getPriceQtyQtyDmg",
                    "product_id": productSelected
                };
                $.ajax({
                    url: "ajaxcall.php",
                    type: "POST",
                    dataType: "json",
                    data: data,
                    cache: false,
                    success: function (response) {
                        var price = response.price;
                        var quantity = response.quantity;
                        var quantity_damaged = response.quantity_damaged;
                        var quantity_entered = document.getElementById("qty").value;
                        if (quantity_entered <= (quantity - quantity_damaged)) {
                            setPrice = price * quantity_entered;
                            document.getElementById("price").value = setPrice;
                        } else {
                            alert("Insufficient Quantity. Max allowed is : " + (quantity - quantity_damaged));
                        }
                    }
                });
            }
        </script>
    </head>
    <body>
        <div id="container">
            <div style="float:right;margin-top: 20px;margin-right: 30px;">
                <input type="button" id="home" name="home" class="btn btn-success" value="Home" onclick="window.location = 'home.php'">
            </div>
            <form id='form' class="form-group">
                <table id="billform" style="border-collapse: separate; border-spacing: 10px;">
                    <tr> 
                        <td> <span class="form-inline"> Selcect Technician Name  </span> </td>
                        <td>
                            <?php
                            require 'config/config.php';
                            $tech = "select id, first_name,last_name from users WHERE position = 'Technician'";
                            $rstech = $conn->query($tech);
                            echo "<select id='technames' class = 'form-control'>"
                            . " <option selected disabled hidden value='Choose here'>Choose here</option>";
                            while ($techs = $rstech->fetch_assoc()) {
                                $techid = $techs['id'];
                                $techname = $techs['first_name'] . $techs['last_name'];
                                echo '<option value="' . $techid . '">' . $techname . '</option>';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td> <span class="col-4 col-form-label"> Choose Product name  </span> </td>    
                        <td>
                            <?php
                            echo "<select name='product_name' id='product' class = 'form-control' >"
                            . " <option selected disabled hidden value='Choose here'>Choose here</option>";
                            if ($location === "Oxford") {
                                $sql = "select * from stock WHERE location = 'Oxford'";
                                $rs = $conn->query($sql);
                                while ($row = $rs->fetch_assoc()) {
                                    unset($id, $name);
                                    $id = $row['id'];
                                    $name = $row['item_name'];
                                    echo '<option value="' . $id . '">' . $name . '</option>';
                                }
                            } else if ($location === "Bridgeport") {
                                $sql = "select id,item_name from stock WHERE location = 'Bridgeport'";
                                $rs = $conn->query($sql);
                                while ($row = $rs->fetch_assoc()) {
                                    unset($id, $name);
                                    $id = $row['id'];
                                    $name = $row['item_name'];
                                    echo '<option value="' . $id . '">' . $name . '</option>';
                                }
                                echo "</select>";
                            }
                            ?></td></tr>
                    <tr>
                        <td> <span class="col-2 col-form-label"> Enter Quantity : </span> </td>
                        <td> <input type="text" id="qty" name="qty" class="form-control" required> </td>
                    </tr> <br>
                    <tr>
                        <td> <input type="button" onclick="checkq('product');" name="check" id="check" value="Check Price" class="btn btn-default" />  </td>
                    </tr>
                    <tr>
                        <td><span class='col-2 col-form-label'> Price : </span> </td>
                        <td> <input type="text" id="price" name="price" disabled="" class="form-control"> </td>

                    </tr> <br> <br>
                    <tr>
                        <td> <input type="button" id="submit" name="submit" value="Add" onclick="addRow();" class="btn btn-default" >  </td>
                        <td> <input type="button" name="clear" id="clear" value="Clear" onclick="clean();"class="btn btn-default"> </td>
                    </tr>
                </table>
            </form>
        </div>
        <!--<form action="" method="post">-->
        <div id = "printable">
            <span> <strong>  Date : <?php echo  date("Y/m/d"); ?> &nbsp;&nbsp;&nbsp;&nbsp; Location : <?php echo $_SESSION['location']; ?> </strong> </span>
            <table id = "list" cellspacing = "0px" cellpadding = "20px" text-align = "center" class="table table-stripped">
                <thead>
                    <tr>
                        <td>Delete</td>
                        <td>Technician Name</td>
                        <td>Product Name</td>
                        <td>Quantity</td>
                        <td>Price</td>
                    </tr>
                </thead>

                <tbody>

                </tbody>
            </table> <br> <br </div>
        <div id="container">
            <input type="button" onclick="window.print()" value="Print Bill" class="btn btn-success" style="margin-left: 45%;" /> 
        </div>  
        <!--</form>-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    </body>
</html>
