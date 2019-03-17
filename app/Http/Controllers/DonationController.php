<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donation;
use App\ProgramPackage;
use App\User;
use XenditClient;
use Illuminate\Support\Facades\Mail;
use App\Mail\DonationCreated;
use App\Mail\DonationCompleted;

class DonationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['callback']);
        $this->middleware('checkRole:' . \App\User::ROLE_ADMIN)
            ->except(['index', 'callback', 'create', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->sort ? $request->sort : 'updated_at';
        $order = $request->order == 'ascending' ? 'asc' : 'desc';

        $donations = Donation::selectRaw('donations.*, users.name AS user, programs.name AS program, program_packages.name AS package')
            ->join('users', 'users.id', '=', 'donations.user_id')
            ->join('programs', 'programs.id', '=', 'donations.program_id')
            ->join('program_packages', 'program_packages.id', '=', 'donations.program_package_id')
            ->when($request->user()->role == \App\User::ROLE_MEMBER, function($q) use ($request) {
                return $q->where('user_id', $request->user()->id);
            })->when($request->keyword, function ($q) use ($request) {
                return $q->where('programs.name', 'LIKE', '%' . $request->keyword . '%')
                    ->orWhere('program_packages.name', 'LIKE', '%' . $request->keyword . '%')
                    ->orWhere('users.name', 'LIKE', '%' . $request->keyword . '%');
            })->when($request->status, function ($q) use ($request) {
                return $q->whereIn('status', $request->status);
            })->orderBy($sort, $order)->paginate($request->pageSize);

        if ($request->ajax()) {
            return $donations;
        }

        return view('donation.index', [
            'title' => 'Donasi Saya',
            'donations' => $donations,
            'breadcrumbs' => [
                'Donasi Saya' => '#',
            ]
        ]);

    }

    public function show(Donation $donation)
    {
        return view('donation.show', ['donation' => $donation]);
    }

    public function create(Request $request)
    {
        $package = ProgramPackage::where('id', $request->package)->first();

        if (!$package) {
            abort(404, 'Paket program tidak ditemukan!');
        }

        return view('donation.create', [
            'title' => 'Donasi',
            'package' => $package,
            'breadcrumbs' => [
                'Donasi' => url('program'),
                $package->program->name => url('program/'.$package->program_id),
                $package->name => '#'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *p
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required',
            'program_package_id' => 'required',
            'amount' => 'required',
        ]);

        $input = $request->all();
        $input['user_id'] = $request->user()->id;
        $donation = Donation::create($input);

        $options['secret_api_key'] = env('XENDIT_API_KEY');

        $xenditPHPClient = new XenditClient\XenditPHPClient($options);

        $external_id = 'donasi-qiblat-'.$donation->id;
        $payer_email = $request->user()->email;
        $description = $request->remark;
        $amount = $request->amount;
        $response = $xenditPHPClient->createInvoice($external_id, $amount, $payer_email, $description);

        if (!isset($response['error_code'])) 
        {
            $donation->expired_at = date('Y-m-d H:i:s', strtotime($response['expiry_date']));
            $donation->status = $response['status'];
            $donation->external_id = $external_id;
            // $donation->invoice_url = $response[ 'invoice_url'];
            $donation->save();

            // Mail::to($donation->user)
            //     ->cc(User::where('role', User::ROLE_ADMIN)->get())
            //     ->queue(new DonationCreated($donation));
        }
        
        else {
            $donation->delete();
        }

        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Donation $donation)
    {
        return $donation->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Donation $donation)
    {
        $donation->delete();
        return ['message' => 'OK'];
    }

    public function callback(Request $request)
    {
        // script buat test
        // curl  --include \--request POST  \--header  "Content-Type: application/json" \--data - binary "{
        //     \"id\": \"5691da1ccad1b1322b8a39e5\",
        //     \"user_id\": \"569c861f909bb3f68020d363\",
        //     \"external_id\": \"5691dab1322b8a39e51ccad1\",
        //     \"status\": \"COMPLETED\",
        //     \"is_high\": false,
        //     \"merchant_name\": \"Xendit\",
        //     \"merchant_profile_picture_url\": \"https://www.xendit.co/profile.png\",
        //     \"amount\": 8000000,
        //     \"billable_amount\": 8640000,
        //     \"payer_email\": \"payer@test.com\",
        //     \"description\": \"Invoice #123124123 for Nike shoes\",
        //     \"received_amount\": 7760000,
        //     \"xendit_fee_amount\": 79000,
        //     \"taxes\": [
        //         {
        //             \"name\": \"VAT\",
        //             \"percentage\": 0.10,
        //             \"amount\": 800000
        //         },
        //         {
        //             \"name\": \"PPH\",
        //             \"percentage\": -0.02,
        //             \"amount\": -160000
        //         }
        //     ],
        //     \"fees\": [
        //         {
        //             \"name\": \"Agent Fee\",
        //             \"percentage\": 0.02,
        //             \"amount\": 80000,
        //             \"xendit_user_id\": \"57078f3faedd2019cfd8b2fc\"
        //         }
        //     ]
        // }" \'http://localhost:8000/donation/callback'

        // {
        //     "id": "579c8d61f23fa4ca35e52da4",
        //     "user_id": "5781d19b2e2385880609791c",
        //     "external_id": "invoice_123124123",
        //     "is_high": true,
        //     "status": "PAID",
        //     "merchant_name": "Xendit",
        //     "amount": 50000,
        //     "payer_email": "albert@xendit.co",
        //     "description": "This is a description",
        //     "paid_amount": 50000,
        //     "payment_method": "POOL",
        //     "adjusted_received_amount": 47500,
        //     "updated": "2016-10-10T08:15:03.404Z",
        //     "created": "2016-10-10T08:15:03.404Z"
        // }

        $data = file_get_contents("php://input");
        $donation = Donation::where('external_id', $data['external_id'])->first();
        $donation->status = $data['status'];
        $donation->save();

        if ($donation) 
        {
            $donation->update($data);

            // Mail::to($donation->user)
            //     ->cc(User::where('role', User::ROLE_ADMIN)->get())
            //     ->queue(new DonationCompleted($donation));
            
        }

        return ['message' => 'OK'];
    }
}
