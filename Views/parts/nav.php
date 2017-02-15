<?php use Attendance\Models\User; ?>
<div class="row">
 <nav>
   <?php
   $user = User::logged();
   $role = $user->getAttribute('role');
    //link, text, condition
   $navs = [
   [route('home'), 'Home', true],
   [route('page.teacher'), 'Teachers', $role == USER::ADMIN],
   [route('page.student'), 'Students', $role == USER::ADMIN],
   [route('page.subject'), 'Subjects', $role == USER::ADMIN],
   [route('page.mark'), 'Marks', $role == USER::TEACHER]
   ];
   ?>
   <?php
   $path = get_current_route()->getUri(true);
   foreach ($navs as $nav) :
     if (!$nav[2]) continue;
     $css = "";
     if ($path == $nav[0]) $css = ' class="selected"';
     echo sprintf('<li%s><a href="%s">%s</a></li>', $css, $nav[0], $nav[1]);
   endforeach;
   ?>
   <li style="float: right">
     <a href="<?php echo route('logout'); ?>">Logout</a>
   </li>
 </nav>
 <p style="text-align: right; margin-top: 8px;">
   Logged in as: <strong><?php echo $user->getAttribute('full_name'); ?></strong>
 </p>
</div>

<?php include_once 'message.php'; ?>