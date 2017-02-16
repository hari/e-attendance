<?php include_once DIR_VIEW.'./parts/header.php';?>
<body class="student">
  <?php $subjectCode = ''; if (isset($_GET['sub'])) $subjectCode = $_GET['sub'];
  include_once DIR_VIEW.'./parts/nav.php' ;?>
  <div class="row">
    <h1>My Report</h1>
    Subject: &nbsp; 
    <select onchange="change(this);" name="subject">
      <?php if (isset($subjects) && count($subjects) > 0) : 
      foreach($subjects as $subject) :
        ?>
      <option <?php if ($subject['code'] == $subjectCode) echo "selected"; ?> value="<?php echo $subject['code']; ?>">
        <?php echo $subject['name']; ?>
      </option>
    <?php endforeach; else :?>
    <option value="-1">No subject</option>
  <?php endif; ?>
</select>
</div>
<div class="row" style="height: 2px; margin: 8px auto; background-color: #ddd"></div>
<?php
include DIR_VIEW .'./admin/parts/a.php' ;
if ($real_classes == 0) $real_classes = 1;
$present = substr((($real_classes - $absent) / $real_classes ) * 5, 0, 4);
?>
<div class="row">
  <div class="col two">
   <div class="report">
    <h3>Attendance report</h3>
    <ul style="list-style: none;">
     <li>Total academic days: <strong><?php echo $total; ?></strong></li>
     <li>Total class days: <strong><?php echo $real_classes; ?></strong></li>
     <li>Your attendance: <strong><?php echo $real_classes - $absent; ?></strong></li>
     <li>Attendance marks: <strong><?php echo $present; ?>/5</strong></li>
   </ul>
 </div>
</div>
<div class="col two">
 <div class="report">
  <h3>Marking report</h3>
  <ul style="list-style: none;">
    <?php
    if (isset($fields) && count($fields) > 0) :
     foreach ($fields as $field) : ?>
   <li><?php echo \Attendance\Models\MarksModel::$fields[$field['name']]; ?> <strong>0/<?php echo $field['weight']; ?></strong></li>
   <?php 
   endforeach;
   endif;
   ?>
 </ul>
</div>
</div>
</div>
<script type="text/javascript">
  function change(e) {
    document.location.href = "?sub=" + encodeURI(e.value);
  }
</script>
<?php include_once DIR_VIEW.'./parts/footer.php' ;?>