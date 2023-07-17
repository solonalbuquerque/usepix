<?php

function getAllParams() {
    $params = array();
    $params = array_merge($params, $_GET);
    $params = array_merge($params, $_POST);
    $params['urldata'] = (isset($params['url'])) ? explode("/", $params['url']) : [];
    return $params;
}