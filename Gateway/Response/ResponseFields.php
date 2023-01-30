<?php

declare(strict_types=1);

namespace Silin\Authorizenet\Gateway\Response;

interface ResponseFields
{
    public const TRANSACTION_RESPONSE = 'transactionResponse';
    public const RESPONSE_CODE = 'responseCode';
    public const AUTH_CODE = 'authCode';
    public const AVS_RESULT_CODE = 'avsResultCode';
    public const CVV_RESULT_CODE = 'cvvResultCode';
    public const CAVV_RESULT_CODE = 'cavvResultCode';
    public const TRANSACTION_ID = 'transId';
    public const REF_TRANSACTION_ID = 'refTransID';
    public const TRANSACTION_HASH = 'transHash';
    public const TEST_REQUEST = 'testRequest';
    public const ACCOUNT_NUMBER = 'accountNumber';
    public const ACCOUNT_TYPE = 'accountType';
    public const MESSAGES = 'messages';
    public const MESSAGE_CODE = 'code';
    public const MESSAGE_DESCRIPTION = 'description';
    public const TRANSACTION_HASH_SH2 = 'transHashSha2';
    public const REFERENCE_ID = 'refId';
}
