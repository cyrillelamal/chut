<?php

namespace Tests\Unit;

use App\Models\Participation;
use App\Models\User;
use App\Policies\ConversationPolicy;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ConversationPolicyTest extends TestCase
{
    use DatabaseTransactions;

    public function test_read_ability()
    {
        /** @var ConversationPolicy $policy */
        $policy = app(ConversationPolicy::class);

        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();
        /** @var Participation $participation */
        $participation = $user->participations->random();

        $this->assertTrue($policy->read($user, $participation->conversation));

        /** @var User $malicious */
        $malicious = User::factory()->create();

        $this->assertFalse($policy->read($malicious, $participation->conversation));
    }

    public function test_post_ability()
    {
        /** @var ConversationPolicy $policy */
        $policy = app(ConversationPolicy::class);

        /** @var User $user */
        $user = User::query()->inRandomOrder()->first();
        /** @var Participation $participation */
        $participation = $user->participations->random();

        $this->assertTrue($policy->read($user, $participation->conversation));

        /** @var User $malicious */
        $malicious = User::factory()->create();

        $this->assertFalse($policy->read($malicious, $participation->conversation));
    }
}
