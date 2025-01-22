<?php

namespace App\Services;

use Imagick;
use setasign\Fpdi\Fpdi;
use Exception;

class PdfService
{
    protected $fpdi;
    public function __construct(Fpdi $fpdi) {
        $this->fpdi = $fpdi;
    }
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
        // $pdf = new Fpdi();

        if (!file_exists($filePath)) {
            throw new Exception('PDF file not found.');
        }

        $pageCount = $this->fpdi->setSourceFile($filePath);
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

     /**
     * Insert an image at specific coordinates on a PDF page.
     *
     * @param string $pdfPath Path to the original PDF file.
     * @param string $imagePath Path to the image file to insert.
     * @param float $x X-coordinate for the image.
     * @param float $y Y-coordinate for the image.
     * @param int $page Page number where the image will be inserted.
     * @return string Path to the newly generated PDF with the image.
     */
    public function insertImageAtCoordinates($pdfPath, $imagePath, $x, $y, $page = 1)
    {
        // Import the existing PDF page
        $pageCount = $this->fpdi->setSourceFile($pdfPath);

        //Read all page using page count
        for ($i=1; $i <= $pageCount; $i++) {
            $templateId = $this->fpdi->importPage($i);
            // Insert the image at specified coordinates
            $pdfDimensions = $this->fpdi->getTemplateSize($templateId);
            $w = $pdfDimensions['width'];
            $h = $pdfDimensions['height'];
            //Calculate the position of the Signature Image
            $x = $x * $w;
            $y = $y * $h;

            $orientation 	= 'P';
            $page_size 	= 'A4';
            if($w > $h){
                $orientation 	= 'L';
                /* A4 size is width 210 x height 297 mm */
                /* A3 size is width 297 x height 420 mm */
                if($w > 297){
                    $page_size 			= 'A3';
                }
            }

            // Add a page to the PDF
            $this->fpdi->AddPage($orientation,$page_size);
            $this->fpdi->useTemplate($templateId);

            // Add a image to the PDF
            $this->fpdi->Image($imagePath, $x, $y, 22, 0);
            $this->fpdi->SetFont('Arial', '', 5);

            // Generate a file path for the output PDF
            $outputPath = storage_path('app/public/modified_pdf.pdf');
        }
        $this->fpdi->Output();
    }
}
