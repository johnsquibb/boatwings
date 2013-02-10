<?php
require_once __DIR__ . '/FrameworkTest.php';

use Application\Website\MyPage;

// Expected output strings used in tests.
$expectedOutputForTestMyPage = <<<END
<html>
  <head></head>
  <body>
    <p>Condition A was met.</p>
  </body>
</html>
END;

class WebsiteTest extends FrameworkTest 
{
  public function testMyPage()
  {
    global $expectedOutputForTestMyPage;
    
    // Capture output from page.
    ob_start();
    $myPage = new MyPage();
    $myPage->myPageAsPhp(array());
    
    $this->assertEquals(ob_get_clean(), $expectedOutputForTestMyPage);
  }
}