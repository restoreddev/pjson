<?php

namespace Pjson\Tests;

use Pjson\Renderer;

class RendererTest extends \PHPUnit\Framework\TestCase
{
    public function test_it_can_render_template()
    {
        $renderer = new Renderer('tests/');
        
        $movies = ['Gone with the Wind', 'Ben Hur', 'Casablanca'];
        $result = $renderer->render('testTemplate.php', [
            'movies' => $movies
        ]);

        $decode = json_decode($result);

        $this->assertEquals($decode->greeting, 'Hello World!');
        $this->assertEquals($decode->classic_movies[0]->name, $movies[0]);
        $this->assertEquals($decode->classic_movies[1]->name, $movies[1]);
        $this->assertEquals($decode->classic_movies[2]->name, $movies[2]);
    }
}
