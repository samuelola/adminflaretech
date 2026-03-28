<?php

namespace App\Services;

use App\Models\ArtistOwnerSong;
use App\Models\ArtistCatalogOwnershipSubmit;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DSPSubmissionService
{
    public function processSubmission($artistOwnerId)
    {
        $submission = ArtistCatalogOwnershipSubmit::where('artist_ownership_identity_id',$artistOwnerId)->first();
        $submissionId = $submission->id;

        $songs = ArtistOwnerSong::where('artist_ownership_identity_id', $artistOwnerId)
            ->with('contributors')
            ->get();

        $basePath = "catalog_submissions/{$artistOwnerId}/{$submissionId}";

        // =========================
        // CLEAN OLD DATA (optional)
        // =========================
        Storage::deleteDirectory($basePath);

        foreach ($songs as $index => $song) {

            if (!$song->file_path) {
                continue; // skip unfinished uploads
            }

            $songFolder = $basePath . '/song_' . ($index + 1);

            // =========================
            // COPY AUDIO FILE
            // =========================
            $extension = pathinfo($song->file_path, PATHINFO_EXTENSION);

            $source = 'public/' . $song->file_path;
            $destination = $songFolder . '/audio.' . $extension;

            if (Storage::exists($source)) {
                Storage::copy($source, $destination);
            }

            // =========================
            // BUILD METADATA
            // =========================
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

            // =========================
            // SAVE METADATA JSON
            // =========================
            Storage::put(
                $songFolder . '/metadata.json',
                json_encode($metadata, JSON_PRETTY_PRINT)
            );
        }

        // =========================
        // CREATE ZIP
        // =========================
        $zipPath = storage_path("app/{$basePath}.zip");

        $this->zipFolder(storage_path("app/{$basePath}"), $zipPath);


        return [
            'zip_path' => $zipPath,
            'relative_zip' => "{$basePath}.zip"
        ];
    }

    private function zipFolder($source, $zipFile)
    {
        $zip = new ZipArchive();

        if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($source),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $name => $file) {

                if (!$file->isDir()) {

                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($source) + 1);

                    $zip->addFile($filePath, $relativePath);
                }
            }

            $zip->close();
        }
    }
}