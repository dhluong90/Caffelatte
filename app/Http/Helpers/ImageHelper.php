<?php

namespace App\Http\Helpers;

//use File;
use App\Http\Helpers\ConvertStringHelper;
use App\Http\Helpers\Constants;
use Intervention\Image\ImageManagerStatic;
use Illuminate\Support\Facades\File;

Class ImageHelper {

    /**
     * upload image
     * @param files
     * @param array config ex: ['url' => 'uploads/user', 'size' => ['50x50','150x150','300x300']]
     * @return array links
     */
    public static function upload_multi_image($files, $config) {
        $links = [];
        foreach ($files as $file) {
            $link = self::upload_image($file, $config);
            array_push($links, $link);
        }

        return $links;
    }

    /**
     * upload image
     * @param file
     * @param array config ex: ['url' => 'uploads/user', 'size' => ['50x50','150x150','300x300']]
     * @return string link
     */
    public static function upload_image($file, $config) {
        $manage_image = ImageManagerStatic::make($file);

        // get image link
        $month = date('m', time());
        $year = date('Y', time());
        $image_link = $config['url'] . '/' . $year . '/' . $month;

        // convert name file
        $image_name_main = time() . '_' . ConvertStringHelper::convert_vn_to_str(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $image_main = $image_link . '/' . $image_name_main . '.' . $extension;
        
        // create folder
        File::makeDirectory($image_link, 0777, true, true);

        // save image main
        $manage_image->save($image_main);

        // drop and save image
        foreach ($config['size'] as $str_size) {
            // reset manage_image to process
            $manage_image_resize = ImageManagerStatic::make($file);

            // get image size drop
            $arr_size = explode('x', $str_size);
            $image_drop_width = $arr_size[0];
            $image_drop_height = $arr_size[1];

            $image_main_width = $manage_image_resize->width();
            $image_main_height = $manage_image_resize->height();

            // check image to drop top-bottom or left-right
            if ($image_drop_height * $image_main_width / $image_main_height >= $image_drop_width) {
                // height as standard to drop left-right
                $manage_image_resize->resize($image_drop_height * $image_main_width / $image_main_height, $image_drop_height)->resizeCanvas($image_drop_width, $image_drop_height);
            } else {
                // width as standard to drop top-bottom
                $manage_image_resize->resize($image_drop_width, $image_drop_width * $image_main_height / $image_main_width)->resizeCanvas($image_drop_width, $image_drop_height);
            }

            // get name image resize
            $image_resize = $image_link . '/' . $image_name_main . '_' . $str_size . '.' . $extension;

            // save image resize
            $manage_image_resize->save($image_resize);
        }

        return $image_main;
    }

    /**
     * delete image
     * @param string image_url
     * @param array config ex: ['url' => 'uploads/user', 'size' => ['50x50','150x150','300x300']]
     */
    public static function delete_image($image_url, $config) {
        // delete image main
        File::delete($image_url);

        foreach ($config['size'] as $size) {
            File::delete(self::get_image_by_size($image_url, $size));
        }
    }

    /**
     * get link image by size
     * @param string image_url
     * @param string size
     * @return string link
     */
    public static function get_image_by_size($image_url, $size) {
        return mb_substr($image_url, 0, mb_strrpos($image_url, '.')) . '_' . $size . mb_substr($image_url, mb_strrpos($image_url, '.'));
    }

    /**
     * get link image icon size 150x150
     * @param string image_url
     * @return string link
     */
    public static function get_image_icon($image_url) {
        return self::get_image_by_size($image_url, '150x150');
    }
}