<?php
 
$bud_strong_g = $_SESSION['bud_strong_g'];
$bud_cold_g = $_SESSION['bud_cold_g'];
$bud_hot_g = $_SESSION['bud_hot_g'];
$bud_strong_p = $_SESSION['bud_strong_p'];
$bud_hot_p = $_SESSION['bud_hot_p'];
$bud_cold_p = $_SESSION['bud_cold_p'];
$bud_strong_pp = $_SESSION['bud_strong_pp'];
$bud_cold_pp = $_SESSION['bud_cold_pp'];
$bud_hot_pp = $_SESSION['bud_hot_pp'];
$bud_strong_v = $_SESSION['bud_strong_v'];
$bud_hot_v = $_SESSION['bud_hot_v'];
$bud_cold_v = $_SESSION['bud_cold_v'];
$bud_hot_t = $_SESSION['bud_hot_t'];
$bud_strong_t = $_SESSION['bud_strong_t'];
$bud_cold_t = $_SESSION['bud_cold_t'];
$bud_strong_f = $_SESSION['bud_strong_f'];
$bud_hot_f = $_SESSION['bud_hot_f'];
$bud_cold_f = $_SESSION['bud_cold_f'];
$bud_strong_h = $_SESSION['bud_strong_h'];
$bud_hot_h = $_SESSION['bud_hot_h'];
$bud_cold_h = $_SESSION['bud_cold_h'];
$bud_strong_c = $_SESSION['bud_strong_c'];
$bud_hot_c = $_SESSION['bud_hot_c'];
$bud_cold_c = $_SESSION['bud_cold_c'];
$bud_strong_b = $_SESSION['bud_strong_b'];
$bud_hot_b = $_SESSION['bud_hot_b'];
$bud_cold_b = $_SESSION['bud_cold_b'];
$bud_strong_ms = $_SESSION['bud_strong_ms'];
$bud_hot_ms = $_SESSION['bud_hot_ms'];
$bud_cold_ms = $_SESSION['bud_cold_ms'];

$pro_s_g = $_SESSION['pro_s_g']  ;
$pro_h_g = $_SESSION['pro_h_g'];
$pro_c_g = $_SESSION['pro_c_g'];
$pro_s_p = $_SESSION['pro_s_p'];
$pro_h_p = $_SESSION['pro_h_p'] ;
$pro_c_p = $_SESSION['pro_c_p'] ;
$pro_s_v = $_SESSION['pro_s_v'];
$pro_c_v = $_SESSION['pro_c_v'];
$pro_h_v = $_SESSION['pro_h_v'];
$pro_s_pp = $_SESSION['pro_s_pp'];
$pro_c_pp = $_SESSION['pro_c_pp'];
$pro_h_pp = $_SESSION['pro_h_pp'];
$pro_s_f = $_SESSION['pro_s_f'];
$pro_c_f = $_SESSION['pro_c_f'];
$pro_h_f = $_SESSION['pro_h_f'] ;
$pro_s_t = $_SESSION['pro_s_t']  ;
$pro_c_t = $_SESSION['pro_c_t'];
$pro_h_t = $_SESSION['pro_h_t'] ;
$pro_s_c = $_SESSION['pro_s_c'];
$pro_c_c = $_SESSION['pro_c_c'];
$pro_h_c = $_SESSION['pro_h_c'] ;
$pro_s_h = $_SESSION['pro_s_h'];
$pro_c_h = $_SESSION['pro_c_h'];
$pro_h_h = $_SESSION['pro_h_h'];
$pro_s_b =  $_SESSION['pro_s_b'] ;
$pro_c_b = $_SESSION['pro_c_b'];
$pro_h_b =  $_SESSION['pro_h_b'];
$pro_s_ms = $_SESSION['pro_s_ms'];
$pro_c_ms = $_SESSION['pro_c_ms'];
$pro_h_ms = $_SESSION['pro_h_ms'];

