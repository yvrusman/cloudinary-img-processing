<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Cloudinary\CloudinaryService;
use App\Utils\JsonApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;


class CloudinaryController extends Controller
{

    public function getImageDetail(Request $request)
    {
        try {
            $image = CloudinaryService::getImageDetail($request->publicId);
            return JsonApiResponse::ofData($image, 'success');
        } catch (Exception $e) {
            Log::error("Error occurred while getting image", [$e]);
            return JsonApiResponse::ofInternalError($e->getMessage());
        }

    }

    public function imageResize(Request $request)
    {
        try {
            $image = CloudinaryService::resizeImage($request);
            return JsonApiResponse::ofData($image, 'success');
        } catch (Exception $e) {
            Log::error("Error occurred while resizing image", [$e]);
            return JsonApiResponse::ofInternalError($e->getMessage());
        }

    }

    public function upload(Request $request)
    {
        try {
            $result = CloudinaryService::uploadImage($request);
            return JsonApiResponse::ofData($result, 'success');
        } catch (Exception $e) {
            Log::error("Error occurred while uploading image", [$e]);
            return JsonApiResponse::ofInternalError($e->getMessage());
        }
    }

    public function getExternalImageDetail(Request $request)
    {
        try {
            $result = CloudinaryService::uploadAndGetExternalImageDetail($request);
            return JsonApiResponse::ofData($result, 'success');
        } catch (Exception $e) {
            Log::error("Error occurred while processing image", [$e]);
            return JsonApiResponse::ofInternalError($e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $response = CloudinaryService::destroyResource($request->publicId);
            return JsonApiResponse::ofMessage($response['result'] ?? 'Resource deleted successfully');
        } catch (Exception $e) {
            Log::error("Error occurred while deleting image", [$e]);
            return JsonApiResponse::ofInternalError($e->getMessage());
        }
    }
}
