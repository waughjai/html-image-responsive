<?php

declare( strict_types = 1 );
namespace WaughJ\HTMLImageResponsive
{
	use WaughJ\HTMLImage\HTMLImage;
	use WaughJ\FileLoader\FileLoader;

	class HTMLImageResponsive extends HTMLImage
	{
		public function __construct( string $base_url, string $extension, array $sizes, FileLoader $loader = null, array $other_attributes = [] )
		{
			$srcset = self::generateSrcSet( $base_url, $extension, $sizes );
			if ( $srcset !== '' )
			{
				$other_attributes[ 'srcset' ] = $srcset;
			}
			$sizes_attribute = self::generateSizesAttribute( $sizes );
			if ( $sizes_attribute !== '' )
			{
				$other_attributes[ 'sizes' ] = $sizes_attribute;
			}
			parent::__construct( "{$base_url}.{$extension}", $loader, $other_attributes );
		}

		private static function generateSrcSet( string $base_url, string $extension, array $sizes ) : string
		{
			$srcset_list = [];
			foreach ( $sizes as $size )
			{
				$srcset_list[] = "{$base_url}-{$size[ 'w' ]}x{$size[ 'h' ]}.{$extension} {$size[ 'w' ]}w";
			}
			return ( !empty( $srcset_list ) ) ? implode( ', ', $srcset_list ) : '';
		}

		private static function generateSizesAttribute( array $sizes ) : string
		{
			$srcset_list = [];
			$size_count = count( $sizes );
			for ( $i = 0; $i < $size_count; $i++ )
			{
				$size = $sizes[ $i ];

				// Last entry, just show width in pixels;
				// else, add (max-width) media query.
				$srcset_list[] = ( $i === $size_count - 1 )
					? "{$size[ 'w' ]}px"
					: "(max-width:{$size[ 'w' ]}px) {$size[ 'w' ]}px";
			}
			return ( !empty( $srcset_list ) ) ? implode( ', ', $srcset_list ) : '';
		}
	}
}
