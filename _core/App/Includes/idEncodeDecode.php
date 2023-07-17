<?php

use Jenssegers\Optimus\Optimus;

function idEncode($id='') {
  $optimus = new Optimus(OPTMUS_PRIME, OPTMUS_INVERSE, OPTMUS_RANDOM, OPTMUS_BIT);
  return $optimus->encode($id);
}

function idDecode($id='') {
  $optimus = new Optimus(OPTMUS_PRIME, OPTMUS_INVERSE, OPTMUS_RANDOM, OPTMUS_BIT);
  return $optimus->decode($id);
}