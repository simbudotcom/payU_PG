<?php
//error_reporting(0);
require('config.php');


require('dept_functions.php');

/*Check for authentication otherwise user will be redirects to main.php page.*/
if (!isset($_SESSION['UserData'])) {
    exit(header("location:dept_main.php"));
}

require('header.php');
?>
<?php
$data=get_user_data($con, $_SESSION['UserData']['user_id']);
$hname=$data['name'];
$dept_id=$data['code'];
$txnid = date("Ymdhis").rand(1000,9999);
if(isset($_POST['checkpoint'])&&$_POST['checkpoint']=='checkvalue152')
{
$sem=$conn->real_escape_string($_POST['sem']);
$centre_code=$conn->real_escape_string($_POST['centre']);
$course_codeget=$conn->real_escape_string($_POST['course_code']);
$sessi_year=$conn->real_escape_string($_POST['sessi_year']);
$papercode = json_decode($_POST['subhidden']);
$regno = json_decode($_POST['reghidden']);
$semester = json_decode($_POST['semhidden']);
$index_order = json_decode($_POST['indexhidden']);
$amount =$_POST['amount'];
$date2=date("Y/m/d");

if(!empty($papercode)){
  foreach ($papercode as $k => $value) {

$lock=$txnid.'-'.$regno[$k];


$sql1 = "INSERT INTO exam_fee(txnid,regno,course_code,papercode,sessi_year,centre_code,semester)VALUES ('$txnid','$regno[$k]','$course_codeget','$value','$sessi_year','$centre_code','$semester[$k]')";

            if (mysqli_query($conn, $sql1)) {
 $sql2 = "INSERT IGNORE INTO exam_fee_payment(orderid,student,regno,fee,paid_date,status,locker)VALUES ('$txnid','$centre_code','$regno[$k]','$amount','$date2','pending','$lock')";

            if (mysqli_query($conn, $sql2)) {
             
            
$sql3 = "INSERT IGNORE INTO apply_student_db(orderid,regno,name,degree,centre_code,amount,date2,status,locker)VALUES ('$txnid','$regno[$k]','$centre_code','$course_codeget','$centre_code','$amount','$date2','pending','$lock')";

            if (mysqli_query($conn, $sql3)) {          
            }
}
}
}
}
}
error_reporting(0);
// Merchant key here as provided by Payu
$MERCHANT_KEY = ""; //Please change this value with live key for production
//$MERCHANT_KEY = "gtKFFx"; //Please change this value with test key for production

   $hash_string = '';
// Merchant Salt as provided by Payu
$SALT = ""; //Please change this value with live salt for production
//$SALT = "eCwWELxi"; //Please change this value with live salt for production

// End point - change to https://test.payu.in for Test mode
//$PAYU_BASE_URL = "https://test.payu.in";
// End point - change to https://secure.payu.in for LIVE mode
$PAYU_BASE_URL = "https://secure.payu.in";

$action = '';

$posted = array();
if(!empty($_POST)) {
    //print_r($_POST);
  foreach($_POST as $key => $value) {    
    $posted[$key] = $value; 
  
  }
}

$formError = 0;

if(empty($posted['txnid'])) {
   // Generate random transaction id
  //$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  //$txnid = $posted['txnid'];
}
$hash = '';
// Hash Sequence
if(isset($_POST['submit'])) {
$sname=$conn->real_escape_string($_POST['firstname']);
$regno=$conn->real_escape_string($_POST['regno']);
$date2=date("Y/m/d");
$degree=$conn->real_escape_string($_POST['degree_name']);
$course=$conn->real_escape_string($_POST['subject_name']);
$centre_code_select=$conn->real_escape_string($_POST['centre_code_select']);
$amount=$conn->real_escape_string($_POST['amount']);
$phone=$conn->real_escape_string($_POST['phone']);
$email=$conn->real_escape_string($_POST['email']);
$add1=$conn->real_escape_string($_POST['add1']);
$add2=$conn->real_escape_string($_POST['add2']);
$add3=$conn->real_escape_string($_POST['add3']);
$add4=$conn->real_escape_string($_POST['add4']);
$txnid = $conn->real_escape_string($_POST['txnid']);
$id=$txnid;

 $sql = "UPDATE exam_fee_payment SET mobile='$phone',email='$email'  WHERE orderid='$txnid'";
mysqli_query($conn, $sql);
$sqlup1 = "UPDATE apply_student_db SET mobile='$phone',email='$email' WHERE orderid='$txnid'";
mysqli_query($conn, $sqlup1);              


$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
         
  ) {
    $formError = 1;
  } else {
    
  $hashVarsSeq = explode('|', $hashSequence);
 
  foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }

    $hash_string .= $SALT;


    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
} } 
?>
<html>
  <head>
  <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
  </script>
  </head>
  <body onload="submitPayuForm()">


    <section id="intro1"></section>   
 <main id="main">
