<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 24.01.2017
 * Time: 20:35
 */

namespace RT\Client;


use RT\Enum\AbstractEnum;
/**
 * @method static Placement PRE_BODY()
 * @method static Placement BODY()
 * @method static Placement POST_BODY()
 * @method static Placement CONNECT_CALLBACK()
 * @method static Placement RE_CONNECT_CALLBACK()
 * @method static Placement RE_CONNECT_CALLBACK_URL()
 * @method static Placement DEFAULT()
 */
class Placement extends AbstractEnum
{

    const PRE_BODY = "pre-body";
    const BODY = "in-body";
    const POST_BODY = "post-body";
    const CONNECT_CALLBACK = "connect-callback";
    const RE_CONNECT_CALLBACK = "re-connect-callback";
    const RE_CONNECT_CALLBACK_URL = "re-connect-callback-url";
    const DEFAULT = "default";

}