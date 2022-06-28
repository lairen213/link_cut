<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class LinkController extends Controller
{
    //Return cuted link by id
    public function getCuttedLinkById($link_slug)
    {
        $url = substr(URL::current(), 0, strrpos(URL::current(), '/'));

        return $url . '/' . $link_slug;
    }

    //Redirect to original link
    public function redirectToLink($link_slug)
    {
        if ($link_slug) {

            $link = Link::where('slug', $link_slug)->first();
            if ($link && $link['at_work']) {
                $at_work = true;

                if ($link['transitions_limit'] && ($link['current_transitions'] + 1) > $link['transitions_limit']) {//have reached the limit of transitions per page
                    $at_work = false;
                }
                if ($link['expiration_date'] < date('Y-m-d H:i:s')) {//if date expired
                    $at_work = false;
                }

                if (!$at_work)
                    $link->update(['at_work' => false]);

                $link->update(['current_transitions' => $link['current_transitions'] + 1]);
                $link->save();

                if (!$at_work)
                    return abort(404);
                else
                    return redirect($link['address']);
            } else {
                return abort(404);
            }

        } else {
            return redirect('/main');
        }
    }

    public function createLink(Request $request)
    {
        $error_messages = [];
        $url = '';

        // gets current date + 24 hours
        $cur_date_24h = date("Y-m-d H:i:s", strtotime('+24 hours'));

        //parsing of expiration date
        $expiration_date = strtotime(str_replace('T', '', $request->get('expiration_date')));
        $expiration_date = date('Y-m-d H:i:s', $expiration_date);

        if (!$request->get('original_address') || !$request->exists('transitions_count') || !$expiration_date) {
            $error_messages[] = 'Enter all required inputs!';
        } elseif (!filter_var($request->get('original_address'), FILTER_VALIDATE_URL)) { // validating the URL
            $error_messages[] = 'Wrong url address!';
        } elseif ($expiration_date > $cur_date_24h || $expiration_date < date('Y-m-d H:i:s')) { // validating expiration date
            $error_messages[] = 'The expiration date of the link must not be earlier than the current date, and cannot be more than 24h';
        } else {

            try {
                // generating slug for link
                do {
                    $slug = str_random(8);
                    $link = Link::where('slug', $slug)->first();
                } while ($link);

                $link = new Link([
                    'slug' => $slug,
                    'address' => $request->get('original_address'),
                    'transitions_limit' => (int)$request->get('transitions_count'),
                    'expiration_date' => $expiration_date
                ]);
                $link->save();

                $url = $this->getCuttedLinkById($link['slug']);
            } catch (Exception $ex) {
                $error_messages[] = 'Unknown error occurred, double-check the data';
            }
        }

        return view('main', [
            'error_messages' => $error_messages,
            'url' => $url
        ]);
    }
}
