<?php

/**
 *Upload Image In Local Storage.
 * @param  $folder
 * @param $image
 */
if (!function_exists('upload_image')) {
    function upload_image($folder, $image)
    {
        $store = \Illuminate\Support\Facades\Storage::disk('public')->put($folder, $image);
        $url = \Illuminate\Support\Facades\Storage::disk('public')->url($store);
        return $url;

    }

    /**
     *Get Current Currency .
     * @param int $number
     */
    if (!function_exists('currency')) {
        function currency($number)
        {
            $formatter = new NumberFormatter('en-US', NumberFormatter::CURRENCY);
            return $formatter->formatCurrency($number, 'USD');
        }
    }
}


