<?php include_once DIR_VIEW.'./parts/header.php';?>
<body class="student">
  <?php $subjectCode = ''; if (isset($_GET['sub'])) $subjectCode = $_GET['sub'];
  include_once DIR_VIEW.'./parts/nav.php' ;?>
  <div class="row">
    <h1>My Attendance</h1>
    <p style="text-transform: uppercase;">Hey! <strong><?php echo \Attendance\Models\User::logged()->getAttribute('full_name'); ?></strong></p>
    We are showing attendance of: 
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
<?php
include DIR_VIEW .'./admin/parts/a.php' ;
$present = substr(((($total - $absent) / $total)) * 5 , 0, 4);
?>
<h3>You have not attended class for <?php echo $absent; ?> days out of total <?php echo $total; ?> academic days.</h3>
<p>You have hence received <strong><?php echo $present; ?>/5</strong> in you attendance marks</p>
</div>
<script type="text/javascript">
  function change(e) {
    document.location.href = "?sub=" + encodeURI(e.value);
  }
</script>