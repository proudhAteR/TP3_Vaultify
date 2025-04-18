<?php

function login(string $title) : bool {
    return strcasecmp($title, 'Login') === 0;
}