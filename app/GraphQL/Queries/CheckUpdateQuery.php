<?php

namespace App\GraphQL\Queries;

class CheckUpdateQuery
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $isAvailable = false;
        $isRequired = false;

        if (isset($args['version']) && $args['version'] != setting('app.latest_app_version')) {
            $isAvailable = true;
            if(setting('app.minimum_app_version') && $args['version'] < setting('app.minimum_app_version')) {
                $isRequired = true;
            }
        }
        
        return (object) [
            'available' => $isAvailable,
            'required' => $isRequired,
            'latest' => setting('app.latest_app_version'),
            'url' => route('app.download'),
        ];
    }
}
