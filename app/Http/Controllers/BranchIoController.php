<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiHelper;
use App\Http\Models\Dal\CustomerCModel;
use App\Http\Models\Dal\CustomerQModel;
use Illuminate\Http\Request;

class BranchIoController extends Controller
{
    public function webhook(Request $request)
    {
        $data = file_get_contents('php://input');
        try {
            $file = fopen("logs/webhook.txt", "w");
            echo fwrite($file, $data);
            fclose($file);

            if ($data) {
                $data = json_decode($data);
            }

            $action = $data->name;
            if ($action == 'INSTALL') {
                $lastAttributedTouchData = $data->last_attributed_touch_data;
                $shareLinkId = $lastAttributedTouchData->{'~id'};
                $customer = CustomerQModel::get_user_by_share_link_id($shareLinkId);

                if ($customer) {
                    $current_time = time();
                    if ($customer->point_at != date('Y-m-d', $current_time)) {
                        // new date, reset old_point
                        $log = $customer->point_log;
                        if (!$log) {
                            $log = [];
                        } else {
                            $log = json_decode($log, true);
                        }
                        $log[] = [
                            'point' => 2,
                            'created_at' => date('Y-m-d', $current_time)
                        ];
                        CustomerCModel::update_user($customer->id, [
                            'point' => $customer->point + 2,
                            'old_point' => 2,
                            'point_at' => date('Y-m-d', $current_time),
                            'point_share' => $customer->point_share + 2,
                            'point_log' => json_encode($log, true)
                        ]);

                        return ApiHelper::success(['message' => 'success add point new date']);
                    } else {
                        $log = $customer->point_log;
                        if (!$log) {
                            $log = [];
                        } else {
                            $log = json_decode($log, true);
                        }
                        $log[] = [
                            'point' => 2,
                            'created_at' => date('Y-m-d', $current_time)
                        ];
                        CustomerCModel::update_user($customer->id, [
                            'point' => $customer->point + 2,
                            'old_point' => $customer->old_point + 2,
                            'point_share' => $customer->point_share + 2,
                            'point_log' => json_encode($log, true)
                        ]);

                        return ApiHelper::success(['message' => 'success add point']);
                    }
                }
            }

        } catch (Exception $e) {
            $file = fopen("logs/error_webhook.txt", "w");
            echo fwrite($file, $e->getMessage());
            fclose($file);
        }

        return response()->json(['status' => 'success']);
    }
}
