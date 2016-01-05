<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shopping extends CI_Controller {

function pagehead(){
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$now=time();

if(isset($_SESSION['expire'])&&($now>$_SESSION['expire']))
header("Location:/CI/index.php/shopping/logout");

if(isset($_SESSION['customer']))
{
$cid=$_SESSION['customer'];
$this->load->model("model_shopping");
$result=$this->model_shopping->get_customer($cid);
$data['AccountName']=htmlspecialchars($result[0]->AccountName);
$data['head']="<div style='float:left'>Welcome Back&nbsp<a class='link' href='/CI/index.php/shopping/myaccount'>".$data['AccountName']."!</a>&nbsp&nbsp</div>"
. "<a href='/CI/index.php/shopping/logout' style='color:black;float:right'>Logout</a>";
}

else
$data['head']="<div style='float:left'><a href='/CI/index.php/shopping/login'style='color:black'>Login</a>&nbsp&nbsp</div>";    

$this->load->model("model_shopping");
$result = $this->model_shopping->head_category();
$data['choose']="";

foreach ($result as $row)
{
 $data['choose'].="<a class='link'href='/CI/index.php/shopping/category/". $row->CategoryID."' style='color:black;'>".$row->CategoryName."</a>&nbsp;&nbsp;&nbsp;&nbsp";
}

$this->load->view("view_pagehead",$data);
}


function homepage(){
    $this->pagehead();
    $_SESSION['page']="/CI/index.php/shopping/homepage";
    $this->load->model("model_shopping");
    $result = $this->model_shopping->home_special();
    $data['special']="";
    foreach ($result as $row)
    { 
      $data['special'].="<a class='link'href='/CI/index.php/shopping/productdetail/".$row->ProductID."'><img class='pic' src='data:image/jpg;base64,".base64_encode( $row->Pic )."'/></a></br>"
      ."<a class='link'href='/CI/index.php/shopping/productdetail/".$row->ProductID."' style='color:black;'>".$row->ProductName."</a></br>"
      ."<span style='text-decoration:line-through'>$".$row->Price."</span></br>"
      ."<span style='color:red'>$".$row->SpecialSalesPrice."</span></br>"
      ."End Date:".$row->EndDate."</br>"
      ."Qty<select style='font-size:35px'id='".$row->ProductID."'>"
             ."<option value='1'>1</option>"
             ."<option value='2'>2</option>"
             ."<option value='3'>3</option>"
             ."<option value='4'>4</option>"
             ."<option value='5'>5</option>"
             ."<option value='6'>6</option>"
             ."<option value='7'>7</option>"
             ."<option value='8'>8</option>"
             ."<option value='9'>9</option>"
             ."<option value='10'>10</option>"
             ."</select>&nbsp<input type='button' style='font-size:35px' class='addcart'title='".$row->ProductID."' value='Add to Shopping Cart'/></br></br></br>";
    }
    $this->load->view('view_homepage',$data);
    
}

function category($cid){
  $this->pagehead();
  $_SESSION['page']="/CI/index.php/shopping/category/".$cid;
  $this->load->model("model_shopping");
  $result = $this->model_shopping->category($cid); 
  foreach ($result as $row)
  $data['CategoryName']=$row->CategoryName;
  $this->load->model("model_shopping");
  $result = $this->model_shopping->category_product($cid);
  $data['category_product']="";
  foreach ($result as $row){
    $data['category_product'].="<a class='link'href='/CI/index.php/shopping/productdetail/".$row->ProductID."'><img class='pic'src='data:image/jpg;base64,".base64_encode( $row->Pic )."'/></a></br>"
      ."<a class='link'href='/CI/index.php/shopping/productdetail/".$row->ProductID."' style='color:black;'>".$row->ProductName."</a></br>";
     $this->load->model("model_shopping");
     $result1 = $this->model_shopping->category_special($row->ProductID);  
     if($result1==NULL)
       $data['category_product'].= "$".$row->Price."</br>";
     else{
       foreach($result1 as $row1)
       $data['category_product'].= "<span style='text-decoration:line-through'>$".$row->Price."</span></br>" 
                              ."<span style='color:red'>On Sale:$".$row1->SpecialSalesPrice."</span></br>";
  }
     
      
     $data['category_product'].="Qty<select style='font-size:35px'id='".$row->ProductID."'>"
             ."<option value='1'>1</option>"
             ."<option value='2'>2</option>"
             ."<option value='3'>3</option>"
             ."<option value='4'>4</option>"
             ."<option value='5'>5</option>"
             ."<option value='6'>6</option>"
             ."<option value='7'>7</option>"
             ."<option value='8'>8</option>"
             ."<option value='9'>9</option>"
             ."<option value='10'>10</option>"
             ."</select>&nbsp<input type='button' style='font-size:35px'class='addcart'title='".$row->ProductID."' value='Add to Shopping Cart'/></br></br></br>";  
  }
  $this->load->view('view_category',$data);
}


function productdetail($pid){
    $this->pagehead();
    $_SESSION['page']="/CI/index.php/shopping/productdetail/".$pid;
  $this->load->model("model_shopping");
  $result = $this->model_shopping->product($pid); 
  $data['ProductID']=$pid;
  $data['ProductName']=$result[0]->ProductName;
  $data['Pic']=base64_encode($result[0]->Pic);
  $data['Description']=$result[0]->Description;
  $this->load->model("model_shopping");
  $result1 = $this->model_shopping->category_special($pid); 
  $data['product']="";
  if($result1==NULL)
  $data['product'].= "$".$result[0]->Price."</br>";
  else
  {
   $data['product'].="<span style='text-decoration:line-through'>$".$result[0]->Price."</span></br>"
                     ."<span style='color:red'>On Sale:$".$result1[0]->SpecialSalesPrice."</span></br>";
  }
     
 $this->load->view('view_productdetail',$data);
 }
 
 
function addcart(){
 SESSION_start();
if(!isset($_SESSION['customer'])){

if(!isset($_SESSION['i'])){
    $i=0;
    $_SESSION['cartpid'][$i]=$this->input->get('cartpid');
    $_SESSION['cartqty'][$i]=$this->input->get('cartqty');
    echo'Add item and quantity successfully!';
    $_SESSION['i']=$i+1;
  
}
else
{ 
$i=$_SESSION['i'];

for($j=0;$j<$_SESSION['i'];$j++){
    if(($_SESSION['cartpid'][$j]==$this->input->get('cartpid'))&&($_SESSION['cartqty'][$j]!=$this->input->get('cartqty'))&&$j<=($i-1))
    {echo'Quantity for this item change successfully!';
    $_SESSION['cartqty'][$j]=$this->input->get('cartqty');
    break;
    }
    if(($_SESSION['cartpid'][$j]==$this->input->get('cartpid'))&&($_SESSION['cartqty'][$j]==$this->input->get('cartqty'))&&$j<=($i-1))
    {echo'This item is already in your shopping cart with same quantity!';
     break;
    }
    if(($_SESSION['cartpid'][$j]!=$this->input->get('cartpid'))&&$j==($i-1))
    {echo'Add item and quantity successfully!';
     $_SESSION['cartpid'][$i]=$this->input->get('cartpid');
     $_SESSION['cartqty'][$i]=$this->input->get('cartqty');
     $_SESSION['i']= $_SESSION['i']+1;}
 
}}}

else{
    
   $cartpid=$this->input->get('cartpid');
   $cartqty=$this->input->get('cartqty');
   $customerid=$_SESSION['customer'];
  $this->load->model("model_shopping");
  $result = $this->model_shopping->customer_cart($cartpid,$customerid); 
  if($result==NULL)
              {$this->load->model("model_shopping");
               $newRow=array(
                  "ProductID"=>$cartpid,
                  "CustomerID"=>$customerid,
                  "ProductQty"=>$cartqty
               );
               $this->model_shopping->customer_cart_insert($newRow);
               echo 'Add item and quantity successfully!';}

 else {
      $ProductQty=$result[0]->ProductQty;
      if($cartqty==$ProductQty)
         echo'This item is already in your shopping cart with same quantity!';
      else
      {
       $this->load->model("model_shopping");
       $result1 = $this->model_shopping->customer_cart_update1($cartqty,$cartpid,$customerid); 
       echo 'Quantity for this item change successfully!'; 
      }
    
}
   
   
   
}   
}


 
function login(){
    SESSION_start();
    $data['page']=$_SESSION['page'];
     $this->load->view('view_login',$data);
    $submit=$this->input->post('submit');
    $name=$this->input->post('account_name');
    $password=$this->input->post('password');
    if($submit=='Login'){
      $this->load->model("model_shopping");
      $result = $this->model_shopping->login($name,$password); 
      
      if($result==NULL)
        echo "<script>window.alert('Invalid Login!')</script>";  
      else{
          $_SESSION['customer']=$result[0]->CustomerID;
          if(isset($_SESSION['i']))
          {for($j=0;$j<$_SESSION['i'];$j++)
          if(isset($_SESSION['cartpid'][$j])){
          {$customerid=$result[0]->CustomerID;
              $cartpid=$_SESSION['cartpid'][$j];
              $cartqty=$_SESSION['cartqty'][$j];
              $customerid=$_SESSION['customer'];
              $this->load->model("model_shopping");
              $result1 = $this->model_shopping->customer_cart($cartpid,$customerid); 
              if($result1==NULL)
              {$this->load->model("model_shopping");
               $newRow=array(
                  "ProductID"=>$cartpid,
                  "CustomerID"=>$customerid,
                  "ProductQty"=>$cartqty
               );
               $this->model_shopping->customer_cart_insert($newRow); }
              else{
                  $this->load->model("model_shopping");
                  $this->model_shopping->customer_cart_update($cartqty,$cartpid); 
                }
         
          }}}
          
           $_SESSION['time']=time();
           $_SESSION['expire']=$_SESSION['time']+300;
           header("Location:".$_SESSION['page']."");
           
              
          }
      }
  }
  
  
  
function myaccount(){
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if(!isset($_SESSION['customer']))
header("Location:/CI/index.php/shopping/logout");
$this->pagehead();
$_SESSION['page']="/CI/index.php/shopping/myaccount";
$this->load->view('view_myaccount');
}


function profile(){
    SESSION_start();
$data['fn']='';
$data['ln']='';
$data['an']='';
$data['pw']='';
$data['cpw']='';
$data['em']='';
$data['ph']='';
$data['sa']='';
$data['ba']='';
if(isset($_SESSION['customer'])){
    $this->myaccount();
    $cid=$_SESSION['customer'];
    $this->load->model("model_shopping");
    $result=$this->model_shopping->get_customer($cid); 
    $data['fn']=$result[0]->FirstName;
    $data['ln']=$result[0]->LastName;
    $data['pw']=$result[0]->Password;
    $data['cpw']=$result[0]->Password;
    $data['em']=$result[0]->Email;
    $data['ph']=$result[0]->Phone;
    $data['sa']=$result[0]->DefaultShippingAddress;
    $data['ba']=$result[0]->DefaultBillingAddress;
    $data['an']=$result[0]->AccountName;
}
else 
    $this->pagehead();
$this->load->view('view_profile',$data);
}

function edit_add_profile(){
  SESSION_start();

   $data['fn']=$this->input->get('fn');
   $data['ln']=$this->input->get('ln');
   $data['pw']=$this->input->get('pw');
   $data['an']=$this->input->get('an');
   $data['em']=$this->input->get('em');
   $data['ph']=$this->input->get('ph');
   $data['sa']=$this->input->get('sa');
   $data['ba']=$this->input->get('ba');
 
if(strlen($data['em'])==0)
    $data['em']=NULL;
if(strlen($data['ph'])==0)
    $data['ph']=NULL;
if(strlen($data['sa'])==0)
    $data['sa']=NULL;
if(strlen($data['ba'])==0)
    $data['ba']=NULL;

if(isset($_SESSION['customer'])){
  $cid=$_SESSION['customer'];
  $this->load->model("model_shopping");
  $result=$this->model_shopping->login($data['an'],$data['pw']); 
  if($result==NULL)
{ $this->load->model("model_shopping");
  $this->model_shopping->update_customer($data['fn'],$data['ln'],$data['pw'],$data['em'],$data['ph'],$data['sa'],$data['ba'],$data['an'],$cid); 
  echo'Update Profile Successfully!';}
else{
    
    if(($result[0]->CustomerID)!=$cid)
{echo 'Customer already exsited! Please change your account name or password!';}
else{
    $this->load->model("model_shopping");
  $this->model_shopping->update_customer($data['fn'],$data['ln'],$data['pw'],$data['em'],$data['ph'],$data['sa'],$data['ba'],$data['an'],$cid);
  echo'Update Profile Successfully!';}
}}
 
else{
  $this->load->model("model_shopping");
  $result=$this->model_shopping->login($data['an'],$data['pw']); 
    if($result==NULL){
    $this->load->model("model_shopping");
    $this->model_shopping->insert_customer($data['fn'],$data['ln'],$data['ph'],$data['pw'],$data['em'],$data['sa'],$data['ba'],$data['an']); 
    echo'Create Profile Successfully!Please Login!';}
    else 
    echo 'Customer already exsited! Please change your account name or password!';}
    }

function shopping_cart(){
    SESSION_start();
$data['output']="";
$_SESSION['page']="/CI/index.php/shopping/shopping_cart";
$f=0;
if(!isset($_SESSION['customer'])){
    $this->pagehead();
if(!isset($_SESSION['i']))
    $data['output'].="<p style='text-align:center'>Your shopping cart is empty!</p>";
else {
        $data['output'].="<form action='/CI/index.php/shopping/pay.php'method='POST'>";
        $data['output'].="<table style='width:80%'>";
        for($j=0;$j<$_SESSION['i'];$j++){
          if(isset($_SESSION['cartpid'][$j])){
          $pid=$_SESSION['cartpid'][$j];
          $qty=$_SESSION['cartqty'][$j];
           $this->load->model("model_shopping");
           $result=$this->model_shopping->product($pid); 
           $proname=$result[0]->ProductName;
          $proprice=$result[0]->Price;
          $this->load->model("model_shopping");
           $result1=$this->model_shopping->category_special($pid); 
          if($result1!=NULL)
          {
          $proprice=$result1[0]->SpecialSalesPrice;}
          $price=$qty*$proprice;
          $data['output'].="<div><input type='hidden' id='price1".$pid."' value='".$price."'/>"
          ."<input type='hidden'id='price2".$pid."' value='".$proprice."'/>"
          ."<input type='hidden' id='pqty".$pid."' value='".$qty."'/>"
          
          ."<tr><td>"
          ."<input type='checkbox'name='cart'value='". $pid."'/></td>"
          ."<td><a class='link'href='/CI/index.php/shopping/ProductDetail".$pid."'><img class='pic'src='data:image/jpg;base64,".base64_encode($result[0]->Pic)."'/></a>&nbsp&nbsp&nbsp</td>"
          ."<td><a class='link'href='/CI/index.php/shopping/ProductDetail".$pid."' style='color:black;'>".$result[0]->ProductName
          ."</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>Qty<input type='text'class='cartqtychange1'title='".$pid."'style='width:1cm'value='".$qty."'/>&nbsp&nbsp&nbsp</td>"
          ."<td id='".$price."'>$".$price."</td></tr></div>";
        }}
    $data['output'].="</table></form>"
   ."<input style='font-size:35px'type='button'id='deletecart1'value='Delete selected items'/>&nbsp&nbsp&nbsp"
    . "<input style='font-size:35px'type='button'id='emptycart1'value='Delete All'/>"
    ."<div id='logincheck'style='float:right'><a class='link'href='/CI/index.php/shopping/login' >Login to checkout>></div>"
          ."</a></br></br></br></br>";
    
    
}
}

else{
    
    $this->myaccount();
    $customerid=$_SESSION['customer'];
    $this->load->model("model_shopping");
    $result=$this->model_shopping->cart($customerid); 
    if($result==NULL)
 {$data['output'].="<p style='text-align:center'>Your shopping cart is empty!</p>"; }
else {
        $data['output'].="<form action='/CI/index.php/shopping/pay'method='POST'><table>";
        foreach($result as $row){
           unset($_SESSION['qty']);
           unset($_SESSION['id']);
          $pid=$row->ProductID;
          $qty=$row->ProductQty;
          $this->load->model("model_shopping");
          $result1=$this->model_shopping->orderdetail($pid); 
        
         if($result1!=NULL)
         {
          foreach ($result1 as $row1){
               $oid=$row1->OrderID;
               if($f==0)
               {$_SESSION['qty']=$row1->ProductQty;
               $_SESSION['id']=$pid;
               
               }
        $this->load->model("model_shopping");
        $result2=$this->model_shopping->orderdetail1($oid);        
        foreach($result2 as $row2){
                   $opid=$row2->ProductID;
                   $tq=$row2->ProductQty;
                   if(($opid!=$pid)&&($tq>=$_SESSION['qty']))
                   {$_SESSION['qty']=$tq;
                    $_SESSION['id']=$opid;
                    $f=1;
                   
                    break;
                       
                   }
                       
               }
               
           }  
         $id=$_SESSION['id'];
         
        $this->load->model("model_shopping");
        $result3=$this->model_shopping->product($id);  
        $n=$result3[0]->ProductID;
        $pic=$result3[0]->Pic; }
      
        $this->load->model("model_shopping");
       $result4=$this->model_shopping->product($pid);
        $proname=$result4[0]->ProductName;
        $proprice=$result4[0]->Price;
        $this->load->model("model_shopping");
       $result5=$this->model_shopping->category_special($pid);
          
          if($result5!=NULL)
          {
          $proprice=$result5[0]->SpecialSalesPrice;}
          $price=$qty*$proprice;
          $data['output'].="<input type='hidden' id='price21".$pid."' value='".$price."'/>"
          ."<input type='hidden' id='price22".$pid."' value='".$proprice."'/>"
          ."<input type='hidden' id='pqty2".$pid."' value='".$qty."'/>"
          ."<tr><td><input type='checkbox'name='cart'value='". $pid."'/></td>"
          ."<td><a class='link'href='/CI/index.php/shopping/ProductDetail/".$pid."'><img class='pic'src='data:image/jpg;base64,".base64_encode( $result4[0]->Pic)."'/></a>&nbsp&nbsp&nbsp</td>"
          ."<td><a class='link'href='/CI/index.php/shopping/ProductDetail/".$pid."' style='color:black;'>".$result4[0]->ProductName
          ."</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>Qty<input type='text'class='cartqtychange2'title='".$pid."'style='width:1cm'value='".$qty."'>&nbsp&nbsp&nbsp</td><td id='".$price."'>"
          ."$".$price."</td>";
        if(isset($_SESSION['id'])&&($id!=$pid))
        {$f=0;
        $data['output'].="<td>Recommend</td><td><a class='link'href='/CI/index.php/shopping/ProductDetail/".$n."'><img height='42' width='42'src='data:image/jpg;base64,".base64_encode($pic)."'/></a></td>";}
        $data['output'].="</tr>";
    }
    $data['output'].="</table style='width:80%'>"
    ."<input style='font-size:35px'type='button'value='Delete selected items'id='deletecart2'/>&nbsp&nbsp&nbsp"
    . "<input style='font-size:35px'type='button'id='emptycart2'value='Delete All'/>"
    ."<div style='float:right'><input style='font-size:35px'type='submit'value='Process to checkout'/></div></br></br></br></br>"
    ."</form>";
    
}}$this->load->view('view_shopping_cart',$data);

}


function deletecart1(){
 SESSION_start();
$num=$this->input->get('num');

$pid = explode(',', $this->input->get('pid'));


for($j=0;$j<$_SESSION['i'];$j++){
    for($i=0;$i<$num;$i++){
      if($_SESSION['cartpid'][$j]==$pid[$i])
          unset ($_SESSION['cartpid'][$j]);
    }
}
   
}

function deletecart2(){
    SESSION_start();

$num=$this->input->get('num');

$pid = explode(',', $this->input->get('pid'));
$cid=$_SESSION['customer'];
for($i=0;$i<$num;$i++){
    $this->load->model("model_shopping");
$this->model_shopping->delete_cart($cid,$pid[$i]);}
    
}


function emptycart1(){
 SESSION_start();

unset($_SESSION['i']);
unset($_SESSION['cartpid']);
unset($_SESSION['cartqty']); 
    
}

function emptycart2(){
    SESSION_start();
$cid=$_SESSION['customer'];
$this->load->model("model_shopping");
$this->model_shopping->empty_cart($cid);
}


function cartqtychange1(){
    SESSION_start();
$pid=$this->input->get('pid');
$qty=$this->input->get('qty');
for($j=0;$j<$_SESSION['i'];$j++){
  if($_SESSION['cartpid'][$j]==$pid)
  {$_SESSION['cartqty'][$j]=$qty;
break;}
}
echo $_SESSION['cartqty'][$j];
}


function cartqtychange2(){
    SESSION_start();
$pid=$this->input->get('pid');
$qty=$this->input->get('qty');
$customerid=$_SESSION['customer'];
$this->load->model("model_shopping");
$this->model_shopping->change_cart($qty,$customerid,$pid);
}

function pay(){
SESSION_start();
$this->myaccount();
$data['fn']='';
$data['ln']='';
$data['ph']='';
$data['sa']='';
$data['ba']='';
$cid=$_SESSION['customer'];
$this->load->model("model_shopping");
$result=$this->model_shopping->cart($cid);
$data['table']="<table>";

        $total=0;
        foreach($result as $row){
            
          $pid=$row->ProductID;
          $qty=$row->ProductQty;
          
         $this->load->model("model_shopping");
         $result1=$this->model_shopping->product($pid); 
         $proname=$result1[0]->ProductName;
        $proprice=$result1[0]->Price;
        $this->load->model("model_shopping");
         $result2=$this->model_shopping->category_special($pid);
         if($result2!=NULL)
          {
          $proprice=$result2[0]->SpecialSalesPrice;}
          $price=$qty*$proprice;
          $total+=$price;
        $data['table'].="<tr>"
          ."<td><img class='pic'src='data:image/jpg;base64,".base64_encode( $result1[0]->Pic )."'/>&nbsp&nbsp&nbsp</td>"
          ."<td>".$result1[0]->ProductName."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>"
          ."<td>Qty&nbsp&nbsp&nbsp".$qty."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>"
          ."<td>"."$".$price."</td></tr>";
    }
   $data['table'].="</table>"
    ."<p style='position:absolute;right:8cm'>Total Price:$".$total."</p></br></br></br></br>";
 
    
     $this->load->model("model_shopping");
     $result=$this->model_shopping->get_customer($cid); 
    $data['fn']=$result[0]->FirstName;
    $data['ln']=$result[0]->LastName;
    $data['ph']=$result[0]->Phone;
    $data['sa']=$result[0]->DefaultShippingAddress;
    $data['ba']=$result[0]->DefaultBillingAddress;
    
 $this->load->view('view_pay',$data);  
}


function place_order(){
SESSION_start();
$this->myaccount();

$fn=$this->input->post('fn');
$ln=$this->input->post('ln');
$ph=$this->input->post('ph');
$sa=$this->input->post('sa');
$ba=$this->input->post('ba');
$cn=$this->input->post('cn');
$cid=$_SESSION['customer'];
date_default_timezone_set('America/Los_Angeles');
$date = date("Y-m-d");

$this->load->model("model_shopping");
$result=$this->model_shopping->insert_order($cid,$date,$sa,$ba,$cn,$ph,$fn,$ln);
$this->load->model("model_shopping");
$result1=$this->model_shopping->order();

$oid=$result1[0]->OrderID;


$this->load->model("model_shopping");
$result2=$this->model_shopping->cart($cid);

foreach($result2 as $row2){
    $pid=$row2->ProductID;
    $qty=$row2->ProductQty;
    $this->load->model("model_shopping");
    $this->model_shopping->insert_orderdetail($pid,$qty,$oid);
}

$this->load->model("model_shopping");
$this->model_shopping->empty_cart($cid);
$this->load->view('view_place_order');
}

function order_history(){
    $this->myaccount();
$cid=$_SESSION['customer'];
$this->load->model("model_shopping");
$result=$this->model_shopping->select_order($cid);
$data['output']="";
if($result==NULL)
    $data['output'].="<h1 style='text-align:center'>No Order History!</h1>";
else{
    $data['output'].="<table>";
    foreach($result as $row)
    {$oid=$row->OrderID;
     $date=$row->OrderDate;
     $data['output'].="<tr>"
          ."<td><a class='link'href='/CI/index.php/shopping/OrderDetail/".$oid."' style='color:black;'>Order#:".$oid
          ."</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td>OrderDate:".$date."</td></tr>";
    }
    $data['output'].="</table>";
    
}$this->load->view('view_orderhis',$data);}

function OrderDetail($oid){
    $this->myaccount();
$this->load->model("model_shopping");
$result=$this->model_shopping->select_orderdetail($oid);
$data['table']="<table style='width:80%'>";
$data['total']=0;
foreach($result as $row){
     $pid=$row->ProductID;
     $qty=$row->ProductQty;
     $this->load->model("model_shopping");
     $result1=$this->model_shopping->product($pid);
     $proname=$result1[0]->ProductName;
     $proprice=$result1[0]->Price;
     $this->load->model("model_shopping");
     $result2=$this->model_shopping->category_special($pid);
     if($result2!=NULL)
     {
     $proprice=$result2[0]->SpecialSalesPrice;}
     $price=$qty*$proprice;
     $data['total']+=$price;
     $data['table'].="<tr>"
          ."<td><a class='link'href='/CI/index.php/shopping/ProductDetail/".$pid."'><img class='pic'src='data:image/jpg;base64,".base64_encode( $result1[0]->Pic )."'/>&nbsp&nbsp&nbsp</a></td>"
          ."<td><a class='link'href='/CI/index.php/shopping/ProductDetail/".$pid."' style='color:black;'>". $result1[0]->ProductName."</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>"
          ."<td>Qty&nbsp&nbsp&nbsp".$qty."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>"
          ."<td>"."$".$price."</td></tr>";
 }
 $data['table'].="</table>";
 $this->load->model("model_shopping");
 $result=$this->model_shopping->select_orderinfor($oid);
    $data['fn']=htmlspecialchars($result[0]->FirstName);
    $data['ln']=htmlspecialchars($result[0]->LastName);
    $data['ph']=htmlspecialchars($result[0]->Phone);
    $data['sa']=htmlspecialchars($result[0]->ShippingAddress);
    $data['ba']=htmlspecialchars($result[0]->BillingAddress);
    $data['cn']=htmlspecialchars($result[0]->CardNumber);
    $this->load->view('view_OrderDetail',$data);
     }

function logout(){
     SESSION_start();
     SESSION_destroy();
     header("Location:/CI/index.php/shopping/homepage");}  
     
     
     
    }

?>