<?php

$pjson->greeting = 'Hello World!';
$pjson->classic_movies($movies, function ($pjson, $movie) {
    $pjson->name = $movie;
});
