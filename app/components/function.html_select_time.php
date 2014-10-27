<?php
function html_select_time($time, $prefix = 'publish_on_', $interval = 30, $seconds = false, $hours24 = false) {
  if(empty($time)) {
    $time = time();
  }

  echo '<select name="'.$prefix.'Hour">';
  if($hours24 === true) {
    for($i=0;$i<=24;$i++) {
      echo '<option value="'.$i.'"'.(($i == date('G', $time))?' selected="selected"':'').'>'.str_pad($i, 2, 0, STR_PAD_LEFT).'</option>';
    }
  } else {
    for($i=1;$i<=12;$i++) {
      echo '<option value="'.$i.'"'.(($i == date('g', $time))?' selected="selected"':'').'>'.str_pad($i, 2, 0, STR_PAD_LEFT).'</option>';
    }
  }
  echo '</select>';

  echo '<select name="'.$prefix.'Minute">';
  for($i=0;$i<=60;$i+=$interval) {
    echo '<option value="'.str_pad($i, 2, 0, STR_PAD_LEFT).'"'.((str_pad($i, 2, 0, STR_PAD_LEFT) == date('i', $time))?' selected="selected"':'').'>'.str_pad($i, 2, 0, STR_PAD_LEFT).'</option>';
  }
  echo '</select>';

  if($seconds === true) {
    echo '<select name="'.$prefix.'Second">';
    for($i=1;$i<=60;$i++) {
      echo '<option value="'.str_pad($i, 2, 0, STR_PAD_LEFT).'"'.((str_pad($i, 2, 0, STR_PAD_LEFT) == date('s', $time))?' selected="selected"':'').'>'.str_pad($i, 2, 0, STR_PAD_LEFT).'</option>';
    }
    echo '</select>';
  }

  echo '<select name="'.$prefix.'Meridian">';
  echo '<option value="am"'.(('am' == date('a', $time))?' selected="selected"':'').'>AM</option>';
  echo '<option value="pm"'.(('pm' == date('a', $time))?' selected="selected"':'').'>PM</option>';
  echo '</select>';
}
