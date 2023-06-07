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
        Schema::create(
            'ratings', function (Blueprint $table) {
            $table->id();
            $table->enum(
                'rating', [
                0,
                1,
            ]
            );
            $table->bigInteger('new_list_id')->unsigned();
            $table->timestamps();

            $table->foreign('new_list_id')
                ->references('id')->on('new_lists')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
