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

       if (!function_exists('amicrud_form_labels')) { 
        function amicrud_form_labels($label)
        {
           $exp_label = explode('_',$label);
           $leb = '';
           foreach ($exp_label as $value) {
            
              if ($value=='id') {
              continue;
              }
              $leb .=$value.' ';
           }
           return ucwords($leb);
        }
    }
    
    
    if (!function_exists('amicrud_general_labels')) { 
        function amicrud_general_labels($label)
        {
           $exp_label = explode('_',$label);
           $leb = '';
           foreach ($exp_label as $value) {
              $leb .=$value.' ';
           }
           return ucwords(str_replace('-',' ',$leb));
        }
    }

    if (!function_exists('amicrud_short_string')) {
        function amicrud_short_string($str,$max=30)
        { 
            if (strlen($str) < $max) return $str;
            return substr($str, 0, $max).'...';
        }
    }

    if (!function_exists('amicrud_status_class')) {
        function amicrud_status_class($status)
        {
            switch ($status) {
                case (amicrud_status_name()['PENDING']):
                    return 'secondary';
                    break;
                case amicrud_status_name()['FORWARDED']:
                    return 'secondary';
                    break;
                case amicrud_status_name()['NOT_SUBMITTED']:
                    return 'secondary';
                    break;
                case amicrud_status_name()['APPROVED']:
                    return 'success';
                    break;
                case amicrud_status_name()['COMPLETED']:
                    return 'success';
                    break;
                case amicrud_status_name()['REJECTED']:
                    return 'danger ';
                    break;
                case amicrud_status_name()['DECLINED']:
                    return 'danger';
                    break;
                case amicrud_status_name()['DECLINED_FOR']:
                    return 'danger';
                    break;
                case amicrud_status_name()['CANCELLED']:
                    return 'danger';
                    break;
                case amicrud_status_name()['PAID']:
                    return 'success';
                    break;
                case amicrud_status_name()['PART_PAID']:
                    return 'secondary';
                    break;
                case amicrud_status_name()['CREDIT']:
                    return 'warning';
                    break;
                case amicrud_status_name()['REVIEW']:
                    return 'warning';
                    break;
                default:
                   return 'primary';
                    break;
            }
        }
       }

       if (!function_exists('amicrud_status_name')) {
        function amicrud_status_name($name=null)
        {
          $name = strtoupper($name);
          $statuses = [
            'PENDING' => 'pending',
            'NOT_SUBMITTED' => 'not_submitted',
            'CANCELLED' => 'cancelled',
            'COMPLETED' => 'completed',
            'SUBMITTED' => 'submitted',
            'APPROVED' => 'approved',
            'APPROVED_FOR' => 'approved_for',
            'DECLINED' => 'declined',
            'DECLINED_FOR' => 'declined_for',
            'REJECTED' => 'rejected',
            'FORWARDED' => 'forwarded',
            'PAID' => 'paid',
            'PART_PAID' => 'part_paid',
            'CREDIT' => 'credit',
            'DELIVERED' => 'delivered',
            'RECEIVED' => 'received',
            'AWAITING' => 'awaiting',
            'REVIEW' => 'review',
            'RETURNED' => 'returned',
          ];
          if ($name) {
            return isset($statuses[$name]) ? $statuses[$name] : null;
          }else{
            return $statuses;
          }
        }
       }