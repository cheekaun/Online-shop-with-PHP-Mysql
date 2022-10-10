<?php
session_start();
$fname= $_POST["fname"];
$lname= $_POST["lname"];
$address= $_POST["address"];
$mobile= $_POST["mobile"];
$servername="localhost";
$username="root";
$password="password1234";
$dbname="shop";
$con=mysqli_connect($servername,$username,$password,$dbname);
if(!$con) die("Connnect mysql database fail!!".mysqli_connect_error());
//echo "Connect mysql successfully!";
$sql="INSERT INTO order_product (fname, lname,address,mobile)";
$sql.="VALUES ('$fname', '$lname', '$address','$mobile');";
//echo $sql;
if (mysqli_query($con, $sql)) {
    $last_id = mysqli_insert_id($con);
    //echo "New record created successfully. Last inserted ID is: " . $last_id;
    // loop in session cart and insert each item to database
    $sql1="INSERT INTO order_details (order_id,product_id) VALUES ";
    for($i=0;$i<count($_SESSION["cart"]);$i++){
        $item_id=$_SESSION["cart"][$i]['id'];
        $sql1.="('$last_id','$item_id')";
        if($i<count($_SESSION["cart"])-1)
         $sql1.=",";
        else
         $sql.=";";
    }
    //echo $sql1;
    if(mysqli_query($con,$sql1)){
      echo "<h1>บันทึกข้อมูลการสั่งซื้อเรียบร้อยแล้ว<br></h1>";
      //$sql2 = "SELECT * FROM order_product JOIN order_details ON order_product.id = order_details.order_id JOIN product ON order_details.product_id = product.id ON onder_details.order_id";
      $sql2 = "SELECT * FROM order_product,order_details,product WHERE order_product.id=order_details.order_id AND order_details.product_id =  product.id AND order_details.order_id=$last_id";
      $resultss = mysqli_query($con, $sql2);
      $sum = 0;
      
      if(mysqli_num_rows($resultss)>0){
        $row=mysqli_fetch_assoc($resultss);
        echo "<h2>รายละเอียด</h2>";
        
        echo "ชื่อจริง:&nbsp;&nbsp;&nbsp;".$row["fname"]."<br>";
        echo "นามสกุล:&nbsp;&nbsp;&nbsp;".$row["lname"]."<br>";
        echo "ทีอยู่:&nbsp;&nbsp;&nbsp;".$row["address"]."<br>";
        echo "เบอร์โทรศัพท์:&nbsp;&nbsp;&nbsp;".$row["mobile"]."<br>";
        echo "วันที่และเวลาที่สั่งสินค้า:&nbsp;&nbsp;&nbsp;".$row["order_date"]."<br><br>";
        echo "รายการสินค้าที่สั่ง";
        $count = 1;

        echo "<table border=0><tr><th>ลำดับที่</th><th>รายการ</th><th>รายละเอียด</th><th>ราคา</th></tr>";
        echo "<tr><td>&nbsp;&nbsp;&nbsp;".$count."&nbsp;&nbsp;&nbsp;</td>";
          echo "<td>&nbsp;&nbsp;&nbsp;".$row["name"]."&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;".$row["description"]."</td>&nbsp;&nbsp;&nbsp;<td>&nbsp;&nbsp;&nbsp;".$row["price"]."&nbsp;&nbsp;&nbsp;</td></tr><br>";
          $sum+=$row["price"];
          $count+=1;
        while($row=mysqli_fetch_assoc($resultss)){
          /*echo "&nbsp;&nbsp;&nbsp;".$count."&nbsp;&nbsp;&nbsp;";
          echo "&nbsp;&nbsp;&nbsp;".$row["name"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["description"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["price"]."&nbsp;&nbsp;&nbsp;<br>";
          $sum+=$row["price"];
          $count+=1;*/ 
          echo "<tr><td>&nbsp;&nbsp;&nbsp;".$count."&nbsp;&nbsp;&nbsp;</td>";
          echo "<td>&nbsp;&nbsp;&nbsp;".$row["name"]."&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;".$row["description"]."</td>&nbsp;&nbsp;&nbsp;<td>&nbsp;&nbsp;&nbsp;".$row["price"]."&nbsp;&nbsp;&nbsp;</td></tr><br>";
          $sum+=$row["price"];
          $count+=1;
        }
        echo "</table>";
        
    }else{
        echo "";
      }
      echo "<br><h2>รวมยอดชำระทั้งหมด<br></h2>";
      echo "<h3>".$sum." บาท</h3>";
    } 
    else "เกิดข้อผิดพลาดในการสั่งซื้อ";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
  
  mysqli_close($conn);
//$result=mysqli_query($con,$sql);
//$numrow=mysqli_num_rows($result);
?>

<!-- //SELECT * FROM `order_product` WHERE 1 -->

<!--SELECT * FROM `order_product` JOIN `order_details` ON 
`order_product`.id = `order_details`.order_id JOIN 
`product` ON `order_details`.product_id = `product`.id-->