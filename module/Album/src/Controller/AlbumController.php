<?php

namespace Album\Controller;

// Add the following import:
use Album\Model\AlbumTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Form\AlbumForm;
use Album\Model\Album;
use Album\Itunes_Context;

include_once __DIR__ . '/Itunes_Context.php';

class AlbumController extends AbstractActionController
{
    public function indexAction()
    {
    }

    public function pingAction()
    {
        $response = Itunes_Context::RssTopMusicVideos(20);
        var_dump($response);
        exit();

        self::showResponse(0,'Ping:Success');
    }

    public function itunesRssTopMusicVideosPagingAction()
    {
        $request = $this->getRequest();
        $gets = $request->getQuery();
        $limit = $gets['limit'];
        $page = $gets['page'];
        $start = $gets['start'];
        $callback = $gets['callback'];

        if ($limit<=0) showResponse(1,'Incorrect param',false);

        $resultSearch = Itunes_Context::RssTopMusicVideosPaging($page,$start,$limit);
        $response = self::getJsonResponse(0,'Success', $resultSearch);

        echo "{$callback}({$response});";
        exit();
    }

    private static function showResponse($code, $message, $data = false) {
        echo json_encode([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
        exit();
    }
    private static function getJsonResponse($code, $message, $data = false) {
        return json_encode([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }
}