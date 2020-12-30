<?php


namespace App\Helpers;


use Carbon\CarbonImmutable;

class Carbon extends CarbonImmutable
{
}

//TODO: Add more helper functions?

function now(...$args): Carbon
{
	return Carbon::now(...$args);
}

function today(...$args): Carbon
{
	return Carbon::today(...$args);
}

function tomorrow(...$args): Carbon{
	return Carbon::tomorrow(...$args);
}

function yesterday(...$args): Carbon{
	return Carbon::yesterday(...$args);
}

function timeAgo(Carbon $carbon, ...$args): string
{
	return $carbon->diffForHumans(...$args);
}

