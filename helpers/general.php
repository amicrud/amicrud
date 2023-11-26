<?php
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

if (!function_exists('amicrud_generateSignatureForURL')) {
    function amicrud_generateSignatureForURL($data, $key) {
        return hash_hmac('sha256', json_encode($data), $key);
    }
}

if (!function_exists('amicrud_addParamsToUrl')) {
  function amicrud_addParamsToUrl($url, $params)
    {
        $queryString = http_build_query($params);
        $separator = (strpos($url, '?') === false) ? '?' : '&';
        return $url . $separator . $queryString;
    }
}

if (!function_exists('amicrud_sign_url')) {
    /**
     * @return string
     */
    function amicrud_sign_url($route_url) {

    $parsedUrl = parse_url($route_url);
    // Check if the URL already has a "signature" parameter
    if (isset($parsedUrl['query'])) {
        parse_str($parsedUrl['query'], $queryParams);
        if (isset($queryParams['signature'])) {
            // URL already has a signature, return the URL as is
            return $route_url;
        }
    }

    // will be added to config file
    $SIGNING_URL_SECRET="mysecretkey";

    // Generate the signature
    $signature = amicrud_generateSignatureForURL($route_url, $SIGNING_URL_SECRET);
    $params = [
        'signature' => $signature,
    ];

    return amicrud_addParamsToUrl($route_url, $params);

    }
}

if (!function_exists('amicrud_error_message')) {
    /**
     * @return string
     */
    function amicrud_error_message($message){
        return '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                '.$message.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
}

if (!function_exists('amicrud_gallery_file_upload')) {

    function amicrud_gallery_file_upload(UploadedFile $file,$module_type)
    {   
        if ($file &&  !empty($file) && ($file instanceof UploadedFile)){
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . Str::random(10).'_'.time(). '.' . $file->extension();

            // if(in_array(strtolower($file->getClientOriginalExtension()),['png','jpg','jpeg','webp','heic','heif','bmp'])){
            //     $image = Image::make($file);
            //     $path =  $module_type.'/'.$fileName;
            //     Storage::disk('public')->put($path, $image->encode('jpg', 75));
            //     return 'storage/'.$path;
            // }
            return 'storage/'.$file->storeAs($module_type, $fileName, 'public');
        }
     }
    }

    if (!function_exists('amicrud_log_system_errors')) {
        function amicrud_log_system_errors(Exception $e) {
            Log::channel('error_log')->error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
         }
       }