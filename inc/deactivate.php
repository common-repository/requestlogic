<?php
/**
 * @package requestlogic
 */

class RequestLogicDeactivate{
    public static function deactivate(){
       flush_rewrite_rules();
    }
}