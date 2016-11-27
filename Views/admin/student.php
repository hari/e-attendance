<?php include_once DIR_VIEW.'./parts/header.php' ;?>
<body class="admin">
  <?php include_once DIR_VIEW.'./parts/nav.php' ;?>
  <div class="row">
    <div class="col three">
     <h3>Stats</h3>
   </div>
   <div class="col three">
    <h3>Manage Student</h3>
    <form class="block-form" action="#" method="POST">
      <fieldset>
        <label>Name</label>
        <input type="text" name="name" />
      </fieldset>
      <fieldset>
        <label>Registration</label>
        <input type="text" name="regno" />
      </fieldset>
      <input type="submit" class="btn btn-default" value="Add" />
    </form>
  </div>
  <div class="col three">
    <h3>Select Semester <span>
      <select>
        <option value="1">First</option>
        <option value="2">Second</option>
        <option value="3">Third</option>
        <option value="4">Fourth</option>
        <option value="5">Fifth</option>
        <option value="6">Sixth</option>
        <option value="7">Seventh</option>
        <option value="8">Eight</option>
      </select>
    </span></h3>
    <ul id="student-list" class="list">
      <?php 
      if (isset($students) && count($students) > 0) : 
        foreach($students as $student) :
          ?>
        <li>
         <span>Rajendra Thapa</span>
         <a class="flat l" href="?do=edit&id=1">E</a>
         <a class="flat a" href="?do=delete&id=1">D</a>
       </li>
     <?php endforeach;
     else : ?>
     <li><span>No students found.</span></li>
   <?php endif; ?>
 </ul>
</div>
</div>
</body>
</html>