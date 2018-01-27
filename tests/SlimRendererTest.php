<?php

namespace Pjson\Tests;

use Pjson\SlimRenderer;
use Slim\Http\Headers;
use Slim\Http\Body;
use Slim\Http\Response;

class SlimRendererTest extends \PHPUnit\Framework\TestCase
{
    public function test_it_can_render_template()
    {
        $headers = new Headers();
        $body = new Body(fopen('php://temp', 'r+'));
        $response = new Response(200, $headers, $body);
        $renderer = new SlimRenderer('tests/');
        
        $movies = ['Gone with the Wind', 'Ben Hur', 'Casablanca'];
        $newResponse = $renderer->render($response, 'testTemplate.php', [
            'movies' => $movies
        ]);

        $newResponse->getBody()->rewind();
        $decode = json_decode($newResponse->getBody());

        $this->assertEquals($decode->greeting, 'Hello World!');
        $this->assertEquals($decode->classic_movies[0]->name, $movies[0]);
        $this->assertEquals($decode->classic_movies[1]->name, $movies[1]);
        $this->assertEquals($decode->classic_movies[2]->name, $movies[2]);
    }
}
