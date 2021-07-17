<?php
/*PHP Login and registration script Version 1.0, Created by Gautam, www.w3schools.in*/
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
//echo '<pre>';
  // print_r(get_govt_user_data($con, $_SESSION['UserData']['user_id']));
//die();
$hname='';
$data=get_user_data($con, $_SESSION['UserData']['user_id']);
$hname=$data['name'];
$dept_id=$data['code'];
//echo '</pre>';
//
if ($hname=='admin') {
  
    exit(header("location:dept_main.php"));
}
?>
<!-- container -->
<section id="intro1"></section>   
 <main id="main">
<section id="about1" class="section-bg">
      <div class="container-fluid">
       <?php include 'dept_menu.php'; ?>

<div class="container-fluid">
            <div class="title">
                <h3 style="color: black;">PAY EXAMINATION FEE</h3>
                <span class="hide"></span>

            </div>
            <div class="content">
<?php


$sql1aa = "SELECT * from `ef_table` limit 1"; 
        //echo $sql1aa;
        //die();
       
        $exe1aa = mysqli_query($conn,$sql1aa) or die(mysql_error());
       $row1aa = mysqli_fetch_array($exe1aa);
         

   $ef_fee_dt=$row1aa['hall_date'];



 if($ef_fee_dt<date('Y-m-d H:i:s')) 
  { ?>
      echo ("<script language='JavaScript'>
          window.alert('Your Fee Payment Date is Closed Please Contact to Your Department Office');
          window.location.href='./dept_login.php';
       </script>");

    <?php
  } else
{

    ?>
<form method="post" action="dept_payu_exam_fee_new.php" enctype="multipart/form-data" id="import_form">

    <input type="hidden" name="subhidden" id="subhidden">
    <input type="hidden" name="semhidden" id="semhidden">
    <input type="hidden" name="feehidden" id="feehidden">
       <input type="hidden" name="indexhidden" id="indexhidden">
      <input type="hidden" name="reghidden" id="reghidden" value="reghidden">
       <input type="hidden" name="firstname" id="firstname" value="reghidden">
<style type="text/css">
  .select-info{
    background-color: red;
    color: white;
  }
    .green {
  background-color: #69ce69 !important;
  color: #000 !important;

  }
  .red {
  background-color: #704ef78c !important;
  color: #000 !important;
  }
  .s3 {
  background-color: #98f182c9 !important;
  color: #000 !important;
  }
  .s4 {
  background-color: #82b9f1 !important;
  color: #000 !important;
  }
  .s5 {
  background-color: #98f182c9 !important;
  color: #000 !important;
  }
  .s6 {
  background-color: #82b9f1 !important;
  color: #000 !important;
  }
      .s7 {
  background-color: #98f182c9 !important;
  color: #000 !important;
  }
  .s8 {
  background-color: #82b9f1 !important;
  color: #000 !important;
  }
  .s9 {
  background-color: #98f182c9 !important;
  color: #000 !important;
  }
  .s10 {
  background-color: #82b9f1 !important;
  color: #000 !important;
  }
  .s11 {
  background-color: #98f182c9 !important;
  color: #000 !important;
  }
  .s12 {
  background-color: #82b9f1 !important;
  color: #000 !important;
  }
  .locked {
   pointer-events: none;
  }
</style>
<table width="100%" style="color: black">
<tr><td ><lable class="btn btn-primary">Select Papers for selected Students</lable></td></tr>
</table>
<div class="card-body">
 <table cellpadding="0"cellspacing="0" border="0"  id="myTable"  width="100%" class="table">
<thead class="thead-dark">
<tr class="new_data_tab">
    <th></th>
<th class="text-center">S.No </th>
<th class="text-center">Regno </th>
<th class="text-center">Exam Fee</th>
<th class="text-center">Paper Code</th>
<th class="text-center">Semester</th>
<th class="text-center">Title of the Paper</th>
<th class="text-center">ID</th>
<th class="text-center">Locker</th>
</tr>
</thead><tbody> 
<?php 
$slno=1;
if(isset($_POST['checkpoint'])&&$_POST['checkpoint']=='checkvalue1987')
{
$regno_get = json_decode($_POST['reghidden']);
if(!empty($regno_get)){
  foreach ($regno_get as $k => $value) {
$sqlone = "SELECT * from `student_master` where `ENROLMENT`= '$value'"; 
        //echo $sqlone;
       // die();
       
$exeone = mysqli_query($conn,$sqlone) or die(mysql_error());
        $row1 = mysqli_fetch_array($exeone);
        

   $current_semester=$row1['CURRENTSEM'];
   $regno=$row1['ENROLMENT'];
   $sname=$row1['NAME'];


 
 $semcount=0;
 $subcode=0;
 $current_sem=12;
 $cum_tot=0;
 $cum_tot1=0;
$conv_fee=0;
$subj_code_test='1';
 for($s=12;$s>0;$s--)
 {
$current_sem1=$current_sem-$s;
//echo 'current sem'.$current_sem;
//echo 'current sem1'.$current_sem1;
$regnumber = preg_replace("/[^0-9]{1,2}/", '', $regno);
$regnumber1=substr($regnumber, 0, 2);
//echo 'or'.$regnumber;
$regyr='20'.$regnumber1;
$regnumber2='';
$regnumber2 = preg_replace("/[^A-Z]{1,1}/", '', $regno);
$regnumber2 = mb_substr($regnumber2, 0, 1, "UTF-8");
//$regnumber2=substr($regnumber2, 0, 1);
//echo 'or'.$regnumber;

 
          $CENTRE = $row1['CENTRE'];
          $CCODE = $row1['COURSE'];
          $certfee=$row1['CERTFEE'];
          for($i=1;$i<=55;$i++)
          {
          $semcount = $row1['SEMESTER'.$i];
            $subcode = $row1['SUBCODE'.$i];

       if($semcount!=NULL)
       {
        if($semcount==$current_sem1)
        {
?>
        <tr><td ></td><td><?php echo $slno; ?></td><td><?php echo $regno; ?></td>
          
            <?php $sql811 = "SELECT * from `subject_master` where subje_code='$subcode' AND `sessi_year_name`='$regyr' AND `sessi_name`='$regnumber2' limit 1 "; 
        //echo $sql1;
        //die(); 
        $exe811 = mysqli_query($conn,$sql811) or die(mysql_error());
       $row811=mysqli_fetch_array($exe811);
       
          $subj_name=$row811['subje_name']; 
          $subj_code=$row811['subje_code'];
          $paper_type=$row811['subje_type'];
          
          ?>
  <td> 
    <?php 
    $sql88811 = "SELECT * from `course_master` where cours_code='$CCODE' LIMIT 1"; 
       // echo $sql88811;
       // die();
       
        $exe88811 = mysqli_query($conn,$sql88811) or die(mysql_error());
        $row88811 = mysqli_fetch_array($exe88811);
        
         $ctype=$row88811['prog_code']; 
          
       
    $sql8811 = "SELECT * from `paper_fee_master` where prog_code='$ctype' AND exam_paper_type_code='$paper_type' LIMIT 1"; 
       
       
        $exe8811 = mysqli_query($conn,$sql8811) or die(mysql_error());
       $row8811 = mysqli_fetch_array($exe8811);
        
         echo $row8811['fee_amount']; 
          
           ?>
</td>          
<td><?php   echo $subcode; if($subj_code_test==$subj_code) { ?> <script language='JavaScript'>
          window.alert('Your Requested Papers was not in TT List Please Contact to Office');
          //window.location.href='./student_login.php';
       </script> <?php die(); } $subj_code_test=$subj_code; ?></td><td><?php echo $current_sem1; ?></td><td> <?php echo $subj_name; ?></td><td><?php echo $current_semester; ?></td><td><?php if($certfee==1){ echo 'Yes'; }else{ echo 'No'; } ?></td>
            </tr> 
          
      <?php 
      $slno=$slno+1;
     }   }  }  
   } 

 } } }
        
?> 
</tbody>
</table>
<table width="100%" style="color: black">
<tr><td colspan="5"><hr></td></tr>
<tr><td colspan="4" ><b>Total Paper Fee</b><small style="color: red;">*</small></td><td><b><label id="fav_fee">0</label></b></td></tr>
<tr><td colspan="5"><hr></td></tr>
<tr><td colspan="4" ><b>Mark Statement Fee ( You have selected <b><label id="st_count">0</label>  Student(s)) - Rs: 50/- per student</b><small style="color: red;">*</small></td><td><b><label id="st_count_rs">0</label></b></td></tr>
<tr><td colspan="5"><hr></td></tr>

<tr><td colspan="4" width="80%"><b>Convocation Certificate Fee for<b><label id="st_count1">0</label>  Student(s)) - Rs: 1500/- per student</b><br><small style="color: red;">*First Appearence Candidate only</small></td><td><b><label id="cer">0</label></b></tr>
<tr><td colspan="5"><hr></td></tr>
<?php $late_fee='0'; $cum_tot=$cum_tot1  ?>

</td></tr>

  <?php

$sqls1a = "SELECT * from `e_table`"; 
        //echo $sql1;
        //die();
       
        $exes1a = mysqli_query($conn,$sqls1a) or die(mysql_error());
        while($rows1a = mysqli_fetch_array($exes1a))
        { 

   $e_fee_dt=$rows1a['hall_date'];

}


    if($e_fee_dt<date('Y-m-d H:i:s')) 
  { ?>

    <tr><td colspan="4" ><b>Late Fee</b><small style="color: red;">*</small></td><td><b><?php $late_fee='100'; echo $late_fee;  $cum_tot=$cum_tot1+$late_fee;   ?></b><input type="hidden" value="<?php echo $cum_tot; ?>" id="cum_total"></tr><tr><td colspan="5"><hr></td></tr>
 <?php } else{ ?> <input type="hidden" value="<?php echo $cum_tot; ?>" id="cum_total"> <?php } ?>
</td></tr>

<?php }  ?>
</tbody>
</table></div>
<table width="100%">
<tr><td><br/></td></tr>
   <tr>

        <td colspan="4" style="text-align: center;" ><input type="hidden" name="p_codes" id="p_codes" readonly="" value="" class="amount"><input type="hidden" name="amount" readonly="" value="<?php echo $cum_tot; ?>" class="amount"><input type="hidden" name="sem" id="sem" readonly="" value="<?php echo $sem; ?>"><input type="hidden" name="centre" id="centre" readonly="" value="<?php echo $CENTRE; ?>"><input type="hidden" name="sessi_year" id="sessi_year" readonly="" value="<?php echo $regyr; ?>">
          <input type="hidden" name="course_code" id="course_code" readonly="" value="<?php echo $CCODE; ?>">
          <input type="hidden" name="checkpoint" value="checkvalue152">
            <input type="button" value="<?php echo $cum_tot; ?>" class="btn btn-danger amount">&nbsp;<button type="submit" class="btn btn-primary">Click Here to Pay</a></button> </td>
   </tr>
  
  

   
  </table>
 </form>
