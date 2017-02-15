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
        <input type="text" value="<?php echo $name; ?>" name="name" />
      </fieldset>
      <fieldset>
        <label>Username</label>
        <input type="text" value="<?php echo $username; ?>" name="user" />
      </fieldset>
      <fieldset>
        <label>Password</label>
        <input type="password" name="pass" />
      </fieldset>
      <input type="submit" class="btn btn-default" value="<?php echo $btn; ?>" />
    </form>
  </div>
  <div class="col two">
    <h3>Teachers</h3>
    <?php if (isset($teachers) && count($teachers) > 0) : ?>
      <div class="container profiles">
        <?php foreach($teachers as $teacher) : ?>
         <div class="col three">
           <div class="teacher-profile">
             <img src="http://colorhunt.co/img/logo.gif" />
             <p class="control tb" title="<?php echo $teacher['full_name']; ?>">
               <?php echo $teacher['full_name']; ?>
             </p>
             <p class="control" style="font-size: 14px;"><?php echo $teacher['reg_no']; ?></p>
             <div class="control">
               <a href="?do=edit&id=<?php echo $teacher['reg_no']; ?>">Edit</a>
               <a class="tr" href="?do=delete&id=<?php echo $teacher['reg_no']; ?>">Delete</a>
             </div>
           </div>
         </div>
       <?php endforeach;?>
     </div>
   <?php endif;?>
 </div>
</div>
</body>
</html>