<?php

namespace App\Http\Helpers;

Class YoutubeHelper {
    // youtube
    const YOUTUBE_LINK = 'https://www.youtube.com/watch?v=';
    const YOUTUBE_API_LINK = 'https://www.googleapis.com/youtube/v3/videos';

    /**
     * get info video by id
     * @param $ids
     * @return array item video
     */
    public static function get_info_video_by_id($ids) {
        $youtube_api_key = env('YOUTUBE_API_KEY', '');

        $videos = [];

        foreach ($ids as $id) {
            $video = json_decode(file_get_contents(self::YOUTUBE_API_LINK . '?id=' . $id . '&key=' . $youtube_api_key . '&part=snippet'));
            
            if (isset($video->items) && count($video->items) != 0) {
                array_push($videos, $video->items[0]);
            }
        }

        return $videos;
    }
}