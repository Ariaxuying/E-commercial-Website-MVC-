 <div style="text-align:center">
 <h1><?php echo $ProductName;?></h1>
<img src="data:image/jpg;base64,<?php echo $Pic;?>"/></br></br>
<div style="margin:auto; width:30%"><?php echo $Description;?></div></br>
<?php echo $product;?>
     
     Qty<select style="font-size:35px"id="<?php echo $ProductID?>">
            <option value="1">1</option>
             <option value="2">2</option>
             <option value="3">3</option>
             <option value="4">4</option>
             <option value="5">5</option>
             <option value="6">6</option>
             <option value="7">7</option>
             <option value="8">8</option>
             <option value="9">9</option>
             <option value="10">10</option>
             </select>&nbsp<input type="button" style="font-size:35px"class="addcart"title="<?php echo $ProductID?>" value="Add to Shopping Cart">
             </br></br></br>
 </div>
</body>
</html>

