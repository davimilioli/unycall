<?php
spl_autoload_register(function ($classe) {
    $caminho = 'classes/' . $classe . '.php';

    require $caminho;
});
