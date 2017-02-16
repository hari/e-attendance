<?php include_once DIR_VIEW.'./parts/header.php' ;?>
<body class="teacher">
  <?php
  include_once DIR_VIEW.'./parts/nav.php' ;
  ?>
  <div class="row">
    <div class="col two" style="padding: 0">
      <div class="container">
        <div class="col two">
         <form class="block-form" action="<?php echo route('create.model'); ?>" method="POST">
          <h4>ADD FIELD</h4>
          <label>SUBJECT</label>
          <?php include_once DIR_VIEW.'./parts/subjects.php' ; ?>
          <label>FIELD</label>
          <select name="field_name">
            <?php foreach (\Attendance\Models\MarksModel::$fields as $key => $field) : ?>
              <option value="<?php echo $key; ?>"><?php echo $field; ?></option>
            <?php endforeach; ?>
          </select>
          <label>WEIGHT</label>
          <input type="number" name="weight" />
          <button class="btn btn-default">Add</button>
        </form>
      </div>
      <div class="col two report">
        <h4>Current Structure</h4>
        <ul style="list-style: none;">
         <?php if (isset($fields) && count($fields) > 0) :
         foreach ($fields as $field) : ?>
         <li><?php echo \Attendance\Models\MarksModel::$fields[$field['name']]; ?> <strong><?php echo $field['weight']; ?></strong></li>
       <?php endforeach;
       endif; ?>
     </ul>
   </div>
 </div>
</div>
<div class="col two">

</div>
</div>
<?php include_once DIR_VIEW.'./parts/footer.php' ;?>