<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Channel;
use App\Lead;
use App\LogLead;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadsController extends Controller
{
    public function __construct()
    {
    }

    public function landingPageService(Request $request)
    {
        try {
            // Create Log_leads
            $log = LogLead::create([
                'type' => Lead::LANDING_PAGE_SYSTEM,
                'status' => 0,
                'request' => $request
            ]);

            // Rules
            $validator = Validator::make($request->all(), [
                'channel_id' => 'required|numeric',
                'name' => 'required|string',
                'phone' => 'required',
                'email' => 'required|email',
            ]);

            if($validator->fails()) {
                LogLead::where('id', $log->id)
                    ->update([
                        'result' => json_encode($validator->errors()->all())
                    ]);

                return response()->json([
                    'response' => 'error',
                    'message' => $validator->errors()->all()
                ], 422);
            }

            // Found Campaign_id
            $channel = Channel::where([
                ['id', $request->get('channel_id')]
            ])->first();

            if(!empty($channel))
            {
                 // Found Channel_id within Campaign_id
                 $array_campaign = Channel::where([
                    ['campaign_id', $channel->campaign_id]
                 ])->pluck('id')->toArray();

                 $form_email = $request->get('email');
                 $form_phone = $request->get('phone');

                 // Found Duplicate lead
                 $query = Lead::whereIn('channel_id', $array_campaign);
                 $query->where('is_duplicated', 0);
                 $query->where(function($q) use ($form_email, $form_phone){
                         $q->where([
                             ['form_email', $form_email],
                             ['form_email', '!=', '']
                         ])->orWhere([
                             ['form_phone', $form_phone],
                             ['form_phone', '!=', '']
                         ]);
                     });
                 $duplicated_lead = $query->first();

                 if(!empty($duplicated_lead))
                 {
                    $is_duplicated = 1;
                    $parent_id = $duplicated_lead->id;
                 }
                 else
                 {
                     $is_duplicated = 0;
                     $parent_id = Null;
                 }

                 $lead = Lead::create([
                     'channel_id' => $request->get('channel_id'),
                     'type' => Lead::TYPE_SUBMITTED,
                     'submitted_date_time' => Carbon::now(),
                     'form_name' => $request->get('name'),
                     'form_email' => $request->get('email'),
                     'form_phone' => $request->get('phone'),
                     'form_content' => json_encode($this->get_content($request)),
                     'form_ip_address' => $request->get('ip_address'),
                     'form_page_url' => $request->get('page_url'),
                     'is_duplicated' => $is_duplicated,
                     'parent_id' => $parent_id
                 ]);

                LogLead::where('id', $log->id)
                    ->update([
                        'lead_id' => $lead->id,
                        'status' => 1
                    ]);

                return response()->json([
                    'response' => 'success',
                    'message' => 'Create lead success',
                ], 200);
            }
            else
            {
                return response()->json([
                    'response' => 'error',
                    'message' => 'Not found channel_id',
                ], 422);
            }

        } catch (\Exception $e) {
            return response()->json([
                'response' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * get content
     * @param $request
     * @return array
     */
    public function get_content($request)
    {
        $array = [];

        foreach($request->all() as $key => $value)
        {
            if(!in_array($key, Lead::NOT_CONTENT))
            {
                $array[$key] = [$value];
            }
        }

        return $array;
    }

    public function getLeads(Request $request)
    {
        try {
            // Rules
            $validator = Validator::make($request->all(), [
                'campaign_id' => 'required|numeric',
                'startDateTime' => 'required_with:endDateTime|date_format:Y-m-d\TH:i:s',
                'endDateTime' => 'required_with:startDateTime|date_format:Y-m-d\TH:i:s|after:startDateTime',
            ]);

            if($validator->fails()) {
                return response()->json([
                    'response' => 'error',
                    'message' => $validator->errors()->all()
                ], 422);
            }

            $campaign = Campaign::where('id', $request->get('campaign_id'))->first();

            $array_channel = [];

            foreach($campaign->channels as $key => $channel)
            {
                $array_channel[$key] = $channel->id;
            }

            $query = Lead::whereIn('channel_id', $array_channel);

            if(!empty($request->get('startDateTime')) && !empty($request->get('endDateTime')))
            {
                $startDateTime = Carbon::parse($request->get('startDateTime'));
                $endDateTime   = Carbon::parse($request->get('endDateTime'));
                $query->whereBetween('submitted_date_time', [$startDateTime, $endDateTime]);
            }

            $query->orderBy('submitted_date_time', 'Asc');
            $response = $query->get();

            return response()->json([
                'response' => 'success',
                'message' => 'Create lead success',
                'data' => $response,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'response' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function phoneService(Request $request)
    {

    }
}
