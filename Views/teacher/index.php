<?php include_once DIR_VIEW.'./parts/header.php' ;?>
<body class="teacher">
  <?php include_once DIR_VIEW.'./parts/nav.php' ;?>
  <div class="row">
   <h3 style="margin-bottom: 0">My Subjects</h3>
   <select onchange="changeSubject(this);" name="subject" id="subject">
     <?php $a = '';if (isset($subjects) && count($subjects) > 0) : 
     foreach($subjects as $subject) :
      if ($_GET['sub'] != null && $_GET['sub'] == $subject['code']) {
        $a = 'selected';
      } else {
        $a = '';
      }
      ?>
      <option <?php echo $a; ?> value="<?php echo $subject['code']; ?>">
       <?php echo $subject['name']; ?>
     </option>
   <?php endforeach; else :?>
   <option value="-1">No subject</option>
 <?php endif; ?>
</select>
<script type="text/javascript">
 function changeSubject(o) {
  if (o.value != -1)
    document.location.href = '<?php echo route("home"); ?>' + '?sub=' + o.value;
}
</script>
</div>
<div style="height: 2px; background-color: #ddd"></div>
<?php if (count($students) == 0) echo '<h3 style="text-align: center">Already taken</h3>'; ?>
  <div class="row">
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
      <button class="btn btn-default" onclick="submit();">Submit</button>
    </div>
  </div>
  <script type="text/javascript">
  //count nodes
  var lc, pc, ac;
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
  render();
})();

  /**
   * Changes student's attendance by moving from list
   */
   function moveTo(e, fromList, toList) {
    e = e || window.event;
    if (!e.target) return;
    var id = e.target.getAttribute('data-r');
    if (id == null) return;
    for(var i = 0; i < fromList.length; i++) {
      if (fromList[i].reg == id) {
        var std = fromList.splice(i, 1);
        if (toList.indexOf(std[0]) < 0) {
          toList.push(std[0]);
        }
        break;
      }
    }
    render();
  }

  /**
   * loads student from database according to given subject
   */
   function loadStudents(subject) {
    render();
  }

  /**
   * Displays the students
   */
   function render() {
    lc.textContent = present.length + '/' + total;
    pc.textContent = students.length + '/' + total;
    ac.textContent = absent.length + '/' + total;
    showAbsentList();
    showStudentList();
    showPresentList();
  }

  function showAbsentList() {
    var root = document.getElementById('absent-list');
    while (root.firstChild) {
      root.removeChild(root.firstChild);
    }
    var li, btnPresent, btnLeave, span, student;
    for(var i = 0; i < absent.length; i++) {
      student = absent[i];
      li = document.createElement('li');
      span = document.createElement('span');
      span.textContent = student.name + " ("+ student.reg + ")";
      btnPresent = document.createElement('button');
      btnLeave = document.createElement('button');
      btnPresent.className = 'flat p';
      btnPresent.textContent = 'P';
      btnPresent.setAttribute('data-r', student.reg);
      btnLeave.className = 'flat l';
      btnLeave.textContent = 'L';
      btnLeave.setAttribute('data-r', student.reg);
      btnLeave.onclick = function(e) {
        moveTo(e, absent, students);
      };
      btnPresent.onclick = function(e) {
        moveTo(e, absent, present);
      };
      li.appendChild(span);
      li.appendChild(btnPresent);
      li.appendChild(btnLeave);
      root.appendChild(li);
    }
  }
  function showPresentList() {
    var root = document.getElementById('present-list');
    while (root.firstChild) {
      root.removeChild(root.firstChild);
    }
    var li, btnAbsent, btnLeave, span, student;
    for(var i = 0; i < present.length; i++) {
      student = present[i];
      li = document.createElement('li');
      span = document.createElement('span');
      span.textContent = student.name + " ("+ student.reg + ")";
      li.setAttribute('data-r', student.reg);
      btnAbsent = document.createElement('button');
      btnLeave = document.createElement('button');
      btnAbsent.className = 'flat a';
      btnAbsent.textContent = 'A';
      btnAbsent.setAttribute('data-r', student.reg);
      btnLeave.className = 'flat l';
      btnLeave.textContent = 'L';
      btnLeave.setAttribute('data-r', student.reg);
      btnLeave.onclick = function(e) {
        moveTo(e, present, students);
      };
      btnAbsent.onclick = function(e) {
        moveTo(e, present, absent);
      };
      li.appendChild(span);
      li.appendChild(btnAbsent);
      li.appendChild(btnLeave);
      root.appendChild(li);
    }
  }

  function showStudentList() {
    var root = document.getElementById('student-list');
    while (root.firstChild) {
      root.removeChild(root.firstChild);
    }
    var li, btnAbsent, btnPresent, span, student;
    for(var i = 0; i < students.length; i++) {
      student = students[i];
      li = document.createElement('li');
      span = document.createElement('span');
      btnAbsent = document.createElement('button');
      btnPresent = document.createElement('button');
      span.textContent = student.name;
      btnAbsent.className = 'flat a';
      btnAbsent.textContent = 'A';
      btnPresent.className = 'flat p';
      btnPresent.textContent = 'P';
      btnPresent.setAttribute('data-r', student.reg);
      btnAbsent.setAttribute('data-r', student.reg);
      btnPresent.onclick = function(e) {
        moveTo(e, students, present);
      };
      btnAbsent.onclick = function(e) {
        moveTo(e, students, absent);
      };
      li.appendChild(span);
      li.appendChild(btnAbsent);
      li.appendChild(btnPresent);
      root.appendChild(li);
    }
  }

  function submit() {
    var form = document.createElement('form');
    var ele = document.createElement('input');
    var sub = document.createElement('input');
    if (absent.length == 0) {
      absent.push({name: 'empty', reg: 'marker'});
    }
    sub.name = "subject";
    sub.value = document.getElementById('subject').value;
    form.method = "POST";
    form.action = "take";
    ele.name = "list";
    ele.value =  JSON.stringify(absent);
    form.style.display = 'none';
    form.appendChild(ele);
    form.appendChild(sub);
    document.body.appendChild(form);
    form.submit();
  }
</script>
</body>
</html>