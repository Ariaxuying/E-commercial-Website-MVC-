var xmlhttp;


 var h=document.getElementById("head");
        function change()
        {
            var s=window.innerWidth;
            var oldlinks=document.getElementsByTagName("link");
            for(i=0;i<oldlinks.length;i++)
            {
                oldlinks[i].parentNode.removeChild(oldlinks[i]);
            }
            if(s<1000)
            {
                forSmall();
            }
            else{
                forBig();
            }
        }
        function forSmall()
        {
            var l=document.createElement("link");
            l.href="/CI/small.css";
            l.type="text/css";
            l.rel="stylesheet";
            h.appendChild(l);
        }
        function forBig(){
            var l=document.createElement("link");
            l.href="/CI/css.css";
            l.type="text/css";
            l.rel="stylesheet";
            h.appendChild(l);
        }


$(document).ready(function()
{
    
  $(".addcart").click(function()
{
    var id=$(this).prop("title");
     
    var q=$("#" + id + " option:selected").val();

    $.get("/CI/index.php/shopping/addcart","cartpid="+id+"&cartqty="+q,function(data)
    {alert(data)});
  });
});



    

$(document).ready(function()
{
    
  $("#validateprofile").click(function()
{ 
    var fn=$("#fn").val();
 
    var ln=$("#ln").val();
    var an=$("#an").val();
    var pw=$("#pw").val();
    var cpw=$("#cpw").val();
    var em=$("#em").val();
    var ph=$("#ph").val();
    var sa=$("#sa").val();
    var ba=$("#ba").val();
    if(fn=="")
    {window.alert("Please enter your first name!");
        return false;}
    else if(ln=="")
    {window.alert("Please enter your last name!");
        return false;}
    else if(an=="")
    {window.alert("Please enter your account name!");
         return false;}
    else if(pw=="")
    {window.alert("Please enter your password!");
          return false;}
    else if (cpw!=pw)
    {window.alert("Incorrect Confirmation Password!");
          return false;} 
    else
    {
      $.get("/CI/index.php/shopping/edit_add_profile","an="+an+"&pw="+pw+"&fn="+fn+"&ln="+ln+"&em="+em+"&ph="+ph+"&sa="+sa+"&ba="+ba,function(data)
    {alert(data)});
}
});
});


               

$(document).ready(function()
{
    
  $(".cartqtychange1").change(function()
{   var newqty=$(this).val();
    var pid=$(this).prop("title");
    var price=$("#price1" + pid).val();
    var proprice=$("#price2" + pid).val();
    var qty=$("#pqty" + pid).val();
    if(!(newqty>0)){
    alert("Invalid quantity number!");}
    else{
       $.get("/CI/index.php/shopping/cartqtychange1","pid="+pid+"&qty="+newqty,function()
       {$("#" + price).html("$"+newqty*proprice);
        alert("Quantity Changed!")});}
        
        });
        
  $("#emptycart1").click(function()
{
    if(confirm("Would you like to empty your shopping cart?")){
         $.get("/CI/index.php/shopping/emptycart1",function(){
          alert("Delete Successfully!"); 
             location.reload(true);})}

  });
  
  
$("#deletecart1").click(function()
{
    num=0;
    var pid=new Array(num);
    $("input[name='cart']:checked").each ( function(){
        pid[num]=$(this).val();
         num=num+1;});
if(num==0)
        alert("No item selected!");

else{
      $.get("/CI/index.php/shopping/deletecart1","pid="+pid+"&num="+num,function(){
                
                 window.alert("Delete itmes successfully!"); 
                 location.reload(true);})}
        
});
});
    



$(document).ready(function()
{
    
  $(".cartqtychange2").change(function()
{   var newqty=$(this).val();
    var pid=$(this).prop("title");
    var price=$("#price21" + pid).val();
    var proprice=$("#price22" + pid).val();
    var qty=$("#pqty2" + pid).val();
    

   
 if(!(newqty>0)){
    alert("Invalid quantity number!");}
else{
       $.get("/CI/index.php/shopping/cartqtychange2","pid="+pid+"&qty="+newqty,function()
       {$("#" + price).html("$"+newqty*proprice);
        alert("Quantity Changed!")});}
        
        });
 
    
  $("#emptycart2").click(function()
{
    if(confirm("Would you like to empty your shopping cart?")){
         $.get("/CI/index.php/shopping/emptycart2",function(){
          alert("Delete Successfully!"); 
             location.reload(true);})}

  });
$("#deletecart2").click(function()
{
    num=0;
    var pid=new Array(num);
    $("input[name='cart']:checked").each ( function(){
        pid[num]=$(this).val();
         num=num+1;});
if(num==0)
        alert("No item selected!");

else{
      $.get("/CI/index.php/shopping/deletecart2","pid="+pid+"&num="+num,function(){
                
                 window.alert("Delete itmes successfully!"); 
                 location.reload(true);})}
        
}); });







$(document).ready(function(){
    
  $("#sub").submit(function(){
      

var t=/^[0-9]*$/;
var fn=$("#fn1").val();
var ln=$("#ln1").val();
var ph=$("#ph1").val();
var sa=$("#sa1").val();
var ba=$("#ba1").val();
var cn=$("#cn1").val();
                   if(fn=="")
                   {window.alert("Please enter your first name!");
                       
                       return false;}
                   else if(ln=="")
                   {window.alert("Please enter your last name!");
                       return false;}
                   else if((!t.test(ph))||(ph.length!=10))
                   {window.alert("Phone Number must be 10 digits!");
                    return false;}
                   else if(sa=="")
                   {window.alert("Please enter your shipping address!");
                       return false;}
                   else if(ba=="")
                   {window.alert("Please enter your billing address!");
                       return false;}
                   else if((!t.test(cn))||(cn.length!=16))
                   {window.alert("Card number must be 16 digits!");
                    return false;}
                   else 
                       return true;
                   
});

});





    
         

                   
                   

    


