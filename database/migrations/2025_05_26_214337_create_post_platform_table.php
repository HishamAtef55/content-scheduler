<?php

use App\Models\Post;
use App\Enums\Status;
use App\Models\Platform;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {   
        
        /*
            * i think we don't need this table we can store the same post many time per every platform 
            * that's will be helpful for managing and tracking
         */

        Schema::create('post_platform', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Post::class)->constrained();
            $table->foreignIdFor(Platform::class)->constrained();
            $table->string('platform_status')->default(Status::PENDING->value);
            $table->timestamps();
            $table->unique(['post_id', 'platform_id'], 'post_platform_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_platform');
    }
};
