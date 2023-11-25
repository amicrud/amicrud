<?php

use App\Models\Logs\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

if (!function_exists('user')) {
    /**
     * Generate a url for the application.
     *
     * @param  string $guard
     * @return object
     */
    function user($guard=null)
    {
        return auth()->guard($guard)->user();
    }
}

if (!function_exists('user_has_role')) {
    /**
     * Generate a url for the application.
     *
     * @param  string $guard
     * @return object
     */
    function user_has_role($roles=[],$required=false)
    {
        if(!$roles) return false;
        if ($required) {
            return user()->hasRole($roles,$required);
        }
        return user()->hasRole($roles);
    }
}

if (!function_exists('default_pagination_number')) {
    function default_pagination_number() {
        return 10;
    }
}

if (!function_exists('user_has_permission')) {
    /**
     * Generate a url for the application.
     * @param  string $guard
     * @return object
     */
    function user_has_permission($permissions=[], $required=false)
    {
        if(!$permissions) return false;
        if ($required) {
            return user()->isAbleTo($permissions,$required);
        }
        return user()->isAbleTo($permissions);
    }
}


function generateSignatureForURL($data, $key) {
    return hash_hmac('sha256', json_encode($data), $key);
}
function addParamsToUrl($url, $params)
{
    $queryString = http_build_query($params);
    $separator = (strpos($url, '?') === false) ? '?' : '&';
    return $url . $separator . $queryString;
}

if (!function_exists('sign_url')) {
    /**
     * @return string
     */
    function sign_url($route_url) {

    $parsedUrl = parse_url($route_url);
    // Check if the URL already has a "signature" parameter
    if (isset($parsedUrl['query'])) {
        parse_str($parsedUrl['query'], $queryParams);
        if (isset($queryParams['signature'])) {
            // URL already has a signature, return the URL as is
            return $route_url;
        }
    }

    // Generate the signature
    $signature = generateSignatureForURL($route_url, env('SIGNING_URL_SECRET'));
    $params = [
        'signature' => $signature,
    ];

    return addParamsToUrl($route_url, $params);

    }
}

if (!function_exists('similarity_percentage')) {
    function similarity_percentages($str1, $str2) {
        $len1 = strlen($str1);
        $len2 = strlen($str2);

        // Calculate the Levenshtein distance
        $maxLen = max($len1, $len2);
        $levenshteinDistance = levenshtein($str1, $str2);

        // Calculate the similarity percentage
        $percentage = ((1 - ($levenshteinDistance / $maxLen)) * 100);

        return $percentage;
    }
}



if (!function_exists('verify_sign_url')) {
    /**
     * @return string
     */
    function verify_sign_url(Request $request) {
        $url = $request->fullUrl();
        $queryParameters = parse_url($url, PHP_URL_QUERY);
        parse_str($queryParameters, $queryArray);
        $providedSignature = isset($queryArray['signature']) ? $queryArray['signature'] : null;

        $expectedSignature = generateSignatureForURL($request->url(), env('SIGNING_URL_SECRET'));

        return $providedSignature === $expectedSignature;
    }
}




if (!function_exists('active_route')) {
    /**
     * @return string
     */
    function active_route($route_name)
    {
        return request()->routeIs($route_name) || request()->is("$route_name/*") ? 'active' : '';
    }
}


