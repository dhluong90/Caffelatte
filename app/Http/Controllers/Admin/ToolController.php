<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\ApiHelper;
use App\Http\Models\Dal\UserCModel;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Http\Models\Dal\CustomerQModel;

use Facebook\Facebook;

/**
 * Class ToolController
 * @package App\Http\Controllers\Api
 */
class ToolController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    protected $row_header = [
        'Tên',
        'Email',
        'Giới tính',
        'Số điện thoại',
        'Quốc gia',
        'Ngày đăng ký'
    ];

    protected $row_used = [
        'A',
        'B',
        'C',
        'D',
        'E',
        'F'
    ];

    protected $list_field_export = [
        'name',
        'email',
        'gender',
        'phone',
        'country',
        'created_at'
    ];

    public function index() {

    }

    public function update_friend(Request $request) {

        $user_sucess = [];
        $users = DB::table('users')->get();

        $fb = new Facebook([
            'app_id' => config('facebook.id'),
            'app_secret' => config('facebook.secret')
        ]);

        foreach ($users as $user) {
            $friends = [];
            try {
                $response = $fb->get('/me/friends?limit=4000', $user->facebook_token);
                $graphEdge = $response->getGraphEdge();
                foreach ($graphEdge as $graphNode) {
                    array_push($friends, $graphNode['id']);
                }

                UserCModel::update_user($user->id, [
                    '_friend' => json_encode($friends)
                ]);

                array_push($user_sucess, [$user->id => 'success']);

            } catch (\Exception $e) {
                array_push($user_sucess, [$user->id => $e->getMessage()]);
            }
        }

        return ApiHelper::success($user_sucess);
    }

    public function update_image(Request $request) {
        $user_sucess = [];
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            UserCModel::update_user($user->id, [
                'image' => json_encode(['https://graph.facebook.com/'.$user->facebook_id.'/picture?type=large&width=720&height=720'])
            ]);
            array_push($user_sucess, [$user->id => 'success']);
        }
        return ApiHelper::success($user_sucess);
    }

    public function export_file_customer_list(Request $request) {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Danh Sách Người Dùng');
        $user = CustomerQModel::get_all_user();
        $spreadsheet->getActiveSheet()->getStyle('1:1')->getFont()->setBold(true);
        foreach($this->row_header as $i => $title) {
            $sheet->setCellValue($this->row_used[$i]."1", $title);
        }

        $first_row = 2;
        foreach($user as $index => $item) {
            $current_row = $first_row + $index;
            foreach ($this->row_used as $index2 => $item_row_used) {
                $field_value_cell = $this->list_field_export[$index2];


                $data_cell = $item->{$field_value_cell};
                if ($field_value_cell == 'gender') {
                    if ($data_cell == 1) {
                        $data_cell = 'Nam';
                    } else if ($data_cell == 0) {
                        $data_cell = 'Nữ';
                    }
                }
                if ($field_value_cell == 'phone') {
                    $sheet->setCellValueExplicit($item_row_used.$current_row, $data_cell, DataType::TYPE_STRING);
                } else {
                    $sheet->setCellValue($item_row_used.$current_row, (string)$data_cell);
                }

            }
        }

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="customer-'.time().'.xlsx"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        header('Connection: close');

    }
}