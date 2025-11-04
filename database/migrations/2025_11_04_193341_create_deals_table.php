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
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cus_company_key')->nullable()->default(null);
            $table->unsignedBigInteger('cus_contact_key')->nullable()->default(null);
            $table->nullableMorphs('deal_owner');

            $table->string('name')->nullable()->default(null);;
            
            $table->unsignedBigInteger('deal_stage')->nullable()->default(null);

            $table->decimal('amount', 16, 2)->nullable()->default(0.00);

            $table->date('start_date')->nullable()->default(now()->addDay());
            $table->date('close_date')->nullable()->default(now()->addDay());
            $table->string('deal_type')->nullable()->default(null);
            $table->string('priority')->nullable()->default(null);
            $table->unsignedBigInteger('services')->nullable()->default(null);
            $table->boolean('is_contact_start_date')->nullable()->default(false);
            $table->date('contact_start_date')->nullable()->default(now()->addDay());
            $table->boolean('is_company_start_date')->nullable()->default(false);
            $table->date('company_start_date')->nullable()->default(now()->addDay());
            $table->nullableMorphs('creator');
            $table->integer('status')->nullable()->default(1)->comment('0 = inactive, 1 = active');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('cus_company_key')->references('special_key')->on('customer_companies')->onDelete('NO ACTION');
            $table->foreign('cus_contact_key')->references('special_key')->on('customer_contacts')->onDelete('NO ACTION');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