</div></div>
<!-- Import form (end) -->

<!-- Displaying imported users -->
              
      

</div></section></main>

</div></div>
<!-- /container -->
<?php require('footer.php');?>
<link rel="stylesheet" href="includes/DataTable/datatables.min.css"type="text/css" media="all">
<script  src="includes/DataTable/datatables.min.js"></script>
<script>
$(document).ready(function() {
    var printCounter = 0;
 
    // Append a caption to the table before the DataTables initialisation
   // $('#view_stock').append('<caption style="caption-side: bottom">Stock List View.</caption>');
 
    $('#myTable').DataTable({
        "pageLength": 1000,
          "searching": false,
          "paging": false,
     "oLanguage": {
      "sInfo": "Got a total of _TOTAL_ Papers",
            "select": {
                "rows": {
                    _: "You have selected %d Papers",
                    0: "Click a row to select Student Paper",
                    1: "Only 1 Paper selected"
                }
            }
        },
        "createdRow": function( row, data, dataIndex){
                       
                if ( data[5]== data[7] ) {
                $('td', row).addClass('locked');
                $(row).addClass('green');
            }
            if ( data[5]!= data[7] ) {
                $(row).addClass('red');
            }
            },
        columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets:   0
        } ],
        select: {
            style:    'multi',
            selector: 'td:first-child'

        },
        order: [[ 1, 'asc' ]]
    } );
    setTimeout(function(){
      rows = $('#myTable').find('tbody tr td.select-checkbox').click();
    },1);
});

