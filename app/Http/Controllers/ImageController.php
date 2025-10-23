<?php

namespace App\Http\Controllers;

use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    /**
     * Display a listing of images
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Images::query();

            // Filter by ref_key if provided
            if ($request->has('ref_key')) {
                $query->byRefKey($request->ref_key);
            }

            // Filter by title if provided
            if ($request->has('title')) {
                $query->byTitle($request->title);
            }

            // Pagination
            $perPage = $request->get('per_page', 15);
            $images = $query->orderBy('created_at', 'desc')->paginate($perPage);

            // Add image_url to each item
            $images->getCollection()->transform(function ($image) {
                $image->image_url = $image->image_url;
                return $image;
            });

            return response()->json([
                'success' => true,
                'data' => $images,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch images',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created image
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = $this->validateImageRequest($request);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $image = Images::createFromFile(
                $request->file('image'),
                $request->ref_key,
                $request->title,
                $request->description
            );

            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully',
                'data' => [
                    'id' => $image->id,
                    'ref_key' => $image->ref_key,
                    'title' => $image->title,
                    'description' => $image->description,
                    'img_path' => $image->img_path,
                    'image_url' => $image->image_url,
                    'created_at' => $image->created_at,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified image
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $image = Images::find($id);

            if (!$image) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $image->id,
                    'ref_key' => $image->ref_key,
                    'title' => $image->title,
                    'description' => $image->description,
                    'img_path' => $image->img_path,
                    'image_url' => $image->image_url,
                    'exists' => $image->imageExists(),
                    'created_at' => $image->created_at,
                    'updated_at' => $image->updated_at,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch image',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified image
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $image = Images::find($id);

            if (!$image) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image not found'
                ], 404);
            }

            // Validate request
            $validator = Validator::make($request->all(), [
                'ref_key' => 'nullable|string|max:255',
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Update text fields
            $image->fill($request->only(['ref_key', 'title', 'description']));

            // Update image file if provided
            if ($request->hasFile('image')) {
                $image->updateFile($request->file('image'));
            } else {
                $image->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Image updated successfully',
                'data' => [
                    'id' => $image->id,
                    'ref_key' => $image->ref_key,
                    'title' => $image->title,
                    'description' => $image->description,
                    'img_path' => $image->img_path,
                    'image_url' => $image->image_url,
                    'updated_at' => $image->updated_at,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update image',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified image
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $image = Images::find($id);

            if (!$image) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image not found'
                ], 404);
            }

            $image->delete(); // This will also delete the file thanks to the model's boot method

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete image',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload multiple images at once
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadMultiple(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'images' => 'required|array|max:10',
                'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
                'ref_key' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $uploadedImages = [];
            $errors = [];

            foreach ($request->file('images') as $index => $file) {
                try {
                    $image = Images::createFromFile(
                        $file,
                        $request->ref_key,
                        $request->get("titles.{$index}"), // Optional individual titles
                        $request->get("descriptions.{$index}") // Optional individual descriptions
                    );

                    $uploadedImages[] = [
                        'id' => $image->id,
                        'title' => $image->title,
                        'image_url' => $image->image_url,
                    ];

                } catch (\Exception $e) {
                    $errors[] = "Failed to upload file {$file->getClientOriginalName()}: " . $e->getMessage();
                }
            }

            return response()->json([
                'success' => count($uploadedImages) > 0,
                'message' => count($uploadedImages) . ' images uploaded successfully',
                'data' => $uploadedImages,
                'errors' => $errors
            ], count($uploadedImages) > 0 ? 201 : 500);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload images',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get images by reference key
     *
     * @param string $refKey
     * @return JsonResponse
     */
    public function getByRefKey(string $refKey): JsonResponse
    {
        try {
            $images = Images::byRefKey($refKey)->orderBy('created_at', 'desc')->get();

            $images->transform(function ($image) {
                $image->image_url = $image->image_url;
                return $image;
            });

            return response()->json([
                'success' => true,
                'data' => $images
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch images',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validate image upload request
     *
     * @param Request $request
     * @return \Illuminate\Validation\Validator
     */
    private function validateImageRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max
            'ref_key' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);
    }
}