<section id="about1" class="section-bg">
      <div class="container-fluid">
       <?php include 'dept_menu.php'; ?>
</div>
    <br/>
    <?php if($formError) { ?>
      <span style="color:red">Please fill all mandatory fields.</span>
      <br/>
      <br/>
    <?php } ?>
    <form action="<?php echo $action; ?>" method="post" name="payuForm" >
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
      <input type="hidden" name="surl" value="http://mis.alagappauniversity.ac.in/collaborative/dept_exam_fee_success.php" />   
     <input type="hidden" name="furl" value="http://mis.alagappauniversity.ac.in/collaborative/dept_exam_fee_failure.php" />

  <table border="0" cellpadding="5" cellspacing="5" width="1000" align="center"> 
        <tr>
          <td>Centre Code: </td>
          <td><input name="firstname" id="firstname" class="form-control" readonly="readonly" value="<?php echo $hname; ?>" /></td>
        </tr>
        <tr>
          <td>Email: </td>
          <td><input name="email" id="email" class="form-control" required="required" value="<?php echo (empty($posted['email'])) ? '' : $posted['email']; ?>" /></td>
        </tr>
        <tr>
          <td>Phone: </td>
          <td><input name="phone" class="form-control" required="required" value="<?php echo (empty($posted['phone'])) ? '' : $posted['phone']; ?>" /></td>
        </tr>
        
        <tr>
          <td>Amount: </td>

          <td>
            <label><?php echo (empty($posted['amount'])) ? '' : $posted['amount'] ?></label><input type="hidden" name="amount" readonly="readonly" value="<?php echo (empty($posted['amount'])) ? '' : $posted['amount'] ?>" /> 
         <!--  <input type="text" name="amount" value="<?php echo (empty($posted['amount'])) ? '' : $posted['amount'] ?>" /> -->
        </td>
        </tr>
         <input type="hidden" name="productinfo" value="Exam_Fee" size="64" />
         <input type="hidden" name="lastname" id="lastname" value="<?php echo (empty($posted['lastname'])) ? '' : $posted['lastname']; ?>" />
        <input type="hidden" name="curl" value="http://mis.alagappauniversity.ac.in/collaborative/dept_exam_fee_failure.php" />
        <input type="hidden" name="address1" value="<?php echo (empty($posted['address1'])) ? '' : $posted['address1']; ?>" />
   
         <input type="hidden" name="address2" value="<?php echo (empty($posted['address2'])) ? '' : $posted['address2']; ?>" />
       <input type="hidden" name="city" value="<?php echo (empty($posted['city'])) ? '' : $posted['city']; ?>" />
     <input type="hidden" name="state" value="<?php echo (empty($posted['state'])) ? '' : $posted['state']; ?>" />
       <input type="hidden" name="country" value="<?php echo (empty($posted['country'])) ? '' : $posted['country']; ?>" />
      <input type="hidden" name="zipcode" value="<?php echo (empty($posted['zipcode'])) ? '' : $posted['zipcode']; ?>" />
       <input type="hidden" name="udf1" value="<?php echo (empty($posted['hname'])) ? '' : $posted['hname']; ?>" />
    <input  type="hidden" name="udf2" value="<?php echo (empty($posted['udf2'])) ? '' : $posted['udf2']; ?>" />
       <input type="hidden" name="udf3" value="<?php echo (empty($posted['udf3'])) ? '' : $posted['udf3']; ?>" />
       <input type="hidden" name="udf4" value="<?php echo (empty($posted['udf4'])) ? '' : $posted['udf4']; ?>" />
        <input type="hidden" name="udf5" value="<?php echo (empty($posted['udf5'])) ? '' : $posted['udf5']; ?>" />
       <input type="hidden" name="pg" value="<?php echo (empty($posted['pg'])) ? '' : $posted['pg']; ?>" />
        <tr>
          <?php if(!$hash) { ?>
            <td colspan="4"><center><input type="submit" name="submit" value="Proceed to Pay" class="btn btn-success" /></center></td>
          <?php }  ?>
        </tr>
      </table>
    </form>
  </body>
</html>
<?php
include('footer.php');

?>
<style>
@media only screen and (min-width:768px){
  .home_slider_left{
    width:22%;
    margin:0;
    padding-right:15px;
  }
  .home_slider{
    width:78%;
    margin:0;
  }
  .home_slider_right{
    width:22%;
    margin:0;
    padding-left:28px;

  }
}
</style>
