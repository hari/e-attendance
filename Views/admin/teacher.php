<?php include_once DIR_VIEW.'./parts/header.php' ;
$action = route('do.teacher');
$name = ""; $username = ""; $btn = "Add"; $html = '';
if (isset($edit) && !empty($edit)) {
  $name = $edit['full_name'];
  $username = $edit['reg_no'];
  $btn = "Update";
  $action = route('update.teacher');
  $html = '<input type="hidden" name="id" value="' . $_GET['id'] . '" />';
}
?>
<body class="admin">
  <?php include_once DIR_VIEW.'./parts/nav.php' ;?>
  <div class="row">
   <div class="col two">
    <h3>Manage Teacher</h3>
    <form class="block-form" action="<?php echo $action; ?>" method="POST">
      <?php echo $html; ?>
      <fieldset>
        <label>Name</label>
        <input type="text" value="<?php echo $name; ?>" name="name" required />
      </fieldset>
      <fieldset>
        <label>Username</label>
        <input type="text" value="<?php echo $username; ?>" name="user" required />
      </fieldset>
      <fieldset>
        <label>Password</label>
        <input type="password" name="pass" required />
      </fieldset>
      <input type="submit" class="btn btn-default" value="<?php echo $btn; ?>" />
    </form>
  </div>
  <div class="col two">
    <h3>Teachers</h3>
    <?php
    if (isset($teachers) && count($teachers) > 0) :
      $count = count($teachers);
    echo '<div class="container profiles">';
    for($row = 0; $row < $count; $row ++):
      $teacher = $teachers[$row];
    ?>

    <div class="col three">
      <div class="teacher-profile">
        <img src="<?php echo asset('img/logo.gif'); ?>" />
        <p class="control tb" title="<?php echo $teacher['full_name'];?>"><?php echo $teacher['full_name'];?></p>
        <p class="control" style="font-size: 14px;"><?php echo $teacher['reg_no']; ?></p>
        <div class="control">
          <a href="?do=edit&id=<?php echo $teacher['reg_no']; ?>">Edit</a>
          <a class="tr" href="?do=delete&id=<?php echo $teacher['reg_no']; ?>">Delete</a>
        </div>
      </div>
    </div>

    <?php
    if (($row + 1) % 3 == 0) echo '</div><div class="container profiles">';
    endfor; endif;
    ?>
  </div>
</div>
</div>
<?php include_once DIR_VIEW.'./parts/footer.php' ;?>