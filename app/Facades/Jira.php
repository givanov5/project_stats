<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 04.10.18
 * Time: 16:40
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Jira extends Facade
{
  /**
   * Get the registered name of the component.
   *
   * @return string
   *
   * @throws \RuntimeException
   */
  protected static function getFacadeAccessor()
  {
    return \App\Helpers\Jira::class;
  }
}
