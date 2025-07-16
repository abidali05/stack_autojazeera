<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubmittedForm;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        // $forms = SubmittedForm::with(['post', 'user'])
        //     ->where('user_id', auth()->id())
        //     ->get();
            $forms = SubmittedForm::with(['post', 'user'])
            ->where('dealer_id', auth()->id());
        
        if ($request->has('search') && $request->search) {
            $forms->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            });
        }
        
        $forms = $forms->get();
        $response = new StreamedResponse(function () use ($forms) {
            $handle = fopen('php://output', 'w');
            // Add CSV headers
            fputcsv($handle, ['Type', 'Name', 'Phone', 'Email', 'Comments', 'Date', 'City']);

            // Add data rows
            foreach ($forms as $form) {
                fputcsv($handle, [
                    $form->requesttype,
                    $form->fullname,
                    $form->number,
                    $form->email,
                    $form->comment,
                    $form->created_at->format('Y-m-d'),
                    $form->user->cityname ?? '',
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="forms.csv"');

        return $response;
    }
}
