<?php

function checkActiveMenu($uri)
{
	$class = '';
	if (Request::is($uri)) {
		$class = 'active';
	}
	return $class;
}

function checkActiveToggle($uri)
{
	$class = '';
	if (Request::is($uri)) {
		$class = 'block !important';
	}
	return $class;
}

function apiArrayResponseBuilder($statusCode = null, $message = null, $data = [])
{
	$arr = [
		'status_code' => (isset($statusCode)) ? $statusCode : 500,
		'message' => (isset($message)) ? $message : 'error'
	];
	if (count($data) > 0) {
		$arr['data'] = $data;
	}
	return $arr;
}

function priceFormat($price){

	return "Rp ".number_format((int) $price, 0 , '.' ,'.');

}

function numberingPagination($dataCountToDisplay)
{
    $page = 1;
    if(Request::has('page') && Request::get('page') > 1) {
        $page += (Request::get('page') - 1) * $dataCountToDisplay;
    }
    return $page;
}