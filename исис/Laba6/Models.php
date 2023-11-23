<?php
require 'db.php';

class Model
{
    public $id;
    public $name;
}

R::ext('xdispense', function ($type) {
    return R::getRedBean()->dispense($type);
});

R::ext('xload', function ($type, $id) {
    return R::getRedBean()->load($type, $id);
});

R::ext('xstore', function ($bean) {
    return R::getRedBean()->store($bean);
});

R::ext('xtrash', function ($bean) {
    return R::getRedBean()->trash($bean);
});