
<select onchange="changeSubject(this);" name="subject" id="subject">
 <?php $a = '';if (isset($subjects) && count($subjects) > 0) : 
 $inSub = $_GET['sub'] != null ? $_GET['sub'] : '';
 foreach($subjects as $subject) :
  $a = '';
if ($inSub == $subject['code']) $a = 'selected';
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
    document.location.href = '<?php echo get_current_route()->getUri(true); ?>' + '?sub=' + o.value;
}
</script>