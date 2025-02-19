<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEdocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edocs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            /*
                id
                date_created
                created_by
                category_id
                status
                document_name
                filtered_document_name
                page_count
                remarks
                approval_order
                view_access_users
                dcc_status
                updated_at
                username
                deleted_at
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('edocs');
    }
}
