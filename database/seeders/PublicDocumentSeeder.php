<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PublicDocument;

class PublicDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure the directory exists
        if (!file_exists(storage_path('app/public/documents'))) {
            mkdir(storage_path('app/public/documents'), 0755, true);
        }

        // Define files
        $files = [
            [
                'title' => 'SK Tarif Layanan Penunjang Akademik',
                'description' => 'Surat Keputusan Rektor mengenai tarif layanan penunjang akademik di lingkungan Universitas Mulawarman.',
                'filename' => 'sk_tarif_layanan.pdf',
                'color' => 'blue',
                'icon' => 'pdf',
                'sort_order' => 1
            ],
            [
                'title' => 'SK Rektor No. 999/UN17/HK/2025',
                'description' => 'Peraturan Rektor Universitas Mulawarman Nomor 999 Tahun 2025 tentang Penyelenggaraan Layanan.',
                'filename' => 'sk_rektor_un17.pdf',
                'color' => 'green',
                'icon' => 'pdf',
                'sort_order' => 2
            ]
        ];

        foreach ($files as $file) {
            $source = public_path('files/' . $file['filename']);
            $destination = storage_path('app/public/documents/' . $file['filename']);

            echo "Checking source: " . $source . "\n";
            
            if (file_exists($source)) {
                // Copy file to storage
                copy($source, $destination);
                echo "Copied to: " . $destination . "\n";
                
                // Create record
                PublicDocument::create([
                    'title' => $file['title'],
                    'description' => $file['description'],
                    'file_path' => 'public/documents/' . $file['filename'],
                    'color' => $file['color'],
                    'icon' => $file['icon'],
                    'is_active' => true,
                    'sort_order' => $file['sort_order'],
                ]);
            } else {
                 echo "Source file not found: " . $source . "\n";
            }
        }
    }
}
