<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\Circle\CircleRegisterRequest;
use App\Models\Circle;
use App\Models\CircleLink;
use App\Models\Event;
use App\Repositories\CircleRepository;
use App\Repositories\EventRepository;
use App\Services\CircleEventService;
use App\Services\CircleService;
use App\Services\EventService;
use Illuminate\Http\Request;

class CircleController extends Controller
{
    //

    public function __construct(private CircleRepository $circleRepository, private CircleService $circleService, private EventRepository $eventRepository, private EventService $eventService, private CircleEventService $circleEventService)
    {

    }

    public function index(Request $request)
    {
        $filter = $request->all();

        $circles = $this->circleService->getCircleList($filter);

        // // return $circles;


        // $circle = new Circle([
        //     'name' => 'テストサークル_1',
        //     'author' => 'テスト作家',
        //     'circle_ms_id' => 13013043
        // ]);

        // $circleLinks = [
        //     'twitter_1' => 'https://twitter.com/xxxxxx1',
        //     'twitter_2' => 'https://twitter.com/xxxxxx2',
        //     'twitter_3' => 'https://twitter.com/xxxxxx3',
        //     'pixiv_1' => 'https://pixiv.com/xxxxxx1',
        //     'website_1' => 'https://example.com/',
        // ];

        // $circleLinkModelArray = [];

        // foreach ($circleLinks as $type => $url) {
        //     $circleLinkModelArray[] = new CircleLink([
        //         // 'circle_id' => $circle->id,
        //         'type' => $type,
        //         'url' => $url,
        //     ]);
        // }

        // $circle = $this->circleRepository->save($circle);
        // $circle = $this->circleRepository->saveLinks($circle, $circleLinkModelArray);

        // return $circle->getLinks();


        // return [
        //     'ok' => 'success'
        // ];

        return view('page.circle.index', compact('circles'));
    }

    public function register(CircleRegisterRequest $request)
    {
        $request->validated();
    }

    public function show(Request $request, int $id)
    {
        $circle = $this->circleRepository->findById($id);
        if (!$circle) {
            $this->success([], 404);
        }

        $response = [];
        $response['circle'] = $this->circleService->makeCircleResponse($circle);

        $eventParticipation = $this->circleEventService->makeEventCircleInfoArray($circle);

        $eventIds = array_map(fn($event) => $event['event_id'], $eventParticipation);
        $events = $this->eventRepository->getByIds($eventIds);

        $resEvents = [];
        /** @var Event $event */
        foreach ($events as $event) {
            foreach ($eventParticipation as $participation) {
                if ($participation['event_id'] === $event->id) {
                    $resEvents[] = [
                        'info' => $this->eventService->makeEventResponse($event),
                        'participation' => $participation,
                    ];
                }
            }
        }

        $response['event'] = $resEvents;

        return view('page.circle.show', compact('response'));
        // return $response;
    }
}
