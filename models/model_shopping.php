<?php
class Model_shopping extends CI_Model {
   function get_customer($cid){
       $query=  $this->db->query("select * from Customer where CustomerID=$cid");
       return $query->result();
   } 
   
   function head_category(){
      $query=  $this->db->query("select * from Category");
      return $query->result();
   }
   
   function home_special(){
      $query=  $this->db->query("select * from Product, SpecialSales where Product.ProductID=SpecialSales.ProductID");
      return $query->result(); 
   }
   
   function category($cid){
    $query=  $this->db->query("select * from Category where CategoryID=$cid");  
    return $query->result(); 
   }
   
   function category_product($cid){
    $query=  $this->db->query("select * from Product where CategoryID=$cid");  
    return $query->result(); 
   }
   
    function category_special($pid){
    $query=  $this->db->query("select * from SpecialSales where ProductID=$pid"); 
    if($query->num_rows()!=0)
    return $query->result(); 
    else
    return NULL;}
    
     function product($pid){
    $query=  $this->db->query("select * from Product where ProductID=$pid");  
    return $query->result(); 
   }
   
    function login($name,$password){
    $query=  $this->db->query("select * from Customer where AccountName=".$this->db->escape($name)." and Password=".$this->db->escape($password));  
    if($query->num_rows()!=0)
    return $query->result(); 
    else
    return NULL; 
   }
   
   function customer_cart($cartpid,$customerid){
    $query=  $this->db->query("select * from ShoppingCart where ProductID=$cartpid and CustomerID=$customerid");  
    if($query->num_rows()!=0)
    return $query->result(); 
    else
    return NULL; 
   }
   
   function customer_cart_insert($newRow){
       $this->db->insert("ShoppingCart",$newRow);
   }
   
   function customer_cart_update($cartqty,$cartpid){
   $this->db->query("update ShoppingCart set ProductQty=$cartqty where ProductID=$cartpid");     
   } 
   
   function customer_cart_update1($cartqty,$cartpid,$customerid){
   $this->db->query("update ShoppingCart set ProductQty=$cartqty where ProductID=$cartpid and CustomerID=$customerid");     
   } 
   
   function update_customer($fn,$ln,$pw,$em,$ph,$sa,$ba,$an,$cid){
   $this->db->query("update Customer set FirstName=".$this->db->escape($fn).",LastName=".$this->db->escape($ln).",Password=".$this->db->escape($pw).",Email=".$this->db->escape($em).",Phone=".$this->db->escape($ph).",DefaultShippingAddress=".$this->db->escape($sa).",DefaultBillingAddress=".$this->db->escape($ba).",AccountName=".$this->db->escape($an)." where CustomerID=".$this->db->escape($cid));     
   } 
   
   function insert_customer($fn,$ln,$ph,$pw,$em,$sa,$ba,$an){
    $this->db->query("insert into Customer (FirstName,LastName,Phone,Password,Email,DefaultShippingAddress,DefaultBillingAddress,AccountName)values (".$this->db->escape($fn).",".$this->db->escape($ln).",".$this->db->escape($ph).",".$this->db->escape($pw).",".$this->db->escape($em).",".$this->db->escape($sa).",".$this->db->escape($ba).",".$this->db->escape($an).")");      
   }
   
   function cart($customerid){
     $query=$this->db->query("select * from ShoppingCart where CustomerID=$customerid");
     if($query->num_rows()!=0)
    return $query->result(); 
    else
    return NULL; 
   }
   
   function orderdetail($pid){
     $query=$this->db->query("select * from OrderDetail where ProductID=$pid");  
     if($query->num_rows()!=0)
    return $query->result(); 
    else
    return NULL;
   }
   
   function orderdetail1($oid){
   $query=$this->db->query("select ProductQty, ProductID from OrderDetail where OrderID=$oid Order by ProductQty DESC");
   return $query->result();}
   
   function delete_cart($cid,$pid){
    $this->db->query("Delete from ShoppingCart where CustomerID=$cid and ProductID=$pid");   
   }
   
   function empty_cart($cid){
   $this->db->query("Delete from ShoppingCart where CustomerID=$cid");    
   }
   
   function change_cart($qty,$customerid,$pid){
   $this->db->query("update ShoppingCart set ProductQty=$qty where CustomerID=$customerid and ProductID=$pid");
    }  
    
  function insert_order($cid,$date,$sa,$ba,$cn,$ph,$fn,$ln){
   $this->db->query("insert into OrderInfor(CustomerID,OrderDate,ShippingAddress,BillingAddress,CardNumber,Phone,FirstName,LastName) values ($cid,'$date',".$this->db->escape($sa).",".$this->db->escape($ba).",'$cn','$ph',".$this->db->escape($fn).",".$this->db->escape($ln).")");
    }
   
    function order(){
   $query=$this->db->query("select * from OrderInfor where OrderID=LAST_INSERT_ID()");
   return $query->result(); }  
   
   function insert_orderdetail($pid,$qty,$oid){
    $this->db->query("insert into OrderDetail(ProductID, ProductQty, OrderID) values ($pid,$qty,$oid)");   
   }
   
   function select_order($cid){
    $query=$this->db->query("select * from OrderInfor where CustomerID=$cid");
    if($query->num_rows()!=0)
    return $query->result(); 
    else
    return NULL;   
   }
   
   function select_orderdetail($oid){
       $query=$this->db->query("select * from OrderDetail where OrderID=$oid");
       return $query->result(); 
       
   }
   
   function select_orderinfor($oid){
       $query=$this->db->query("select * from OrderInfor where OrderID=$oid");
       return $query->result(); 
       
   }
   
}
?>