$bud_g = $bud_strong_g + $bud_cold_g + $bud_hot_g;
$bud_p = $bud_strong_p + $bud_cold_p + $bud_hot_p;
$bud_pp = $bud_strong_pp+ $bud_cold_pp + $bud_hot_pp;
$bud_v = $bud_strong_v + $bud_cold_v + $bud_hot_v;
$bud_t = $bud_strong_t + $bud_cold_t + $bud_hot_t;
$bud_f = $bud_strong_f + $bud_cold_f + $bud_hot_f;
$bud_h = $bud_strong_h + $bud_cold_h + $bud_hot_h;
$bud_c = $bud_strong_c + $bud_cold_c + $bud_hot_c;
$bud_b = $bud_strong_b + $bud_cold_b + $bud_hot_b;
$bud_ms = $bud_strong_ms + $bud_cold_ms + $bud_hot_ms;

?>
<input type="hidden" id="bud_strong_g" value="<?= $bud_g ?>">
<input type="hidden" id="bud_strong_p" value="<?= $bud_p ?>">
<input type="hidden" id="bud_strong_pp" value="<?= $bud_pp ?>">
<input type="hidden" id="bud_strong_v" value="<?= $bud_v ?>">
<input type="hidden" id="bud_strong_f" value="<?= $bud_f ?>">
<input type="hidden" id="bud_strong_t" value="<?= $bud_t ?>">
<input type="hidden" id="bud_strong_h" value="<?= $bud_h ?>">
<input type="hidden" id="bud_strong_c" value="<?= $bud_c ?>">
<input type="hidden" id="bud_strong_b" value="<?= $bud_b ?>">

<input type="hidden" id="pro_s_g" value="<?= $pro_s_g ?>">
<input type="hidden" id="pro_h_g" value="<?= $pro_h_g ?>">
<input type="hidden" id="pro_c_g" value="<?= $pro_c_g ?>">
<input type="hidden" id="pro_s_p" value="<?= $pro_s_p ?>">
<input type="hidden" id="pro_h_p" value="<?= $pro_h_p ?>">
<input type="hidden" id="pro_c_p" value="<?= $pro_c_p ?>">
<input type="hidden" id="pro_s_v" value="<?= $pro_s_v ?>">
<input type="hidden" id="pro_h_v" value="<?= $pro_h_v ?>">
<input type="hidden" id="pro_c_v" value="<?= $pro_c_v ?>">

<input type="hidden" id="pro_s_pp" value="<?= $pro_s_pp ?>">
<input type="hidden" id="pro_h_pp" value="<?= $pro_h_pp ?>">
<input type="hidden" id="pro_c_pp" value="<?= $pro_c_pp ?>">
<input type="hidden" id="pro_s_f" value="<?= $pro_s_f ?>">
<input type="hidden" id="pro_h_f" value="<?= $pro_h_f ?>">
<input type="hidden" id="pro_c_f" value="<?= $pro_c_f ?>">
<input type="hidden" id="pro_s_t" value="<?= $pro_s_t ?>">
<input type="hidden" id="pro_h_t" value="<?= $pro_h_t ?>">
<input type="hidden" id="pro_c_t" value="<?= $pro_c_t ?>">

<input type="hidden" id="pro_s_h" value="<?= $pro_s_h ?>">
<input type="hidden" id="pro_h_h" value="<?= $pro_h_h ?>">
<input type="hidden" id="pro_c_h" value="<?= $pro_c_h ?>">
<input type="hidden" id="pro_s_c" value="<?= $pro_s_c ?>">
<input type="hidden" id="pro_h_c" value="<?= $pro_h_c ?>">
<input type="hidden" id="pro_c_c" value="<?= $pro_c_c ?>">
<input type="hidden" id="pro_s_b" value="<?= $pro_s_b ?>">
<input type="hidden" id="pro_h_b" value="<?= $pro_h_b ?>">
<input type="hidden" id="pro_c_b" value="<?= $pro_c_b ?>">
<input type="hidden" id="pro_s_ms" value="<?= $pro_s_ms ?>">
<input type="hidden" id="pro_h_ms" value="<?= $pro_h_ms ?>">
<input type="hidden" id="pro_c_ms" value="<?= $pro_c_ms ?>">
 
