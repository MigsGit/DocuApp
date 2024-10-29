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
        $pdf = new Fpdi();

        if (!file_exists($filePath)) {
            throw new Exception('PDF file not found.');
        }

        $pageCount = $pdf->setSourceFile($filePath);
        return $pageCount;
    }

    /**
     * Convert a specific PDF page to an image and get its dimensions.
     *
     * @param string $filePath Path to the PDF file
     * @param int $pageNumber Page number to convert
     * @return array Image data, width, and height
     * @throws \Exception If the conversion fails
     */
    public function convertPdfPageToImageTest(string $filePath, int $pageNumber, string $outputDir)
    {
        if (!file_exists($filePath)) {
            throw new Exception('PDF file not found.');
        }
        $imagick = new Imagick();
        /**
         * Set desired resolution
        */
        $imagick->setResolution(300, 300);

        /**
         * Read specific page
         */
		$imagick->readImage($filePath.'['.($pageNumber).']');
        $width = $imagick->getImageWidth();
        $height = $imagick->getImageHeight();

        /**
         * Convert to an image
         */
        $imagick->setImageFormat('jpeg');

        /**
         * PDF pages can contain transparency,
         * which sometimes renders as black in image formats like JPEG.
         * To fix this, set a white background color before converting.
         */

        $imagick->setImageAlphaChannel(\Imagick:: ALPHACHANNEL_REMOVE);

        /**
         * Flattening removes any transparency layers that might be causing issues:
         */

        $imagick->mergeImageLayers(\Imagick::LAYERMETHOD_FLATTEN);
        /**
         * To improve quality, set a higher resolution before reading the PDF page with Imagick.
         * A higher resolution will result in a clearer, higher-quality image but also a larger
         * file size.
         */

        $imagick->setImageCompressionQuality(100);

        /**
         * Optimize for web (optional)
        */

        $imagick->stripImage();
        /**
         * ! Error: Malformed UTF-8 characters, possibly incorrectly encoded
         * ! Error: When return as json
         * @param string $imageData Return Image
         * $imageData = $imagick->getImagesBlob();
         * return response($imagePath, 200) ->header('Content-Type', 'image/jpeg');
         */

        // Get image data as base64 Blob
        $imageData = base64_encode($imagick->getImagesBlob());
        /**
         * Return array insted of string
        */
        return [
            'image' => 'data:image/jpeg;base64,' . $imageData,
            'width' => $width,
            'height' => $height,
        ];
    }
}
