<?php

/**
 * Sort a content type by given column and ordering
 *
 * @param  string $content_type pages, partials or templates
 * @param  string $sortBy       Column to sort by
 * @param  string $order        Ordering - asc or desc
 * @param  array  $qs           Any other query string parameters to append
 * @return string               URL
 */
function sort_contents_by_link($content_type, $sortBy='title', $order='asc', array $qs=array())
{
	$qs = http_build_query(array_merge($qs, array(
		'sortBy' => $sortBy,
		'order' => $order,
	)));
	return resources("orchestra-cms.".$content_type."?" . $qs);
}