<?php
function e($s){ return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }

function normalize_hex($hex, $fallback="#0d6efd"){
  $hex = trim($hex);
  if (preg_match('/^#?[0-9a-fA-F]{6}$/',$hex)) return ($hex[0]==='#'?$hex:"#".$hex);
  return $fallback;
}
