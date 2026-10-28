<?php
/**
 * Unit tests for WP_SAM\Intelligence\Country_Groups -- the bundled country
 * groupings behind the Country Block List's "Select by group" control.
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;
use WP_SAM\Intelligence\Country_Groups;
use WP_SAM\Intelligence\Iso_Countries;

class CountryGroupsTest extends TestCase {

	/** @return string[] */
	private function codes_of( string $key ): array {
		$groups = Country_Groups::all();
		$this->assertArrayHasKey( $key, $groups );
		return $groups[ $key ]['codes'];
	}

	/** @return array<string, array<string, mixed>> */
	private function groups_in( string $category ): array {
		return array_filter( Country_Groups::all(), static fn( $group ) => $category === $group['category'] );
	}

	public function test_every_code_in_every_group_is_a_known_iso_country(): void {
		$known = Iso_Countries::all();
		foreach ( Country_Groups::all() as $key => $group ) {
			foreach ( $group['codes'] as $code ) {
				$this->assertArrayHasKey( $code, $known, "Group {$key} contains unknown code {$code}." );
			}
		}
	}

	public function test_no_group_is_empty_or_has_duplicates(): void {
		foreach ( Country_Groups::all() as $key => $group ) {
			$this->assertNotEmpty( $group['codes'], "Group {$key} is empty." );
			$this->assertSame( count( $group['codes'] ), count( array_unique( $group['codes'] ) ), "Group {$key} has duplicate codes." );
		}
	}

	public function test_every_group_is_well_formed_with_a_source_and_as_of_date(): void {
		$categories = Country_Groups::categories();
		foreach ( Country_Groups::all() as $key => $group ) {
			$this->assertSame( $key, $group['key'] );
			$this->assertNotSame( '', $group['label'] );
			$this->assertArrayHasKey( $group['category'], $categories, "Group {$key} has an unknown category." );
			$this->assertNotSame( '', $group['source'], "Group {$key} has no source." );
			$this->assertStringStartsWith( 'https://', $group['source_url'], "Group {$key} has no https source URL." );
			$this->assertMatchesRegularExpression( '/^\d{4}-\d{2}-\d{2}$/', $group['as_of'], "Group {$key} has no as-of date." );
		}
	}

	public function test_eu_has_27_members_and_eea_is_eu_plus_iceland_liechtenstein_norway(): void {
		$eu  = $this->codes_of( 'eu' );
		$eea = $this->codes_of( 'eea' );

		$this->assertCount( 27, $eu );
		$this->assertCount( 30, $eea );
		$this->assertSame( array(), array_diff( $eu, $eea ) );
		$this->assertEqualsCanonicalizing( array( 'IS', 'LI', 'NO' ), array_values( array_diff( $eea, $eu ) ) );
		$this->assertNotContains( 'GB', $eu );
		$this->assertNotContains( 'CH', $eea );
	}

	public function test_m49_continents_partition_every_assigned_country(): void {
		$this->assert_partition( 'continents', 5 );
	}

	public function test_m49_sub_regions_partition_every_assigned_country(): void {
		$this->assert_partition( 'm49-sub-regions', 17 );
	}

	public function test_m49_sub_regions_nest_inside_one_continent_each(): void {
		$continents = $this->groups_in( 'continents' );
		foreach ( $this->groups_in( 'm49-sub-regions' ) as $key => $sub ) {
			$parents = array_filter(
				$continents,
				static fn( $continent ) => array() === array_diff( $sub['codes'], $continent['codes'] )
			);
			$this->assertCount( 1, $parents, "Sub-region {$key} is not wholly inside exactly one continent." );
		}
	}

	public function test_m49_intermediate_regions_do_not_overlap_and_nest_inside_a_sub_region(): void {
		$seen = array();
		$subs = $this->groups_in( 'm49-sub-regions' );
		foreach ( $this->groups_in( 'm49-intermediate-regions' ) as $key => $group ) {
			foreach ( $group['codes'] as $code ) {
				$this->assertArrayNotHasKey( $code, $seen, "{$code} is in both {$key} and " . ( $seen[ $code ] ?? '' ) . '.' );
				$seen[ $code ] = $key;
			}
			$parents = array_filter( $subs, static fn( $sub ) => array() === array_diff( $group['codes'], $sub['codes'] ) );
			$this->assertCount( 1, $parents, "Intermediate region {$key} is not wholly inside one sub-region." );
		}
	}

	public function test_sanctions_groups_never_include_ukraine_or_syria_on_the_ofac_list(): void {
		foreach ( $this->groups_in( 'sanctions' ) as $key => $group ) {
			$this->assertNotContains( 'UA', $group['codes'], "{$key} must not over-block Ukraine for Crimea/DNR/LNR." );
			$this->assertStringContainsString( 'Crimea', $group['note'] );
		}
		$this->assertEqualsCanonicalizing( array( 'CU', 'IR', 'KP' ), $this->codes_of( 'us-ofac-comprehensive' ) );
	}

	public function test_by_category_returns_every_group_once_in_category_order(): void {
		$flattened = array();
		foreach ( Country_Groups::by_category() as $category => $entry ) {
			$this->assertArrayHasKey( $category, Country_Groups::categories() );
			foreach ( array_keys( $entry['groups'] ) as $key ) {
				$flattened[] = $key;
			}
		}
		$this->assertSame( array_keys( Country_Groups::all() ), $flattened );
	}

	/**
	 * Every country except M49_UNASSIGNED is in exactly one group of the category.
	 */
	private function assert_partition( string $category, int $expected_groups ): void {
		$groups = $this->groups_in( $category );
		$this->assertCount( $expected_groups, $groups );

		$owner = array();
		foreach ( $groups as $key => $group ) {
			foreach ( $group['codes'] as $code ) {
				$this->assertArrayNotHasKey( $code, $owner, "{$code} is in both {$key} and " . ( $owner[ $code ] ?? '' ) . '.' );
				$owner[ $code ] = $key;
			}
		}

		$expected = array_diff( array_keys( Iso_Countries::all() ), Country_Groups::M49_UNASSIGNED );
		$this->assertEqualsCanonicalizing( array_values( $expected ), array_keys( $owner ) );
	}
}
