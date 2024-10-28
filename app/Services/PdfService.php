<?php

namespace App\Services;

use Imagick;
use setasign\Fpdi\Fpdi;
use Exception;

class PdfService
{
    /**
     * Get the total number of pages in a PDF file.
     *
     * @param string $filePath
     * @return int
     * composer require calcinai/php-imagick
     * composer require setasign/fpd
     */
    public function getPageCount(string $filePath)
    {
        // return 'true';
        $pdf = new Fpdi();

        if (!file_exists($filePath)) {
            throw new Exception('PDF file not found.');
        }

        $pageCount = $pdf->setSourceFile($filePath);
        return $pageCount;
    }

    /**
     * Convert a specific page of a PDF to an image.
     *
     * @param string $filePath
     * @param int $pageNumber
     * @param string $outputDir
     * @return string
     */
    public function convertPdfPageToImage(string $filePath, int $pageNumber, string $outputDir): string
    {
        if (!file_exists($filePath)) {
            throw new Exception('PDF file not found.');
        }

        $imagick = new Imagick();
        $imagick->setResolution(300, 300);
        // $imagick->readImage("{$filePath}[{$pageNumber - 1}]");
        $imagick->readImage($filePath,$pageNumber - 1);

        $imagePath = $outputDir . '/page_' . $pageNumber . '.jpg';
        $imagick->setImageFormat('jpg');
        $imagick->writeImage($imagePath);

        $imagick->clear();
        $imagick->destroy();

        return $imagePath;
    }
}
