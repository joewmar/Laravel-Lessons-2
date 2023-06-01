<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Show all Listing
    public function index(){
        // request();
        // dd(request('tag'));
        return view('listings.index', [
            // 'listings' => Listing::all(),
            // 'listings' => Listing::latest()->get(),
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6),
        ]);
    }

    // Get one Listing
    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing,
        ]);
    }

    // Show Create Form
    public function create(){
        return view('listings.create');
    }

    // Store Listing Data
    public function store(Request $request){
        // dd($request->all());
        // dd($request->file('logo')->store());

        $formFields = $request->validate([
            'company' => ['required', Rule::unique('listings', 'company')],
            'title' => 'required',
            'location' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')){                          // storage/app/logos
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Add Ownership to Listing
        $formFields['user_id'] = auth()->id();

        // If is Valid it can send this data to database
        Listing::create($formFields);

        // Session::flash('message', 'Listing Created');

        return redirect('/')->with('message', 'Listing created successfully');
    }
    // Show Edit Form
    public function edit(Listing $listing){
        // dd($listing->title);
        return view('listings.edit', ['listing' => $listing]);
    }

    // Update Listing
    public function update(Request $request, Listing $listing){

        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()){
            abort(403, 'Unauthorized Action');
        }

        $formFields = $request->validate([
            'company' => ['required'],
            'title' => 'required',
            'location' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')){                          // storage/app/logos
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        

        // If is Valid it can send this data to database
        $listing->update($formFields);

        // Session::flash('message', 'Listing Created');

        return back()->with('message', 'Listing updated successfully');
    }

    // Delete Listing
    public function destroy(Request $request, Listing $listing){

        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()){
            abort(403, 'Unauthorized Action');
        }
        // If is Valid it can send this data to database
        $listing->delete();

        // Session::flash('message', 'Listing Created');

        return redirect('/')->with('message', 'Listing deleted successfully');
    }
    
    // Manage Listings
    public function manage(){
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
