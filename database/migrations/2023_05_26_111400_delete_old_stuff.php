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
        if (!Schema::hasColumn('agenda_elements', 'booking_request_id'))
        {
            Schema::table('agenda_elements', function (Blueprint $table)
            {
                $table->unsignedBigInteger('booking_request_id')->nullable()->default(null)->change();
            });
        }

        Schema::dropIfExists('partner_balance_events');
        Schema::dropIfExists('invoice_lines');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('mail_user');
        Schema::dropIfExists('mail_messages');
        Schema::dropIfExists('mails');
        Schema::dropIfExists('estimate_elements');
        Schema::dropIfExists('offer_elements');
        Schema::dropIfExists('offers');
        Schema::dropIfExists('subscription_items');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('discounts');
        Schema::dropIfExists('estimate_activity');
        if(Schema::hasTable('blog_categorys'))
        {
            Schema::rename('blog_categorys', 'blog_categories');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
