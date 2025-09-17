<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\City;
use App\Mail\Contact;
use App\Models\ContactUs;
use App\Models\NewsLetter;
use App\Models\ModelCompany;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class GeneralController extends Controller
{
    public function term_condition()
    {
        return view('general.term_condition');
    }
    public function privacy_policy()
    {
        return view('general.privacy_policy');
    }
    public function faq()
    {
        return view('general.faq');
    }
    public function aboutus()
    {
        return view('general.aboutus');
    }
    public function subscribe(Request $request)
    {
        // Validate the email
        $request->validate([
            'sub_email' => 'required|email',
        ]);

        // Check if the email already exists in the database
        $check = Subscription::where('email', $request->sub_email)->first();

        if (!$check) {
            // Create a new subscription
            $subscribe = new Subscription();
            $subscribe->email = $request->sub_email;
            $subscribe->save();

            // Return a JSON response for successful subscription
            return response()->json(['message' => 'Subscribed successfully!'], 200);
        } else {
            // Return a JSON response for already subscribed
            return response()->json(['message' => 'Already subscribed.'], 409); // 409 Conflict
        }
    }

    public function get_city($provinceId)
    {
        $cities = City::where('state_id', $provinceId)->get();

        return response()->json($cities);
    }

    public function get_model($modelId, Request $request)
    {
        $path = $request->query('path', '');
        $sql = "SELECT model_companies.id, model_companies.name, COUNT(DISTINCT posts.id) as count
        FROM model_companies
        LEFT JOIN posts ON model_companies.id = posts.model
        WHERE model_companies.make_id = ? 
        AND posts.status = 1
        AND posts.deleted_at IS NULL";

        $params = [$modelId];

        if (str_contains($path, 'cars/used')) {
            $sql .= " AND posts.condition = ?";
            $params[] = 'used';
        } elseif (str_contains($path, 'cars/new')) {
            $sql .= " AND posts.condition = ?";
            $params[] = 'new';
        }

        $sql .= " GROUP BY model_companies.id, model_companies.name";

        $models = DB::select($sql, $params);

        return response()->json($models);
    }


    public function get_cities($provinceId, Request $request)
    {
        $path = $request->query('path', '');
        $conditionFilter = '';

        if (str_contains($path, 'cars/used')) {
            $conditionFilter = "AND p.condition = 'used'";
        } elseif (str_contains($path, 'cars/new')) {
            $conditionFilter = "AND p.condition = 'new'";
        }

        // $cities = City::where('state_id', $provinceId)->get();

        // Construct the raw SQL query
        $sql = "SELECT DISTINCT c.id, c.name, COUNT(DISTINCT p.id) as count
                FROM locations l
                INNER JOIN cities c ON l.city = c.id
                INNER JOIN posts p ON l.post_id = p.id
                WHERE l.province = ?
                AND p.status = 1
                AND p.deleted_at IS NULL
                $conditionFilter
                GROUP BY c.id, c.name
                    ";

        // Execute the raw query
        $cities = DB::select($sql, [$provinceId]);

        return response()->json($cities);
    }
    public function get_models($makeId, Request $request)
    {
        $models = ModelCompany::where('make_id', $makeId)
            ->select('id', 'name')
            ->get();

        return response()->json($models);
    }

    public function contact()
    {
        return view('user.contact.create');
    }
    public function contactUs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'dealer' => 'required|max:255',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'number' => 'required',
            'message' => 'required',

        ]);

        if ($validator->fails()) {

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $contact = new ContactUs();
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->email = $request->email;
        $contact->number = $request->number;
        $contact->message = $request->message;

        $contact->save();
        //$body = view('emails.contact_us', compact('contact'));
        //      sendMail($contact->first_name, $contact->email, 'Auto Jazera', 'Auto Jazera', $body);
        //     sendMail($contact->first_name, 'contactus@autojazeera.pk', 'Auto Jazera', 'Auto Jazera', $body);
        Mail::to($contact->email)->send(new Contact($contact));
        Mail::to('contactus@autojazeera.pk')->send(new Contact($contact));

        return redirect()->back()->with('success', 'Your request is submitted successfully, our team will be in contact with you soon');
    }

    public function allBlogs()
    {
        $blogs = Blog::latest()->paginate(6);
        return view('blogs', compact('blogs'));
    }

    public function blogDetail($id)
    {
        $blog = Blog::findOrFail($id);
        return view('blog_detail', compact('blog'));
    }


    public function newsletterSubmit(Request $request)
    {
        if (!$request->email || $request->email == null || $request->email == '') {
            return response()->json(['status' => 'error', 'message' => 'Please enter a valid email address.']);
        }
        // check if email already exists
        $check = NewsLetter::where('email', $request->email)->first();
        if ($check) {
            return response()->json(['status' => 'error', 'message' => 'You are already subscribed to our newsletter.']);
        }
        $newsletter = new NewsLetter();
        $newsletter->email = $request->email;
        $newsletter->save();
        return response()->json(['status' => 'success', 'message' => 'Thank you for subscribing to our newsletter!']);
    }

    public function all_newsletters()
    {
        $newsletters = NewsLetter::get();
        return view('superadmin.newsletters.index', compact('newsletters'));
    }
}
