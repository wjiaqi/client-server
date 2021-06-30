<?php
declare (strict_types=1);
/**
 * @copyright 安巽
 * @version   1.0.0
 * @link
 */

namespace App\JsonRpc\Contract;

/**
 * TestServiceInterface
 *
 * @author  小琪(991010625.com)
 * @package App\JsonRpc\Contract
 */
interface TestServiceInterface
{
    public function check(int $id, int $num): int;
}