<?php include_once DIR_VIEW.'./parts/header.php' ;
$action = route('do.student');
$name = ""; $reg = ""; $batch = ""; $sem = ""; $password = ""; $btn = "Add"; $html = '';
if (isset($edit) && !empty($edit)) {
  $name = $edit['full_name'];
  $reg = $edit['reg_no'];
  $batch = $edit['batch'];
  $sem = $edit['semester'];
  $btn = "Update";
  $action = route('update.student');
  $html = '<input type="hidden" name="id" value="' . $_GET['id'] . '" />';
}
?>
<body class="admin">
  <?php include_once DIR_VIEW.'./parts/nav.php' ;?>
  <div class="row">
   <div class="col two">
    <h3>Manage Student</h3>
    <form class="block-form" action="<?php echo $action; ?>" method="POST">
      <?php echo $html; ?>
      <fieldset>
        <label>Name</label>
        <input type="text" value="<?php echo $name; ?>" name="name" />
      </fieldset>
      <fieldset>
        <label>Registration</label>
        <input type="text" value="<?php echo $reg; ?>" name="regno" />
      </fieldset>
      <fieldset>
        <label>Batch</label>
        <input type="number" value="<?php echo $batch; ?>" name="batch" />
      </fieldset>
      <fieldset>
        <label>Semester</label>
        <input type="number" value="<?php echo $sem; ?>" name="semester" />
      </fieldset>
      <fieldset>
        <label>Password</label>
        <input type="password" name="pass" />
      </fieldset>
      <input type="submit" class="btn btn-default" value="<?php echo $btn; ?>" />
    </form>
  </div>
  <div class="col two">
   <?php $sems = ['First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eight'] ; ?>
   <h3>Select Semester <span>
    <select onchange="changeTo(this);">
     <?php
     foreach ($sems as $key => $value) {
      $t = $key + 1;
      if (isset($_GET['sem']) && $_GET['sem'] == $t) 
        echo "<option value=\"{$t}\" selected>{$value}</option>";
      else
        echo "<option value=\"{$t}\">{$value}</option>";
    }
    ?>
  </select>
</span></h3>
<ul id="student-list" class="list">
  <?php 
  if (isset($students) && count($students) > 0) : 
    foreach($students as $student) :
      ?>
    <li>
     <span><?php echo $student['full_name']; ?></span>
     <a class="flat l" href="?do=edit&id=<?php echo $student['reg_no']; ?>">E</a>
     <a class="flat a" href="?do=delete&id=<?php echo $student['reg_no']; ?>">D</a>
   </li>
 <?php endforeach;
 else : ?>
 <li><span>No students found.</span></li>
<?php endif; ?>
</ul>
</div>
</div>
<script type="text/javascript">
  function changeTo(e) {
    document.location.href = '<?php echo route("page.student") . "?sem="; ?>' + e.value; 
  }
</script>
</body>
</html>