<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
$location = $_SESSION['location'];
$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
?>
     <html>
                <head>
                    <meta charset="UTF-8">
                        <title>IMS-My Home</title>
                        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                        <script>
                    function logout()
                        {
                             $.ajax({ 
                             url: 'functions.php',
                             data: {action: 'doLogout'},
                             type: 'post',
                             success: function(output) {
                             alert(output);
                            }
                            });
                        }
                        </script>
                        <style>
                            
                            body{
                                background-image: url('images/images.jpg');
                                background-size: cover;
                            }
                            
                            h3{
                                color: grey;
                                font-family: Adobe Garamond Pro Bold;
                            }
                            
                            #header{
                                font-style: Italic;
                                color: white;
                                font-size : 50px;
                                font-family: Elephant;
                            }
                            #reports {
                                color: black;;
                                font-size: 20px;
                                border: none;
                            }
                            #nav{
                                background-image: url('images/images.jpg');
                                text-align: right;
                                border: none;
                                
                            }
                            #form{
                                margin-left: 20px;
                                margin-top: 15px;
                            }
                            .btn.btn-default{
                                margin-right: 25px;
                                padding-right: 25px;
                                font-family: Cooper Black;
                                font-size: 16px;
                                background-color: black;
                                color: white;
                                
                            }
                            #logout{
                                margin-right: 10px;
                            }
                        </style>
                </head>
                <body>
                    <nav class="navbar navbar-default" id="nav">
                        <h3>
                            <input type="button" onclick="window.location='home.php'" class="btn btn-default" value="Home"/> 
                            <input type="button" onclick="window.location='bill.php'"  class="btn btn-default" value="Make a Bill"/> 
                            <input type="button" onclick="window.location='companybill.php'"  class="btn btn-default" value="Place an Order"/> 
                            <a href="logout.php" class="btn btn-default">Logout </a></h3>
                        </nav> 
                        <h1 id="header" style="text-align: center; margin-top: 50px; "> Welcome to IMS-Stock Center </h1>    
                        
                     <?php
                    require 'functions.php';
                    require 'config/config.php';
                    echo $_SESSION['location'];
                    $location = $_SESSION['location'];
                    $email = $_SESSION['email'];
                     if ($location === "Oxford"){
                         $query = "Select * from stock WHERE location = 'Oxford'";
                         $result1 = $conn->query($query);
                          if ($result1->num_rows > 0){
                              ?>
                        <table class="table"id="reports">
                              <thead>
                              <tr> 
                              <th> Item name </th>
                              <th> Price </th>
                              <th> Quantity </th>
                              <th> Quantity Damaged </th>
                              </tr> </thead> <tbody>
                              <?php
                            while( $row = $result1->fetch_assoc() ){
                            echo
                                 "<tr>
                                     <td>{$row['item_name']}</td>
                                     <td>{$row['price']}</td>
                                     <td>{$row['quantity']}</td>
                                     <td>{$row['quantity_damaged']}</td>
                                     </tr>\n";
                          }  ?> </tbody>
                </table>  
                    <?php  
                          }
                         
                     }
                     elseif ($location === "Bridgeport")
                     {
                         require 'config/config.php';
                         $query1 = "Select * from stock WHERE location = 'Bridgeport'";
                         $result2 = $conn->query($query1);
                         if ($result2->num_rows > 0){
                               ?>
                        <table class="table" id="reports">
                              <thead>
                              <tr> 
                              <th> Item name </th>
                              <th> Price </th>
                              <th> Quantity </th>
                              <th> Quantity Damaged </th>
                              </tr> </thead> <tbody>
                              <?php
                            while( $row = $result2->fetch_assoc() ){
                            echo
                                 "<tr>
                                     <td>{$row['item_name']}</td>
                                     <td>{$row['price']}</td>
                                     <td>{$row['quantity']}</td>
                                     <td>{$row['quantity_damaged']}</td>
                                     </tr>\n";
                          }  ?> </tbody>
                </table>  <?php
                         }   }
                     else
                     {
                         die("Location not valid");
                     }    
                   ?>  
        </body>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

                    </html>
   
