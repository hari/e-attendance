<?php use Attendance\Models\User; ?>
<div class="row">
 <nav>
   <li><a href="<?php echo route('home'); ?>">Home</a></li>
   <?php if (User::logged()->getAttribute('role') == User::ADMIN) : ?>
     <li><a href="<?php echo route('page.teacher'); ?>">Teachers</a></li>
     <li><a href="<?php echo route('page.student'); ?>">Students</a></li>
     <li><a href="<?php echo route('page.subject'); ?>">Subjects</a></li>
   <?php endif;
   if (User::logged()->getAttribute('role') == User::TEACHER) : ?>
   <li><a href="<?php echo route('page.mark'); ?>">Marks</a></li>
 <?php endif; ?>
 <li style="float: right"><a href="<?php echo route('logout'); ?>">Logout</a></li>
</nav>
</div>

<?php include_once 'message.php'; ?>