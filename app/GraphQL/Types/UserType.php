<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use App\User;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'Details about a wine',
        'model' => User::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of the wine',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the wine',
            ],
        ];
    }
}