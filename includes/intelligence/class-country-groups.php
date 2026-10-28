<?php
/**
 * Static table of recognised country groupings, used by Control → Traffic
 * Controls → Network Intelligence → Geo-IP's Country Block List as a
 * selection aid: picking a group only ticks or unticks that group's
 * countries in the grid. Nothing here is ever saved or enforced on its own.
 *
 * Like Iso_Countries, a plain, bundled, never-fetched reference table. Only
 * defensible, citable groupings belong here:
 *
 * - UN M49 regions, sub-regions and intermediate regions, taken from the
 *   UN Statistics Division's M49 table (via the CSV mirror at
 *   github.com/lukes/ISO-3166-Countries-with-Regional-Codes, all/all.csv,
 *   retrieved 2026-10-27). M49 assigns no region to Antarctica (AQ) and does
 *   not list Taiwan (TW) separately, so both are deliberately left out of
 *   every M49 group rather than guessed. The mirror omits M49's Channel
 *   Islands intermediate region (830); it is added by hand from M49.
 * - The EU and EEA, as membership stood on the as_of date.
 * - Sanctions snapshots (UK country-specific regimes, US OFAC comprehensive
 *   sanctions). These change: each carries an as_of date and source, and
 *   SAM never updates them automatically -- a plugin release is the only
 *   way they change. Sub-national regions (Crimea, the so-called DNR/LNR)
 *   have no ISO 3166-1 code and are explained in the group's note rather
 *   than approximated by blocking all of Ukraine.
 *
 * Every code must be a key of Iso_Countries::all() (CountryGroupsTest).
 */

declare( strict_types=1 );

namespace WP_SAM\Intelligence;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Country_Groups {

	/**
	 * Countries M49 does not place in any region.
	 *
	 * @var string[]
	 */
	public const M49_UNASSIGNED = array( 'AQ', 'TW' );

	/** @return array<string, string> Category key => English label, in display order. */
	public static function categories(): array {
		return array(
			'continents'               => 'Continents (UN M49 regions)',
			'm49-sub-regions'          => 'UN M49 sub-regions',
			'm49-intermediate-regions' => 'UN M49 intermediate regions',
			'blocs'                    => 'Political and economic blocs',
			'sanctions'                => 'Sanctions (snapshot)',
		);
	}

