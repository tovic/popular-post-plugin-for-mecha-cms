<?php

// Load the configuration data ...
$popular_post_config = File::open(PLUGIN . DS . File::B(__DIR__) . DS . 'states' . DS . 'config.txt')->unserialize();

Widget::add('popularPost', function() use($config, $popular_post_config) {
    $html = "";
    $T1 = TAB;
    $T2 = str_repeat(TAB, 2);
    $T3 = str_repeat(TAB, 3);
    $T4 = str_repeat(TAB, 4);
    $T5 = str_repeat(TAB, 5);
    $speak = Config::speak();
    $stats = array();
    foreach(glob(PLUGIN . DS . 'page-views-counter' . DS . 'assets' . DS . 'cargo' . DS . 'articles' . DS . '*.txt', GLOB_NOSORT) as $stat) {
        $stats[File::N($stat)] = (int) File::open($stat)->get(1);
    }
    natsort($stats);
    $stats = array_reverse($stats);
    $html = O_BEGIN . '<div class="widget widget-popular widget-popular-post widget-popular-post-' . Text::parse($popular_post_config['kind'], '->slug') . '"' . (count($stats) ? ' id="widget-popular-post-' . (Config::get('popular_post', 0) + 1) . '"' : "") . '>' . NL;
    include PLUGIN . DS . File::B(__DIR__) . DS . 'workers' . DS . $popular_post_config['kind']. '.php';
    return $html . '</div>' . O_END;
});

Weapon::add('shell_after', function() {
    echo Asset::stylesheet('cabinet/plugins/' . File::B(__DIR__) . '/assets/shell/widget.css');
});