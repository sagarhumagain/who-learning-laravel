<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContractType;
use App\Models\Course;
use App\Models\CourseAssignmentSetting;
use App\Models\Designation;
use App\Models\Pillar;
use App\Models\Role;
use App\Models\StaffCategory;
use App\Models\StaffType;
use App\Models\Unit;
use App\Models\User;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use ZipArchive;

use function PHPUnit\Framework\isEmpty;

class BaseController extends Controller
{
    public function checkDirectoryExist()
    {
        //check folder
        if (!file_exists(public_path($this->folder_path))) {
            mkdir(public_path($this->folder_path));
        }
    }

    //check folder exits
    public function checkFolderExist($path)
    {
        if (!file_exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
            File::makeDirectory($path . '/thumbs', $mode = 0777, true, true);
        }
    }
    //rename directory if already exists
    public function renameDirectory($old_dir, $new_dir)
    {
        rename($old_dir, $new_dir);
    }
    //making image with thumb
    public function makeImageWithThumb($slug, $photo, $path)
    {
        $ext = explode('/', explode(':', substr($photo, 0, strpos($photo, ';')))[1])[1];
        $name = $slug . '.' .$ext;
        Image::make($photo)->save($path.'/'. $name);
        Image::make($photo)->resize(1024, 700)->save($path.'/thumbs/'.'big_'.$name);//resize image
        Image::make($photo)->resize(100, 100)->save($path.'/thumbs/'.'small_'.$name);//resize image
        return '/'.$path.'/'. $name;
    }
    public function getRandId()
    {
        $alphabet = array('A','B','C','D','E','F','G','H','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y');
        $rand_char = $alphabet[array_rand($alphabet, 1)];

        $time_stamp = Carbon::today()->format('ymd');

        $seconds = $this->convertTimeToSecond(Carbon::now()->format('H:i:s'));
        return str_pad(\rand(1, 1000), 4, "0", STR_PAD_LEFT).'-'.$time_stamp.'-'.str_pad($seconds, 5, "0", STR_PAD_LEFT).$rand_char;
    }
    private function convertTimeToSecond(string $time): int
    {
        $d = explode(':', $time);

        $time =  ($d[0] * 3600) + ($d[1] * 60) + $d[2];
        return $time;
    }

    public function notifications(Request $request)
    {
        $user = $request->user();
        $data['notifications'] = $user->unreadnotifications;
        return $data;
    }

    public function read(Request $request)
    {
        $notification = auth()->user()->notifications->where('id', '=', $request->read_notification)->first();
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function unread(Request $request)
    {
        $notification = auth()->user()->notifications->where('id', '=', $request->unread_notification)->first();
        if ($notification) {
            $notification->markAsUnread();
        }
    }

    public function readAll()
    {
        $notification = auth()->user()->notifications;
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function filterArrayByKey($datas, $key)
    {
        if (!$datas || $datas == 'null' || $datas == 'undefined') {
            return [];
        } else {
            $datas = gettype($datas) == "string" ? json_decode($datas, true) : $datas;
        }
        $val =  [];
        foreach ($datas as $data) {
            array_push($val, $data[$key]);
        }
        return $val;
    }
    public function getChoices()
    {
        if (auth()->user()->hasRole('super-admin')) {
            $query = Role::select('name', 'id');
        } else {
            $query = Role::select('name', 'id')->where('name', '=', 'normal-user');
        }
        $roles = $query->get();
        $pillars = Pillar::select('name', 'id')->get();
        $supervisors = User::role('supervisor')->pluck('name', 'id');
        $contract_types = ContractType::pluck('name', 'id');
        $designation_types = Designation::pluck('name', 'id');
        $staff_categories = StaffCategory::pluck('name', 'id');
        $staff_types = StaffType::pluck('name', 'id');
        $units = Unit::pluck('name', 'id');
        $data = [
            'roles' => $roles,
            'pillars' => $pillars,
            'supervisors' => $supervisors,
            'contract_types' => $contract_types,
            'designation_types' => $designation_types,
            'staff_categories' => $staff_categories,
            'staff_types' => $staff_types,
            'units' => $units,
        ];
        return $data;
        ;
    }

    public function epub()
    {
        return view('epub');
    }
    public function epubReader(Request $request)
    {
        $file = $request->file('file');
        $zip = new ZipArchive();
        $res = $zip->open($file);
        dd($res);
        if ($res === true) {
            $container = $zip->getFromName('META-INF/container.xml');
            dd($container);
            preg_match('/full-path="(.*?)"/', $container, $matches);
            $opf = $matches[1];

            $opf = $zip->getFromName($opf);

            preg_match('/<dc:title>(.*?)<\/dc:title>/', $opf, $matches);
            $title = $matches[1];

            preg_match('/<dc:creator opf:role="aut">(.*?)<\/dc:creator>/', $opf, $matches);
            $author = $matches[1];

            $chapters = [];

            //<item id="Chapter01" href="xhtml/11_chapter01.xhtml" media-type="application/xhtml+xml" />
            preg_match_all('/<item id="(.*?)" href="(.*?)" media-type="(.*?)" \/>/', $opf, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                $id = $match[1];
                $href = $match[2];
                $mediaType = $match[3];

                if ($mediaType == 'application/xhtml+xml') {
                    $chapters[$id] = [
                        'href' => $href,
                        'chapter_content' => $zip->getFromName($href),
                    ];
                }
            }

            $zip->close();


            dd($title, $author, $chapters);

            // Pass the information to the view
            return view('epub', [
                'title' => $title,
                'author' => $author,
                'chapters' => $chapters,
            ]);
        } else {
            return redirect()->back()->with('error', 'Failed to extract the contents of the EPUB file.');
        }
    }
}