$(document).on('load',function(){
  


  alert('load')
   
   

});
$(document).on('click','.select-checkbox',function(e) {
    //$("#badge-area").show();
    var myValues= $('#myTable').DataTable();
    var data = myValues.row($(this).parents('tr')).data();
    //console.log(data);
    //var id = table.row( this ).id();
    //var numberOfChecked = $('input:checkbox:checked').length;
    //$("#stock_count").html(numberOfChecked);
    var totalfee = 0;
    var confee =0;
    var cert_amount = 0;
    var c_amount = 0;
    var fee = 50;
    var cfee = 1500;
    myarray1 = [];
    myarray2 = [];
     myarray3 = [];
     myarray4 = [];
     myarray5 = [];
     myarray6 = [];
     myarray7 = [];
    myValues.rows('.selected').every(function() {
      if(myValues.row(this).data()[8]=='Yes'){
       myarray7.push(myValues.row(this).data()[2]+myValues.row(this).data()[8]); 
      }
      myarray4.push(myValues.row(this).data()[6]);
       myarray3.push(myValues.row(this).data()[5]);
      myarray1.push(myValues.row(this).data()[4]);
      myarray2.push(myValues.row(this).data()[3]);
      myarray5.push(myValues.row(this).data()[2]);
       myarray6.push(myValues.row(this).data()[2]);
      totalfee += parseInt(myValues.row(this).data()[3]);
      
   }); 
    
var unique = myarray5.filter((item, i, ar) => ar.indexOf(item) === i);
var unique_con = myarray7.filter((items, j, ars) => ars.indexOf(items) === j);
console.log(unique_con);
function countUnique(iterable) {
  return new Set(iterable).size;
}
var counts=countUnique(myarray5);
var nocounts=countUnique(myarray7);
var confee=nocounts*cfee;
var count_rs=counts*fee;
var t_count1=nocounts;
    var cumu_tot=$('#cum_total').val();
    $('#fav_fee').text(totalfee);
    $('#st_count').text(counts);
    $('#st_count1').text(t_count1);
    $('#st_no').text(unique);
     $('#cer').text(confee);
   $('#st_count_rs').text(count_rs);
     $('.amount').val(totalfee+count_rs+confee+parseInt(cumu_tot));
   $('#subhidden').val(JSON.stringify(myarray1));
   $('#feehidden').val(JSON.stringify(myarray2));
$('#semhidden').val(JSON.stringify(myarray3));
$('#indexhidden').val(JSON.stringify(myarray4));
$('#reghidden').val(JSON.stringify(myarray6));
   });
</script>
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





