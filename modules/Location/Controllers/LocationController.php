<?php
namespace Modules\Location\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Location\Models\Location;
use Modules\Tour\Models\Tour;

class LocationController extends Controller
{
    public $location;
    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function index(Request $request)
    {

    }

    public function detail(Request $request, $slug)
    {
        $row = $this->location::where('slug', $slug)->where("status", "publish")->first();;
        if (empty($row)) {
            return redirect('/');
        }

        //Auth::user()->can('viewAny', Tour::class);


        $translation = $row->translateOrOrigin(app()->getLocale());
        $data = [
            'row' => $row,
            'translation' => $translation,
            'seo_meta' => $row->getSeoMetaWithTranslation(app()->getLocale(), $translation),
        ];
        $this->setActiveMenu($row);
        return view('Location::frontend.detail', $data);
    }

    public function searchForSelect2( Request $request ){
        $search = $request->query('search');
        $query = Tour::select('bravo_tours.id', 'bravo_tours.title', 'bravo_tours.status')->where("bravo_tours.status","publish");
        // $query = Location::select('bravo_locations.*', 'bravo_locations.name as title')->where("bravo_locations.status","publish");
        if ($search) {
            $query->where('bravo_tours.title', 'like', '%' . $search . '%');
            //     $query->where('bravo_locations.name', 'like', '%' . $search . '%');

            // if( setting_item('site_enable_multi_lang') && setting_item('site_locale') != app_get_locale() ){
            //     $query->leftJoin('bravo_location_translations', function ($join) use ($search) {
            //         $join->on('bravo_locations.id', '=', 'bravo_location_translations.origin_id');
            //     });
            //     $query->orWhere(function($query) use ($search) {
            //         $query->where('bravo_location_translations.name', 'LIKE', '%' . $search . '%');
            //     });
            // }

        }
        $res = $query->orderBy('id', 'desc')->limit(20)->get();
        if(!empty($res) and count($res)){
            foreach ($res as $location) {
                $translate = $location->translateOrOrigin(app()->getLocale());
                $list_json[] = [
                    'id' => $location->id,
                    'title' => $translate->title,
                ];
            }
        //     $list_json = [];
        //     $traverse = function ($locations, $prefix = '') use (&$traverse, &$list_json) {
        //         foreach ($locations as $location) {
        //             $translate = $location->translateOrOrigin(app()->getLocale());
        //             $list_json[] = [
        //                 'id' => $location->id,
        //                 'title' => $prefix . ' ' . $translate->name,
        //             ];
        //             $traverse($location->children, $prefix . '-');
        //         }
        //     };
        //     $traverse($res);
        //     $this->sendSuccess(['data'=>$list_json]);
            $this->sendSuccess(['data'=>$list_json]);
        }
        return $this->sendError(__("Tour not found"));
    }
}
