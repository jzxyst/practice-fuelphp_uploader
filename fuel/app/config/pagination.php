<?php
/**
 * Part of the Fuel framework.
 *
 * @package    Fuel
 * @version    1.8
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2016 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * NOTICE:
 *
 * If you need to make modifications to the default configuration, copy
 * this file to your app/config folder, and make them in there.
 *
 * This will allow you to upgrade fuel without losing your custom config.
 */

return array(

	// the active pagination template
	'active'                      => 'default',

	// default FuelPHP pagination template, compatible with pre-1.4 applications
	'default'                     => array(
		'wrapper'                 => "<ul class=\"pagination\" role=\"navigation\" aria-label=\"Pagination\">{pagination}</ul>",

		'first'                   => "<li class=\"first\">{link}</li>",
		'first-marker'            => "&laquo;&laquo;",
		'first-link'              => "<a href=\"{uri}\">{page}</a>",

		'first-inactive'          => "",
		'first-inactive-link'     => "",

		'previous'                => "<li class=\"pagination-previous\">{link}</li>",
		'previous-marker'         => "<span class=\"show-for-sr\">page</span>",
		'previous-link'           => "<a href=\"{uri}\" rel=\"prev\" aria-label=\"Prev page\">{page}</a>",

		'previous-inactive'       => "<li class=\"pagination-previous disabled\">{link}</li>",
		'previous-inactive-link'  => "{page}",

		'regular'                 => "<li>{link}</li>",
		'regular-link'            => "<a href=\"{uri}\" aria-label=\"Page {page}\">{page}</a>",

		'active'                  => "<li class=\"current\">{link}</li>",
		'active-link'             => "{page}",

		'next'                    => "<li class=\"pagination-next\">{link}</li>",
		'next-marker'            => "<span class=\"show-for-sr\">page</span>",
		'next-link'               => "<a href=\"{uri}\" rel=\"next\" aria-label=\"Next page\">{page}</a>",

		'next-inactive'           => "<li class=\"pagination-next disabled\">{link}</li>",
		'next-inactive-link'      => "{page}",

		'last'                    => "<li class=\"last\">{link}</li>",
		'last-marker'             => "&raquo;&raquo;",
		'last-link'               => "<a href=\"{uri}\">{page}</a>",

		'last-inactive'           => "",
		'last-inactive-link'      => "",
	),
);
