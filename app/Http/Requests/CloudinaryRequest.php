<?php

namespace App\Http\Requests;

class CloudinaryRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                return $this->imageValidation();
                break;
            case 'POST':
                $basename = basename($this->url());
                if ($basename === 'upload') {
                    return $this->uploadValidation();
                } else {
                    return $this->bulkUploadValidation();
                }
                break;
            default:
                return [];
        }
    }

    /**
     * Handle get cloudinary validation
     *
     * @return array
     */
    private function imageValidation(): array
    {
        return [
            'publicId' => 'required|string'
        ];
    }

    private function uploadValidation(): array
    {
        return [
            'image' => 'required_without:imageUrl|file|mimes:jpeg,jpg,png,gif,svg',
            'imageUrl' => 'required_without:image|url',
        ];
    }

    private function bulkUploadValidation(): array
    {
        return [
            'images' => 'required|array',
            'images.*' => 'url',
        ];
    }
}
