<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Tests\CacheClearer;

use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Bridge\PhpUnit\ForwardCompatTestTrait;
use Symfony\Component\HttpKernel\CacheClearer\Psr6CacheClearer;

class Psr6CacheClearerTest extends TestCase
{
    use ForwardCompatTestTrait;

    public function testClearPoolsInjectedInConstructor()
    {
        $pool = $this->getMockBuilder(CacheItemPoolInterface::class)->getMock();
        $pool
            ->expects($this->once())
            ->method('clear');

        (new Psr6CacheClearer(['pool' => $pool]))->clear('');
    }

    public function testClearPool()
    {
        $pool = $this->getMockBuilder(CacheItemPoolInterface::class)->getMock();
        $pool
            ->expects($this->once())
            ->method('clear');

        (new Psr6CacheClearer(['pool' => $pool]))->clearPool('pool');
    }

    public function testClearPoolThrowsExceptionOnUnreferencedPool()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Cache pool not found: unknown');
        (new Psr6CacheClearer())->clearPool('unknown');
    }
}
