<?php
declare(strict_types=1);

namespace Fc2blog\Tests\App\Core\Html;

use Fc2blog\Tests\LoaderHelper;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
  public function setUp(): void
  {
    LoaderHelper::requireBootStrap();
    require_once(TEST_APP_DIR . "/core/html.php");
    require_once(TEST_APP_DIR . "/core/app.php");

    # 擬似的にアクセスURLをセットする
    $_SERVER['HTTP_USER_AGENT'] = "phpunit";
    $_SERVER['HTTPS'] = "on";
    $_SERVER["REQUEST_METHOD"] = "GET";
    $_SERVER['REQUEST_URI'] = "/";
    $_POST = [];

    # Requestはキャッシュされるので、都度消去する
    /** @noinspection PhpFullyQualifiedNameUsageInspection */
    \Request::resetInstanceForTesting();

    /** @noinspection PhpIncludeInspection */
    require_once(\Config::get('MODEL_DIR') . 'model.php');
    if (!class_exists(\BlogsModel::class)) {
      \Model::load('blogs');
    }

    parent::setUp();
  }

  public function testNotFullUrl()
  {
    # 擬似的にアクセスURLをセットする
    $_SERVER['HTTP_USER_AGENT'] = "phpunit";
    $_SERVER['HTTPS'] = "on";
    $_SERVER["REQUEST_METHOD"] = "GET";
    $_SERVER['REQUEST_URI'] = "/";
    $_POST = [];
    $url = \Html::url([
      'controller' => 'test',
      'action' => 'action',
      'blog_id' => 'testblog1'
    ], false, false);
    $this->assertStringStartsWith('/', $url);
    $this->assertStringNotContainsString('http', $url);
  }

  public function testFullUrl()
  {
    # 擬似的にアクセスURLをセットする
    $_SERVER['HTTP_USER_AGENT'] = "phpunit";
    $_SERVER['HTTPS'] = "on";
    $_SERVER["REQUEST_METHOD"] = "GET";
    $_SERVER['REQUEST_URI'] = "/";
    $_POST = [];
    $url = \Html::url([
      'controller' => 'test',
      'action' => 'action',
      'blog_id' => 'testblog1'
    ], false, true);
    $this->assertStringStartsWith('https://', $url);
  }

}
