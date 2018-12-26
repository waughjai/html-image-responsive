<?php

use PHPUnit\Framework\TestCase;
use WaughJ\HTMLImageResponsive\HTMLImageResponsive;
use WaughJ\FileLoader\FileLoader;

class HTMLImageResponsiveTest extends TestCase
{
	public function testBasicResponsiveImage()
	{
		$image = new HTMLImageResponsive( 'poodle', 'png', [ [ 'w' => '224', 'h' => '480' ], [ 'w' => '448', 'h' => '960' ], [ 'w' => '896', 'h' => '1920' ] ], new FileLoader([ 'directory-url' => 'http://localhost/slider', 'shared-directory' => 'img' ]) );
		$this->assertContains( ' src="http://localhost/slider/img/poodle.png"', $image->getHTML() );
		$this->assertContains( ' alt=""', $image->getHTML() );
		$this->assertContains( ' srcset="http://localhost/slider/img/poodle-224x480.png 224w, http://localhost/slider/img/poodle-448x960.png 448w, http://localhost/slider/img/poodle-896x1920.png 896w"', $image->getHTML() );
		$this->assertContains( ' sizes="(max-width:224px) 224px, (max-width:448px) 448px, 896px"', $image->getHTML() );
	}
}
