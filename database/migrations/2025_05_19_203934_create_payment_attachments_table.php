<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('payment_attachments')) {
            Schema::create('payment_attachments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('invoice_key')->nullable()->default(null);
                $table->string('email')->nullable()->default(null);
                $table->string('payment_method')->nullable()->default(null);
                $table->string('transaction_reference')->nullable()->default(null);
                $table->date('payment_date')->nullable()->default(null);
                $table->decimal('amount', 10, 2)->nullable()->default(null);
                $table->json('attachments')->nullable()->default(null);
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->text('rejection_reason')->nullable()->default(null);
                $table->text('notes')->nullable()->default(null);
                $table->foreignId('reviewed_by')->nullable()->default(null)->constrained('users')->onDelete('NO ACTION');
                $table->timestamp('reviewed_at')->nullable()->default(null);
                $table->ipAddress()->nullable()->default(null);
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('invoice_key')->references( 'invoice_key')->on('invoices')->onDelete('NO ACTION');

            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_attachments', function (Blueprint $table) {
            if (Schema::hasColumn('payment_attachments', 'invoice_key')) {
                $table->dropForeign(['invoice_key']);
                $table->dropColumn('invoice_key');
            }
        });
        Schema::dropIfExists('payment_attachments');
    }
};
