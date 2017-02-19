<?php
/**
 * @file
 * @license https://opensource.org/licenses/Apache-2.0 Apache-2.0
 */

namespace Wikimedia\CSS\Grammar;

use Wikimedia\CSS\Objects\ComponentValueList;
use Wikimedia\CSS\Objects\CSSFunction;
use Wikimedia\CSS\Objects\SimpleBlock;
use Wikimedia\CSS\Objects\Token;

/**
 * @covers \Wikimedia\CSS\Grammar\NothingMatcher
 */
class NothingMatcherTest extends MatcherTestBase {

	public function testStandard() {
		$matcher = new NothingMatcher( Token::T_IDENT );
		$generateMatches = $this->getGenerateMatches( $matcher );

		$ws = new Token( Token::T_WHITESPACE );
		$tok = new Token( Token::T_IDENT, 'foo' );
		$block = SimpleBlock::newFromDelimiter( '{' );
		$func = CSSFunction::newFromName( 'foo' );

		$list = new ComponentValueList( [ $ws, $tok, $func, $ws, $ws, $tok, $block, $tok, $func, $ws ] );

		$options = [ 'skip-whitespace' => true ];
		$l = $list->count();
		for ( $i = 0; $i <= $l; $i++ ) {
			$this->assertPositions( $i, [], $generateMatches( $list, $i, $options ),
				"Skipping whitespace, index $i" );
		}
	}
}
