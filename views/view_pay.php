
    <form action="/CI/index.php/shopping/place_order"method="POST"id="sub">
    
    
    <h1 style="text-align:center">Order Information</h1>
    <?php echo $table;?>

    <h1 style="text-align:center">Shipping Information</h1>
    <PRE style="text-align:center">
    *FirstName       <input type="text" name="fn"id="fn1"required value="<?php echo $fn;?>"/>
    *LastName        <input type="text" name="ln"id="ln1"required value="<?php echo $ln;?>"/>
    *Phone           <input type="text" name="ph"id="ph1"required value="<?php echo $ph;?>"/>
    *Shipping Address
    <input required type="text" name="sa"id="sa1"value="<?php echo $sa;?>"/>
    *Billing Address
    <input required type="text" name="ba"id="ba1"value="<?php echo $ba;?>"/>
    *Card Number
    <input required type="text" name="cn"id="cn1"/>
    
    <input style='font-size:35px'type="submit"value="Place Your Order"></PRE>
    </form>
 
    </body>
   </html>
      

      