if (!function_exists('success_message')) {
    /**
     * @return string
     */
function success_message($message){
    return '<div class="alert alert-success alert-dismissible fade show" role="alert">
            '.$message.'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
}

if (!function_exists('error_message')) {
    /**
     * @return string
     */
    function error_message($message){
        return '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                '.$message.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
}

if (!function_exists('gallery_file_upload')) {

    function gallery_file_upload(UploadedFile $file,$module_type)
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


    if (!function_exists('get_errors')) {
        /**
         * @return string
         */
        function get_errors($erros)
        {
          $msg='<ul>';
           foreach ($erros as $key => $value) {
            $msg.='<li> <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
            '.$value.'. </li>';
           }
           $msg.='</ul>';
           return $msg;
        }
    }

    if (!function_exists('dynamic_page_prefix')) {
        /**
         * @return string
         */
      function dynamic_page_prefix(){
        return  'browse';
      }
    }

    if (!function_exists('form_labels')) { 
        function form_labels($label)
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
    
    
    if (!function_exists('general_labels')) { 
        function general_labels($label)
        {
           $exp_label = explode('_',$label);
           $leb = '';
           foreach ($exp_label as $value) {
              $leb .=$value.' ';
           }
           return ucwords(str_replace('-',' ',$leb));
        }
    }

    if (!function_exists('short_string')) {
        function short_string($str,$max=30)
        { 
            if (strlen($str) < $max) return $str;
            return substr($str, 0, $max).'...';
        }
    }

    if (!function_exists('human_readable_file_size')) {
       function human_readable_file_size($bytes, $decimals = 2) {
           $sz = 'BKMGTP';
           $factor = floor((strlen($bytes) - 1) / 3);
           return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
           }
       }

       if (!function_exists('log_system_errors')) {
        function log_system_errors(Exception $e) {
            Log::channel('error_log')->error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
         }
       }


       if (!function_exists('status_name')) {
        function status_name($name=null)
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



       if (!function_exists('message_types')) {
        function message_types($name=null)
        {
          $name = strtoupper($name);
          $statuses = [
            'ANNOUNCEMENT' => 'announcement',
            'ALERT' => 'alert',
            'SUCCESS' => 'success',
            'ERROR' => 'error',
            'INFO' => 'info',
            'EMAIL' => 'email',
            'ACTION' => 'action',
          ];
          if ($name) {
            return isset($statuses[$name]) ? $statuses[$name] : null;
          }else{
            return $statuses['ALERT'];
          }
        }
       }


    
       if (!function_exists('status_class')) {
        function status_class($status)
        {
            switch ($status) {
                case (status_name()['PENDING']):
                    return 'secondary';
                    break;
                case status_name()['FORWARDED']:
                    return 'secondary';
                    break;
                case status_name()['NOT_SUBMITTED']:
                    return 'secondary';
                    break;
                case status_name()['APPROVED']:
                    return 'success';
                    break;
                case status_name()['COMPLETED']:
                    return 'success';
                    break;
                case status_name()['REJECTED']:
                    return 'danger ';
                    break;
                case status_name()['DECLINED']:
                    return 'danger';
                    break;
                case status_name()['DECLINED_FOR']:
                    return 'danger';
                    break;
                case status_name()['CANCELLED']:
                    return 'danger';
                    break;
                case status_name()['PAID']:
                    return 'success';
                    break;
                case status_name()['PART_PAID']:
                    return 'secondary';
                    break;
                case status_name()['CREDIT']:
                    return 'warning';
                    break;
                case status_name()['REVIEW']:
                    return 'warning';
                    break;
                default:
                   return 'primary';
                    break;
            }
        }
       }

      
       if (!function_exists('log_details')) {
        
        function log_details($details,$data)
        {
            switch ($details) {
                case "new sale":
                    return 'made new sale : '. $data;
                    break;
                case "repayment":
                    return 'made a sale repayment : '.$data;
                    break;
                default:
                   return 'Performed system activity with no details : '.$data;
                    break;
            }
        }
       }

       if (!function_exists('safe_array_access')) {
        function safe_array_access($array, array $keys=[]) {
         $value = $array;
         foreach ($keys as $key) {
             $key = trim($key, "'\"");
                 if (isset($value[$key])) {
                     $value = $value[$key];
                 } else {
                     return null; // Return null if any key is missing
                 }
             }
             return $value;
         }
     }

//        if (!function_exists('generate_barcode')) {
//        function generate_barcode($text, $size = 300) {
//         // Create a QR Code instance
//         $qrCode = new QrCode($text, new Png());
    
//         // Set the size of the barcode
//         $qrCode->setSize($size);
    
//         // Generate the barcode image
//         $image = $qrCode->getImage();
    
//         // Return the image as an HTML <img> tag
//         return "<img src='data:" . $image->getMimeType() . ";base64," . base64_encode($image->getString()) . "' />";
//     }
// }

if (!function_exists('time_ago')) {
    function time_ago($datetime): string {
        $timestamp = strtotime($datetime);
        $dateTime = new DateTime();
        $dateTime->setTimestamp($timestamp);
        $currentDate = new DateTime();

        $diff = $currentDate->diff($dateTime);

        if ($diff->y > 0) {
            return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
        } elseif ($diff->m > 0) {
            return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
        } elseif ($diff->d > 0) {
            return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
        } elseif ($diff->h > 0) {
            return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
        } elseif ($diff->i > 0) {
            return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
        } else {
            return 'Just now';
        }
    }
}

if (!function_exists('number_to_words')) {
    function number_to_words($number) {
        $units = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine"];
        $teens = ["", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen"];
        $tens = ["", "Ten", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];
        $thousands = ["", "Thousand", "Million"];

        if ($number < 10) return $units[$number];
        if ($number < 20) return $teens[$number - 10];
        if ($number < 100) return $tens[intval($number / 10)] . ($number % 10 !== 0 ? " " . $units[$number % 10] : "");
        if ($number < 1000) return $units[intval($number / 100)] . " Hundred" . ($number % 100 !== 0 ? " and " . number_to_words($number % 100) : "");
        if ($number < 1000000) {
            $prefix = number_to_words(intval($number / 1000)) . " " . $thousands[1];
            $suffix = $number % 1000;
            if ($suffix) {
                return $prefix . " " . number_to_words($suffix);
            } else {
                return $prefix;
            }
        }
        if ($number == 1000000) return "One " . $thousands[2];

        return "Number out of range";
    }
}


if (!function_exists('get_segmented_url')) {
    /**
     * @return string
     */
    function get_segmented_url($segmeted_request)
    {
    $url = '/';
    $slash='/';
    foreach($segmeted_request as $k=>$s){
     if($k==0 && $s==dynamic_page_prefix()){continue;}
     if(end($segmeted_request)==$s){$slash='';}
      $url.=$s.$slash;
    }
    return $url;
   }
}


