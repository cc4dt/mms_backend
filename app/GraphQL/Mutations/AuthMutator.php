<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\FcmToken;

class AuthMutator
{

    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function login($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $input = (object) $args['input'];
        $user = User::where('email',$input->email)->first();

        if (!$user || !Hash::check($input->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $fcmToken = FcmToken::where('token', $input->fcmToken)->first();
        if($fcmToken) {
            $fcmToken->update([
                "device_name" => $input->deviceName,
                "device_type" => 1,// $input->deviceType,
                "user_id" => $user->id,
            ]);
        } else {
            FcmToken::create([
                "token" => $input->fcmToken,
                "device_name" => $input->deviceName,
                "device_type" => 1,// $input->deviceType,
                "user_id" => $user->id,
            ]);
        }

        $token = $user->createToken($input->deviceName)->plainTextToken;

        return (object) [
            "tokenType" => "Bearer", 
            "token" => $token, 
            "deviceName" => $input->deviceName,
            "me" => $user
        ];
    }
    
    public function changePassword($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if($args['confirm_password'] == $args["new_password"]) {
            $user = User::find(Auth::id());
            if(Hash::check($args["old_password"], $user->password)) {
                if($user->update(["password" => Hash::make($args['new_password'])])) {
                    return true;
                }
            }
        }
        return false;
    }
    
}