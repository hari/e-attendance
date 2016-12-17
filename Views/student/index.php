<?php include_once DIR_VIEW.'./parts/header.php';?>
<body class="teacher">
  <?php include_once DIR_VIEW.'./parts/nav.php' ;?>
  <div class="row">
    <div class="col two"> 
      <h1>My Attendance</h1>
      <select onchange="" name="subject">
        <?php if (isset($subjects) && count($subjects) > 0) : 
        foreach($subjects as $subject) :
          ?>
        <option value="<?php echo $subject['id']; ?>">
          <?php echo $subject['name']; ?>
        </option>
      <?php endforeach; else :?>
      <option value="-1">No subject</option>
    <?php endif; ?>
  </select>
  <h3><?php echo $absent; ?>/30</h3>
</div>
<div class="col two">
  <h1>My Marks</h1>
</div>
</div>