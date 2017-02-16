<?php include_once DIR_VIEW.'./parts/header.php' ;?>
<body class="teacher">
  <?php include_once DIR_VIEW.'./parts/nav.php' ; ?>
  <div class="row">
    Subject: <?php include_once DIR_VIEW.'./parts/subjects.php' ; ?>
  </div>
  <div class="row">
    <p>Assign marks to student.</p>
    <table>
      <thead>
        <tr>
          <th>Student</th>
          <?php foreach ($fields as $field): ?>
            <th><?php echo \Attendance\Models\MarksModel::$fields[$field['name']];?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($students as $student): ?>
          <tr>
            <td><?php echo $student['full_name'] . ' | ' . $student['reg_no']; ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php include_once DIR_VIEW.'./parts/footer.php' ;?>