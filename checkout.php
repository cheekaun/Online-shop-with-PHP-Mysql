<?php
session_start();

if(isset($_SESSION["cart"])){
    echo "<h1>สรุปรายการสินค้า</h1>";
    $total=0;
    echo "<h1>ตระกร้าสินค้า</h1>";
    echo "<table><tr><th>ลำดับ</th><th>id</th><th>name</th><th>description</th><th>price</th><th>image</th></tr>";
        for($i=0;$i<count($_SESSION["cart"]);$i++)
        {
            $item=$_SESSION["cart"][$i];
            echo "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($i+1)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
            echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$item['id']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
            echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$item['name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
            echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$item['description']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
            echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$item['price']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
            echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src = '".$item['image']."'alt = 'Testimage' width='100px' height='100px'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
            echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='del_cart.php?i=".$i."'>";
                
                $total+=$item['price'];
        }
    echo "</table>";
    echo "<h1>ราคาสิ้นค้า $total บาท</h1>";
?>
        <form action="order.php" method="post">
        <label for="fname">First name:</label><br>
        <input type="text" id="fname" name="fname" value=""><br>
        <label for="lname">Last name:</label><br>
        <input type="text" id="lname" name="lname" value=""><br>
        <lable for="address">Address:</label><br>
<textarea id="address" name="address"  rows="4" cols="50"></textarea><br>
        <lable for="mobile">mobile no.:</label><br>
        <input type="text" id="mobile" name="mobile" value=""><br>
        <input type="submit" value="ยืนยัน">
        </form> 
<?php
}
?>