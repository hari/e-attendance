<?php include_once DIR_VIEW.'./parts/header.php' ;?>
<body class="admin">
  <?php include_once DIR_VIEW.'./parts/nav.php' ;?>
  <div class="row">
   <section class="col two">
     <h1>Chart</h1>
     <canvas style="width: 100%; background-color: #fff" id="chart">
     </canvas>
     <?php
      $subjects = ['DSA', 'CG', 'PQT', 'RWT', 'ASC'];
      $data = [20, 30, 10, 15, 40];
     ?>
     <script type="text/javascript">
       var c = document.getElementById("chart");
       c.width = 500;
       c.height = 250;
       c.style.width = c.width + 'px';
       c.style.height = c.height + 'px';
       var ctx = c.getContext("2d");
       ctx.font = "12px Changa";
       ctx.strokeStyle = "blue";
       ctx.moveTo(15, 210);
       <?php for($i = 0; $i < count($subjects); $i++ ) : ?>
       ctx.fillText("<?php echo $subjects[$i] ?>", 100 * <?php echo $i; ?> + 10, 240);
       <?php 
         if ($i > 0)
          echo 'ctx.lineTo('.($i*100+20).','.(220-$data[$i]).'); ctx.stroke();';
       endfor; ?>
       ctx.fillStyle = "blue";
       <?php for($i = 0; $i < count($subjects); $i++ ) : ?>
       ctx.beginPath();
       <?php 
         $valX = $i * 100 + 20; if ($i == 0) $valX -= 5;
         $valY = 220 - $data[$i]; if ($i == 0) $valY += 10;
       ?>
       ctx.arc(<?php echo $valX; ?>,<?php echo $valY; ?>, 4, 0, 2 * Math.PI, false);
       ctx.closePath();
       ctx.fill();
       <?php endfor; ?>
     </script>
   </section>
   <section class="col two">
     <h1>Information</h1>
   </section>
 </div>
</body>
</html>