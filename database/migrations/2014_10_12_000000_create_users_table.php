<?php

use App\Services\UserSearch\Exception\CannotCreateCollectionException;
use App\Services\UserSearch\UserSearchInterface;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws CannotCreateCollectionException
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        try {
            $this->dropIndexCollection();
        } catch (Exception) {
        }
        $this->createIndexCollection();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropIndexCollection();
        Schema::dropIfExists('users');
    }

    /**
     * @throws CannotCreateCollectionException
     */
    private function createIndexCollection(): void
    {
        $this->getSearchEngine()->createCollection();
    }

    private function dropIndexCollection(): void
    {
        $this->getSearchEngine()->dropCollection();
    }

    private function getSearchEngine(): UserSearchInterface
    {
        return app(UserSearchInterface::class);
    }
}
