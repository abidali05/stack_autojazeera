<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bike\BikeLeads;
use App\Models\SubmittedForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
  public function index(Request $request)
  {
    $user = Auth::user();
    if ($user->role == 2) {

      $baseQuery = SubmittedForm::with(['post', 'user'])
        ->where('dealer_id', $user->dealer_id)->orderby('id', 'desc');
    } else {
      $baseQuery = SubmittedForm::with(['post', 'user'])
        ->where('dealer_id', Auth::user()->id)->orderby('id', 'desc');
    }
    // $baseQuery = SubmittedForm::with(['post', 'user'])
    //     ->where('dealer_id', Auth::user()->id)->orderby('id','desc');

    // Apply search filter if provided
    if ($request->search) {
      $baseQuery->whereHas('user', function ($query) use ($request) {
        $query->where('name', $request->search);
      });
    }

    // Retrieve Used Forms
    $Usedforms = (clone $baseQuery)
      ->whereHas('post', function ($query) {
        $query->where('condition', 'used');
      })
      ->get();

    // Retrieve New Forms
    $Newforms = (clone $baseQuery)
      ->whereHas('post', function ($query) {
        $query->where('condition', 'new');
      })
      ->get();

    // Retrieve All Forms
    $forms = $baseQuery->get();

    return view('user.submitform.sub_index', compact('forms', 'Newforms', 'Usedforms'));
  }


  public function bikeleads(Request $request)
  {
    $user = Auth::user();
    if ($user->role == 2) {

      $baseQuery = BikeLeads::where('dealer_id', $user->dealer_id)->orderby('id', 'desc');
    } else {
      $baseQuery = BikeLeads::where('dealer_id', Auth::user()->id)->orderby('id', 'desc');
    }
    
    $posts = $baseQuery->get();

    return view('user.submitform.bike_leads', compact('posts'));
  }
}
