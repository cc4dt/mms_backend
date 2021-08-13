<?php

namespace App\GraphQL\Subscriptions;


// use App\User;
// use App\Tikect;

// use Illuminate\Http\Request;
// use Nuwave\Lighthouse\Schema\Types\GraphQLSubscription;
// use Nuwave\Lighthouse\Subscriptions\Subscriber;
// use Illuminate\Support\Str;
// use GraphQL\Type\Definition\ResolveInfo;
// use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

// class TikectAdded extends GraphQLSubscription
// {
//     /**
//      * Check if subscriber is allowed to listen to the subscription.
//      *
//      * @param  \Nuwave\Lighthouse\Subscriptions\Subscriber  $subscriber
//      * @param  \Illuminate\Http\Request  $request
//      * @return bool
//      */
//     public function authorize(Subscriber $subscriber, Request $request): bool
//     {
//         $user = $subscriber->context->user;

//         return true;
//     }

//     /**
//      * Filter which subscribers should receive the subscription.
//      *
//      * @param  \Nuwave\Lighthouse\Subscriptions\Subscriber  $subscriber
//      * @param  mixed  $root
//      * @return bool
//      */
//     public function filter(Subscriber $subscriber, $root): bool
//     {
//         $user = $subscriber->context->user;

//         // Don't broadcast the subscription to the same
//         // person who updated the post.
//         return $root->create_by !== $user->id;
//     }

//     public function resolve($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): Post
//     {
//         // Optionally manipulate the `$root` item before it gets broadcasted to
//         // subscribed client(s).

//         return $root;
//     }
// }