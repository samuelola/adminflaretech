<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\ArtistOwnerSong;
use App\Models\ArtistCatalogOwnershipSubmit;


class DSPSubmissionService
{

    public function processSubmission($artistOwnerId)
    {

        //prevent double submission
        $double_sub = ArtistCatalogOwnershipSubmit::where([
            'artist_ownership_identity_id' => $artistOwnerId,
            'metadata_created'=> 1
        ])->first();

        if($double_sub){
           
            throw new \Exception("Metadata already created");
        }
        
        $submissions = ArtistCatalogOwnershipSubmit::where([
            'artist_ownership_identity_id' => $artistOwnerId,
            'is_submitted' => 1
        ])->get();

        if ($submissions->isEmpty()) {
            throw new \Exception("No submissions found");
        }

    
        foreach ($submissions as $submission) {

            
            $songs = ArtistOwnerSong::where('artist_ownership_identity_id', $submission->artist_ownership_identity_id)
                ->with('contributors')
                ->get();

            if ($songs->isEmpty()) continue;

            $baseFolder = "catalog_submissions/{$artistOwnerId}/{$submission->id}";
            $count = 1;

            foreach ($songs as $song) {

                if (!$song->file_path) continue;

                $songFolder = $baseFolder . '/song_' . $count;
                $count++;

                $audioUrl = config('services.external_url.website_storage_link') . '/storage/' . $song->file_path;

                $tempFile = tempnam(sys_get_temp_dir(), 'song_');

                $metaTemp = null;

                try {

                    // DOWNLOAD AUDIO
                    $audioResponse = Http::timeout(60)->get($audioUrl);

                    if (!$audioResponse->successful()) {
                        \Log::error("Audio download failed", ['url' => $audioUrl]);
                        continue;
                    }

                    file_put_contents($tempFile, $audioResponse->body());

                    $extension = pathinfo($song->file_path, PATHINFO_EXTENSION);

                    $metadata = [
                        'title' => $song->title,
                        'artist_name' => $song->artist_name,
                        'release_year' => $song->release_year,
                        'genre' => $song->genre,
                        'duration' => $song->duration,
                        'distribution_status' => $song->distribution_status,
                        'links' => [
                            'spotify' => $song->spotify_link,
                            'apple' => $song->apple_link,
                            'audiomack' => $song->audiomack_link,
                            'youtube' => $song->youtube_link,
                        ],
                        'contributors' => $song->contributors->map(function ($c) {
                            return [
                                'name' => $c->name,
                                'role' => $c->role,
                                'percentage' => $c->percentage
                            ];
                        })->values()
                    ];

                    // BUILD METADATA
                    $metadataJson = json_encode($metadata, JSON_PRETTY_PRINT);

                    // CREATE META TEMP FILE
                    $metaTemp = tempnam(sys_get_temp_dir(), 'meta_');
                    file_put_contents($metaTemp, $metadataJson);

                    // UPLOAD AUDIO
                $audioUpload = Http::withHeaders([
                        'X-APP-A-KEY' => env('APP_A_API_KEY'),
                    ])->attach(
                        'file',
                        fopen($tempFile, 'r'),
                        "audio.{$extension}"
                    )->post(config('services.external_url.website_storage_link') . "/api/upload_catalog_file", [
                        'folder' => $songFolder
                    ]);

                    if (!$audioUpload->successful()) {
                        \Log::error('Audio upload failed', [
                            'song_id' => $song->id,
                            'response' => $audioUpload->body()
                        ]);
                        continue;
                    }

                    // UPLOAD METADATA
                    Http::withHeaders([
                        'X-APP-A-KEY' => env('APP_A_API_KEY'),
                    ])->attach(
                        'file',
                        fopen($metaTemp, 'r'),
                        "metadata.json"
                    )->post(config('services.external_url.website_storage_link') . "/api/upload_catalog_file", [
                        'folder' => $songFolder
                    ]);

                } finally {

                    if ($tempFile && file_exists($tempFile)) {
                        unlink($tempFile);
                    }

                    if ($metaTemp && file_exists($metaTemp)) { // safe check
                        unlink($metaTemp);
                    }
                }
            }

            //update 

            $submission->metadata_created = 1;
            $submission->save();

        }

        return true;
    }
   
}

