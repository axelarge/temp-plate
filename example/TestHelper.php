<?php
use Axelarge\TempPlate\Helpers\Helper;

class TestHelper extends Helper
{
    public function input($name, $value = '')
    {
        return "<input type=\"text\" name=\"{$name}\" value=\"{$value}\">";
    }
}
