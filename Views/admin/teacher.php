<?php include_once DIR_VIEW.'./parts/header.php' ;?>
<body class="admin">
  <?php include_once DIR_VIEW.'./parts/nav.php' ;?>
  <div class="row">
    <div class="col four">
     <h3>Stats</h3>
   </div>
   <div class="col four">
    <h3>Manage Teacher</h3>
    <form class="block-form" action="<?php echo route('do.teacher'); ?>" method="POST">
      <fieldset>
        <label>Name</label>
        <input type="text" name="name" />
      </fieldset>
      <fieldset>
        <label>Username</label>
        <input type="text" name="user" />
      </fieldset>
      <fieldset>
        <label>Password</label>
        <input type="password" name="pass" />
      </fieldset>
      <input type="submit" class="btn btn-default" value="Add" />
    </form>
  </div>
  <div class="col two">
    <h3>Teachers</h3>
    <?php for($i = 0 ; $i < 3; $i++) : ?>
      <div class="container profiles">
        <?php for($k = 0 ; $k < 3; $k++) : ?>
         <div class="col three">
           <div class="teacher-profile">
             <img src="http://colorhunt.co/img/logo.gif" />
             <p class="control tb">Rajendra Thapa</p>
             <p class="control">Subjects: <strong>5</strong></p>
             <div class="control">
               <a href="?do=edit&type=teacher&id=1">Edit</a>
               <a class="tr" href="?do=delete&type=teacher&id=1">Delete</a>
             </div>
           </div>
         </div>
       <?php endfor;?>
     </div>
   <?php endfor;?>
 </div>
</div>
</body>
</html>