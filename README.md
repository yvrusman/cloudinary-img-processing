<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## CloudinaryImageProcessing

Cloudinary is a cloud-based image management solution that offers powerful image processing capabilities. CloudniaryImageProcessing tool allows to manage resources easily. 
- Upload Image.
- Get Image.
- Image resizing/ transformation.
- Get image colors.
- Destroy Image. 


## Prerequisites
   Before you begin, make sure you have the following prerequisites installed on your local development environment: 
 - PHP Version: >= 8.1
 - Laravel Version: 9.19
 - Composer or You can User Composer.phar file placed in Project Root
 - Cloudinary Account

## How to setup the Project
 To Setup the project open your terminal in the root directory of the project and run the following commands:
 ```
 1. composer install (To install all dependencies)
 ```

```
2. copy .env-example to .env (to setup project configuration)
```

```
3. Configure Cloudinary credentials in .env (CLOUDINARY_URL = "cloudinary://MY_KEY:MY_SECRET@MY_CLOUD_NAME")
```

```
4. php artisan key:generate (to generate key)
```

```
5. php artisan optimize:clear (to clear all cache)
```

```
6. php artisan serve
```

## API Endpoints

### Get Image & Colors

Endpoint: `/api/get-image?{publicId}`
- Method: `GET`
- Description: Fetches the detail along with dominant colors of an image with the specified `publicId`.
- Query Parameters:
  - `publicId` (string): The public ID of the image in Cloudinary.

### Resize Image

Endpoint: `/api/image-resize?{publicId}`
- Method: `GET`
- Description: Resizes an image with the specified `publicId` to the specified `width` and `height` using Cloudinary and returns image url.
- Query Parameters:
  - `publicId` (string): The public ID of the image in Cloudinary.


### Upload Image To Cloudinary

Endpoint: `/api/upload`
- Method: `POST`
- Description: Uploads an image file to Cloudinary after transformation
- Request Body:
  - `image` (file): The image file to upload.
     OR
  - `imageUrl` (string): The image url that to be uploaded.


### Delete Image From Cloudinary

Endpoint: `/api/delete?{publicId}`
- Method: `DELETE`
- Description: Deletes an image with the specified `publicId` from Cloudinary.
- Query Parameters:
  - `publicId` (string): The public ID of the image in Cloudinary.