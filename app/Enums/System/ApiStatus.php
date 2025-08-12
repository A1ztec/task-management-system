<?php


namespace App\Enums\System;


  enum ApiStatus : string
{
  case SUCCESS = 'success';
  case ERROR = 'error';

  case VALIDATION_FAILED = 'validation_failed',

  case UNAUTHORIZED = 'unauthorized';

  case NOT_FOUND = 'not_found';



  public function message() : string
  {
      return match ($this){

        self::SUCCESS => __('Request Successful'),
        self::ERROR => __('Error Accurred'),
        self::VALIDATION_FAILED => __('Validation Failed'),
        self::UNAUTHORIZED => __('Unauthorized Access'),
        self::NOT_FOUND => __('Resource Not Found')
    };
  }


  public static function options() : array
  {
       return collect(self::cases())->mapWithKeys(fn($item) => [$item->value => $item->message()])->toArray()
  }

}
