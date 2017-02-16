<?php include_once DIR_VIEW.'./parts/header.php';
include DIR_VIEW .'./admin/parts/a.php' ;
if (isset($_GET['ad'])) {
  if (is_numeric($_GET['ad']))
    $total = intval($_GET['ad']);
  $file = fopen( DIR_VIEW .'./admin/parts/a.php', 'w+');
  fwrite($file,'<?php $total = ' . $total . ';');
  fclose($file);
}
?>
<body class="admin">
  <?php include_once DIR_VIEW.'./parts/nav.php' ;?>
  <div class="row">
   <section class="col two">
     <h1>Chart</h1>
     Select Sem: &nbsp; <select name="sem" onchange="changeTo(this)">
     <?php for($i = 1; $i <= 8; $i++) : ?>
       <option <?php if ($sem == $i) echo "selected";?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
     <?php endfor; ?>
   </select>
    &nbsp; Total Students: <strong>
   <?php
   echo $total_student . '</strong>';
   $subs = array_filter($subjects, function($item) 
    use ($sem) {
      return $item['sem'] == $sem;
    });
   $data = [];
   $names = [];
   foreach ($subs as $sub) {
    $names[] = short_code($sub['name']);
    $data[] = $total_student - \Attendance\Models\Attendance::countOf($sub['code']);
  }
  ?>
  <canvas id="chart"></canvas>
  <script type="text/javascript">
    (function(d) {
      Chart.defaults.global.hover.mode = 'label';
      Chart.defaults.global.tooltips.enabled = true;
      var ctx = document.getElementById("chart");
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: <?php echo json_encode($names); ?>,
          datasets: [{
            label: 'Attendance',
            data: <?php echo json_encode($data); ?>,
            borderWidth: 1,
            borderColor: 'rgb(128,120,192)'
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero:true
              }
            }]
          }
        }
      });
    })(document);
  </script>
</section>
<section class="col two">
 <h1>Academic days</h1>
 <p>Change academic days</p>
 <form class="">
   <input type="text" value="<?php echo $total; ?>" name="ad" />
   <input type="submit" value="Change" />
 </form>
 This semester has total of <strong><?php echo $total; ?></strong> academic days.
</section>
<script type="text/javascript">
  function changeTo(e) {
    document.location.href = '<?php echo route("home") . "?sem="; ?>' + e.value; 
  }
</script>
</div>
<?php include_once DIR_VIEW.'./parts/footer.php' ;?>