<?php
$message = MessageBox::pullMessage();
if (!empty($message)) :
  $template = '<div class="message-box %s">%s</div>';
  $msg      = '<div class="message">%s</div>';
  $class = $message['type'];
  $col = '';
  foreach ($message as $key => $value) :
    if ($key != 'type' && $key != 'title') $col .= sprintf($msg, $value);
  endforeach;
  $mTitle = '';
  if (isset($message['title'])) :
    $mTitle = "<h1 class=\"title\" id=\"message-header\">".$message['title']."</h1>";
  endif;
  echo sprintf($template, $class, $mTitle.$col);
endif;