	/**
	 * Every group, in display order.
	 *
	 * @return array<string, array{key: string, label: string, category: string, codes: string[], source: string, source_url: string, as_of: string, note: string}> Group key => group.
	 */
	public static function all(): array {
		$groups = array(
			array(
				'key'        => 'm49-africa',
				'label'      => 'Africa',
				'category'   => 'continents',
				'codes'      => array( 'AO', 'BF', 'BI', 'BJ', 'BW', 'CD', 'CF', 'CG', 'CI', 'CM', 'CV', 'DJ', 'DZ', 'EG', 'EH', 'ER', 'ET', 'GA', 'GH', 'GM', 'GN', 'GQ', 'GW', 'IO', 'KE', 'KM', 'LR', 'LS', 'LY', 'MA', 'MG', 'ML', 'MR', 'MU', 'MW', 'MZ', 'NA', 'NE', 'NG', 'RE', 'RW', 'SC', 'SD', 'SH', 'SL', 'SN', 'SO', 'SS', 'ST', 'SZ', 'TD', 'TF', 'TG', 'TN', 'TZ', 'UG', 'YT', 'ZA', 'ZM', 'ZW' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => 'Antarctica (AQ) has no M49 region, and Taiwan (TW) is not listed separately in M49, so neither is in any UN M49 group -- tick them individually if needed.',
			),
			array(
				'key'        => 'm49-americas',
				'label'      => 'Americas',
				'category'   => 'continents',
				'codes'      => array( 'AG', 'AI', 'AR', 'AW', 'BB', 'BL', 'BM', 'BO', 'BQ', 'BR', 'BS', 'BV', 'BZ', 'CA', 'CL', 'CO', 'CR', 'CU', 'CW', 'DM', 'DO', 'EC', 'FK', 'GD', 'GF', 'GL', 'GP', 'GS', 'GT', 'GY', 'HN', 'HT', 'JM', 'KN', 'KY', 'LC', 'MF', 'MQ', 'MS', 'MX', 'NI', 'PA', 'PE', 'PM', 'PR', 'PY', 'SR', 'SV', 'SX', 'TC', 'TT', 'US', 'UY', 'VC', 'VE', 'VG', 'VI' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => 'Antarctica (AQ) has no M49 region, and Taiwan (TW) is not listed separately in M49, so neither is in any UN M49 group -- tick them individually if needed.',
			),
			array(
				'key'        => 'm49-asia',
				'label'      => 'Asia',
				'category'   => 'continents',
				'codes'      => array( 'AE', 'AF', 'AM', 'AZ', 'BD', 'BH', 'BN', 'BT', 'CN', 'CY', 'GE', 'HK', 'ID', 'IL', 'IN', 'IQ', 'IR', 'JO', 'JP', 'KG', 'KH', 'KP', 'KR', 'KW', 'KZ', 'LA', 'LB', 'LK', 'MM', 'MN', 'MO', 'MV', 'MY', 'NP', 'OM', 'PH', 'PK', 'PS', 'QA', 'SA', 'SG', 'SY', 'TH', 'TJ', 'TL', 'TM', 'TR', 'UZ', 'VN', 'YE' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => 'Antarctica (AQ) has no M49 region, and Taiwan (TW) is not listed separately in M49, so neither is in any UN M49 group -- tick them individually if needed.',
			),
			array(
				'key'        => 'm49-europe',
				'label'      => 'Europe',
				'category'   => 'continents',
				'codes'      => array( 'AD', 'AL', 'AT', 'AX', 'BA', 'BE', 'BG', 'BY', 'CH', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FO', 'FR', 'GB', 'GG', 'GI', 'GR', 'HR', 'HU', 'IE', 'IM', 'IS', 'IT', 'JE', 'LI', 'LT', 'LU', 'LV', 'MC', 'MD', 'ME', 'MK', 'MT', 'NL', 'NO', 'PL', 'PT', 'RO', 'RS', 'RU', 'SE', 'SI', 'SJ', 'SK', 'SM', 'UA', 'VA' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => 'Antarctica (AQ) has no M49 region, and Taiwan (TW) is not listed separately in M49, so neither is in any UN M49 group -- tick them individually if needed.',
			),
			array(
				'key'        => 'm49-oceania',
				'label'      => 'Oceania',
				'category'   => 'continents',
				'codes'      => array( 'AS', 'AU', 'CC', 'CK', 'CX', 'FJ', 'FM', 'GU', 'HM', 'KI', 'MH', 'MP', 'NC', 'NF', 'NR', 'NU', 'NZ', 'PF', 'PG', 'PN', 'PW', 'SB', 'TK', 'TO', 'TV', 'UM', 'VU', 'WF', 'WS' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => 'Antarctica (AQ) has no M49 region, and Taiwan (TW) is not listed separately in M49, so neither is in any UN M49 group -- tick them individually if needed.',
			),
			array(
				'key'        => 'm49-northern-africa',
				'label'      => 'Northern Africa',
				'category'   => 'm49-sub-regions',
				'codes'      => array( 'DZ', 'EG', 'EH', 'LY', 'MA', 'SD', 'TN' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-sub-saharan-africa',
				'label'      => 'Sub-Saharan Africa',
				'category'   => 'm49-sub-regions',
				'codes'      => array( 'AO', 'BF', 'BI', 'BJ', 'BW', 'CD', 'CF', 'CG', 'CI', 'CM', 'CV', 'DJ', 'ER', 'ET', 'GA', 'GH', 'GM', 'GN', 'GQ', 'GW', 'IO', 'KE', 'KM', 'LR', 'LS', 'MG', 'ML', 'MR', 'MU', 'MW', 'MZ', 'NA', 'NE', 'NG', 'RE', 'RW', 'SC', 'SH', 'SL', 'SN', 'SO', 'SS', 'ST', 'SZ', 'TD', 'TF', 'TG', 'TZ', 'UG', 'YT', 'ZA', 'ZM', 'ZW' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-latin-america-and-the-caribbean',
				'label'      => 'Latin America and the Caribbean',
				'category'   => 'm49-sub-regions',
				'codes'      => array( 'AG', 'AI', 'AR', 'AW', 'BB', 'BL', 'BO', 'BQ', 'BR', 'BS', 'BV', 'BZ', 'CL', 'CO', 'CR', 'CU', 'CW', 'DM', 'DO', 'EC', 'FK', 'GD', 'GF', 'GP', 'GS', 'GT', 'GY', 'HN', 'HT', 'JM', 'KN', 'KY', 'LC', 'MF', 'MQ', 'MS', 'MX', 'NI', 'PA', 'PE', 'PR', 'PY', 'SR', 'SV', 'SX', 'TC', 'TT', 'UY', 'VC', 'VE', 'VG', 'VI' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-northern-america',
				'label'      => 'Northern America',
				'category'   => 'm49-sub-regions',
				'codes'      => array( 'BM', 'CA', 'GL', 'PM', 'US' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-central-asia',
				'label'      => 'Central Asia',
				'category'   => 'm49-sub-regions',
				'codes'      => array( 'KG', 'KZ', 'TJ', 'TM', 'UZ' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-eastern-asia',
				'label'      => 'Eastern Asia',
				'category'   => 'm49-sub-regions',
				'codes'      => array( 'CN', 'HK', 'JP', 'KP', 'KR', 'MN', 'MO' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-south-eastern-asia',
				'label'      => 'South-eastern Asia',
				'category'   => 'm49-sub-regions',
				'codes'      => array( 'BN', 'ID', 'KH', 'LA', 'MM', 'MY', 'PH', 'SG', 'TH', 'TL', 'VN' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-southern-asia',
				'label'      => 'Southern Asia',
				'category'   => 'm49-sub-regions',
				'codes'      => array( 'AF', 'BD', 'BT', 'IN', 'IR', 'LK', 'MV', 'NP', 'PK' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-western-asia',
				'label'      => 'Western Asia',
				'category'   => 'm49-sub-regions',
				'codes'      => array( 'AE', 'AM', 'AZ', 'BH', 'CY', 'GE', 'IL', 'IQ', 'JO', 'KW', 'LB', 'OM', 'PS', 'QA', 'SA', 'SY', 'TR', 'YE' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-eastern-europe',
				'label'      => 'Eastern Europe',
				'category'   => 'm49-sub-regions',
				'codes'      => array( 'BG', 'BY', 'CZ', 'HU', 'MD', 'PL', 'RO', 'RU', 'SK', 'UA' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-northern-europe',
				'label'      => 'Northern Europe',
				'category'   => 'm49-sub-regions',
				'codes'      => array( 'AX', 'DK', 'EE', 'FI', 'FO', 'GB', 'GG', 'IE', 'IM', 'IS', 'JE', 'LT', 'LV', 'NO', 'SE', 'SJ' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-southern-europe',
				'label'      => 'Southern Europe',
				'category'   => 'm49-sub-regions',
				'codes'      => array( 'AD', 'AL', 'BA', 'ES', 'GI', 'GR', 'HR', 'IT', 'ME', 'MK', 'MT', 'PT', 'RS', 'SI', 'SM', 'VA' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-western-europe',
				'label'      => 'Western Europe',
				'category'   => 'm49-sub-regions',
				'codes'      => array( 'AT', 'BE', 'CH', 'DE', 'FR', 'LI', 'LU', 'MC', 'NL' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-australia-and-new-zealand',
				'label'      => 'Australia and New Zealand',
				'category'   => 'm49-sub-regions',
				'codes'      => array( 'AU', 'CC', 'CX', 'HM', 'NF', 'NZ' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-melanesia',
				'label'      => 'Melanesia',
				'category'   => 'm49-sub-regions',
				'codes'      => array( 'FJ', 'NC', 'PG', 'SB', 'VU' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-micronesia',
				'label'      => 'Micronesia',
				'category'   => 'm49-sub-regions',
				'codes'      => array( 'FM', 'GU', 'KI', 'MH', 'MP', 'NR', 'PW', 'UM' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-polynesia',
				'label'      => 'Polynesia',
				'category'   => 'm49-sub-regions',
				'codes'      => array( 'AS', 'CK', 'NU', 'PF', 'PN', 'TK', 'TO', 'TV', 'WF', 'WS' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-eastern-africa',
				'label'      => 'Eastern Africa',
				'category'   => 'm49-intermediate-regions',
				'codes'      => array( 'BI', 'DJ', 'ER', 'ET', 'IO', 'KE', 'KM', 'MG', 'MU', 'MW', 'MZ', 'RE', 'RW', 'SC', 'SO', 'SS', 'TF', 'TZ', 'UG', 'YT', 'ZM', 'ZW' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-middle-africa',
				'label'      => 'Middle Africa',
				'category'   => 'm49-intermediate-regions',
				'codes'      => array( 'AO', 'CD', 'CF', 'CG', 'CM', 'GA', 'GQ', 'ST', 'TD' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-southern-africa',
				'label'      => 'Southern Africa',
				'category'   => 'm49-intermediate-regions',
				'codes'      => array( 'BW', 'LS', 'NA', 'SZ', 'ZA' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-western-africa',
				'label'      => 'Western Africa',
				'category'   => 'm49-intermediate-regions',
				'codes'      => array( 'BF', 'BJ', 'CI', 'CV', 'GH', 'GM', 'GN', 'GW', 'LR', 'ML', 'MR', 'NE', 'NG', 'SH', 'SL', 'SN', 'TG' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-caribbean',
				'label'      => 'Caribbean',
				'category'   => 'm49-intermediate-regions',
				'codes'      => array( 'AG', 'AI', 'AW', 'BB', 'BL', 'BQ', 'BS', 'CU', 'CW', 'DM', 'DO', 'GD', 'GP', 'HT', 'JM', 'KN', 'KY', 'LC', 'MF', 'MQ', 'MS', 'PR', 'SX', 'TC', 'TT', 'VC', 'VG', 'VI' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-central-america',
				'label'      => 'Central America',
				'category'   => 'm49-intermediate-regions',
				'codes'      => array( 'BZ', 'CR', 'GT', 'HN', 'MX', 'NI', 'PA', 'SV' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-south-america',
				'label'      => 'South America',
				'category'   => 'm49-intermediate-regions',
				'codes'      => array( 'AR', 'BO', 'BR', 'BV', 'CL', 'CO', 'EC', 'FK', 'GF', 'GS', 'GY', 'PE', 'PY', 'SR', 'UY', 'VE' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => '',
			),
			array(
				'key'        => 'm49-channel-islands',
				'label'      => 'Channel Islands',
				'category'   => 'm49-intermediate-regions',
				'codes'      => array( 'GG', 'JE' ),
				'source'     => 'United Nations Statistics Division, Standard country or area codes for statistical use (M49)',
				'source_url' => 'https://unstats.un.org/unsd/methodology/m49/overview/',
				'as_of'      => '2026-10-27',
				'note'       => 'M49 also lists Sark within the Channel Islands; it has no ISO 3166-1 code of its own and is covered by Guernsey (GG).',
			),
			array(
				'key'        => 'eu',
				'label'      => 'European Union (EU)',
				'category'   => 'blocs',
				'codes'      => array( 'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK' ),
				'source'     => 'European Union, EU countries',
				'source_url' => 'https://european-union.europa.eu/principles-countries-history/eu-countries_en',
				'as_of'      => '2026-10-27',
				'note'       => 'The 27 member states only. Outermost regions such as French Guiana (GF), Guadeloupe (GP), Martinique (MQ), Mayotte (YT), Reunion (RE) and Saint Martin (MF) have their own ISO codes and are not included -- tick them individually if needed.',
			),
			array(
				'key'        => 'eea',
				'label'      => 'European Economic Area (EEA)',
				'category'   => 'blocs',
				'codes'      => array( 'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IS', 'IT', 'LI', 'LT', 'LU', 'LV', 'MT', 'NL', 'NO', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK' ),
				'source'     => 'EFTA, EEA Agreement',
				'source_url' => 'https://www.efta.int/eea',
				'as_of'      => '2026-10-27',
				'note'       => 'The 27 EU member states plus Iceland, Liechtenstein and Norway. Switzerland is not in the EEA.',
			),
			array(
				'key'        => 'uk-sanctions',
				'label'      => 'UK: countries with a country-specific sanctions regime',
				'category'   => 'sanctions',
				'codes'      => array( 'AF', 'BA', 'BY', 'CD', 'CF', 'GN', 'GW', 'HT', 'IQ', 'IR', 'KP', 'LB', 'LY', 'ML', 'MM', 'NI', 'RU', 'SD', 'SO', 'SS', 'SY', 'VE', 'YE', 'ZW' ),
				'source'     => 'GOV.UK, UK sanctions regimes under the Sanctions Act: regimes listed by country',
				'source_url' => 'https://www.gov.uk/government/collections/uk-sanctions-regimes-under-the-sanctions-act#regimes-listed-by-country',
				'as_of'      => '2026-10-28',
				'note'       => 'Countries with a country-specific UK sanctions regime: Afghanistan, Belarus, Bosnia and Herzegovina, Central African Republic, Democratic People\'s Republic of Korea, Democratic Republic of the Congo, Guinea, Republic of Guinea-Bissau, Haiti, Iran (two regimes: Iran, and Iran nuclear), Iraq, Lebanon (two regimes: Lebanon, and the assassination of Rafiq Hariri), Libya, Mali, Myanmar, Nicaragua, Russia, Somalia, South Sudan, Sudan, Syria (two regimes: Syria, and Syria cultural property), Venezuela, Yemen and Zimbabwe. These regimes mostly target named persons, entities or sectors; having a regime is not a requirement to block all traffic from a country. Thematic regimes (cyber, global human rights, anti-corruption and others) and the non-statutory arms embargo on mainland China and Hong Kong are not country lists and are not included. Crimea and the other Russian-controlled areas of Ukraine have no ISO country code of their own and cannot be selected by country -- Ukraine (UA) is deliberately not included.',
			),
			array(
				'key'        => 'us-ofac-comprehensive',
				'label'      => 'US OFAC: comprehensively sanctioned jurisdictions',
				'category'   => 'sanctions',
				'codes'      => array( 'CU', 'IR', 'KP' ),
				'source'     => 'US Treasury, OFAC FAQ 10: What jurisdictions or countries are sanctioned by the United States?',
				'source_url' => 'https://ofac.treasury.gov/faqs/10',
				'as_of'      => '2026-10-28',
				'note'       => 'The jurisdictions OFAC lists as subject to broad, jurisdiction-based sanctions ("at times referred to as comprehensive sanctions"): Cuba, Iran and North Korea. OFAC itself says it keeps no list of countries U.S. persons may not do business with; its Sanctions Programs and Country Information page lists every program, most of them targeted. The Crimea region and the so-called Donetsk and Luhansk People\'s Republics are also comprehensively sanctioned, but have no ISO country code of their own and cannot be selected by country -- Ukraine (UA) is deliberately not included. Syria is no longer included: the Syria sanctions program was revoked by Executive Order 14312 (30 June 2025) and the Syrian Sanctions Regulations were removed on 26 August 2025; targeted Syria-related designations remain. Russia, Venezuela, Belarus and other programs are targeted or sectoral, not comprehensive, and are not included. OFAC blocks the Government of Venezuela, not the country as a whole.',
			),
		);

		$keyed = array();
		foreach ( $groups as $group ) {
			$keyed[ $group['key'] ] = $group;
		}
		return $keyed;
	}

	/**
	 * Groups organised by category, in display order; empty categories are omitted.
	 *
	 * @return array<string, array{label: string, groups: array<string, array{key: string, label: string, category: string, codes: string[], source: string, source_url: string, as_of: string, note: string}>}>
	 */
	public static function by_category(): array {
		$out = array();
		foreach ( self::categories() as $category => $label ) {
			$out[ $category ] = array(
				'label'  => $label,
				'groups' => array(),
			);
		}
		foreach ( self::all() as $key => $group ) {
			$out[ $group['category'] ]['groups'][ $key ] = $group;
		}
		return array_filter( $out, static fn( $category ) => array() !== $category['groups'] );
	}
}
