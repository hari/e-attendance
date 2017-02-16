<?php include_once DIR_VIEW.'./parts/header.php' ;?>
<body class="teacher">
  <?php include_once DIR_VIEW.'./parts/nav.php' ; ?>
  <div class="row">
    <h3 style="margin-bottom: 0">My Subjects</h3> 
    <?php include_once DIR_VIEW.'./parts/subjects.php' ; ?>
  </div>

  <div class="row" style="height: 2px; background-color: #ddd; margin: 8px auto"></div>
  <?php if (count($students) == 0) : $absent = \Attendance\Models\Attendance::countOf($inSub); ?>
    <h3 style="text-align: center">Already taken</h3>
    <p class="row">Total Absent: <strong><?php echo $absent; ?></strong></p>
  <?php endif; if (count($students) != 0) : ?>
  <div class="row">
    <div class="col three">
      <button style="margin-bottom: 16px;" class="btn btn-default" onclick="submit();">Submit</button>
    </div>
  </div>
  <div class="row" id="attendance">
    <div class="col three">
      <h3>Leave <span id="pc">0/40</span></h3>
      <ul id="student-list" class="list">
      </ul>
    </div>
    <div class="col three">
      <h3>Absent <span id="ac">0/40</span></h3>
      <ul id="absent-list" class="list">
      </ul>
    </div>
    <div class="col three">
      <h3>Present <span id="lc">0/40</span></h3>
      <ul id="present-list" class="list">
      </ul>
    </div>
  </div>
  <div class="row">
    <div class="col three">
      <button style="margin-top: 16px;" class="btn btn-default" onclick="submit();">Submit</button>
    </div>
  </div>
  <script type="text/javascript">
    //count nodes
    var lc, pc, ac, action = '<?php echo route("attendance.take"); ?>';
    var students = [], absent = [], present = [], total = 0;
    (function(){
      lc = document.getElementById('lc');
      pc = document.getElementById('pc');
      ac = document.getElementById('ac');
      <?php for($i = 0; $i < count($students); $i++) : ?>
      students[<?php echo $i; ?>] = {
        name: "<?php echo $students[$i]['full_name']; ?>",
        reg: "<?php echo $students[$i]['reg_no']; ?>"
      };
    <?php endfor; ?>
    total = students.length;
    setTimeout(function() { render() }, 500);
  })();
</script>
<script type="text/javascript" src="<?php echo asset('js/attendance.js'); ?>"></script>
<?php endif;
include_once DIR_VIEW.'./parts/footer.php' ;?>