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
            'file_has_new_lists',
            function (Blueprint $table) {
                $table->id();
                $table->bigInteger('file_id')->unsigned();
                $table->bigInteger('new_list_id')->unsigned();
                $table->timestamps();

                $table->foreign('file_id')
                    ->references('id')->on('files')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();

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
        Schema::dropIfExists('file_has_new_lists');
    }
};
