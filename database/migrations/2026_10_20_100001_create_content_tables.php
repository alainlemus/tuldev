<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('tag')->nullable();
            $table->string('icon')->default('codigo');
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->json('tags')->nullable();
            $table->string('badge')->nullable();
            $table->string('scroll_image')->nullable();
            $table->string('scroll_alt')->nullable();
            $table->unsignedSmallInteger('scroll_duration')->default(18);
            $table->smallInteger('scroll_delay')->default(0);
            $table->string('url')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('apps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('status')->default('en_desarrollo');
            $table->string('app_store_url')->nullable();
            $table->string('google_play_url')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('technologies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->unsignedTinyInteger('row')->default(1);
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('business')->nullable();
            $table->string('whatsapp', 20);
            $table->string('email')->nullable();
            $table->string('type');
            $table->text('message')->nullable();
            $table->string('status')->default('nuevo')->index();
            $table->text('notes')->nullable();
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['leads', 'technologies', 'apps', 'projects', 'services'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
