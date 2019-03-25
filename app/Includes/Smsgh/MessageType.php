<?php

namespace App\Includes\Smsgh;

/**
 * Description of MessageType
 *
 * @author Arsene Tochemey GANDOTE
 */
abstract class MessageType extends Enum {

    const TEXT_MESSAGE = 0;
    const BINARY_MESSAGE = 1;
    const UNICODE_MESSAGE = 2;

}
