<?php
declare(strict_types=1);

namespace Fc2blog\Tests\App\Model\BlogsModel;

use Fc2blog\Model\BlogsModel;
use PHPUnit\Framework\TestCase;

class GetSchemaByBlogIdTest extends TestCase
{
  public function testGetSchemaByBlogIdTest(): void
  {
    $this->assertEquals('https:', BlogsModel::getSchemaByBlogId('testblog1'));
    $this->assertEquals('http:', BlogsModel::getSchemaByBlogId('testblog2'));
  }
}
