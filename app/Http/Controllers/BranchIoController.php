<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiHelper;
use App\Http\Models\Dal\CustomerCModel;
use App\Http\Models\Dal\CustomerQModel;
use Illuminate\Http\Request;

class BranchIoController extends Controller {
    public function webhook(Request $request) {
        $data = file_get_contents('php://input');
        try {
            $file = fopen("logs/webhook.txt","w");
            echo fwrite($file,$data);
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
                        CustomerCModel::update_user($customer->id, [
                            'point' => $customer->point + 2,
                            'old_point' => 1,
                            'point_at' => date('Y-m-d', $current_time)
                        ]);

                        return ApiHelper::success(['message' => 'success add point new date']);
                    } else {
                        if ($customer->old_point < 3) {
                            CustomerCModel::update_user($customer->id, [
                                'point' => $customer->point + 2,
                                'old_point' => $customer->old_point + 2
                            ]);

                            return ApiHelper::success(['message' => 'success add point']);
                        } else {
                            return ApiHelper::error(
                                config('constant.error_type.bad_request'),
                                config('constant.error_code.customer.point_limit'),
                                'point limit',
                                400
                            );
                        }
                    }
                }
            }

        } catch (Exception $e) {
            $file = fopen("logs/error_webhook.txt","w");
            echo fwrite($file,$e->getMessage());
            fclose($file);
        }

        return response()->json(['status'=>'success']);
    }
}
