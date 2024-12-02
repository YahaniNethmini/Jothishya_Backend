<?php

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
        Schema::create('astrologers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Personal Information
            $table->string('name');
            $table->string('email');
            $table->string('contact_no', 15);
            $table->string('gender');
            $table->datetime('birth_date');
            $table->string('primary_skill');
            $table->string('all_skill');
            $table->string('language_known');
            $table->string('profile_image')->nullable();
            $table->text('bio')->nullable();

            // Address Information
            $table->text('current_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('pincode', 20)->nullable();

            // Professional Information
            $table->integer('experience_years');
            $table->string('qualification')->nullable();
            $table->json('specialities')->nullable();
            $table->json('languages')->nullable();
            $table->text('certification_details')->nullable();

            // Service Related
            $table->decimal('chat_rate', 10, 2)->default(0);
            $table->decimal('call_rate', 10, 2)->default(0);
            $table->decimal('video_call_rate', 10, 2)->default(0);
            $table->decimal('report_rate', 10, 2)->default(0);
            $table->decimal('commission_rate', 5, 2)->default(0);
            $table->enum('availability_status', ['online', 'offline', 'busy'])->default('offline');

            // Social Media Links
            $table->string('website_link')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('linkedin_link')->nullable();

            // Verification and Status
            $table->boolean('is_verified')->default(false);
            $table->datetime('verification_date')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->text('rejection_reason')->nullable();
            $table->enum('account_status', ['pending', 'active', 'suspended', 'blocked'])->default('pending');

            // Wallet Information
            $table->decimal('wallet_balance', 10, 2)->default(0);
            $table->decimal('total_earned', 10, 2)->default(0);
            $table->datetime('last_withdrawal')->nullable();

            // System Fields
            $table->boolean('is_active')->default(true);
            $table->boolean('is_delete')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('astrologers');
    }
};
