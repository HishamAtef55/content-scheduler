<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('title');
            $table->text('content');
            // $table->string('image_url')->nullable(); // Assuming image_url is not required for now but we also can use spatie/media-library
            $table->dateTime('scheduled_time');
            // $table->enum('status', ['draft', 'scheduled', 'published'])->default('draft');
            $table->string('status')->nullable();
            $table->foreignIdFor(User::class)->constrained();
            $table->dateTime('scheduled_at')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_posts');
    }
};
