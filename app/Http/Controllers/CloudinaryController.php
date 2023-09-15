<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Cloudinary\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Api\Admin\AdminApi;
use Cloudinary\Transformation\Resize;
use Cloudinary\Transformation\Background;
use Cloudinary\Transformation\Gravity;


class CloudinaryController extends Controller
{

    public function getImageDetail(Request $request)
    {
        try {
            $image = (new AdminApi())->asset($request->publicId, ['colors' => true]);
            return response()->json(['status' => true, 'message' => 'success', 'data' => $image]);
        } catch (\Exception $e) {
            return response(['status' => false, 'message' => $e->getMessage()], 500);
        }

    }

    public function imageResize(Request $request)
    {
        try {
            $image = (new AdminApi())->asset($request->publicId);

//   For portrait images
            if ($image['height'] > $image['width']) {
                if ($image['width'] > 810) {
                    $res = (new Cloudinary())->image($request->publicId)
                        ->resize(
                            Resize::crop()
                                ->width(810)
                                ->height(1040)
                                ->gravity(Gravity::center())
                        )->toUrl();
                } else {
                    $res = (new Cloudinary())->image($request->publicId)
                        ->resize(
                            Resize::fillPad()
                                ->width(810)
                                ->height(1040)
//                ->aspectRatio(810 / 1040)
                                ->gravity(Gravity::auto())
                                ->background(Background::color('white'))
                        )->toUrl();
                }
            } else {
                $res = (new Cloudinary())->image($request->publicId)
                    ->resize(
                        Resize::fillPad()
                            ->width(810)
                            ->height(1040)
//                ->aspectRatio(810 / 1040)
                            ->gravity(Gravity::auto())
                            ->background(Background::color('white'))
                    )->toUrl();
            }
            return response()->json(['status' => true, 'message' => 'success', 'data' => $res]);
        } catch (\Exception $e) {
            return response(['status' => false, 'message' => $e->getMessage()], 500);
        }

    }

    public function upload(Request $request)
    {
        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imagePath = $file->path();
                $uploadData = $file->getRealPath();
            } else {
                $imagePath = $uploadData = $request->imageUrl;
            }
            list($width, $height) = getimagesize($imagePath);
            if ($height > $width) {
                if ($width > 810) {
                    $transformations = [
                        'width' => 810, 'height' => 1040,
                        'crop' => 'crop', 'gravity' => 'center'
                    ];
                } else {
                    $transformations = [
                        'width' => 810, 'height' => 1040, 'crop' => 'fill_pad',
                        'gravity' => 'auto', 'background' => 'white',
                    ];
                }
            } else {
                $transformations = [
                    'width' => 810, 'height' => 1040, 'crop' => 'fill_pad',
                    'gravity' => 'auto', 'background' => 'white',
                ];
            }

            // Perform the image upload
            $uploadResult = (new UploadApi())->upload($uploadData, ['transformation' => $transformations]);
// Check if the upload was successful
            if (isset($uploadResult['public_id'])) {
                return response()->json(['status' => true, 'message' => 'success', 'data' => $uploadResult]);
            } else {
                return response()->json(['status' => false, 'message' => 'Failed to upload.']);
            }
        } catch (\Exception $e) {
            return response(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $response = (new UploadApi())->destroy($request->publicId);
            if (isset($response['result'])) {
                if ($response['result'] == 'ok') {
                    return response()->json(['status' => true, 'message' => 'File deleted successfully']);
                } else {
                    return response()->json(['status' => false, 'message' => $response['result']]);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Something went wrong.']);
            }
        } catch (\Exception $e) {
            return response(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getExternalImageDetail(Request $request)
    {
        try {
            $imagePath = $uploadData = $request->imageUrl;
            list($width, $height) = getimagesize($imagePath);
            if ($height > $width) {
                if ($width > 810) {
                    $transformations = [
                        'width' => 810, 'height' => 1040,
                        'crop' => 'crop', 'gravity' => 'center'
                    ];
                } else {
                    $transformations = [
                        'width' => 810, 'height' => 1040, 'crop' => 'fill_pad',
                        'gravity' => 'auto', 'background' => 'white',
                    ];
                }
            } else {
                $transformations = [
                    'width' => 810, 'height' => 1040, 'crop' => 'fill_pad',
                    'gravity' => 'auto', 'background' => 'white',
                ];
            }
            // Perform the image upload
            $uploadResult = (new UploadApi())->upload($uploadData, ['folder' => 'external', 'transformation' => $transformations]);
// Check if the upload was successful
            if (isset($uploadResult['public_id'])) {
                $image = (new AdminApi())->asset($uploadResult['public_id'], ['colors' => true]);
                return response()->json(['status' => true, 'message' => 'success', 'data' => $image]);
            } else {
                return response()->json(['status' => false, 'message' => 'Something went wrong.']);
            }
        } catch (\Exception $e) {
            return response(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
