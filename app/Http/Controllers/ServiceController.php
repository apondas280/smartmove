<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Service;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends BaseController
{
    // 1. get all services
    public function index()
    {
        $services = Service::get();
        return self::sendRes('Services fetched successfully', $services);
    }

    // 2. store services data
    public function store(Request $request)
    {
        // upload icon
        $title     = htmlspecialchars($request->title);
        $slug      = Str::slug($title);
        $icon      = self::upload_file($request->file('icon'), 'services/' . $slug . '/icon');
        $thumbnail = self::upload_file($request->file('thumbnail'), 'services/' . $slug . '/thumbnail');

        // editor images upload dir
        $directory = public_path('upload/services/' . $slug . '/content');
        if (! File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }

        // process editor images and upload
        $content = $request->content;
        $dom     = new DOMDocument();
        $dom->loadHTML($content);
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $image) {
            // Check if the src attribute contains base64 data
            $src = $image->getAttribute('src');
            if (strpos($src, 'data:image') === 0) {
                $mime      = explode(';', $src)[0];
                $extension = explode('/', $mime)[1];
                if ($extension === 'svg+xml') {
                    $extension = 'svg';
                }

                // Extract base64 data and validate
                $data = base64_decode(explode(',', $src)[1]);
                if ($data !== false) {
                    $imgName = 'upload/services/' . $slug . '/content/' . Str::random(20) . '.' . $extension;

                    file_put_contents(public_path($imgName), $data);
                    $image->removeAttribute('src');
                    $image->setAttribute('src', asset('public/' . $imgName));
                } else {
                    return self::sendErr('Something went wrong.');
                }
            }
        }
        $content = $dom->saveHTML();

        $service['title']     = $title;
        $service['slug']      = $slug;
        $service['icon']      = $icon;
        $service['thumbnail'] = $thumbnail;
        $service['slogan']    = htmlspecialchars($request->slogan);
        $service['content']   = $content;

        // insert data in services table
        Service::insert($service);
        return self::sendRes('Service has been added.');
    }

    // 3. show single service data
    public function show($slug, $id)
    {
        // check data exists or not
        $service = Service::where(['id' => $id, 'slug' => $slug])->first();
        if (! $service) {
            return self::sendErr('Data not found.');
        }

        return self::sendRes('Service fetched successfully.', $service);
    }

    // 4. delete a service
    public function delete($id)
    {
        // check data exists or not
        $service = Service::find($id);
        if (! $service) {
            return self::sendErr('Data not found.');
        }

        // delete service record
        $service->delete();
        return self::sendRes('Service has been deleted.');
    }

    // 5. update service data
    public function update(Request $request, $id)
    {
        // check data exists or not
        $service_details = Service::find($id);
        if (! $service_details) {
            return self::sendErr('Data not found.');
        }

        // upload icon
        $title     = htmlspecialchars($request->title);
        $slug      = Str::slug($title);
        $icon      = self::upload_file($request->file('icon'), 'services/' . $slug . '/icon');
        $thumbnail = self::upload_file($request->file('thumbnail'), 'services/' . $slug . '/thumbnail');

        // editor images upload dir
        $directory = public_path('upload/services/' . $slug . '/content');
        if (! File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }

        // process editor images and upload
        $content = $request->content;
        $dom     = new DOMDocument();
        $dom->loadHTML($content);
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $image) {
            // Check if the src attribute contains base64 data
            $src = $image->getAttribute('src');
            if (strpos($src, 'data:image') === 0) {
                $mime      = explode(';', $src)[0];
                $extension = explode('/', $mime)[1];
                if ($extension === 'svg+xml') {
                    $extension = 'svg';
                }

                // Extract base64 data and validate
                $data = base64_decode(explode(',', $src)[1]);
                if ($data !== false) {
                    $imgName = 'upload/services/' . $slug . '/content/' . Str::random(20) . '.' . $extension;

                    file_put_contents(public_path($imgName), $data);
                    $image->removeAttribute('src');
                    $image->setAttribute('src', asset('public/' . $imgName));
                } else {
                    return self::sendErr('Something went wrong.');
                }
            }
        }
        $content = $dom->saveHTML();

        if($icon)
        { 
            $service['icon'] = $icon;
            
        }
        if($thumbnail)
        {
            $service['thumbnail'] = $thumbnail;
            
        }

        $service['title']     = $title;
        $service['slug']      = $slug;
        $service['slogan']    = htmlspecialchars($request->slogan);
        $service['content']   = $content;

        Service::where('id', $id)->update($service);
        return self::sendRes('Service has been updated.');
    }
}
