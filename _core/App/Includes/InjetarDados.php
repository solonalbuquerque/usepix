<?php

// includes
foreach (glob(APP."Dados/*.php") as $_FuncaoAdd){
  require_once($_FuncaoAdd);
}