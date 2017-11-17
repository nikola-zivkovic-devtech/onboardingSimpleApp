<?php
/**
 * Created by PhpStorm.
 * User: nikola.zivkovic
 * Date: 10-Nov-17
 * Time: 14:02
 */

namespace FurnitureStore\Controllers;


class WelcomeController
{
    public function hi()
    {
        print_r("<i>Simple CRUD App</i> welcome page.<br>This is our furniture store.");
    }
}