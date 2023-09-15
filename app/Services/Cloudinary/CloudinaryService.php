<?php

namespace App\Services\Cloudinary;

use Cloudinary\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Api\Admin\AdminApi;
use Cloudinary\Transformation\Resize;
use Cloudinary\Transformation\Background;
use Cloudinary\Transformation\Gravity;
use App\Exceptions\NotFoundException;

class CloudinaryService
{
    /**
     * Get image and color detail
     */
    public static function getImageDetail($publicId)
    {
        return (new AdminApi())->asset($publicId, ['colors' => true]);
    }

    /**
     * Resize image
     * returns transformed url
     */
    public static function resizeImage($request)
    {
        $image = (new AdminApi())->asset($request->publicId);

//   For portrait images
        if ($image['height'] > $image['width']) {
            if ($image['width'] > 810) {
                $result = (new Cloudinary())->image($request->publicId)
                    ->resize(
                        Resize::crop()
                            ->width(810)
                            ->height(1040)
                            ->gravity(Gravity::center())
                    )->toUrl();
            } else {
                $result = (new Cloudinary())->image($request->publicId)
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
            $result = (new Cloudinary())->image($request->publicId)
                ->resize(
                    Resize::fillPad()
                        ->width(810)
                        ->height(1040)
//                ->aspectRatio(810 / 1040)
                        ->gravity(Gravity::auto())
                        ->background(Background::color('white'))
                )->toUrl();
        }
        return $result;
    }

    /**
     * Upload image after processing
     * returns image detail with colors
     */
    public static function uploadImage($request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $imagePath = $file->path();
            $uploadData = $file->getRealPath();
        } else {
            $imagePath = $uploadData = $request->imageUrl;
            $fileName = '';
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
        $uploadOptions = ['transformation' => $transformations, 'overwrite' => true, 'resource_type' => 'image'];
        if ($fileName) {
            $uploadOptions['public_id'] = $fileName;
        } else {
            $uploadOptions['use_filename'] = true;
            $uploadOptions['folder'] = 'external';
        }
        // Perform the image upload
        $uploadResult = (new UploadApi())->upload($uploadData, $uploadOptions);
        if (isset($uploadResult['public_id'])) {
            return self::getImageDetail($uploadResult['public_id']);
        } else {
            throw new NotFoundException('Failed to upload image', 500);
        }
    }

    /**
     * Upload external image after processing
     * returns image detail with colors
     */
    public static function uploadAndGetExternalImageDetail($request)
    {
        $imagePath = $request->imageUrl;
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
        $uploadOptions = [
            'transformation' => $transformations, 'use_filename' => true,
            'folder' => 'external', 'overwrite' => true, 'resource_type' => 'image'
        ];
        $uploadResult = (new UploadApi())->upload($imagePath, $uploadOptions);
        if (isset($uploadResult['public_id'])) {
            return self::getImageDetail($uploadResult['public_id']);
        } else {
            throw new NotFoundException('Failed to process image', 500);
        }
    }

    /**
     * Destroy Resource
     */
    public static function destroyResource($publicId)
    {
        return (new UploadApi())->destroy($publicId);
    }

}
