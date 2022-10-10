<?php
session_start();
$servername="localhost";
$username="root";
$password="password1234";
$dbname="shop";
$per_page=5;
if(isset($_GET["page"])) $start_page=$_GET["page"]*$per_page;
else $start_page=0;
$con=mysqli_connect($servername,$username,$password,$dbname);
if(!$con) die("Connnect mysql database fail!!".mysqli_connect_error());
//echo "Connect mysql successfully!";
$sql="SELECT * FROM product";
$result=mysqli_query($con,$sql);
$numrow=mysqli_num_rows($result);
echo "<h1>SHOP</h1>";
echo "รายการสินค้าทั้งหมด ".$numrow." รายการ<br>";
for($i=0;$i<ceil($numrow/$per_page);$i++)
    echo "<a href='show_product.php?page=$i'>[".($i+1)."]</a>";
$sql="SELECT * FROM product LIMIT $start_page,$per_page";
$result=mysqli_query($con,$sql);
if(mysqli_num_rows($result)>0){
    
    echo "<table border=1><tr><th>id</th><th>name</th><th>description</th><th>price</th><th>image</th></tr>";
    while($row=mysqli_fetch_assoc($result)){
    echo "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["id"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["name"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo $row["description"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["price"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
    echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src = '".$row["image"]."'alt = 'Testimage' width='100px' height='100px'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
    echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='add_product.php?id=".$row["id"]."'>ใส่ตระกร้า</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>";
    }
    echo "</table>";

    $next = ($start_page/$per_page)+1;
    $previous = ($start_page/$per_page)-1;
    if($next > 9)
        $next = 9;
    if($previous < 0)
        $previous = 0;
    echo "<a href='?page=$previous'>[<-- prev]</a>";
    echo "       ";
    echo "<a href='?page=$next'>[next -->]</a>";

}else{
    echo "0 results";
}
if(isset($_SESSION["cart"])){
    if(count($_SESSION["cart"])>0){
        $total=0;
        echo "<h1>ตระกร้าสินค้า</h1>";
        echo "<table><tr><th>ลำดับ</th><th>id</th><th>name</th><th>description</th><th>price</th><th>image</th></tr>";
            for($i=0;$i<count($_SESSION["cart"]);$i++)
            {
                $item=$_SESSION["cart"][$i];
                echo "<tr><td>".($i+1)."</td>";
                echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$item['id']."</td>";
                echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$item['name']."</td>";
                echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$item['description']."</td>";
                echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$item['price']."</td>";
                //echo "<td>".$item['image']."</td>";
                echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src = '".$item['image']."'alt = 'Testimage' width='100px' height='100px'></td>";
                echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='del_cart.php?i=".$i."'>";
                echo "<font color='red'>x</font></a></td></tr>";
                $total+=$item['price'];
            }
        echo "</table>";
        echo "<br>";
        echo "<a href='del_all_cart.php'><font color='red'>นำสินค้าทั้งหมดออก</font></a>";
        echo "<h1>ราคาสิ้นค้า $total บาท</h1>";
        echo "<h2><a href='checkout.php'>สั่งซื้อ</a></h2>";
    }else{

    }

}
mysqli_close($con);
?>