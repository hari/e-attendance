<?php include_once DIR_VIEW.'./parts/header.php' ;?>
<body class="teacher">
  <div class="row">
   <h3 style="margin-bottom: 0">My Subjects</h3>
   <select name="subject">
    <option value="1">DSA</option>
    <option value="2">PQT</option>
    <option value="3">MFC</option>
   </select>
  </div>
  <div style="height: 2px; background-color: #ddd"></div>
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
  <script type="text/javascript">
  //count nodes
  var lc, pc, ac;
  var students = [], absent = [], present = [], total = 0;
  (function(){
    lc = document.getElementById('lc');
    pc = document.getElementById('pc');
    ac = document.getElementById('ac');
    for(var i = 0; i < 10; i++) {
      students[i] = {name: '#' + i + " Student", reg: 'se2014' + i};
    }
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
</script>
</body>
</html>