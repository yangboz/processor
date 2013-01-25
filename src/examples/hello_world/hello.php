<?
require("Toro.php");

$hello = new HelloHandler();

class HelloHandler {
    public function HelloHandler()
    {
        echo "HelloHandler";
    }
    function get() {
      echo "Hello, world";
    }
}
Toro::serve(array(
    "/" => "HelloHandler"
));