<?php


namespace Album;

use Zend\Http\Client;

class Itunes_Context {

    private static function requestSearch($params) {
        $client = new Client('https://itunes.apple.com/search',$params);
        return $client->send()->getBody();
    }

    public static function Search($params) {
        if (empty($params)) return false;

        $response = self::requestSearch($params);
        $response = json_decode($response,true);
        return $response;
    }


    private static function requestRssTopMovies($limit) {
        $url = "https://itunes.apple.com/us/rss/topmovies/limit={$limit}/json";
        $client = new Client($url);
        return $client->send()->getBody();
    }

    public static function RssTopMovies($limit = 20) {
        if ($limit <= 0) return false;
        $response = self::requestRssTopMovies($limit);
        $response = json_decode($response,true);
        return $response;
    }


    private static function requestRssTopMusicVideos($limit) {
        $url = "https://itunes.apple.com/us/rss/topmusicvideos/limit={$limit}/json";
        $client = new Client($url);
        return $client->send()->getBody();
    }

    public static function RssTopMusicVideos($limit = 20) {
        if ($limit <= 0) return false;
        $response = self::requestRssTopMusicVideos($limit);
        $response = json_decode($response,true);
        return $response;
    }

    private static function requestRssTopMusicVideosPaging($page,$start,$limit) {
        $url = "https://itunes.apple.com/us/rss/topmusicvideos/limit=50/json?page={$page}&start={$start}&limit=$limit";
        $client = new Client($url);
        return $client->send()->getBody();
    }

    public static function RssTopMusicVideosPaging($page,$start,$limit) {
        $response = self::requestRssTopMusicVideosPaging($page,$start,$limit);
        $response = json_decode($response,true);
        return $response;
    }

}