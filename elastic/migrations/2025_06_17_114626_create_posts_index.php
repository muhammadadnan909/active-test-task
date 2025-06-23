<?php
declare(strict_types=1);

use ElasticAdapter\Indices\Mapping;
use ElasticAdapter\Indices\Settings;
use ElasticMigrations\Facades\Index;
use ElasticMigrations\MigrationInterface;

final class CreatePostsIndex implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Index::createIfNotExists('posts', function (Mapping $mapping, Settings $settings) {

             $settings->analysis([
                'analyzer' => [
                    'default' => [
                        'type' => 'standard',
                    ],
                ],
            ]);
            $mapping->long('id');
            $mapping->long('user_id');
            $mapping->text('title', [
                'fields' => [
                    'keyword' => [
                        'type' => 'text',
                        'analyzer' => 'standard',
                    ],
                ],
            ]);
            $mapping->text('content');

            $mapping->date('created_at', [
                'format' => 'yyyy-MM-dd HH:mm:ss||strict_date_optional_time||epoch_millis',
            ]);
            $mapping->date('updated_at', [
                'format' => 'yyyy-MM-dd HH:mm:ss||strict_date_optional_time||epoch_millis',
            ]);
        });


    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        //
        Index::dropIfExists('posts');

    }
}
