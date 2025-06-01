    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up()
        {
            // Drop the existing table if it exists
            Schema::dropIfExists('reviews');

            // Create the table fresh with all columns
            Schema::create('reviews', function (Blueprint $table) {
                $table->id();
                $table->foreignId('project_id')->constrained()->onDelete('cascade');
                $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('freelancer_id')->constrained('users')->onDelete('cascade');
                $table->integer('rating')->comment('1-5 rating');
                $table->string('title')->nullable();
                $table->text('comment');
                $table->boolean('is_public')->default(true);
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('reviews');
        }
    };
