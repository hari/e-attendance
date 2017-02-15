<?php include_once DIR_VIEW.'./parts/header.php' ;?>
<body class="admin">
  <?php include_once DIR_VIEW.'./parts/nav.php' ;?>
  <div class="row">
    <div class="col two">
      <h3>Manage Subject</h3>
      <form class="block-form" action="<?php echo route('do.subject'); ?>" method="POST">
        <?php
        $name="";
        $code="";
        $sem="";
        $tid = 0;
        $btn = "Add";
        if (isset($edit) && !empty($edit)) {
          $name = $edit['name'];
          $code = $edit['code'];
          $sem = $edit['sem'];
          $btn = "Update";
          $tid = $edit['teacher'];
          echo '<input type="hidden" name="update" value="1" />';
          echo '<input type="hidden" name="id" value="' . $_GET['id'] . '" />';
        }
        ?>
        <fieldset>
          <label>Name</label>
          <input type="text" value="<?php echo $name; ?>" name="name" required="required" />
        </fieldset>
        <fieldset>
          <label>Code</label>
          <input type="text" value="<?php echo $code; ?>" name="code" required="required" />
        </fieldset>
        <fieldset>
          <label>Semester</label>
          <input type="text" value="<?php echo $sem; ?>" name="sem" required="required" />
        </fieldset>
        <fieldset>
          <label>Teacher</label>
          <select name="teacher" required="required">
            <?php if (isset($teachers) && count($teachers) > 0) : 
            foreach($teachers as $teacher) :
              ?>
            <option <?php if ($teacher['reg_no'] == $tid) echo "selected"; ?> value="<?php echo $teacher['reg_no']; ?>">
              <?php echo $teacher['full_name'] . " | " . $teacher['reg_no']; ?>
            </option>
          <?php endforeach;endif; ?>
        </select>
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
<ul id="subject-list" class="list">
  <?php if (isset($subjects) && count($subjects) > 0) :
  foreach($subjects as $subject): ?>
  <li>
   <span><?php echo $subject['name']; ?></span>
   <a class="flat l" href="?do=edit&id=<?php echo $subject['id']; ?>">E</a>
   <a class="flat a" href="?do=delete&id=<?php echo $subject['id']; ?>">D</a>
 </li>
<?php endforeach; else: ?>
 <li><span>No subjects found.</span></li>
<?php endif; ?>
</ul>
</div>
</div>
<script type="text/javascript">
  function changeTo(e) {
    document.location.href = '<?php echo route("page.subject") . "?sem="; ?>' + e.value; 
  }
</script>
</body>
</html>